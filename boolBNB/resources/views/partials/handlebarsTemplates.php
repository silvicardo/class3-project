<script id="apartment_template" type="text/x-handlebars-template">
  <div class="card_appartment col-md-4 mt-5">
    <a href="{{{ link }}}">
      <div class="card">
       <img class="card-img-top" src="{{{image_url}}}" alt="Card image cap">
       <div class="card-body">
         <h5 class="card-title">{{title}}</h5>
         <p class="card-text">{{description}}</p>
       </div>
      </div>
    </a>
  </div>
</script>
