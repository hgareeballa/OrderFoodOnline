<style type="text/css">
.nav-tabs > li, .nav-pills > li {
    float:none;
    display:inline-block;
    text-align:center;
}
.nav-tabs {
    text-align:center;
}
</style>

<div class="span11">
  <span class="label label-info"><? echo $rest_name;?></span>
<div id="mytab" class="tabbable centered-nav">
  <ul class="nav nav-tabs">
    <?
    $i=1;
    foreach ($groups->result() as $row)
    {

      echo "<li><a class='btn-mini' href='#group$i' data-toggle='tab'>$row->name</a></li>";
      $i=$i+1;

    }
    ?>    
  </ul>
  <div class="tab-content">   
    <?
    $i=1;
    foreach ($groups->result() as $row)
    {      
    ?>
      <div id="group<? echo $i ?>" class="tab-pane">     
      <? 
      foreach ($query[$i]->result() as $row) {         
      ?>    
       <ul class="thumbnails">
          <li class="span11 clearfix">
            <div class="thumbnail clearfix">
              <img src="<? echo $row->url?>" alt="ALT NAME" class="pull-left clearfix" width="220px" style="height: 150px">
              <div class="caption"  class="pull-left">                              
                <h5><span class="label-info">Name: </span><? echo $row->name ?></h5>
                <h6><span class="label label-primary">Price: </span><? echo $row->price ?>SDG</h6>
                <p align="left">
                <a name="<? echo $row->id?>" href="javascript:void(0)" onclick="clickTheButton('<? echo $row->id?>')" class="btn-success btn-xs" data-toggle="tooltip" title="Add To Cart">Add </i></a>
                <a href="javascript:void(0)" onclick="rateOK(<?php echo $row->id;?>,'<?php echo $row->name;?>')" class="btn-warning btn-xs" data-toggle="tooltip" title="Rate This Item"><?php echo round($row->rating,1);?>/10   <i class="icon-thumbs-up"></i></a>  
                <a href="javascript:void(0)" onclick="show_food_info(<?php echo $row->id;?>)" class="btn-info btn-xs"data-toggle="tooltip" title="More Information About This Item">Info       <i class="icon-question-sign"></i></a>
                </p>
              </div>
            </div>
          </li>          
            </ul>

      <?

      }
      ?>
    </div>
    <?
    $i=$i+1;
    }
    ?>   
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->

</div>


<script type="text/javascript">  
$(document).ready(function(){
    //$("#main").hide();
    //$("#main").fadeIn(1500);
  });
</script>

<script type="text/javascript">
function rateOK($id,$n){
  //alert($n);
    $("#dog").load('<?php echo site_url("frontpage/rate_food") ;?>',{id:$id,name:$n});  
    //$('#myModal').modal('show');
    $("#dialog").modal();

}

function remove_($rr){
  alert($rr);
  var url = '<?php echo $delurl ?>';
  //alert(url);
  /*  var person = {id: $rr}                        
                              $.ajax(
                              {
                                  type:"POST",
                                  beforeSend: function (){},
                                  url: url,
                                  dataType: 'json',
                                  data:  person,                                  
                                  success: function(result)
                                  {                                                                            
                                       topRight("",result.msg);
                                  },
                                  complete: function(){},
                                  error:function(result){                                    
                                     topRight("Error!",result.msg);
                                  }
                              });*/
}
function clickTheButton($rr) {

//var Sender = window.event.srcElement;
//alert(Sender.name);
//$(Sender.name).attr("disabled", true);

var xxx = '<?php echo $add_order_url ?>/'+$rr;
//save_order("#form","#save","#resultbox",Sender.value,"no_redirect","<div class='pagination-centered'><img  src='<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>'></div>"); //"no_redirect"  
save_order("#form","#save","#resultbox",xxx,"no_redirect","<div class='pagination-centered'><img  src='<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>'></div>"); //"no_redirect"  
//return false;
}

$('#mytab a:first').tab('show'); // Select first tab 
$(document).ready(function(){
  $("#c_out").click(function(){
 $.get('<?php echo $checkoutpage ?>', function(data) {
  //$('#checkout_content').html("");
  $('#coc').html(data);
  //alert('Load was performed.');
   return false;
});
  });
});

//"<html><img src='<?php echo base_url('mythings/loader/ajax-loader.gif') ?>' class='img-rounded'></html>"
</script>

<script type="text/javascript">
function save_order($formid,$button_id,$resultbox,$url,$rd_url,$ld){
  $($resultbox).hide();  
   $.ajax({
      url: $url,
      type: 'GET',
      data: '',
      beforeSend : function(){
      //bootbox.backdrop(true);
      //bootbox.dialog($ld);
       //$.messager.show({title: '',msg: $ld});
       //topRight("",$ld);
      },
      complete: function(){
       //bootbox.hideAll();
      },
      error: function($errorThrown){
      bootbox.alert("Java Script errorThrown !");
      },
      success: function(response) {
      var json = $.parseJSON(response);                         
      topRight("","<div class='pagination-centered'>"+json.msg+"</div>");
      //$("#two").load('<?php echo site_url("frontpage/order_details") ;?>');         
      }
   });
return true;
}
</script>

<script type="text/javascript">
 function show_food_info($id){ 
 $("#dog").html("Loading...");  
        $("#myModalLabel").html("Food Info");
      $("#dog").load('<?php echo site_url("frontpage/food_details") ;?>',{id:$id});  
      //$('#myModal').modal('show');      
      $("#dialog").modal();
    }
</script>