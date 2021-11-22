<style>

.input {

  box-shadow:inset 1px 1px 10px #cfcfd2 !important
  } 

  .input:focus{

  box-shadow:inset 1px 1px 10px #cfcfd2 !important
  }

title{
color:red !important;
}

</style>
<!-- Main Content -->
<div class="main-content">
<section class="section">
<div class="section-body">
<div class="row">
<div class="col-12">

<div class="card">
<div class="card-header">
<h4>Vendors</h4>

</div>

<div class="card-body">
<!--BREADCRUMB START-->  
<div class="breadcrumb pull-right" style="margin-top:0px;float:left !important">
<a href="<?=base_url()?>config_admin/Index">Dashboard</a>
<a href="#" class="active_">Vendors</a>
</div>

<div class="buttons" >                    
<a href="#" style="float:right !important;" data-toggle="modal" data-target="#add" class="btn btn-icon btn-primary btn_" title="Add New Vendor"><i class="fas fa-plus"></i></a>


</div>
<div class="table-responsive">
<table class="table table-striped" id="table-1">
<thead>
<tr>
<th>S:No</th>
<th>Vendor Code</th>
<th>Name</th>
<th>CNIC</th>
<th>Phone No</th>
<th>Mobile No</th>
<th>Type</th>
<th>Running Balance</th>
<th style="width:15% !important;">Option</th> 
</tr>
</thead>
<tbody>
<?php $no=1;if(!empty($vendors)){
foreach($vendors as $vendor){?>
<tr>
<td><?=$no++;?></td>
<td><?=$vendor->vendor_code?></td>
<td><?=$vendor->vendor_name?></td>
<td><?=$vendor->vendor_cnic?></td>
<td><?=$vendor->vendor_phone?></td>
<td><?=$vendor->vendor_mobile?></td>
<td><?=$vendor->vendor_type?></td>
<td></td> 
<td>
<a href="#" data-vendor_id="<?=$vendor->vendor_id?>" data-toggle="tooltip" title="Update Vendor"  data-toggle="modal" data-vendor_id="<?=$vendor->vendor_id?>" data-target="#edit_modal" class="btn btn-icon btn-primary btn_ edit"><i  class="far fa-edit"></i></a>

<a href="config_admin/vendor_ledger/<?=$vendor->vendor_id?>" data-toggle="tooltip" title="Vendor Ledger" class="btn btn-icon btn-dark btn_"><i class="fas fa-th"></i></a>

<a href="config_admin/delete_vendor/<?=$vendor->vendor_id?>" data-toggle="tooltip" title="Delete Vendor" onclick="return delete_record()" class="btn btn-icon btn-danger btn_"><i class="fas fa-trash"></i></a>

</td>                   
</tr>
<?php }}?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>  
</div>
</div>

<!-- Add Modal with form -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Add Vendor</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form method="post">
<div class="form-group">
<label>Username</label>
<div class="input-group">
<input type="text" name="vendor_name" id="vendor_name" class="form-control input" required>
</div>
</div>
<div class="form-group">
<label>CNIC</label>
<div class="input-group">
<input type="text" name="vendor_cnic" id="vendor_cnic" class="form-control input" pattern=".{15,}"   required title="Invalid CNIC" onkeypress="return onlyCNIC(jQuery(this),event)">
</div>
</div>
<div class="form-group">
<label>Phone</label>
<div class="input-group">
<input type="text" name="vendor_phone" id="vendor_phone" class="form-control input">
</div>
</div>
<div class="form-group">
<label>Mobile</label>
<div class="input-group">
<input type="text" name="vendor_mobile" id="vendor_mobile" class="form-control input" required>
</div>
</div>
<div class="form-group">
<label>Type</label>
<div class="input-group">
<input type="text" name="vendor_type" id="vendor_type" class="form-control input" required>
</div>
</div>
<div class="modal-footer bg-whitesmoke br">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>

</div>
</div>
</div>

<!--- Add Model End---->

<!-- Edit Modal with form -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby=""
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="">Update Vendor</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form method="post" action="config_admin/update_vendor">
<input type="hidden" name="vendor_id" id="vendor_id" />
<div class="form-group">
<label>Username</label>
<div class="input-group">
<input type="text" name="edit_vendor_name" id="edit_vendor_name" class="form-control input" required>
</div>
</div>
<div class="form-group">
<label>CNIC</label>
<div class="input-group">
<input type="text" name="edit_vendor_cnic" id="edit_vendor_cnic" class="form-control input" pattern=".{15,}" title="Invalid CNIC" onkeypress="return onlyCNIC(jQuery(this),event)" required >
</div>
</div>
<div class="form-group">
<label>Phone</label>
<div class="input-group">
<input type="text" name="edit_vendor_phone" id="edit_vendor_phone" class="form-control input">
</div>
</div>
<div class="form-group">
<label>Mobile</label>
<div class="input-group">
<input type="text" name="edit_vendor_mobile" id="edit_vendor_mobile" class="form-control input" required>
</div>
</div>
<div class="form-group">
<label>Type</label>
<div class="input-group">
<input type="text" name="edit_vendor_type" id="edit_vendor_type" class="form-control input" required>
</div>
</div>
<div class="modal-footer bg-whitesmoke br">
<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
</div>
</div>
</div>
</div>

<!--- Edit Model End---->

<script> 
$(document).ready(function(){
$('.edit').click(function(){
var vendor_id = $(this).data('vendor_id');
$.ajax({
url:'config_admin/ajax_get_vendor/'+vendor_id,
datType:'json',
success:function(res){
var data = jQuery.parseJSON(res);
$('#vendor_id').attr('value',vendor_id);
$('#edit_vendor_name').prop('value',data.vendor_name);
$('#edit_vendor_cnic').attr('value',data.vendor_cnic);
$('#edit_vendor_phone').attr('value',data.vendor_phone);
$('#edit_vendor_mobile').attr('value',data.vendor_mobile);
$('#edit_vendor_type').attr('value',data.vendor_type);
}
}); 
});


$('.input').click(function(){

  $(this).css('border','2px solid #4650cb');

   $(this).css('box-shadow','none')

});





});
</script>

<script>
function delete_record(){ 
var confirm_delete = confirm('Are you sure you want to DELETE this record?');

if(confirm_delete){
return true;
}
else{
return false;
}
}

</script>
