<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

  public function testp(){
          //$this->load->view('include/header_lib');
      $this->load->view('myforms/testp'); 

  }

  public function is_ok(){
    if($this->session->userdata('username')){
          return true;
      } else {
          return false;
      }    
  }
  public function load_page($pg){
    //$this->load->view($pg); 
    echo "TEST_".$page;
  }

public function main()
{
     $data['username'] = $this->session->userdata('username');       
      $this->load->view('include/header_lib');
      $this->load->view('myforms/main',$data); 
}

public function tbl()
{
   //$this->load->view('include/header_lib');
   //$data['header_page']=site_url('frontpage/header_admin');
   $this->load->view('myforms/tbl');   
}

  public function admin()
  {
      $this->load->view('include/header_admin');         
      $this->load->view('include/footer');
  }
 
    public function index()
  {  

    $this->db->delete('order_details', array('userid' => $this->session->userdata('username'),'status'=>'new'));     
    $this->session->sess_destroy();
    
    $this->load->view('include/header_lib');      
    $this->load->view('myforms/main');              
      
  }

public function advert_page()
  {         
      $query = $this->db->get('advert');    
      $data['query']=$query;
      //$this->load->view('include/header_lib');            
      $this->load->view('myforms/advert',$data);              
  }  

  public function rest_page()
  {         
    $dv=isset($_POST['dv']) ? strval($_POST['dv']) : 'all';
    $sort=isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
    $order =isset($_POST['order']) ? strval($_POST['order']) : 'desc';
    $query; 
    //echo $dv;  
    //echo $sort;
        
      if ($dv =="all") {      
      $q="select * from rest order by $sort $order";        
      $query = $this->db->query($q); 
      }
      if ($dv =="no") {          
         
          $q="select * from rest where delivery='no' order by $sort $order";        
          $query = $this->db->query($q);
      }
      if ($dv =="yes") {                  
          $q="select * from rest where delivery='yes' order by $sort $order";        
          $query = $this->db->query($q);
      }    
    /*  else {
        $query = $this->db->get('rest');

      }*/    
      //$query = $this->db->get('rest');
     $data['query']=$query;
     //$this->load->view('include/header_lib');            
     $this->load->view('myforms/rest',$data);              
  }  

  public function login_ok()
  {          
      $data['username'] = $this->session->userdata('username'); 
      //$data['advert'] = site_url('frontpage/advert_page');
      //$this->load->view('include/header_lib');
      $this->load->view('myforms/main',$data);      
      
  }

  public function food($group)
  {
      
        # code...
      $query = $this->db->get_where('food', array('group' => $group));         
      $data['query'] = $query;       
      $this->load->view('myforms/mainpage',$data);                   
      
  }

   public function new_order()
  {
//    if ($this->is_ok()) {
      # code...
    //$id=2;
    $id=$_POST['id'];

    $this->db->where('rest_id', $id);    
    $groups = $this->db->get('food_group');

    $data['groups']=$groups;


    $query =array(500);
    $i=1;
    foreach ($groups->result() as $row)
    {
      //echo $row->name; 
      $query[$i] = $this->db->get_where('food', array('group' => $row->id,'rest_id'=>$id));
      //echo "Q$i:".$query[$i]->num_rows();
      //echo "<br>";
      $i=$i+1;
    }

      $data['query'] = $query;
      $data['username'] = $this->session->userdata('username'); 

      $data['checkoutpage'] = site_url('frontpage/order_detail_list');
      $data['add_order_url'] = site_url('frontpage/add_order');
      $data['delurl'] =site_url('frontpage/delete/order_details');

      $data['rest_name'] = $this->getw_id("rest","id",$id,"name");

      //$this->load->view('include/header_lib');
      $this->load->view('myforms/mainpage',$data);      
      //$this->load->view('include/footer');
  //  } else {
      //echo "<h1 class='well'>Please Login in First !";
     // echo "<h1 class='well'>Please Login in First ! Click <a href='index'>Here</a> to Login.";
   // }
        
  }

public function add_order($fid){
  //sleep(2);
if ($this->is_ok()==false) {
  echo json_encode(array('msg'=>'Kindly, Login in First'));  
} else {
  # code...
  $food=$this->getw_id("food","id",$fid,"name");
  $price=$this->getw_id("food","id",$fid,"price");

         $data = array(
         'food' => $food,
         'amount' => $price,         
         'userid' => $this->session->userdata('username'),
         'status' => 'new');

    $x =$this->db->insert('order_details', $data);  
    if ($x) {
      echo json_encode(array('msg'=>'Added to Your Cart!'));  
    } else {
      echo json_encode(array('msg'=>'Fail.!'));  
    }
    
    //echo json_encode(array('msg'=>'Done!'));  
    //echo "okok";
  }
}

public function add_order_tid(){
  if ($this->is_ok()==false) {
  echo json_encode(array('msg'=>'Login First Please.!')); 
  }
  else
  {
    $email=$this->session->userdata('username');  
  //----get amount total
  $amount = $this->get_amount($email);
  //--------------------  
  $dt = $this->get_user_info($email,$amount);  
    $x= $this->db->insert('orders', $dt); 
    if ($x) {
          //sleep (1);
        $query = $this->db->query("select max(id) as ID from orders where email='$email' and status='new'");      
        $tid=0;
          foreach ($query->result() as $row)
          {
              $tid=$row->ID;
          } 

          $data = array(
                   'tid' => $tid,
                   'status' => 'processed'               
                );

          //$this->db->where('userid', $email,'status','new');
          $array = array('userid' => $email, 'status' => 'new');
          $this->db->where($array); 
          $x= $this->db->update('order_details', $data); 
          if ($x) {
           echo json_encode(array('msg'=>'Success!','url'=>site_url('frontpage/login_ok')));
           //$this->sendemail("sudane@gmail.com","You have Order the follow Stuff !");
          } else {
            # code...
            echo json_encode(array('msg'=>'Fail.!'));  
          }
          

    } else {
      echo json_encode(array('msg'=>'Fail.!'));  
    }
  }    
}

public function get_amount($email){
$query = $this->db->query("select sum(amount) as amount from order_details where userid='$email' and status='new'");      
    $amount=0;
      foreach ($query->result() as $row)
      {
          $amount = $row->amount;
      } 
      return $amount;
}

public function get_user_info($email,$amount){
  $query = $this->db->get_where('users', array('email' => $email));
  
    foreach ($query->result() as $row)
    {
         $dt = array(
         'username' => $row->name,
         'mobile' => $row->mobile ,
         'email' => $row->email,
         'amount' => $amount,
         'status' => 'new');
    }

    return $dt;
}

public function check_login(){
    //$this->session->set_userdata('usertype', "null");
    //$this->session->set_userdata('username', "null");
  //$this->session->sess_destroy();



    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'PassWord', 'required');
    

    if ($this->form_validation->run() == FALSE)
    {
      echo  json_encode(array('msg'=>validation_errors()));
    }
    else
    {
      //$data = array('cardnumber' => $_POST['username'] ,'status' => 'free');
      $u = $_POST['email'];      
      $p = $_POST['password'];     
      
      $query = $this->db->query("select * from users where email='$u' and password='$p'");      
      if ($query->num_rows() > 0) {   

         $this->session->set_userdata('userid',  $this->getw_id("users","email",$u,"id"));
         $this->session->set_userdata('username', $u);              

          echo json_encode(array('msg'=>'success','username'=>$u,'url'=>site_url('frontpage/main')));
      } else {         
          echo json_encode(array('msg'=>'Check UserName and PassWord','url'=>''));                                
    }  
  }
}

public function add_food(){      
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Food Name', 'required');
    $this->form_validation->set_rules('price', 'Price', 'required');
    $this->form_validation->set_rules('group', 'Group Name', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      //echo  validation_errors();
      echo json_encode(array('msg'=>validation_errors()));
    }
    else
    {      
                         
    $name = $_POST['name'];          
      $query = $this->db->query("select * from food where name='$name'");      
      if ($query->num_rows() > 0) {
         //echo "Food already exists! ..";
          echo json_encode(array('msg'=>'Food already exists! ..'));
      } else {
          $this->db->insert('food', $_POST);
         //echo "Food successfuly Registered..!";  
         echo json_encode(array('msg'=>'Food successfuly Registered..!'));

      } 
  }
}
public function add_feedback(){      
  //sleep(2);
   $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('feedback', 'FeedBack', 'required');    
    
    if ($this->form_validation->run() == FALSE)
    {
      echo  json_encode(array('msg'=>validation_errors()));
    }
    else
    {
         $this->db->insert('feedback', $_POST);
         echo  json_encode(array('msg'=>'Feedback successfuly Registered..!'));
         
  }
}

public function update_comment(){      
  //sleep(2);
       $data = array(
               'comments' => $_POST['comments']        
            );

      $this->db->where('id', $_POST['id']);
      $this->db->update('orders', $data);
      echo  json_encode(array('msg'=>'Comment successfuly Registered..!'));  
}


public function add_user(){      
   $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'required|max_length[20]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      echo  json_encode(array('msg'=>validation_errors()));
    }
    else
    {
      
      $email = $_POST['email'];          
      $pass = $_POST['password'];  
      $query = $this->db->query("select * from users where email='$email'");      
      if ($query->num_rows() > 0) {
        echo  json_encode(array('msg'=>'User already exists! ..'));
         //echo "User already exists! ..";
      } else {
          $this->db->insert('users', $_POST);
          echo  json_encode(array('msg'=>'User successfuly Registered..!'));
         //echo "User successfuly Registered..!";            
      }    
  }
}

//------------------------FORMS-------------------------------------------

   public function login_form(){
      //$this->session->set_userdata('pagename', 'login Page');          
      //$data['pagename'] = "Login Page";
      $fields = array(
        array('label' => "Email",'input' => "<input class='form-control' type='text' id='email' name='email' autofocus/>"),
        array('label' => "Password",'input' => "<input class='form-control' type='password' id='password' name='password'/>"),          
        );
       $buttons = array(        
        //array('btn' => "<a href='' class='btn btn-danger'> Close <i class='icon-ban-circle'></i></a>"),
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Login Submit</button>"),
        array('btn' => "<button id='clear' class='btn btn-warning' onclick='clear_()'>Clear</button>"),
        );

      $data['fields'] = $fields;
      $data['buttons'] = $buttons;

      $data['save_url'] = site_url('frontpage/check_login');      
      $data['button_name'] = "Login";
      $data['advert'] = site_url('frontpage/advert_page');
      $data['form_name'] = "Login Form!";

      //$this->load->view('include/header_lib');  
      $this->load->view('myforms/frm',$data);
      //$this->load->view('include/footer');
   }

public function advert_form(){
  
      $fields = array(
        array('label' => "Image URL",'input' => "<input class='form-control' type='text' id='url' name='url' autofocus/>"),
        array('label' => "Image Lable",'input' => "<input class='form-control' type='text' id='name' name='name'/>"),       
        array('label' => "Image Description",'input' => "<input class='form-control' type='text' id='desc' name='desc' autofocus/>"),   
        );
       $buttons = array(                
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Save Advert</button>"),
        array('btn' => "<button id='clear' class='btn btn-warning' onclick='clear_()'>Clear</button>"),
        );

      $data['fields'] = $fields;
      $data['buttons'] = $buttons;
      
      $data['save_url'] = site_url('frontpage/add_/advert');    
      $data['button_name'] = "Save_Advert";
      $data['advert'] = site_url('frontpage/advert_page');

      $this->load->view('include/header_admin');  
      $this->load->view('myforms/form',$data);
      $this->load->view('include/footer');
   }

   public function register_form(){      
    //sleep(1);
      // $this->session->set_userdata('pagename', 'Register Page');    
      //$data['table_name'] = "Register Form";
      $data['pagename'] = "Register Form";
     
        $fields = array(
        array('label' => "Name",'input' => "<input class='form-control' type='text' id='name' name='name' autofocus/>"),
        array('label' => "Email",'input' => "<input class='form-control' type='text' id='email' name='email'/>"),
        array('label' => "Mobile",'input' => "<input class='form-control' type='text' id='mobile' name='mobile'/>"),
        array('label' => "Password",'input' => "<input class='form-control' type='password' id='password' name='password'/>"),        
        );
       $buttons = array(                
        //array('btn' => "<a href='' class='btn btn-danger icon-ban-circle'> Close</a>"),
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Register</button>"),
        array('btn' => "<button class='btn btn-warning' onclick='clear_()'>Clear</button>"),
        );



//------------------



//------------------       
      $data['fields'] = $fields;
      $data['buttons'] = $buttons;


      $data['save_url'] = site_url('frontpage/add_user');            
      $data['advert'] = site_url('frontpage/advert_page');
      $data['form_name'] = "Register Form!";

     // $this->load->view('include/header_lib');  
      $this->load->view('myforms/frm',$data);
      //$this->load->view('include/footer');
   }
   

public function create_food_form(){
      $this->load->view('include/header_admin');            
      $options=$this->get_options("food_group","name");
      $rest_ids=$this->get_options("rest","id");
      $rests=$this->get_options("rest","name");
      $imgs=$this->get_options("img","name");
            
       $fields = array(
        array('label' => "Name",'input' => "<input class='form-control' type='text' id='name' name='name' autofocus/>"),
        array('label' => 'Description','input' => "<input class='form-control' type='text' id='desc' name='desc'/>"),
        array('label' => 'Price','input' => "<input class='form-control' type='text' id='price' name='price'/>"),
        array('label' => 'Image Url','input' => "<input class='form-control' type='text' id='url' name='url'/>"),
        //array('label' => 'Image Url','input' => "<input class='form-control' type='file' id='url' name='url'/>"),
        //array('label' => 'Images','input' => "<select style='width: 500px' id ='url' name='url' class='selectpicker'> $imgs </select> "), 
        array('label' => 'Resturant','input' => "<select style='width:30%;' id ='rest_id' name='rest_id' class='selectpicker'> $rests </select> "),                  
        array('label' => 'Group','input' => "<select style='width:30%;' id ='group' name='group' class='selectpicker'> $options </select> "),                  
        );

       $buttons = array(
        //array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),
        array('btn' => "<button id='save' class='btn' onclick='saveForm()'>Save Food</button>"),
        array('btn' => "<button id='clear' class='btn btn-warning' onclick='clear_()'>Clear</button>"),
        );
 
      $data['fields'] = $fields;
      $data['buttons'] = $buttons;
      $data['save_url'] = site_url('frontpage/add_food');
      $data['rd_url'] = "no_redirect";
      $data['advert'] = site_url('frontpage/advert_page');
      $data['form_name']="Create Food Form";
      $this->load->view('myforms/frm',$data);
      $this->load->view('include/footer');
   }

public function create_rest_form(){
      $this->load->view('include/header_admin');            
     // $options=$this->get_options("food_group","name");
     // $rest_ids=$this->get_options("rest","id");
      //$rests=$this->get_options("rest","name");
      //$imgs=$this->get_options("img","name");
            
       $fields = array(
        array('label' => "Name",'input' => "<input class='form-control' type='text' id='name' name='name' autofocus/>"),
        array('label' => 'Address','input' => "<input class='form-control' type='text' id='address' name='address'/>"),
        array('label' => 'Phone','input' => "<input class='form-control' type='text' id='phone' name='phone'/>"),
        array('label' => 'FoodType','input' => "<input class='form-control' type='text' id='food_type' name='food_type'/>"),
        array('label' => 'Delivery','input' => "<input class='form-control' type='text' id='delivery' name='delivery' value='yes'/>"),
        array('label' => 'Delivery Cost','input' => "<input class='form-control' type='text' id='delivery_cost' name='delivery_cost' value='free'/>"),
        array('label' => 'Image Url','input' => "<input class='form-control' type='text' id='url' name='url'/>"),
        //array('label' => 'Image Url','input' => "<input class='form-control' type='file' id='url' name='url'/>"),
        //array('label' => 'Images','input' => "<select style='width: 500px' id ='url' name='url' class='selectpicker'> $imgs </select> "), 
        //array('label' => 'Resturant','input' => "<select style='width:30%;' id ='rest_id' name='rest_id' class='selectpicker'> $rests </select> "),                  
        //array('label' => 'Group','input' => "<select style='width:30%;' id ='group' name='group' class='selectpicker'> $options </select> "),                  
        );

       $buttons = array(
        //array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),
        array('btn' => "<button id='save' class='btn' onclick='saveForm()'>Save Resturant</button>"),
        array('btn' => "<button id='clear' class='btn btn-warning' onclick='clear_()'>Clear</button>"),
        );
 
      $data['fields'] = $fields;
      $data['buttons'] = $buttons;
      $data['save_url'] = site_url('frontpage/add/rest');
      $data['rd_url'] = "no_redirect";
      $data['advert'] = site_url('frontpage/advert_page');
      $data['form_name']="Create rest Form";
      $this->load->view('myforms/frm',$data);
      $this->load->view('include/footer');
   }

 public function feedback_form(){      
           
        $fields = array(
        array('label' => "Name",'input' => "<input class='form-control' type='text' id='name' name='name' autofocus/>"),
        array('label' => "Comments",'input' => "<textarea rows='3' name='feedback'></textarea> ")
        );
//array('label' => "Feedback",'input' => "<input class='form-control' type='text' id='feedback' name='feedback'/>"),
        

       $buttons = array(        
        //array('btn' => "<a href='' class='btn btn-danger icon-ban-circle' > Close</a>"),
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Feedback Submit</button>"),
        array('btn' => "<button id='clear' class='btn btn-warning' onclick='clear_()'>Clear</button>")
        );

      $data['fields'] = $fields;
      $data['buttons'] = $buttons;

      $data['save_url'] = site_url('frontpage/add_feedback');
      $data['advert'] = site_url('frontpage/advert_page');


      //$data['button_name'] = "Submit.";
      //$this->load->view('include/header_1');  
      $this->load->view('myforms/frm',$data);
      //$this->load->view('include/footer');
   }

//--------------LIST STUFF--------------------------------------------------------------

 public function food_list()
   {
      
      $data['table_name'] = "Foods";

      
      $data['geturl'] = site_url('frontpage/get/food');
      $data['addurl'] = site_url('frontpage/add_food');
      $data['delurl'] = site_url('frontpage/delete/food');
      $data['updurl'] = site_url('frontpage/update/food');
      $data['table_header'] = array("id"=>"ID","name"=>"Food Name","desc"=>"Food Description","price"=>"Price","url"=>"Image Url","group"=>"Group","rest_id"=>"Resturant ID");      
      //$data['form_header'] = array("name"=>"Food Name","desc"=>"Food Description","price"=>"Price","url"=>"Image Url","group"=>"Group");      
      $options=$this->get_options("food_group","name");

      $data['form_header'] = array(
        "Food Name"=>"<input class='span3 easyui-validatebox' name='name' type='text' required> ",
        "Description"=>"<input class='span3 easyui-validatebox' name='desc' type='text' required> ",
        "Price"=>"<input class='span3 easyui-validatebox' name='price' type='text' required> ",
        "Image URL"=>"<input class='span3 easyui-validatebox' name='url' type='text' required> ",
        "Food Group"=>"<select id ='group' name='group' class='selectpicker' > $options </select> "
        );    

      $delurl=site_url('frontpage/delete/food');
      $delall=site_url('frontpage/delall/food');
      $updurl=site_url('frontpage/update/food');
      $addurl=site_url('frontpage/add/food');
       
        $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "), 
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),    
        //array('btn' => "<button   class='btn btn-danger icon-trash' onclick=delall('$delall')> Delete All</button>"),            
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        //array('btn' => "<button   id='showd' class='btn btn-success  icon-ok-sign'> Show Order Details</button>"),
        //array('btn' => "<a href='#' class='easyui-linkbutton'  plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );    

      $data['buttons']=$buttons;
      $data['hideColumn']="id";    
      
      $this->load->view('include/header_admin',$data);  
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }
public function advert_list()
   {

    $data['hideColumn']="id";      
      $data['table_name'] = "Advert list";
      $data['geturl'] = site_url('frontpage/get/advert');
      $data['addurl'] = site_url('frontpage/add/advert');
      $data['delurl'] = site_url('frontpage/delete/advert');
      $data['updurl'] = site_url('frontpage/update/advert');
      $data['table_header'] = array("id"=>"ID","name"=>"Food Name","desc"=>"Food Description","url"=>"Image Url");      
      //$data['form_header'] = array("name"=>"Food Name","desc"=>"Food Description","price"=>"Price","url"=>"Image Url","group"=>"Group");      
      //$options=$this->get_options("food_group","name");
      $imgs=$this->get_options("img","name");
      $data['form_header'] = array(
        //"URL"=>"<input class='span3 easyui-validatebox' name='url' type='text'> ",
        "Image URL" =>"<select style='width: 500px'  id ='url' name='url' class='selectpicker'> $imgs </select> ",
        "Image Name"=>"<input class='span3 easyui-validatebox' name='name' type='text' required> ",
        "Image Description"=>"<input class='span3 easyui-validatebox' name='desc' type='text' required> ",        
        );    

      $delurl=site_url('frontpage/delete/advert');
      $delall=site_url('frontpage/empty_table/advert');
      $updurl=site_url('frontpage/update/advert');
      $addurl=site_url('frontpage/add/advert');
       
        $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "), 
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),    
        array('btn' => "<button   class='btn' onclick=delall('$delall')> Delete All</button>"),            
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        //array('btn' => "<button   id='showd' class='btn btn-success  icon-ok-sign'> Show Order Details</button>"),
        array('btn' => "<a href='#' class='easyui-linkbutton' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );    

      $data['buttons']=$buttons;
      $data['hideColumn']="id";   
      
      $this->load->view('include/header_admin',$data);  
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }


    public function order_detail_list()
   {
      
      $data['table_name'] = "Cart View";
      $data['geturl'] = site_url('frontpage/get/order_details');
      $data['addurl'] = site_url('frontpage/add/order_details');
      $data['delurl'] = site_url('frontpage/delete/order_details');
      $data['delall'] = site_url('frontpage/delall/order_details');
      $data['updurl'] = site_url('frontpage/update/order_details');
      $data['table_header'] =  array("id"=>"ID","food"=>"Food","amount"=>"Amount","userid"=>"Email","status"=>"Status","tid" =>"Transaction ID");            
      $data['form_header'] = array("Email"=>"<input class='span3 easyui-validatebox' name='userid' type='text'> "); 
      
      $data['username'] = $this->session->userdata('username'); 
      $data['order'] = "";
      $data['pagename'] = "Current Order Detail";

      $delurl=site_url('frontpage/delete/order_details');
      $delall=site_url('frontpage/delall/order_details');

        $buttons = array(        
        array('btn' => "<a href='login_ok' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),
        array('btn' => "<button   class='btn' onclick=delall('$delall')> Delete All</button>"),
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        array('btn' => "<button   id='confirm' class='btn'>Confirm Order</button>"),
        );
      

      $data['buttons']=$buttons;
      $data['hideColumn']="id";
      
      //$this->load->view('include/header_2',$data);  
     // $this->load->view('include/header_lib');  
      $this->load->view('myforms/grid_view_order_details',$data);
      //$this->load->view('include/footer');
   }

public function rest_list()
   {
      $options=$this->get_options("rest","name");
      $data['table_name'] = "Resturant list";
      $data['geturl'] = site_url('frontpage/get/rest');
      $data['addurl'] = site_url('frontpage/add/rest');
      $data['delurl'] = site_url('frontpage/delete/rest');
      $data['updurl'] = site_url('frontpage/update/rest');
      $data['table_header'] =  array("id"=>"RESTURANT ID",
        "name"=>"Rest Name",
        "address"=>"Address",
        "phone"=>"Phone",
        "food_type"=>"Food Type",
        "delivery"=>"Delivery",
        "delivery_cost"=>"Delivery Cost",
        "url"=>"url");              
      $data['form_header'] = array(
        "Resturant Name"=> "<input class='span3 easyui-validatebox' name='name' type='text'>",
        "Resturant Address"=> "<input class='span3 easyui-validatebox' name='address' type='text'>",
        "Resturant phone"=> "<input class='span3 easyui-validatebox' name='phone' type='text'>",
        "Resturant Food Type"=> "<input class='span3 easyui-validatebox' name='food_type' type='text'>",
        "Resturant Delivery(yes/no)"=> "<input class='span3 easyui-validatebox' name='delivery' type='text'>",
        "Resturant Delivery Cost (free) default"=> "<input class='span3 easyui-validatebox' name='delivery_cost' type='text'>",
        "Resturant Logo URL"=> "<input class='span3 easyui-validatebox' name='url' type='text'>",
        );   

      $updurl= site_url('frontpage/update/rest');
      $delurl= site_url('frontpage/delete/rest');
      $addurl= site_url('frontpage/add/rest');
      $data['hideColumn']="url";


      $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "),         
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
       // array('btn' => "<button   class='btn btn-success  icon-ok-sign' onclick=showd('$detailurl')>Show Order Details</button>"),
        //        array('btn' => "<a href='#' class='easyui-linkbutton' iconCls='icon-add' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      
      
      
      $data['buttons'] = $buttons;

      
      $this->load->view('include/header_admin',$data);  
      //$this->load->view('myforms/grid_view_order',$data);      
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }
    

public function menu_list()
   {
      $options=$this->get_options("rest","name");
      $data['table_name'] = "Menu list";
      $data['geturl'] = site_url('frontpage/get/food_group');
      $data['addurl'] = site_url('frontpage/add/food_group');
      $data['delurl'] = site_url('frontpage/delete/food_group');
      $data['updurl'] = site_url('frontpage/update/food_group');
      $data['table_header'] =  array("id"=>"ID","name"=>"Menu list","rest_id"=>"ResturantID");              
      $data['form_header'] = array(
        "Menu Name"=> "<input class='span3 easyui-validatebox' name='name' type='text'>",
        "Resturant Name"=> "<select style='width:30%;' id ='rest_id' name='rest_id' class='selectpicker'> $options </select> ");   

      $updurl= site_url('frontpage/update/food_group');
      $delurl= site_url('frontpage/delete/food_group');
      $addurl= site_url('frontpage/add/food_group');
      $data['hideColumn']="id";


      $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "),         
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
       // array('btn' => "<button   class='btn btn-success  icon-ok-sign' onclick=showd('$detailurl')>Show Order Details</button>"),
        array('btn' => "<a href='#' class='easyui-linkbutton' iconCls='icon-add' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      
      
      
      $data['buttons'] = $buttons;

      
      $this->load->view('include/header_admin',$data);  
      //$this->load->view('myforms/grid_view_order',$data);      
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }

   public function order_list()
   {
      
      $data['table_name'] = "Orders History";
      $data['geturl'] = site_url('frontpage/get/orders');
      $data['addurl'] = site_url('frontpage/add/orders');
      $data['delurl'] = site_url('frontpage/delete/orders');
      $data['updurl'] = site_url('frontpage/update/orders');
      $data['table_header'] =  array("id"=>"ID","username"=>"Customer Name","mobile"=>"Mobile","email"=>"Email","amount"=>"Amount$","comments"=>"Comments","status"=>"Order Status","date" => "Date");      

      //echo "<th sortable='true' width='30' field=$k>$v</th>";
      //$data['form_header'] = array("comments"=>"Comment");      
      $data['form_header'] = array(
        "Comments"=> "<textarea name='comments'></textarea>");   
//"Status" =>"<select name='order_status' class='selectpicker'> <option>new</option> <option>Under Process</option> <option>Finished</option> <option>Canceled</option> </select>  " );   
      $updurl= site_url('frontpage/update/orders');

      $detailurl= site_url('frontpage/admin_show_details');

      $buttons = array(        
        array('btn' => "<a href='' class='btn btn-danger'> Close</a>"),        
        //array('btn' => "<button   class='btn btn-warning icon-trash' onclick=removeUser('$delurl')> Delete</button>"),
        array('btn' => "<button   class='btn btn-warning' onclick=editUser('$updurl')> Edit</button> "),         
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        array('btn' => "<button   class='btn btn-success' onclick=showd('$detailurl')>Show Order Details</button>"),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      $data['buttons'] = $buttons;
      $data['hideColumn']="id";
  
      
      //$this->load->view('include/header_lib');  
      //$this->load->view('myforms/grid_view_order',$data);      
      $this->load->view('myforms/grid_view_order_details',$data);
      //$this->load->view('include/footer');
   }

public function admin_order_list()
   {
      $data['table_name'] = "All Orders";

      $data['geturl'] = site_url('frontpage/get/admin');
      $data['addurl'] = site_url('frontpage/add/orders');
      $data['delurl'] = site_url('frontpage/delete/orders');
      $data['updurl'] = site_url('frontpage/update/orders');
      $data['table_header'] =  array("id"=>"ID","username"=>"Customer Name","mobile"=>"Mobile","email"=>"Email","amount"=>"Amount$","comments"=>"Comments","status"=>"Order Status","date" => "Date");      
      //$data['form_header'] = array("comments"=>"Comment");      
      $data['form_header'] = array(
        "Comments"=> "<textarea name='comments'></textarea>",
        "Status" =>"<select name='status' class='selectpicker'> <option>new</option> <option>Under Process</option> <option>Finished</option> <option>Canceled</option> </select>  " );   
      $updurl= site_url('frontpage/update/orders');
      $detailurl= site_url('frontpage/admin_show_details');

      $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        //array('btn' => "<button   class='btn btn-warning icon-trash' onclick=removeUser('$delurl')> Delete</button>"),
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "),         
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        array('btn' => "<button   class='btn' onclick=showd('$detailurl')>Show Order Details</button>"),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      $data['username'] = $this->session->userdata('username'); 
      $data['order'] = "";
      $data['pagename'] = "Orders History";
      $data['buttons'] = $buttons;

      
      $this->load->view('include/header_admin');  
      //$this->load->view('myforms/grid_view_order',$data);      
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
      
   }
   public function feedback_list()
   {
      $data['hideColumn']="id";
      $data['table_name'] = "Feedback";
      $data['geturl'] = site_url('frontpage/get/feedback');
      $data['addurl'] = site_url('frontpage/add/feedback');
      $data['delurl'] = site_url('frontpage/delete/feedback');
      $data['updurl'] = site_url('frontpage/update/feedback');
      $data['table_header'] =  array("id"=>"ID","name"=>"UserName","feedback"=>"Feedback","date"=>"Action Date");      
      $data['form_header'] = array("Name"=>"<input class='span3 easyui-validatebox' name='name' type='text'> ","Comments"=> "<input class='span3 easyui-validatebox' name='feedback' type='text'> "); 

      $addurl=site_url('frontpage/add/feedback');
      $updurl="";
      $delurl="";
      $delall=site_url('frontpage/empty_table/feedback');

      
        $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        //array('btn' => "<button   class='btn btn-warning icon-folder-open' onclick=editUser('$updurl')> Edit</button> "), 
        //array('btn' => "<button   class='btn btn-inverse icon-trash' onclick=removeUser('$delurl')> Delete</button>"),    
        //array('btn' => "<button   class='btn btn-danger icon-trash' onclick=delall('$delall')> Delete All</button>"),            
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        //array('btn' => "<button   id='showd' class='btn btn-success  icon-ok-sign'> Show Order Details</button>"),
        //array('btn' => "<a href='#' class='easyui-linkbutton' iconCls='icon-add' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      //$data['username'] = $this->session->userdata('username'); 
      $data['order'] = "";
      $data['pagename'] = "FeedBack List";
      $data['buttons'] = $buttons;

      
      $this->load->view('include/header_admin',$data);          
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }

    public function img_list()
   {
      $data['hideColumn']="id";
      $data['table_name'] = "Images";
      $data['geturl'] = site_url('frontpage/get/img');      
      //$data['delurl'] = site_url('frontpage/delete/img');
      
      $data['table_header'] =  array("id"=>"ID","name"=>"IMG Name");      
      $data['form_header'] = array("Name"=>"<input class='span3 easyui-validatebox' name='name' type='text'> ","Comments"=> "<input class='span3 easyui-validatebox' name='feedback' type='text'> "); 

      $addurl="";
      $updurl="";
      $delurl=site_url('frontpage/delete/img');
      $delall="";

      
        $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        //array('btn' => "<button   class='btn btn-warning icon-folder-open' onclick=editUser('$updurl')> Edit</button> "), 
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),    
        //array('btn' => "<button   class='btn btn-danger icon-trash' onclick=delall('$delall')> Delete All</button>"),            
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        //array('btn' => "<button   id='showd' class='btn btn-success  icon-ok-sign'> Show Order Details</button>"),
        //array('btn' => "<a href='#' class='easyui-linkbutton' iconCls='icon-add' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );                           
 
      //<input class='span3 easyui-validatebox' name=$k type='text' required> 

      //$data['username'] = $this->session->userdata('username'); 
      
      $data['buttons'] = $buttons;

      
      $this->load->view('include/header_admin',$data);          
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }


    public function user_list()
   {
    $data['hideColumn']="id";
      $data['table_name'] = "Users";      
      $data['geturl'] = site_url('frontpage/get/users');
      $data['addurl'] = site_url('frontpage/add/users');
      $data['delurl'] = site_url('frontpage/delete/users');
      $data['updurl'] = site_url('frontpage/update/users');
      $data['table_header'] = array("id"=>"ID","name"=>"User Name","email"=>"Email","mobile"=>"Mobile");      
      //$data['form_header'] = array("name"=>"User Name","email"=>"Email","mobile"=>"Mobile");      
       $data['form_header'] = array(
        "UserName"=> "<input class='span3 easyui-validatebox' name='name' type='text'> ",
        "Email"=> "<input class='span3 easyui-validatebox' name='email' type='text'> ",
        "Mobile"=> "<input class='span3 easyui-validatebox' name='mobile' type='text'> "
        );   


      $delurl=site_url('frontpage/delete/users');      
      $updurl= site_url('frontpage/update/users');
         

         $buttons = array(        
        array('btn' => "<a href='admin' class='btn-danger'> Close</a>"),        
        array('btn' => "<button   class='btn' onclick=editUser('$updurl')> Edit</button> "), 
        array('btn' => "<button   class='btn' onclick=removeUser('$delurl')> Delete</button>"),    
        //array('btn' => "<button   class='btn btn-inverse icon-trash' onclick=delall('$delall')> Delete All</button>"),            
        array('btn' => "<button   class='btn' onclick=refresh('#dg')> Refresh</button>"),
        //array('btn' => "<button   id='showd' class='btn btn-success  icon-ok-sign'> Show Order Details</button>"),
        //array('btn' => "<a href='#' class='easyui-linkbutton' iconCls='icon-add' plain='true' onclick=newUser('$addurl')>Add New</a> "),
        );                  

      
      $data['pagename'] = "User List Page";
      $data['buttons'] = $buttons;
      
      $this->load->view('include/header_admin',$data);          
      $this->load->view('myforms/grid_view_order_details',$data);
      $this->load->view('include/footer');
   }


    public function add2log($t){
   $data = array('transactions' => $t);
    $this->db->insert('op_log', $data);
   }
  

//---------------------------------------------------------------------

//--------------------------FUNCTIONS----------------------------------

  public function get_($tablename){    
    $result = $this->db->get($tablename)->result();    
    echo json_encode($result); 
  }

  public function get_options($tablename,$fname){      
    $query = $this->db->get($tablename);    
    $options="";
      foreach ($query->result() as $row)
      {
          $options=$options."<option value=".$row->id.">".$row->$fname."</option> ";        
      }
    return $options;
  }

//to get field value
public function getw_id($tablename,$wid,$id,$field){    
    //$result = $this->db->get($tablename)->result();
    $result = $this->db->get_where($tablename, array($wid => $id));
    //echo json_encode($result); 
    return $result->first_row()->$field ;
  }

public function get($tablename){
            //$id= $this->session->userdata('userid'); 
            $userid=$this->session->userdata('username'); 

            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
            //echo $rows;
            $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
            $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
            $offset = ($page-1)*$rows;  
              
            $result = array();  

$qrs="select count(*) from $tablename";
$qrs2="select * from $tablename order by $sort $order limit $offset,$rows";

//
if ($tablename=="orders") {
 $qrs="select count(*) from $tablename where email='$userid'";
 $qrs2="select * from $tablename where email='$userid' order by $sort $order limit $offset,$rows";               
}     
if ($tablename=="order_details") { 
$qrs="select count(*) from $tablename where userid='$userid' and status='new'";
$qrs2="select * from $tablename where userid='$userid' and status='new' order by $sort $order limit $offset,$rows";           
}       
if ($tablename=="admin") { 
$qrs="select count(*) from orders";
 $qrs2="select * from orders order by $sort $order limit $offset,$rows";               
}       
          
//            include 'conn.php';  
              
            $rs = mysql_query($qrs);  
            $row = mysql_fetch_row($rs);  
            $result["total"] = $row[0];  
              
            $rs = mysql_query($qrs2);  
              
            $items = array();  
            while($row = mysql_fetch_object($rs)){  
                array_push($items, $row);  
            }  
            $result["rows"] = $items;  
              
            echo json_encode($result); 
  }


   public function add($tablename){
      //sleep(2);
       $x= $this->db->insert($tablename, $_POST);
       if ($x) {
         # code...
       echo json_encode(array('msg'=>'Successfuly Commited..!')); 
       } else {
         # code...
       echo json_encode(array('msg'=>'Fail.!'));
       }
  }

 
  public function delete($tablename){    
    //sleep(2);
        $result = $this->db->delete($tablename, array("id"=>$_POST['id']));
      if ($result){
        echo json_encode(array('success'=>true,'msg'=>'Deleted .. !'));        
      } else {
        echo json_encode(array('msg'=>'Some errors occured.'));
          }

  }

  public function update($tablename,$id){
    //sleep(2);
    //$id=$this->session->userdata('userid'); 
     $result = $this->db->update($tablename, $_POST, array("id"=>$id));         
      if ($result){
        echo json_encode(array('success'=>true,'msg'=>'Updated'));        
      } else {
        echo json_encode(array('msg'=>'Some errors occured.'));
          }

      }

  public function delall($tablename){
    //$result = $this->db->empty_table($tablename);
    //$this->db->where('user', '5');
    //$this->db->delete($tables);

    $result = $this->db->delete($tablename, array('userid' => $this->session->userdata('username'),'status'=>'new')); 

    if ($result){
        echo json_encode(array('success'=>true,'msg'=>'Cleared...!'));  
              

      } else {
        echo json_encode(array('msg'=>'Some errors occured.'));
          }

      }

    public function empty_table($tablename){
    $result = $this->db->empty_table($tablename);
  
    if ($result){

        echo json_encode(array('success'=>true,'msg'=>'Cleared....!'));  


      } else {
        echo json_encode(array('msg'=>'Some errors occured.'));
          }

      }
   

      //------------Make Payment---------------------------------------------
   
  
   public function sendemail($to_mail,$msg){
            $this->load->library('email');
            $this->email->set_newline("\r\n"); /* for some reason it is needed */
            $this->email->from('scratch.cards.system@gmail.com', 'Scratch CARD SYSTEM');
            $this->email->to($to_mail);
            $this->email->subject('Your Zain Card 50SDG Serial');
            $this->email->message($msg);
            if($this->email->send())
            {
            //$this->add2log("Email Sent to =".$to_mail." with MSG=".$msg); 
            }
            else
            {
            //$this->add2log("Email Sent Fail for=".$to_mail." >>>> EMAIL FAIL"); 
            }
   }

      //---------------------------------------------------------
  public function admin_show_details()
   {
      $id=$_POST['id'];
      $this->load->library('table');   
      //$query = $this->db->query("SELECT food,amount from order_details where tid='$id'");
      $q="SELECT food, amount FROM order_details where tid='$id' UNION ALL SELECT  'Total:', SUM( amount ) FROM order_details where tid='$id'";
      //$query = $this->db->query("SELECT food,amount from order_details where tid='$id'");
      $query = $this->db->query($q);
     
      $this->table->set_caption("Order '$id' Details");
      $this->table->set_heading('Food Ordered', 'Amount (SDG)');

      echo json_encode(array('success'=>true,'msg'=>$this->table->generate($query)));   
      //echo  $this->table->generate($query);
      
   }
    public function show_details()
   {
      $id=$_POST['id'];
      
      $this->load->library('table');   
      //$query = $this->db->query("SELECT food,amount from order_details where tid='$id'");
      $q="SELECT food, amount FROM order_details where tid='$id' UNION ALL SELECT  'Total:', SUM( amount ) FROM order_details where tid='$id'";
      //$query = $this->db->query("SELECT food,amount from order_details where tid='$id'");
      $query = $this->db->query($q);
     
      $this->table->set_caption("Order '$id' Details");
      $this->table->set_heading('Food Ordered', 'Amount (SDG)');

      //echo json_encode(array('success'=>true,'msg'=>$this->table->generate($query)));   
      //echo  $this->table->generate($query);
      $data['results'] = $this->table->generate($query);      
      //$this->load->view('include/header_lib');   
      $this->load->view('myforms/show_data',$data);      
   }

   public function order_details()
   {
      $userid=$this->session->userdata('username'); 
      $this->load->library('table');
      $this->load->helper('html');

      $q="select id,food,amount, userid,status from order_details where userid='$userid' and status='new'";  
      $amount=$this->get_amount($userid);

      $query = $this->db->query($q);
      
      //$query = $this->get('order_details');
      if ($query->num_rows()<=0) {
         $this->table->set_caption("Cart.Empty <i class=''></i>");
         $this->table->add_row('');
      } else {      
          $this->table->set_caption("Cart Details <i class=''></i>");
          $this->table->set_heading('Food', 'Amount','');
          foreach ($query->result() as $row)
          {
           $this->table->add_row(array($row->food,$row->amount,"<button id='save' data-toggle='tooltip' title='Delete' class='btn btn-xs' onclick='del_item($row->id)'>[X]</button>"));
          }    
          $this->table->add_row(array('TOTAL',$amount));          
          $conf="<button id='save' data-toggle='tooltip' title='Confirm Order' class='btn btn-xs btn-success' onclick='conf_order()'>Confirm</button>";
          $clr="<button id='save' data-toggle='tooltip' title='Clear All' class='btn btn-xs  btn-danger' onclick='del_all()'>Clear</button>";
          $this->table->add_row($conf.' '.$clr);     
      }          
          

      $data['results'] = $this->table->generate();      
      //$this->load->view('include/header_lib');   
      $this->load->view('myforms/show_data',$data);
  }
    public function my_history()
   {
      if ($this->is_ok()==false) {
        echo "Kindly, Login in First . !?";
      } else {

      $userid=$this->session->userdata('username'); 

      $this->load->library('table');
      $this->load->helper('html');

      $q="select * from orders where email='$userid' order by date desc";  
      //$amount=$this->get_amount($userid);

      $query = $this->db->query($q);
      //$query = $this->get('order_details');
      if ($query->num_rows()<=0) {                
         
         $this->table->set_caption("Empty.History <i class='icon-th'></i>");
         //$this->table->add_row("--------------------------------------------------");
      } else {                
          $this->table->set_caption("Your History <i class='icon-th'></i>");
          $this->table->set_heading('ID', 'Amount','Status','Date','');
          foreach ($query->result() as $row)
          {
          $ED_B="<button id='save' data-toggle='tooltip' title='Send Comments' class='btn btn-xs' onclick='form_comment($row->id)'>Comment</button>";
          $DT_B="<button id='save' data-toggle='tooltip' title='View Order Details' class='btn btn-xs' onclick='show_details($row->id)'>Details</button>";
           $this->table->add_row(array($row->id,$row->amount,$row->status,strftime("%Y-%m-%d", strtotime($row->date)),$ED_B,$DT_B));
          }       
      }      
         //$this->table->add_row("");
          //$this->table->add_row("");
      $data['results'] = $this->table->generate();      
      //$this->load->view('include/header_lib');   
      $this->load->view('myforms/show_data',$data);    
      }
   }

public function form_comment(){
  $id=$_POST['id']; 
  $fb=$this->getw_id("orders","id",$id,"comments");

        $fields = array(        
        array('label' => "OrderID#$id",'input' => "<input type='hidden' class='form-control' value='$id' type='text' id='id' name='id'/>"),
        array('label' => "Comment",'input' => "<textarea rows='3' name='comments'>$fb</textarea> ")
        );


       $buttons = array(                
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Submit</button>"),
        );
      $data['fields'] = $fields;
      $data['buttons'] = $buttons;

      $data['form_name']="Comment for the Order!";

      $data['save_url'] = site_url('frontpage/update_comment');      
      //$this->load->view('include/header_lib');  
      $this->load->view('myforms/frm',$data);      

}
      public function rest_details()
   {

      $id=$_POST['id'];        
    //$id=1;
      $this->load->library('table');
      $this->load->helper('html');

      $q="SELECT * FROM rest where id='$id'";     
      $query = $this->db->query($q);
      $this->table->set_caption("Resturan Information");
      //$this->table->set_heading('Info', '-------------------------------');
      $this->table->add_row(array('Name:', $query->row('name')));
      $this->table->add_row(array('Address:', $query->row('address')));
      $this->table->add_row(array('Phone:', $query->row('phone')));
      $this->table->add_row(array('Food Type:', $query->row('food_type')));
      $this->table->add_row(array('Delivery Cost:', $query->row('delivery_cost')));          
      $this->table->add_row(array('Rating:', round($query->row('rating'), 1).'/10'));
      $this->table->add_row(array('Logo:', img(array('src'=>$query->row('url'),'height'=>'200','width'=>'200'))));
      
      $data['results'] = $this->table->generate();
      

      //$this->load->view('include/header_lib');   
      $this->load->view('myforms/show_data',$data);
//      echo json_encode(array('success'=>true,'msg'=>$this->load->view('myforms/show_data',$data)));    
      

   }

    public function food_details()
   {

      $id=$_POST['id'];        
    //$id=1;
      $this->load->library('table');
      $this->load->helper('html');

      $q="SELECT * FROM food where id='$id'";     
      $query = $this->db->query($q);
      $this->table->set_caption("Food Information");
      //$this->table->set_heading('Info', '-------------------------------');
      $this->table->add_row(array('Name:', $query->row('name')));
      $this->table->add_row(array('Description:', $query->row('desc')));
      $this->table->add_row(array('Category:', $query->row('group')));
      $this->table->add_row(array('Price:', $query->row('price')));
      $this->table->add_row(array('Logo:', img(array('src'=>$query->row('url'),'height'=>'300','width'=>'300'))));
      
      $data['results'] = $this->table->generate();
      
      //$this->load->view('include/header_lib');   
      $this->load->view('myforms/show_data',$data);
//      echo json_encode(array('success'=>true,'msg'=>$this->load->view('myforms/show_data',$data)));    
      

   }


   public function rate_resturant(){
     $id=$_POST['id']; 
     $name=$_POST['name']; 
     //$this->session->set_userdata('pagename', 'login Page');          
      //$data['pagename'] = "Login Page";
      $fields = array(
        array('label' => "Resturan Name",'input' => "<input value='$name' class='form-control' type='text' id='name' name='name'/>"),        
        array('label' => "Rate",'input' => "<select name='rating' class='selectpicker'> <option>1</option> 
                                                                                        <option>2</option> 
                                                                                        <option>3</option>
                                                                                        <option>4</option> 
                                                                                        <option>5</option>
                                                                                        <option>6</option>
                                                                                        <option>7</option>
                                                                                        <option>8</option>
                                                                                        <option>9</option>
                                                                                        <option>10</option>
                                                                                        </select>"),
//        array('label' => "Password",'input' => "<input class='form-control' type='password' id='password' name='password'/>"),          
        );
       $buttons = array(        
        //array('btn' => "<a href='' class='btn btn-info'> Close <i class='icon-ban-circle'></i></a>"),
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Submit</button>"),
        );

      $data['fields'] = $fields;
      $data['buttons'] = $buttons;
      $data['form_name']="Rating Form!";

      $data['save_url'] = site_url('frontpage/save_rate_rest/'.$id);              

      //$this->load->view('include/header_lib');  
      $this->load->view('myforms/frm',$data);
      //$this->load->view('include/footer');
   }

   public function save_rate_rest($idd){
      $r = $_POST['rating'];      
      $id = $idd;    

      $cr=$this->getw_id("rest","id",$id,"rating");
      $rc=$this->getw_id("rest","id",$id,"rating_count");
      $nr=($cr+$r)/2;

      $data = array(
               'rating' => $nr,
               'rating_count' => $rc+1,               
            );

      $this->db->where('id', $id);
      $this->db->update('rest', $data); 
      echo json_encode(array('msg'=>'success','msg'=>'Thank You !'));
      //echo json_encode(array('msg'=>'success','msg'=>$r));
   }


//---------

    public function rate_food(){
     $id=$_POST['id']; 
     $name=$_POST['name']; 
     //$this->session->set_userdata('pagename', 'login Page');          
      //$data['pagename'] = "Login Page";
      $fields = array(
        array('label' => "Food Name",'input' => "<input value='$name' class='form-control' type='text' id='name' name='name'/>"),        
        array('label' => "Rate",'input' => "<select name='rating' class='selectpicker'> <option>1</option> 
                                                                                        <option>2</option> 
                                                                                        <option>3</option>
                                                                                        <option>4</option> 
                                                                                        <option>5</option>
                                                                                        <option>6</option>
                                                                                        <option>7</option>
                                                                                        <option>8</option>
                                                                                        <option>9</option>
                                                                                        <option>10</option>
                                                                                        </select>"),
//        array('label' => "Password",'input' => "<input class='form-control' type='password' id='password' name='password'/>"),          
        );
       $buttons = array(        
        //array('btn' => "<a href='' class='btn btn-info'> Close <i class='icon-ban-circle'></i></a>"),
        array('btn' => "<button id='save' class='btn btn-primary' onclick='saveForm()'>Submit</button>"),
        );

      $data['fields'] = $fields;
      $data['buttons'] = $buttons;
      $data['form_name']="Rating Form! - Food";

      $data['save_url'] = site_url('frontpage/save_rate_food/'.$id);              

      //$this->load->view('include/header_lib');  
      $this->load->view('myforms/frm',$data);
      //$this->load->view('include/footer');
   }

   public function save_rate_food($idd){
      $r = $_POST['rating'];      
      $id = $idd;    

      $cr=$this->getw_id("food","id",$id,"rating");
      //$rc=$this->getw_id("rest","id",$id,"rating_count");
      $nr=($cr+$r)/2;

      $data = array(
               'rating' => $nr,               
            );

      $this->db->where('id', $id);
      $this->db->update('food', $data); 
      echo json_encode(array('msg'=>'success','msg'=>'Thank You !'));
      //echo json_encode(array('msg'=>'success','msg'=>$r));
   }

   //----------------------------upload  img
   public function do_upload()
  {    

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '10000';
    $config['overwrite'] = 'true';
    //$this->upload->overwrite = true;
    //$config['max_width']  = '1024';
    //$config['max_height']  = '768';

    $this->load->library('upload', $config);


    if ( ! $this->upload->do_upload())
    {    
      
      $this->load->view('include/header_admin');
      $data['res']= "File not Uploaded";
      $this->load->view('myforms/upload',$data);
      //Echo "File not Uploaded";
    }
    else
    {   
       $this->load->view('include/header_admin');
       $x = array('upload' => $this->upload->data());
       $fname= $x['upload']['file_name'];
       try {
        $this->db->set('name', base_url('uploads/'.$fname));        
        $this->db->insert('img'); 
         
        } catch (Exception $e) {
          
        } 
       
      $data['res']= "File Uploaded Successfuly ! ".$fname;
      $this->load->view('myforms/upload',$data);
      //echo "File Uploaded SFile Uploaded Successfuly !ccessfuly !";     
    }    
  }  

 
    public function upload()
  {
      $this->load->view('include/header_admin');
      $this->load->view('myforms/upload');
      //$this->load->view('include/footer');
  }  
}


/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
