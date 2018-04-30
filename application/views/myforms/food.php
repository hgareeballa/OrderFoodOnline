 <div>
  <?    
    foreach ($query->result() as $row)
    {
     ?>
          <ul class="thumbnails">
          <li class="span11 clearfix">
            <div class="thumbnail clearfix">
              <img src="<? echo $row->url?>" alt="ALT NAME" class="img-rounded pull-left clearfix" width="200px" style="height: 150px">
              <div class="caption"  class="pull-left">
                <h5><span class="label">Name: </span><? echo $row->name ?></h5>
                <h6><span class="label label-important">Rating: </span><? echo round($row->rating,1) ?>/10</h6>
                <h6><span class="label label-important">Price: </span><? echo $row->price ?>SDG</h6>                
                <h6><span class="label">Resturant-ID: </span><? echo $row->restname; ?></h6>
                <p align="left">
                <a name="<? echo $row->id?>" class="btn btn-primary btn-mini" href="javascript:void(0)" onclick="clickTheButton('<? echo $row->id?>');" data-toggle="tooltip" title="Add To Cart">Add <i class='icon-plus-sign'></i></a>
                <a href="javascript:void(0)" onclick="rateOK('<?php echo $row->id;?>','<?php echo $row->name;?>')" class="btn btn-mini" data-toggle="tooltip" title="Rate This Item">Rate <?php echo round($row->rating,1);?>/10   <i class="icon-thumbs-up"></i></a>  
                <a href="javascript:void(0)" onclick="show_food_info('<?php echo $row->id;?>');" class="btn btn-mini"data-toggle="tooltip" title="More Information About This Item">Info       <i class="icon-question-sign"></i></a>                
                </p>
              </div>
            </div>
          </li>          
      </ul>        
    <?
    }  
    if ($query->num_rows()<=0) {?><h3><span class="label label-important">No Result Found ..!</span></h3><?};
  ?>

</div>

