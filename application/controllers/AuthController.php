<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthController extends CI_controller{
public function __construct(){
parent::__construct();
//$this->load->model('AuthModel');	
$this->load->library('auto_no.php','zend');
$this->load->library('form_validation');
}

    public function index()
    {
        $this->load->view('authLogin');
    }
    
    public function checkUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == FALSE)
        {
            $error = array('error' => validation_errors()); //print_r($error); exit();
            $message= implode(" ",$error);
            $this->messages('alert-danger',$message);
            echo strip_tags($message); exit;
           // return redirect('Employee/AddEmployeePage');
            
        }
        else
        {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $array = array('varUsername'=>$username,'varPassword'=>$password,'intStatus'=>1);
            $response = $this->AuthModel->checkUser($array); 
            if(!empty($response))// is user name and passsword valid
			   {
					if($response->intRid == '1')
					{	
						$this->session->set_userdata('IsSuperAdminLogin',"1");					
						$this->session->set_userdata('AdminId',$response->intAid);
						$this->session->set_userdata('username',$response);
						$this->session->set_userdata('intRoleId',$response->intRid);
						$this->session->set_userdata('loginId',$response->intAid);
						
							redirect('/admin/dashboard');
						exit();
					}
					
					elseif($response->intRid == '2')
					{	
						echo "IT Staff";
						exit();
					}
                    elseif($response->intRid == '3')
					{	
						echo "IT Team";
						exit();
					}
                    elseif($response->intRid == '4')
					{	
						echo "Public";
						exit();
					}
				} // end is user name and passsword valid
                else// not match ue name and pass
	             {
	             	$this->session->set_flashdata('errorMsg', "Username Or Password Invalid");
                     $this->messages('alert alert-danger',"Username Or Password Invalid");
                     echo "username or passwro invalid"; 
	         	    redirect(base_url());
	         	    exit();
	             }  //end // not match ue name and pass 
             print_r($response);
        }
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




































public function index1()
{
$data['title'] = 'Dashboard';
$data['page']  = 'dashboard';
$this->load->view('template',$data);
}

public function vendors(){

if($this->input->post()){
$vendor_code =  new auto_no();
$vendor_code = $vendor_code->get_auto_num('vendor','auto_no');
$vendor_name   = $this->input->post('vendor_name');
$vendor_cnic   = $this->input->post('vendor_cnic');
$vendor_phone  = $this->input->post('vendor_phone');
$vendor_mobile = $this->input->post('vendor_mobile');
$vendor_type   = trim($this->input->post('vendor_name'));

if(isset($vendor_name) && empty($vendor_name) && isset($vendor_cnic) && empty($vendor_cnic)){
$this->session->set_flashdata('error','Please provide basic information');
redirect('config_admin/vendors');
}

$data = array(
'vendor_code'  => $vendor_code,
'vendor_name'  => $vendor_name,
'vendor_cnic'  => $vendor_cnic,
'vendor_phone' => $vendor_phone,
'vendor_mobile'=> $vendor_mobile,
'vendor_type'  => $vendor_type,
);

$this->db->insert('vendors',$data);
$this->AuthModel->set_auto_no('vendor');
$this->session->set_flashdata('msg','New vendor record has been saved');
redirect('config_admin/vendors');

}

$data['vendors'] = $this->AuthModel->get_vendors();
$data['title']   = 'Vendors'; 
$data['page']    = 'vendors'; 
$this->load->view('template',$data);

}

public function delete_vendor($vendor_id){
$this->db->where('vendor_id',$vendor_id)
->delete('vendors');
$this->session->set_flashdata('error','venodr has been deleted');
redirect('config_admin/vendors');

}

public function ajax_get_vendor($vendor_id){
$data  = $this->AuthModel->get_agex_vendor($vendor_id);
echo json_encode($data);die;
}

public function update_vendor(){

if($this->input->post()){
$vendor_id = $this->input->post('vendor_id');

$data = array(
'vendor_name'    => $this->input->post('edit_vendor_name'),
'vendor_cnic'    => $this->input->post('edit_vendor_cnic'),
'vendor_phone'   => $this->input->post('edit_vendor_phone'),
'vendor_mobile'  => $this->input->post('edit_vendor_mobile'),
'vendor_type'    => $this->input->post('edit_vendor_type'),
'user_id'        =>'2',
);
$this->db->where('vendor_id',$vendor_id)
->update('vendors',$data);
$this->session->set_flashdata('msg','Vendor record has been updated');
redirect('config_admin/vendors');
}
}


public function vendor_ledger($vendor_id){

if($this->input->post()){

$ven_inv_no   =  new auto_no();
$ven_inv_no   = $ven_inv_no->get_auto_num('vendor_invoice','auto_no');

$invoice_data=array(
'ven_inv_date'  => date('Y-m-d',strtotime($this->input->post('ven_inv_date'))),
'ven_inv_no'    => $ven_inv_no,
'ven_inv_refno' => $this->input->post('ven_inv_refno'),
'ven_inv_desc'  => $this->input->post('ven_inv_desc'),
'vendor_id'     => $vendor_id,
'user_id'       => '2'
);

/*INVOICE ITEMS*/
$inv_item_name = $this->input->post('inv_item_name');
$inv_item_desc = $this->input->post('inv_item_desc');
$inv_item_qty  = $this->input->post('inv_item_qty');
$inv_item_rate = $this->input->post('inv_item_rate');

if(empty($inv_item_name) && empty($inv_item_qty) &&  empty($inv_item_rate)){
$this->session->set_flashdata('error','Sorry! please fill all fields');
redirect('index/ledger/'.$vendor_id);
}else{
$this->db->insert('vendor_invoices',$invoice_data);
$ven_inv_id = $this->db->insert_id();
$this->AuthModel->set_auto_no('vendor_invoice');

for($i=0;$i<count($inv_item_name);$i++){
$vendor_item_data = array(
'ven_item_name' => $inv_item_name[$i],
'ven_item_desc' => $inv_item_desc[$i],
'ven_item_qty'  => $inv_item_qty[$i],
'ven_item_rate' => $inv_item_rate[$i],
'ven_inv_id'    => $ven_inv_id,
);
$this->db->insert('vendor_items',$vendor_item_data);
}

$vendor_recipts = array(

'ven_rec_date'   => date('Y-m-d',strtotime($this->input->post('ven_rec_date'))),
'ven_rec_refno'  => $this->input->post('ven_inv_refno'),
'ven_rec_desc'   => $this->input->post('ven_inv_desc'),
'vendor_id'      => $vendor_id,
'ven_inv_id'     => $ven_inv_id,
'user_id'        => '2'

);

$this->db->insert('vendor_receipts',$vendor_recipts);

}
$this->session->set_flashdata('msg','Purchase invoice has been created');
redirect('config_admin/vendor_ledger/'.$vendor_id);
}


$data['invoices']  = $this->AuthModel->get_vendor_invoices($vendor_id); 
$data['receipts']  = $this->AuthModel->get_vendor_receipts($vendor_id); 
$data['vendor_id'] = $vendor_id;
$data['title']     = 'Vendor Ledger';
$data['page']      = 'vendor_ledger';
$this->load->view('template',$data);
}

public function add_vendor_receipt(){
if($this->input->post()){

$vendor_id = $this->input->post('vendor_id');

$receipts_data = array(

'ven_rec_date'   => date('Y-m-d',strtotime($this->input->post('ven_rec_date'))),
'ven_rec_refno'  => $this->input->post('ven_rec_refno'),
'ven_rec_desc'   => $this->input->post('ven_rec_desc'),
'ven_rec_amount' => $this->input->post('ven_rec_amount'),
'vendor_id'      => $vendor_id,
'user_id'        => '2'
);

$this->db->insert('vendor_receipts',$receipts_data);
$this->session->set_flashdata('msg','Vendor receipt has been added');
redirect('config_admin/vendor_ledger/'.$vendor_id);
}
}

public function delete_vendor_invoice($ven_inv_id,$vendor_id){

/* delete vendor items*/
$this->db->where('ven_inv_id',$ven_inv_id)->delete('vendor_items');


/* delete vendor receipt*/
$this->db->where('ven_inv_id',$ven_inv_id)->delete('vendor_receipts');

/* delete vendor invoice*/
$this->db->where('ven_inv_id',$ven_inv_id)->delete('vendor_invoices');

$this->session->set_flashdata('error','Invoice & its references deleted successfully');
redirect('config_admin/vendor_ledger/'.$vendor_id);
}



public function delete_vendor_receipt($ven_rec_id,$vendor_id){

$this->db->where('ven_rec_id',$ven_rec_id)->delete('vendor_receipts');

$this->session->set_flashdata('error','Vendor receipt has been deleted');

redirect('config_admin/vendor_ledger/'.$vendor_id);
}

public function delete_invoice_item($ven_item_id,$vendor_id){
$this->db->where('ven_item_id',$ven_item_id)
->delete('vendor_items');
//$this->session->set_flashdata('error','Invoice item has been removed');
redirect('config_admin/vendor_ledger/'.$vendor_id);
}



public function sale_purchase(){
if($this->input->post()){

$vendor_id   = $this->input->post('vendor_id',true);
$sum         = $this->input->post('sum',true);
$amount_paid = $this->input->post('amount_paid',true);

if($this->input->post('full_paid')):
$amount_paid = $sum;
endif;


if($amount_paid == ''){
$amount_paid = 0;
}
/*VENDOR INVOICE*/
$ven_inv_no   =  new auto_no();
$ven_inv_no   = $ven_inv_no->get_auto_num('invoice','auto_no');

$invoice_data = array(
'ven_inv_date'   => date('Y-m-d',strtotime($this->input->post('ven_inv_date',true))),
'ven_inv_no'     => $ven_inv_no,
'ven_inv_desc'   => $this->input->post('ven_inv_desc',true),
'vendor_id'      => $vendor_id,
'user_id'        => 2
);	



/*INVOICE ITEMS*/
$item_id = $this->input->post('item_id',true);
$inv_item_qty  = $this->input->post('inv_item_qty',true);
$inv_item_rate = $this->input->post('inv_item_rate',true);

if(empty($item_id) && empty($inv_item_qty) &&  empty($inv_item_rate)){
$this->session->set_flashdata('error','Sorry! Please fill all fields');
redirect('index/purchase_invoice/'.$vendor_id);
}

else{

$this->db->insert('vendor_invoices',$invoice_data);
$ven_inv_id = $this->db->insert_id();
$this->AuthModel->set_auto_no('invoice');

for($x = 0;$x<count($item_id);$x++){

$vendor_item_data = array(
'item_id'       => $item_id[$x],
'ven_item_qty'  => $inv_item_qty[$x],
'ven_item_rate' => $inv_item_rate[$x],
'ven_inv_id'    => $ven_inv_id,
);

$this->db->insert('vendor_items',$vendor_item_data);

/* check site stock*/

$check__item_stock = $this->AuthModel->check_item_in_stock($item_id[$x]);

if(!empty($check_site_item_stock)){

$stock_qty = $check__item_stock['stock_qty'] + $inv_item_qty[$x];
$stock_actual_rate = $inv_item_rate[$x];

$stock_data = array(

'stock_qty'   => $site_stock_qty,
'stock_rate'  => $site_stock_actual_rate,

);

$this->db->where('item_id',$check__item_stock['item_id'])
->update('sites_stock',$stock_data);
}
else
{

$site_stock_qty = $check__item_stock['stock_qty'] + $inv_item_qty[$x];
$site_stock_actual_rate = $inv_item_rate[$x];


$stock_data = array(

'stock_qty'  => $site_stock_qty,
'stock_rate' => $site_stock_actual_rate,
'item_id'     => $item_id[$x],

);

$this->db->insert('stocks',$stock_data);

}

$check_item_in_stock = $this->AuthModel->check_item_in_stock($item_id[$x]);

if(!empty($check_item_in_stock)){
$stock_actual_rate = $inv_item_rate[$x];
$data = array(

'rate' => $stock_actual_rate,

);

$this->db->where('item_id',$check_item_in_stock['item_id'])
->update('items',$data);
}

}

$receipt_data = array(
'ven_rec_date'   =>  date('Y-m-d',strtotime($this->input->post('ven_inv_date',true))),
'ven_inv_id'     =>  $ven_inv_id,
'ven_rec_desc'   =>  $this->input->post('ven_inv_desc',true),
'ven_rec_amount' =>  $amount_paid,
'vendor_id'      =>  $vendor_id,
'user_id'        =>  2
);	

$this->db->insert('vendor_receipts',$receipt_data);
}


$this->session->set_flashdata('msg','Purchase invoice has been created');
redirect('config_admin/sale_purchase/'.$vendor_id);

}

$data['items'] = $this->AuthModel->get_items();
$data['title']  = 'Sale & Purchase';
$data['page']   = 'sale_purchase';
$this->load->view('template',$data);
}


public function get_items(){
$query = $this->db->select('items.`item_id`,items.`item_name`,items.`qty`,items.`rate`,items.`uom_id`,items.`is_active`,items.`create_on`,uom.uom_title')
->from('items')
->join('uom','uom.uom_id=items.uom_id');
$query  = $this->db->get();
return $query->result();
}

public function load_ajax_items($item_id){

$check_item_stock = $this->AuthModel->check_item_in_stock($$item_id);
echo json_encode($check_item_stock);die;


}

public function ajax_get_vendor_last_balance($vendor_id){

$invoices   = $this->AuthModel->vendor_invoices($vendor_id);
$receipts   = $this->AuthModel->get_vendor_receipts($vendor_id);

$receivable = 0;
if(!empty($invoices)){
foreach($invoices as $invoice){
$receivable += ($invoice->ven_item_rate * $invoice->ven_item_qty);

}

$total_paid = 0;
if(!empty($receipts)){
foreach($receipts as $row){
$total_paid += $row->ven_rec_amount;
}

}

echo $receivable - $total_paid;die;
}

}
}
?>