require('./bootstrap');
var dropin = require('braintree-web-drop-in');
var $ = require("jquery");
var dotEnv = require('dotenv');
dotEnv.config();
var {MIX_API_AUTH_KEY} = process.env;

$(document).ready(function(){

   MIX_API_AUTH_KEY = `Bearer ${MIX_API_AUTH_KEY}`;

   var token = null;

   $.ajax({
      method: 'GET',
      url: '/api/braintree/token',
      headers: {'Authorization': MIX_API_AUTH_KEY },
      success: function(tokenData){

        var token = tokenData.data.token
        console.log('token',token);

        //MOSTRIAMO IL BOTTONE DI CONFERMA SCELTE PER PAGARE
        $('#conferma_prima_di_pagare').removeClass('d-none');

        //ASCOLTIAMO IL CLICK DEL BOTTONE SCELTE AVVENUTE
        $('#conferma_prima_di_pagare').click(attemptAndManageBraintreeDropinCreation.bind(this))
      },
      fail: tokenUnavailable,
   })

   function attemptAndManageBraintreeDropinCreation(){

               //MOSTRIAMO ED ANIMIAMO FINO AL 75% LA PROGRESS BAR
               $('#loading-braintree').removeClass('d-none');
               $('#loading-braintree .progress-bar').css('width', '75%');

               //PROVIAMO A MOSTRARE IL DROPIN DI BRAINTREE
               const options = {
                   authorization: token,
                   container: '#dropin-container',
                   locale:'it_IT'
                 }

               this.dropin.create(options,function (createErr, instance){

                   console.log('Errori ? -> ', createErr);

                   //IN CASO DI ERRORI FAI....
                   if(createErr !== null){
                       manageDropinCreationFailed()
                       return

                   }

                   //INVECE SE NON CI SONO ERRORI FAI....
                   console.log('Dropin ? -> ',instance);

                   $('#payment-button').removeClass('d-none');

                   $('#loading-braintree').remove();

                   $('#payment-button').click(payNowBtnHandler.bind(null, instance))

                   console.log('fatto');

                 })
   }

   function manageDropinCreationFailed(){
     $('.form-group').remove()
     $('h2').remove()
     $('#loading-braintree').remove()
     $('#conferma_prima_di_pagare').remove()
     $('#payment-button').remove()
     $('#dropin-container').remove()
     $('#alert_errore_token').removeClass('d-none');
     $('#alert_errore_token').html('Errore nel caricamento del metodo di pagamento');

   }


  function payNowBtnHandler(event, instance){

    //BLOCCHIAMO IL SUBMIT DEL FORM
    event.preventDefault();

    //TENTIAMO IL PAGAMENTO
    instance.requestPaymentMethod(function (err, payload) {

      //SE CI SONO ERRORI FAI .....

      //SE TUTTO OK FAI...


      //CREA UN INPUT NASCOSTO DOVE METTI L'ID DI AVVENUTO PAGAMENTO
      var nuance = $("<input>")
         .attr("type", "hidden")
         .attr("name", "payment_method_nonce").val(payload.nonce);

        //LO INSERIAMO NEL FORM CON APPEND
        $('#payment-form').append(nuance);

        //SUBMIT DEL FORM
        //INVIA AL NOSTRO SERVER I DATI DI PAGAMENTO
        //L'APPARTAMENTO SCELTO(ID), IL PIANO SPONSOR SCELTO(ID), E L'ID
        //DI TRANSAZIONE AVVENUTA (payload)
        $('#payment-form').submit();
    });
  }

   function tokenUnavailable(error){

     console.log(error);
     $('#alert_errore_token').removeClass('d-none');
     $('#conferma_prima_di_pagare').remove()
     $('.form-group').remove()
     $('h2').remove()
     $('#loading-braintree').remove()
   }

});
