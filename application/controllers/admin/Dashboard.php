<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
    // public function __construct()
    // {
	// 	parent::__construct();
	// 	if($this->session->userdata('IsSuperAdminLogin'))
	// 	{
	// 		$this->load->model('EmployeeMdl','model');
	// 	}
	// 	else
	// 	{	
	// 		redirect(base_url());
	// 	}
    // }

    public function index()
    {
    $data['title'] = 'Dashboard';
    $data['page']  = 'dashboard';
    $this->load->view('template',$data);
    }
}
?>