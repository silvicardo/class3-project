require('./bootstrap');
var braintree = require('braintree');
var $ = require("jquery");



$(document).ready(function(){

  console.log('braintree script');

  //BRAINTREE DROPIN

  braintree.dropin.create({
        authorization: 'CLIENT_TOKEN_FROM_SERVER',
        container: '#dropin-container'
      }, function (createErr, instance) {
        

        button.addEventListener('click', function () {
          instance.requestPaymentMethod(function (err, payload) {
            // Submit payload.nonce to your server
          });
        });
      });


})
