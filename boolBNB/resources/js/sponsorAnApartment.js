require('./bootstrap');
var dropin = require('braintree-web-drop-in');
var $ = require("jquery");
var dotEnv = require('dotenv');
dotEnv.config();
var {MIX_API_AUTH_KEY} = process.env;

$(document).ready(function(){

   MIX_API_AUTH_KEY = `Bearer ${MIX_API_AUTH_KEY}`;

   $('#loading-braintree .progress-bar').css('width', '25%');


  //chiamo l'api del nostro sito per
  //ottenere il token che ci serve per
  //poter implementare il servizio di pagamento
  $.ajax({
    type: 'GET',
    url: '/api/braintree/token',
    headers: {
        'Authorization': MIX_API_AUTH_KEY
    }
  }).done(function(apiData) {

      $('#loading-braintree .progress-bar').css('width', '90%');

      dropin.create({
            authorization: apiData.data.token,
            container: '#dropin-container',
            locale:'it_IT'
          }, function (createErr, instance) {
              console.log('dropin Creato', createErr, instance);

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




            });
          });
    });
