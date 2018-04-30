<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">
  

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">   
  
<!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>">   -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('mythings/themes/bootstrap/easyui.css') ?>" />  


  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('mythings/jquery.easyui.min.js') ?>"    ></script>
  <script type="text/javascript" src="<?php echo base_url('mythings/hassan_ajax_form.js') ?>"    ></script>
</head>
<title>Online Order</title>    

<script type="text/javascript">
 $( document ).ajaxStart(function() {
  //$( "#loading_bar" ).html( "<div class='pagination-centered'><img  src='<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>'></div>" ); 
  $( "#loading_bar" ).html("Loading...");
  return false;
});

$( document ).ajaxComplete(function() {
  $( "#loading_bar" ).html("");  
  return false;
});  
</script>

    <script type="text/javascript">
jQuery.browser={};(function(){jQuery.browser.msie=false;
jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
    </script>