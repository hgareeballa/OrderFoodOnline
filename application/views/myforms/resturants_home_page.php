<?php $x=isset($username) ? strval($username) : 'Guest';  
if ($x<>"") {
	$x='['.$x.']';
}
?>
<div class="container">
  <div class="well">
		<div class="row-fluid">  	
		    <div class="span6"><img src="<?php echo base_url('uploads/logo.png') ?>" class="img-rounded"></div>   
		    <div class="span6" align="right">
		    		<p>              
						  <button class="btn btn-mini" onclick="go_to_('resturant__page')" type="button">Home		<i class="icon-home"></i></button> 
						  <button class="btn btn-mini" onclick="login__()" type="button">[Login]		<i class="icon-ok"></i></button> 						  
						  <button class="btn btn-mini" onclick="go_to_('resturant_list')" type="button">Current Order	<i class="icon-plus"></i></button>					
              <button class="btn btn-mini" onclick="out__()" type="button">LogOut   <i class="icon-off"></i></button> 
						  <div><?php echo $x?></div>
						  <div id="loading_bar">
                                                      <span class="label label-important">Loading... Please Wait </span>

                                                     </div>						  
					</p>
					
		    </div>
		</div>
 </div>

<div class="container">
 <div id="home" class="row-fluid">  	
    <div class="span12 well">
    	<div id="one" style='overflow:auto; width:100%;height:500px;'></div>
      </div>   
    
  </div> 
</div>  


  <div class="well">
    <div class="alert-info row-fluid">   
     Copyright © 2013
    </div>
 </div>


</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div id="mymodal_content" class="modal-body">
	<a>Loading... Please Wait </a>
</div>
<div class="modal-footer">
    <a href="#" data-dismiss="modal" aria-hidden="true" class="btn"><i class="icon-remove-circle"></i></a>    
</div>
</div>

<div id="d_myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div id="d_mymodal_content" class="modal-body">
	<a>Loading... Please Wait </a>
</div>
<div class="modal-footer">
    <a href="#" data-dismiss="modal" aria-hidden="true" class="btn"><i class="icon-remove-circle"></i></a>    
</div>
</div>

<script>
$(document).ready(function(){  
  //$('#one').load('<?php echo site_url("frontpage/rest_page") ;?>');
  //$("#two").load('<?php echo site_url("frontpage/order_details") ;?>');
  go_to_('resturant_list');
 
});

function go_to_($url){	
var x="<?php echo site_url('frontpage')?>/"+$url;
//alert(x);
  $('#one').load(x);
//window.location.href=x;
}
function login__(){            
      //$("#mymodal_content").html('<a>Loading... Please Wait </a>');
      //$("#mymodal_content").load('<?php echo site_url("frontpage/rest_login_form") ;?>');  
      ///$('#myModal').modal('show');      
      $('#one').load('<?php echo site_url("frontpage/rest_login_form") ;?>');
    }

function out__(){                  
      window.location.href='<?php echo site_url("frontpage/resturant__index") ;?>';      
      return false;     
    }

function send_email($oid){
  try
  {
    var jqxhr = $.ajax('<?php echo site_url("frontpage/sendemail") ;?>/'+$oid)
    .done(function() {})
    .fail(function() {});            
  }
catch(err)
  {
  
  }

}

function save_form_1($formid,$button_id,$resultbox,$loadingbox,$url){
  $($resultbox).hide();
  //var fd = new FormData($formid);
  var fd = $($formid).serialize();
   $.ajax({
      url: $url,
      type: 'POST',
      data: fd,  
      beforeSend : function(){
        $($loadingbox).show();
      },
      complete: function(){
        $($loadingbox).hide();
      },
      error: function($errorThrown){
      //bootbox.alert("Java Script errorThrown !");
      topRight("ERROR",$errorThrown);
     $($loadingbox).hide();
      },
      success: function(response) {
        //alert(response);
        //$($loadingbox).hide();        
      var json = $.parseJSON(response);         
      if (json.msg=="success") {
      
      $("#rest_page_").html('<a>Loading... Please Wait </a>');
      //$("#rest_page_").load(json.url);
      //      alert('rest_head'+json.oid);
      window.location.href=json.url;

      } else{      
          //$($button_id).button('reset');
          $($resultbox).show();
          $($resultbox).html(json.msg);
      };
      

      }
   });
return false;
}

</script>
 
 <style type="text/css">
#myModal .modal-body {
	max-height: 600px;
	max-width: 600px;
}
#d_myModal .modal-body {
	max-height: 600px;
	max-width: 600px;
}
 </style>
