<div id="main" class="well">    
  <div align="center"> <h1><?php echo $form_name;?></div>
     <form id="saveform" method="post">      
        <div class="fitem">  
         <? foreach ($fields as $field): ?>
            
        <label class="control-label"><?= $field['label'] ?></label>         
        <div class="controls">
      <? echo $field['input']; ?>
      </div>      
   <? endforeach; ?>                
        </div>               
    </form>  
  <br>
  <? foreach ($buttons as $field):
  echo $field['btn'];
  echo " ";  
  endforeach; 
  ?>                

<h1></h1>
<div id="resultbox" class="alert alert-info"></div>
<div id="loading" class="alert alert-error">
<img src="<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>" class="img-circle" > Loading... Please Wait
</div>
</div>
<script type="text/javascript">
   $("#resultbox").hide();
   $("#loading").hide();

function saveForm(){
  save_form_1("#saveform","#save","#resultbox","#loading","<?php echo $save_url ?>"); //"no_redirect"   
        }
function clear_(){
  $("#resultbox").hide();
  $('#main input').val('');
}  
    
</script>
<script type="text/javascript">
$(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {          
         saveForm();
    }
});
</script>