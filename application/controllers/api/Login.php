<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_controller
{
    public function __construct()
	{
		parent::__construct();

		$this->load->model('WebServicesModel');
	}
    
    public function index()
    {
        $returning_array = array();
         $username = $this->input->post('username');
         $password = $this->input->post('password');
         $username = trim($username);
       
        $logincheck_data   = $this->WebServicesModel->logincheck($username,$password);
        if(is_object($logincheck_data)) 
       {

           $returning_array['success'] = "1";
           $userData = array();
           $userData['intUid'] = $logincheck_data->intAid;
           $userData['varUsername'] = $logincheck_data->varUsername;
           $userData['intStatus'] = $logincheck_data->intStatus;
           $userData['intRoleId'] = $logincheck_data->intRid;
           $returning_array['userdetail'] = $userData;
           
       }
       else
       {
           $returning_array['success'] = "0";
           $returning_array['message'] = "username or password is incorrect";
       }
       header('Content-Type: application/json');
       echo json_encode($returning_array);
   }





   public function messages($className,$messages)
    { 
       $this->session->set_flashdata('feedback',$messages);
       $this->session->set_flashdata('feedbase_class',$className);
   
    }
    public function logout()  
      {  
           $this->session->unset_userdata('IsSuperAdminLogin'); 
           $this->session->unset_userdata('AdminId'); 
           $this->session->unset_userdata('username');
           $this->session->unset_userdata('intRoleId');
           $this->session->unset_userdata('loginId');
           $this->clear_cache();
           redirect(base_url());  
      }


    function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }


































}
?>