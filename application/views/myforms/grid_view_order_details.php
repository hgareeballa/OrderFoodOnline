<div class="container">
<div id="main" class="container" style="width: 100%; margin: 0 auto;">
<table id="dg" title="<?php echo $table_name;?>" class="easyui-datagrid"  style="width:900px;height:390px"
        url="<?php echo $geturl;?>"  
        toolbar="#toolbar"  
     data-options="  
                rownumbers:true,  
                singleSelect:true,  
                autoRowHeight:true,  
                pagination:true,  
                pageSize:10,
                fitColumns:true">
    <thead>  
        <tr>  
            <?php
            foreach ($table_header as $k => $v) {                    
            echo "<th sortable='true' field=$k>$v</th>"; 
            //<th field="id" width="50">ID</th> 
            }
            ?>            
        </tr>  
    </thead>  
</table>  
<div id="toolbar" class="pagination-centered">  

 <? foreach ($buttons as $field):
  echo $field['btn'];
  echo " ";
  endforeach; 
  ?>  

</div> 
</div>
</div>
<script type="text/javascript">
 $(function(){  
            //$('#dg').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());  
            $('#dg').datagrid('load');
        });  
 //$('#dg').datagrid(hideColumn('id'));
 //$('#dg').datagrid('hideColumn');
 </script>


  

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">    
    <h3 id="myModalLabel"><?php echo $table_name; ?></h3>
  </div>
  <div class="modal-body">
     <form id="fm" method="post">      
        <div class="fitem"> 
         <?php
            foreach ($form_header as $k=>$v) {  
            echo "<label>$k</label>";                         
            echo "$v";              
            }
        ?>     
                         
        </div>               
    </form>  
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" onclick="saveUser()">Save changes</button>
  </div>
</div>


<div id="myModal_d" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header"></div>
  <div class="modal-body">
  <table id ="details" class="table table-bordered"></table>
  </div>     

  </div>
 
</div>
<?php

$colid = isset($hideColumn) ? strval($hideColumn) : 'email';  

?>

<script type="text/javascript">
$ld="<html><img src='<?php echo base_url('mythings/loader/ajax-loader.gif') ?>' class='img-rounded'></html>";
var loader_pic="<div class='pagination-centered'><img  src='<?php echo base_url('mythings/loader/spinner_squares_circle.gif') ?>'></div>";
//$hd="id";
$hd="<?php echo $colid ?>";

$(document).ready(function() {
$('#dg').datagrid('hideColumn',$hd);

    $("#confirm").click(function(){
            
    var rows = $('#dg').datagrid('getRows');        
          if(rows.length == 0)
          {            
            //bootbox.alert("You have no items in your shopping cart.");
            topRight("","You have no items in your shopping cart.!!");
          }else{
      
        //----
                   $.messager.confirm('Confirm','Are you sure ?',function(r){
                    if (r){
                  confirm_order("#form","#save","#resultbox","<?php echo site_url('frontpage/add_order_tid') ?>","<?php echo site_url('frontpage/order_list') ?>","<html><img src='<?php echo base_url('mythings/loader/ajax-loader.gif') ?>' class='img-rounded'></html>"); //"no_redirect"  
                    }
                });
        //----
  /*    bootbox.confirm("Are you sure?", function(result) {   
  if (result) {
      bootbox.hideAll();
      confirm_order("#form","#save","#resultbox","<?php echo site_url('frontpage/add_order_tid') ?>","<?php echo site_url('frontpage/order_list') ?>","<html><img src='<?php echo base_url('mythings/loader/ajax-loader.gif') ?>' class='img-rounded'></html>"); //"no_redirect"  
      return false;
  };

}); */
    }
      
    }); 
});

</script>

<script type="text/javascript">
//<html><img src='http://localhost:8090/resturant/mythings/loader/ajax-loader.gif' class='img-rounded'></html>

      function showd($url){
            var row = $('#dg').datagrid('getSelected');
            $("#details").html();   
            if (row){                                   
                        $.post($url,{id:row.id},function(result){
                            if (result.success){
                               // $('#dg').datagrid('reload');    // reload the user data                                
                               
                                 $("#details").html(result.msg);  
                                 $('#myModal_d').modal('show')                         
                            } else {
                                /*$.messager.show({   // show error message
                                    title: 'Error',
                                    msg: result.msg
                                });*/
                                topRight(result.msg);
                            }
                        },'json');                    
               
            }else{ 
            //  slide("","Please Select one Row to View!");
            topRight("","Please Select one Row to View!");
            }
        }
  

   function refresh_($dg){                               
               //$('#dg').datagrid('clearSelections');                
               //$('#dg').edatagrid('cancelRow');   
               $($dg).datagrid('reload');    // reload the user data   
               $("#details").html("");       
            }

  $(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {          
          //saveUser();
          return false;
    }
});
</script>

<script type="text/javascript">
        var url;
        function newUser($url){
            //$('#dlg').dialog('open').dialog('setTitle','Add New');
            $('#myModal').modal('show')
            $('#fm').form('clear');
            url = $url;
        }
        function editUser($url){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                //$('#dlg').dialog('open').dialog('setTitle','Edit User');
                $('#myModal').modal('show')
                $('#fm').form('load',row);
                url = $url+'/'+row.id;
            }else{ 
            //  slide("","Please Select one Row to Edit!");
            topRight("","Please Select one Row to Edit!");

            }
        }
        function saveUser(){    
        $('#myModal').modal('hide');     
          //bootbox.dialog($ld);
          //$.messager.show({title: '',msg: $ld});
          //topRight("",$ld);
          //$.messager.show({timeout:0,title: 'Please waite ...',msg: $ld });           

            $('#fm').form('submit',{
                url: url,
                type: 'GET',            
                onSubmit: function(){                                   
                    return $(this).form('validate');                     
                },                   
                complete: function(){
                    //bootbox.hideAll();
                                  },                                          
                success: function(result){
                  //bootbox.hideAll();
                    var result = eval('('+result+')');
                    if (result.msg){                      
                       // $('#dlg').dialog('close');      // close the dialog
                      $('#dg').datagrid('reload');    // reload the user data
                       topRight("",result.msg)
                       send_email(result.oid);
                    } else {
                      topRight("Error!",result.msg);
                    }
                }
            });
        }
function send_email($oid){
  try
  {
    var jqxhr = $.ajax('<?php echo site_url("frontpage/sendemail") ;?>/'+$oid)
    .done(function() {})
    .fail(function() {});            
//   alert($oid);
  }
catch(err)
  {
  
  }

}
function removeUser($url){
          
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to remove this Recored ?row:['+row.id+']',function(r){
                    if (r){            
                    var person = {id: row.id}                        
                              $.ajax(
                              {
                                  type:"POST",
                                  beforeSend: function ()
                                  {
                                   //$.messager.show({title: 'Deleteing ...',msg: $ld });                                   
                                    //bootbox.dialog($ld);
                                  //$.messager.show({title: 'Loading...',msg: $ld});
                                  //topRight("",$ld);
                                  },
                                  url: $url,
                                  dataType: 'json',
                                  data:  person,                                  
                                  success: function(result)
                                  {
                                    //bootbox.hideAll();
                                        $('#dg').datagrid('reload');    // reload the user data
                                       topRight("",result.msg);
                                  },
                                  complete: function(){
                                  //bootbox.hideAll();
                                  },
                                  error:function(result){
                                    //bootbox.hideAll();
                                     topRight("Error!",result.msg);
                                  }
                              });
                    }
                });
            }else{ 
            //  slide("","Please Select one Row to Delete!");
            topRight("","Please Select one Row to Delete!");
            }
        }


   function removeUser_($url){
          
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to remove row:['+row.id+']?',function(r){
                    if (r){                                    
//                 $.messager.show({title: 'Deleteing ...',msg: $ld });

                        $.post($url,{id:row.id},function(result){                          
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                                 $.messager.show({
                            title: 'success',
                            msg: result.msg
                        });
                            } else {
                                $.messager.show({   // show error message
                                    title: 'Error',
                                    msg: result.msg
                                });
                            }
                        },'json');
                    }
                });
            }else{ 
            //  slide("","Please Select one Row to Delete!");
            topCenter("Please Select one Row to Delete !");
            }
        }


         function delall($url){
                $.messager.confirm('Confirm','Are you sure you want to remove all ?',function(r){
                    if (r){
                        $.post($url,function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                        topRight("",result.msg);
                            } else {
                                topRight("Error!",result.msg);
                            }
                        },'json');
                    }
                });
            }

         function cancelall(){
               $('#dg').datagrid('clearSelections');            
               $('#dg').edatagrid('cancelRow');   
              
            }

            function refresh($dg){                               
               //$('#dg').datagrid('clearSelections');                
               //$('#dg').edatagrid('cancelRow');   
               $($dg).datagrid('reload');    // reload the user data   

            }

          function getData(){  
            var rows = [];  
            for(var i=1; i<=800; i++){  
                var amount = Math.floor(Math.random()*1000);  
                var price = Math.floor(Math.random()*1000);  
                rows.push({  
                    inv: 'Inv No '+i,  
                    date: $.fn.datebox.defaults.formatter(new Date()),  
                    name: 'Name '+i,  
                    amount: amount,  
                    price: price,  
                    cost: amount*price,  
                    note: 'Note '+i  
                });  
            }  
            return rows;  
        }  
          
        function pagerFilter(data){  
            if (typeof data.length == 'number' && typeof data.splice == 'function'){    // is array  
                data = {  
                    total: data.length,  
                    rows: data  
                }  
            }  
            var dg = $(this);  
            var opts = dg.datagrid('options');  
            var pager = dg.datagrid('getPager');  
            pager.pagination({  
                onSelectPage:function(pageNum, pageSize){  
                    opts.pageNumber = pageNum;  
                    opts.pageSize = pageSize;  
                    pager.pagination('refresh',{  
                        pageNumber:pageNum,  
                        pageSize:pageSize  
                    });  
                    dg.datagrid('loadData',data);  
                }  
            });  
            if (!data.originalRows){  
                data.originalRows = (data.rows);  
            }  
            var start = (opts.pageNumber-1)*parseInt(opts.pageSize);  
            var end = start + parseInt(opts.pageSize);  
            data.rows = (data.originalRows.slice(start, end));  
            return data;  
        }  
          

          function show($t,$msg){  
            $.messager.show({  
                title:$t,  
                msg:$msg,  
                showType:'show'  
            });  
        }  
        function slide($t,$msg){  
            $.messager.show({  
                title:$t,  
                msg:$msg,  
                timeout:4000,  
                showType:'slide'  
            });  
        }  
        function fade($t,$msg){  
            $.messager.show({  
                title:$t,  
                msg:$msg,  
                timeout:4000,  
                showType:'fade'  
            });  
        }  
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
    function topCenter($tl,$msg){
      $.messager.show({
        title:'',
        msg:$msg,
        showType:'slide',
        style:{
          right:'',
          top:document.body.scrollTop+document.documentElement.scrollTop,
          bottom:''
        }
      });
    }

</script>
