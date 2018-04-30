
<div id="main" class="container">
<div class="row-fluid">  
<div id="sp4" class="span4">
<div id="sp5">  

<p class="well">
When you start with the best ingredients available, you don’t need to rely on overly elaborate recipes or culinary fads. That’s why The Palm Restaurant’s menu features honest, satisfying dishes that reflect the best of our Italian-American heritage – from prime aged steaks and jumbo Nova Scotia lobsters to Italian classics like Chicken Parmigiana and Veal Martini. 
</p>

</div>
</div>
<div id="advert" class="span8 well">

</div>
</div>
</div>


<script type="text/javascript">
 
$(document).ready(function(){  
 $.get('<? echo $advert ?>', function(data) {
  $('#advert').html(data);
   return false;
});

});

function load_ad($url){
  $("#sp5").hide();
  $("#sp5").fadeIn(1500); 
   
            $.get($url, function(data) {
              $('#sp5').html(data);             
               return false;
            });
 $( document ).ajaxStart(function() {
  $( "#loading_bar" ).html( "<div class='pagination-centered'><img  src='<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>'></div>" ); 
  return false;
});

$( document ).ajaxComplete(function() {
  $( "#loading_bar" ).html( "" );  
  return false;
});            
       } 

</script>

<style>    

    body {
position: relative;
padding-top: 50px;
background-color: #E6E6FA;
background-image: url("<?php echo base_url('assets/img/Food-Tomatoes.jpg') ?>");
background-repeat: repeat-x;
background-position: 0 50px;
}   
</style>




