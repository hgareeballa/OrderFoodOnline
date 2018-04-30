<?php 
/*$x=isset($username) ? strval($username) : 'Guest';  
if ($x<>"") {
	$x='['.$x.']';
}
<?php echo $x?>
*/
?>


<div id="tt" class="container">
  <div class="well">
		<div class="row-fluid">  	
		    <div class="span8"><img src="<?php echo base_url('uploads/logo.png') ?>" class="img-rounded">
 			[<a id="username">Guest</a>]	
 			 <a id="loading_bar" class="pull-right">Loading...</a>		    		
		    </div>   
		    <div class="span4">
		    		<p>
						  <button class="btn btn-primary" onclick="go_to('rest_page')" type="button">Home		<i class="icon-home"></i></button> 
						  <button class="btn btn-primary" onclick="login_()" type="button">Login		<i class="icon-ok"></i></button> 						  
						  <button class="btn btn-primary" onclick="register_()" type="button">Register	<i class="icon-plus"></i></button>
						  <button class="btn btn-primary" onclick="help_()" type="button">Help		<i class="icon-question-sign"></i></button>				
						   <button class="btn btn-primary" onclick="history_()" type="button">History <i class="icon-th"></i></button> 
						  <button class="btn btn-primary" onclick="cart_()" type="button">Cart		<i class="icon-shopping-cart"></i></button>			  
						  <button class="btn btn-primary" onclick="out_()" type="button">Log-Out	<i class="icon-off"></i></button> 						  						 
						
						   
											  
					</p>
					
		    </div>
		</div>
 </div>

 <div id="home" class="well row-fluid">  	
	    <div>
				<p>						
						  <button class="btn btn-primary" onclick="go_to('rest_page')" type="button">All Resturants <i class="icon-list"></i></button> 						  						  
						  <button class="btn btn-primary" onclick="go_to('advert_page')" type="button">New Offers <i class="icon-fire"></i></button> 						  
					
					<span class="label">Sort By:</span>
					<select id="ds" class="btn-mini"style='width:20%;'>
						<option value="id">List All</option>
						<option value="rating">Resturant Rating</option>
						<option value="name">Resturant Name</option>							
					</select>		
					<select id="do" class="btn-mini"style='width:10%;'>
						<option value="desc">Desc</option>
						<option value="asc">Asce</option>	

					</select>		
					<span class="">Delivery:</span>	
					<select id="dd" class="btn-mini" style='width:10%;'>						
						<option value="all">All</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>						
					</select>						
					<button class="btn btn-primary" onclick="ddd()" type="button"data-toggle="tooltip" title="Click to Search">Search <i class="icon-search"></i></button> 	  							  
			    </p>	  
  </div> 
</div>  
<div class="well">
<div id="one"></div>
</div>


<script type="text/javascript">
 $(document).ready(function(){  
 function dd(){
      var d = $("#dd").val();          
      var s = $("#ds").val();
      var o = $("#do").val();
     $("#one").load('<?php echo site_url("frontpage/rest_page") ;?>',{dv:d,sort:s,order:o});
 }
//$("#dd").change(dd);
//$("#ds").change(dd);    
});

function ddd(){
   var d = $("#dd").val();          
   var s = $("#ds").val();
   var o = $("#do").val();

   $("#one").load('<?php echo site_url("frontpage/rest_page") ;?>',{dv:d,sort:s,order:o});
}

function load_orders(){	
$("#dog").load('<?php echo site_url("frontpage/order_details") ;?>');
}

$(document).ready(function(){  
  $('#one').load('<?php echo site_url("frontpage/rest_page") ;?>');
  //$("#two").load('<?php echo site_url("frontpage/order_details") ;?>');
 
});

function go_to($url){	
	var x="<?php echo site_url('frontpage')?>/"+$url;
  $('#one').load(x);
}
function login_(){
	$("#myModalLabel").html("Login Form");
cleardialog();            
      $("#dog").load('<?php echo site_url("frontpage/login_form") ;?>');  
      //$( "#dialog").dialog({autoOpen: false,modal: true,buttons: {Ok: function() {$( this ).dialog( "close" );}}});
//$( "#dialog").dialog({autoOpen: false,modal: true});
$("#dialog").modal();
        
    }
function register_(){  
$("#myModalLabel").html("Register Form");          
	cleardialog();
      $("#dog").load('<?php echo site_url("frontpage/register_form") ;?>');  
     //$( "#dialog").dialog({autoOpen: false,modal: true});
     $("#dialog").modal();
    }

function out_(){                  	   
      window.location.href='<?php echo site_url("frontpage/index") ;?>';      
      return true;     
    }

function help_(){ 
	$("#myModalLabel").html("Help !");
cleardialog();                 
     $("#dog").html('HELP INFO PAGE');  
      $("#dialog").modal();
    }
function history_(){                  
	$("#myModalLabel").html("Show History");
	cleardialog();
      $("#dog").load('<?php echo site_url("frontpage/my_history") ;?>'); 
      $("#dialog").modal();
    }
function cart_(){
$("#myModalLabel").html("Show Details");
	cleardialog();
$("#dog").load('<?php echo site_url("frontpage/order_details") ;?>');
$("#dialog").modal();
}

function del_item($id){
	//alert ($id);
	$.messager.confirm('Confirm','Are you sure ?',function(r){
    if (r){
			$.ajax({
			  type: "POST",
			  url: "<?php echo site_url('frontpage/delete/order_details') ?>",
			  data: {id:$id}
			}).done(function( msg ) {
				var json = $.parseJSON(msg);
			  	topRight("",json.msg);  
			  	load_orders();
			}).fail(function( msg ) {
			  	var json = $.parseJSON(msg);  
			  	topRight("Error!",json.msg);
			});                			  
     }
     });
}    
function del_all($id){	
	$.messager.confirm('Confirm','Are you sure, Delete all items ?',function(r){
    if (r){
    var jqxhr = $.ajax( "<?php echo site_url('frontpage/delall/order_details') ?>" )
    .done(function(msg) { 
    	var json = $.parseJSON(msg);
			  	topRight("",json.msg);  
			  	load_orders();
     })
    .fail(function(msg) {     	
			  	topRight("Error!","Operation Failed!");  			  	
     });

     }
     });
}    
function conf_order(){
	$.messager.confirm('Confirm','Are you sure ?',function(r){
    if (r){
    var jqxhr = $.ajax( "<?php echo site_url('frontpage/add_order_tid') ?>" )
    .done(function(msg) { 
    	var json = $.parseJSON(msg);
			  	topRight("",json.msg);  		  	
			  	load_orders();
     })
    .fail(function(msg) { 
    	//var json = $.parseJSON(msg);
			  	topRight("Error!","Operation Failed!");  
			  	//load_orders();
     });

     }
     });
}    

  
 function show_details($id){
 	$("#myModalLabel").html("Show Details");
	//$("#d_mymodal_content").load('<?php echo site_url("frontpage/show_details") ;?>',{id:$id});  
	cleardialog();
	$("#dog").load('<?php echo site_url("frontpage/show_details") ;?>',{id:$id});  
	$( "#dialog").modal();
    //$('#d_myModal').modal('show');   


}

function form_comment($id){
	$("#myModalLabel").html("Comments Form");
	cleardialog();
	//$id="1";
	//$co="testtest";
	//$("#d_mymodal_content").load('<?php echo site_url("frontpage/form_comment") ;?>',{id:$id});  
    //$('#d_myModal').modal('show');   
    $("#dog").load('<?php echo site_url("frontpage/form_comment") ;?>',{id:$id});  
    $( "#dialog").modal();
}
function cleardialog(){
	$("#dog").html("Loading...");
	//$( "#dialog" ).dialog( "close" );
	//Close jQuery UI dialog 
    //$("#dialog").hide();
    

	//$this.dialog( "close" );
}

</script>
 

<!--
<div id="dialog" title="--" style="top:10px;hight:500px;width:600px">
<div id="dog"></div>
<div>
<a class='btn-danger btn-mini'>[X]<i class='icon-ban-circle'></i></a>
 <button class="btn btn-mini" onclick="cleardialog()" type="button">Close <i class="icon-fire"></i></button> 						  
</div>
</div>
-->

<!-- Modal -->
<div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><? echo isset($form_name) ? strval($form_name) : 'Modal Title'; ?></h4>
      </div>
      <div id="dog"class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<STYLE TYPE="text/css">
body
{
background-image:url('http://localhost:8090/resturant/assets/img/Food-Tomatoes.jpg');
background-color:black;
}
</STYLE>