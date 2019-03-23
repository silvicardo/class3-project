require('./bootstrap');
var $ = require("jquery");
var dotEnv = require('dotenv');
dotEnv.config();


$(document).ready(function(){


  $('#campo_citta').keydown(function(e) {

    if(e.which == 13) {
      e.preventDefault();
      console.log('enter su navbar');
    }
  });

});
