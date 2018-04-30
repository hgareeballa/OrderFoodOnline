
   function topRight($tl,$msg){
      $.messager.show({
        title:$tl,
        msg:"<div class='pagination-centered'><h5>"+$msg+"</div>",
        showType:'show',
        style:{
          left:'',
          right:0,
          top:document.body.scrollTop+document.documentElement.scrollTop,
          bottom:''
        }
      });
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
        window.location.href=json.url;
      //$("#rest_page").html('<a>Loading... Please Wait </a>');
      //$("#rest_page").load(json.url);
      //alert(json.url);

      } else{      
          if (json.msg=="rest_success") {$("#rest_page").load(json.url);} else{
              $($resultbox).show();
          $($resultbox).html(json.msg);
          };
        
      };
      

      }
   });
return false;
}

function confirm_order($formid,$button_id,$resultbox,$url,$rd_url,$ld){
  $($resultbox).hide();
   $.ajax({
      url: $url,
      type: 'POST',
      data: $($formid).serialize(),
      beforeSend : function(){
      //bootbox.dialog($ld);
      },
      complete: function(){
       //bootbox.hideAll();       
      },
      error: function($errorThrown){
      bootbox.alert("Java Script errorThrown !");
      },
      success: function(response) {
        var json = $.parseJSON(response);                         
      topRight("",json.msg);
      if (json.msg!="Fail.!") {
        //load_ad('<?php echo site_url('frontpage/order_list'); ?>')
         $.get($rd_url, function(data) {
              $('#welcome_main').html(data);              
               return false;
            });
        };
      }
   });
return false;
}


function ee($x){
              bootbox.confirm("YOU SURE", function(result) {
                if (result) {
                  window.location.href=$x;
                } else{
                };
              });
  return false;
}
//you sure
function you_sure($url,$msg){
              bootbox.confirm($msg, function(result) {
                if (result) {
                  window.location.href=$url;
                } else{
                };
              });
  return false;
}


function exit_page($url,$flag){
if ($flag=="confirm") {
              bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                  window.location.href=$url;
                } else{
                };
              });

} else{
          window.location.href=$url;
};

	return false;
}




 


