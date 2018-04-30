   
  <?    
    foreach ($query->result() as $row)
    {
     ?>
     <ul class="thumbnails">
        <li class="span11"> 
        <div class="thumbnail">         
            <img src="<?php echo $row->url;?>" class="pull-left span4 clearfix" width="320px" style="height: 200px">
            <div class="caption" class="pull-left">              
              <a href="javascript:void(0)" onclick="show_menu(<?php echo $row->id;?>)" class="btn btn-primary btn-xs pull-right">View Menu  <i class="icon-list"></i></a>
              <a href="javascript:void(0)" onclick="show_rest_info(<?php echo $row->id;?>)" class="btn btn-primary btn-xs">Info       <i class="icon-search"></i></a>
              <a href="javascript:void(0)" onclick="rate_this(<?php echo $row->id;?>,'<?php echo $row->name;?>')" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Rate This Resturant"><?php echo round($row->rating,1);?>/10</a>              
              <a href="javascript:void(0)" onclick="show_rest_info(<?php echo $row->id;?>)"><h4><? echo $row->name ?></h4></a>  
              <small><b><span class="label label-info">Phone: </span> <? echo $row->phone ?></b></small><br>          
              <small><b><span class="label label-info">Food Type: </span> <? echo $row->food_type ?></b></small><br>
              <small><b><span class="label label-info">Delivery: </span>  <? echo $row->delivery ?></b></small><br>
              <small><b><span class="label label-info">Address: </span>  <? echo $row->address ?></b></small><br>                                                 
            </div>          
      </li>   
      </ul>         
    <?
    }  
  ?>   
 

  <script type="text/javascript">
    function show_menu($id){
      //alert($id);
      $("#one").load('<?php echo site_url("frontpage/new_order") ;?>',{id:$id});  
      //$('#myModal').modal('show');  
    }

    function show_rest_info($id){   
    $("#dog").html("Loading...");
    $("#myModalLabel").html("Resturant Info");         
      $("#dog").load('<?php echo site_url("frontpage/rest_details") ;?>',{id:$id});  
      $("#dialog").modal();     
    }

    function rate_this($id,$n){ 
    $("#dog").html("Loading...");                 
      $("#dog").load('<?php echo site_url("frontpage/rate_resturant") ;?>',{id:$id,name:$n});  
      $("#dialog").modal();
    }

  </script>


  <?    
   /* foreach ($query->result() as $row)
    {
     ?>
      <li class="span5">
        <div class="thumbnail">      
          <img src="<?php echo $row->url;?>" alt="" width="100%" style="height: 150px">                      
            <pre><h3><? echo ' '.$row->name ?><h3></pre>
            <pre><span class="label">Type: </span><? echo ' '.$row->food_type ?></pre>
            <pre><span class="label">Delivery: </span><? echo ' '.$row->delivery ?></pre>          
            <a href="javascript:void(0)" onclick="show_menu(<?php echo $row->id;?>)" class="btn btn-primary btn-mini">View Menu  <i class="icon-list"></i></a>
            <a href="javascript:void(0)" onclick="show_info(<?php echo $row->id;?>)" class="btn btn-mini">Info       <i class="icon-search"></i></a>
            <a href="javascript:void(0)" onclick="rate_this(<?php echo $row->id;?>,'<?php echo $row->name;?>')" class="btn btn-mini"><?php echo round($row->rating,1);?>/10   <i class="icon-thumbs-up"></i></a>
        </div>
      </li>      
    <?
    }
    */
  ?>   