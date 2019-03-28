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
        $('#conferma_prima_di_pagare').click(function(){

          //MOSTRIAMO ED ANIMIAMO FINO AL 75% LA PROGRESS BAR
          $('#loading-braintree').removeClass('d-none');
          $('#loading-braintree .progress-bar').css('width', '75%');

          //PROVIAMO A MOSTRARE IL DROPIN DI BRAINTREE
          const options = {
              authorization: token,
              container: '#dropin-container',
              locale:'it_IT'
            }

          dropin.create(options,function (createErr, instance){

              console.log('Errori ? -> ', createErr);

              //IN CASO DI ERRORI FAI....
              if(createErr !== null){
                $('.form-group').remove()
                $('h2').remove()
                $('#loading-braintree').remove()
                $('#conferma_prima_di_pagare').remove()
                $('#payment-button').remove()
                $('#dropin-container').remove()
                $('#alert_errore_token').removeClass('d-none');
                $('#alert_errore_token').html('Errore nel caricamento del metodo di pagamento');
                return

              }

              //INVECE SE NON CI SONO ERRORI FAI....
              console.log('Dropin ? -> ',instance);

              $('#payment-button').removeClass('d-none');

              $('#loading-braintree').remove();

              $('#payment-button').click(function(event){

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
              })

              console.log('fatto');

            })

        })
      },
      fail: function(error){
        console.log(error);
        $('#alert_errore_token').removeClass('d-none');
        $('#conferma_prima_di_pagare').remove()
        $('.form-group').remove()
        $('h2').remove()
        $('#loading-braintree').remove()

      }
   })

/*
// async function avviaDropin(dropin,apiKey, handler){

  //   var token = await requestBraintreeToken(MIX_API_AUTH_KEY)
  //
  //   console.log('token',token);
  //
  //   const options = {
  //       authorization: token,
  //       container: '#dropin-container',
  //       locale:'it_IT'
  //     }
  //
  //     dropin.create(options,handler)
  //
  //     console.log('sono in fondo alla funzione asincrona');
  //
  //
  // }
   //avviaDropin(dropin,MIX_API_AUTH_KEY,handleDropin)


//
//   avviaDropin(dropin, MIX_API_AUTH_KEY,handleDropin)
//
//   async function avviaDropin(dropin,apiKey, handler){
//
//
//
//
//
//
//
//     var examplePromise = new Promise((resolve, reject)=>{
//
//     var num = 20
//     console.log('ciao sono il numero', 20);
//      if (num > 15){
//        resolve(num)
//      } else {
//         var reason = new Error('non va');
//        reject(reason)
//      }
//    })
//
//    await examplePromise
//    .then(function(num){
//      console.log('ho ritornato', num);
//    })
//    .catch(function(error){
//      console.log(error.message);
//    })
//
//    console.log('ciao');
//
//
//      // var dropinDone = await startBraintreeDropin(dropin, tokenData, handler)
//
//       console.log('dropin Creato ed operativo');
//
//    }
//
//
//
//
*/
  /*
  async function requestBraintreeToken(apiKey){

    var tokenData = await $.ajax({
       method: 'GET',
       url: '/api/braintree/token',
       headers: {'Authorization': apiKey }
    })

    return tokenData.data.token

  }

  async function startBraintreeDropin(dropin, tokenData, dropinHandler){

    $('#loading-braintree .progress-bar').css('width', '90%');

    // return await dropin.create({
    //     authorization: tokenData.data.token,
    //     container: '#dropin-container',
    //     locale:'it_IT'
    //   }, dropinHandler)
    console.log('dropin', dropin);

    const settings = {
        authorization: tokenData.data.token,
        container: '#dropin-container',
        locale:'it_IT'
      }
      dropin.create({
          authorization: tokenData.data.token,
          container: '#dropin-container',
          locale:'it_IT'
        }, dropinHandler)


  }

  function handleDropin(createErr, instance){

  console.log('Errori ? -> ',createErr);
  console.log('Dropin ? -> ',instance);

  $('#loading-braintree').addClass('d-none');

  $('#payment-button').removeClass('d-none');


  $('#payment-button').click(function(event){
    event.preventDefault();
    instance.requestPaymentMethod(function (err, payload) {
      // Submit payload.nonce to your server
      console.log('attacco il method token');
      var nuance = $("<input>")
         .attr("type", "hidden")
         .attr("name", "payment_method_nonce").val(payload.nonce);
        $('#payment-form').append(nuance).submit();
    });
  })

  console.log('fatto');

}
*/
});

















//
//   // function (createErr, instance) {
//   //             console.log('dropin Creato', createErr, instance);
//   //
//   //             $('#loading-braintree').addClass('d-none');
//   //
//   //             $('#payment-button').removeClass('d-none');
//   //
//   //             $('#payment-button').click(function(event){
//   //               event.preventDefault();
//   //               instance.requestPaymentMethod(function (err, payload) {
//   //                 // Submit payload.nonce to your server
//   //                 console.log('attacco il method token');
//   //                 var nuance = $("<input>")
//   //                    .attr("type", "hidden")
//   //                    .attr("name", "payment_method_nonce").val(payload.nonce);
//   //                   $('#payment-form').append(nuance).submit();
//   //               });
//   //             })
