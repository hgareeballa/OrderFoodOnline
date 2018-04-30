<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "frontpage";
$route['404_override'] = '';

//Get rid of the first segment (in our case we get rid of webpages)
//$route["index"] = "frontpage/welcome"; 
//$route["home"] = "frontpage/index"; 
//$route["login"] = "frontpage/login_form"; 
//$route["register"] = "frontpage/register_form"; 
//$route["feedback"] = "frontpage/feedback_form"; 


//$route["login_"] = "frontpage/login_ok"; 
//$route["orders"] = "frontpage/order_list"; 
//$route["neworders"] = "frontpage/new_order"; 



/* End of file routes.php */
/* Location: ./application/config/routes.php */

