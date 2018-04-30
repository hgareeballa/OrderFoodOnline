<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>Online Order</title>
   
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">      
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('mythings/themes/icon.css') ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('mythings/themes/bootstrap/easyui.css') ?>" />

 
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('mythings/jquery.easyui.min.js') ?>"    ></script>
  <script type="text/javascript" src="<?php echo base_url('mythings/hassan_ajax_form.js') ?>"    ></script>
  
  
   
</head>

<body>
<div class="navbar">
      <div class="navbar-inner">
        <div class="">
          <a class="brand" href="#">Online Order</a>
          <div class="nav-collapse collapse" >
            <ul class="nav">
          
              <li><a href="<?php echo site_url('frontpage/feedback_list'); ?>"></a></li>    
              <li><a href="<?php echo site_url('frontpage/admin_order_list'); ?>">Order list</a></li>            
              <li><a href="<?php echo site_url('frontpage/create_food_form'); ?>">Creat new food</a></li> 
              <li><a href="<?php echo site_url('frontpage/create_rest_form'); ?>">Creat New Resturant</a></li> 
              
              <li><a href="<?php echo site_url('frontpage/rest_list'); ?>">Resturant list</a></li> 
              <li><a href="<?php echo site_url('frontpage/food_list'); ?>">Food list</a></li> 
              <li><a href="<?php echo site_url('frontpage/menu_list'); ?>">Menu list</a></li>               
              <li><a href="<?php echo site_url('frontpage/user_list'); ?>">User list</a></li> 
              <li><a href="<?php echo site_url('frontpage/advert_list'); ?>">advert list</a></li> 
              <li><a href="<?php echo site_url('frontpage/feedback_list'); ?>">Feedback list</a></li> 
              <li><a href="<?php echo site_url('frontpage/img_list'); ?>">Images list</a></li> 
              <li><a href="<?php echo site_url('frontpage/upload'); ?>">Photo upload</a></li>            
                            
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
</div>
   <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <script type="text/javascript">
jQuery.browser={};(function(){jQuery.browser.msie=false;
jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
    </script>