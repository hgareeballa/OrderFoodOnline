<div class="" style="width: 85%; margin: 0 auto;">
<div id="myCarousel" class="carousel slide">  
  <ol class="carousel-indicators">    
  </ol>
  <!-- Carousel items -->
  <div class="carousel-inner">    
    <?  foreach ($query->result() as $row){ ?>

    <div class="item"><img src="<? echo $row->url; ?>" width="100%" style="height: 470px">
    <div class="carousel-caption">
          <h4><? echo $row->name; ?></h4>
          <p><? echo $row->desc; ?></p>
        </div>
    </div>
    <? } ?>   
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

<script type="text/javascript">
$('.carousel').carousel({
  interval: 3000
});

jQuery('#myCarousel').find('.item:first').addClass('active');
</script>

