<?php 
  class WebServicesModel extends CI_Model {
	function __construct()
	{
	}
	function logincheck($username,$password)
	{
		$this->db->select('*')->from('auth');
		$this->db->where('varUsername',$username);
		$this->db->where('varPassword',md5($password));
		$this->db->where('intStatus',1);
		return $this->db->get()->row();
	}
}

   ?>  