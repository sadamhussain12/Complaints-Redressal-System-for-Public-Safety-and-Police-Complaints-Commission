<?php  if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class AuthModel extends CI_Model
{

	public function checkUser($array)
	{ 
			$this->db->select('*');
			$this->db->from('auth');
			$this->db->where($array);
			$this->db->get();
	$sql =  $this->db->row();
	return $sql;
	}
    


				
}
	?>