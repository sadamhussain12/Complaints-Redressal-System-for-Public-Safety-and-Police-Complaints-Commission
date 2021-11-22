<style>
.dataTables_wrapper{width:90%;margin:0px auto;}

.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
background-color: #0aa89e;
color: #FFF;
}
#content{padding-top:30px;}
.round {
display: inline-block;
height: 30px;
width: 30px;
line-height: 30px;
-moz-border-radius: 30px;
border-radius: 30px;
background-color: #222;    
color: #0aa89e;
text-align: center;  
box-shadow:0px 0px 2px #0a5e5e;
}
.round:hover{box-shadow:0px -1px 1px #0a5e5e;}
.round.green {
background-color: #FFF;
}

.no-sort::after { display: none!important; }

.no-sort { pointer-events: none!important; cursor: default!important; }
.red-tooltip + .tooltip > .tooltip-inner {background-color: #f00;}
.links a{ display:inline-block;margin:0px 2px;}
.modal-header{padding:0px}
.form-group .form-control ~ label{top:-8px !important} 
</style>

<!-- BEGIN CONTENT-->
<div id="content">
<?php if($this->session->flashdata('msg')):?>
<div class="col-sm-6 col-sm-offset-3 MSG" style="position:absolute;z-index:9999393">
<div class="alert alert-success text-center" role="alert"><strong><?=ucwords($this->session->flashdata('msg'))?></strong></div>
</div>
<?php endif?>

<?php if($this->session->flashdata('error')):?>
<div class="col-sm-6 col-sm-offset-3 MSG" style="position:absolute;z-index:9999393">
<div class="alert alert-danger text-center" role="alert"><strong><?=ucwords($this->session->flashdata('error'))?></strong></div>
</div>
<?php endif?>

<section class="style-default-bright" style="background:none">
<br style="clear:both;" />
<!-- BEGIN DATATABLE 1 -->
<div class="row">
<div class="col-lg-12">
<!--BREADCRUMB START-->  

<!--BREADCRUMB END--> 

<div class="row">
<div class="col-lg-12" style="margin-top:70px;padding:0px 65px;">
<div class="card-body">
<div class="card_header">
<h2><?=$title?></h2>
</div>
<div class="card-body-container">           
<form class="feature_form" method="post" autocomplete="off">

<div class="col-md-3 col-sm-6 col-xs-6">
<div class="form-group">
<label>Date</label>
<input type="text" name="ven_inv_date" id="ven_inv_date" class="form-control date" value="<?=date('d-m-Y')?>" required>
</div>  
</div>

<div class="col-md-3 col-sm-6 col-xs-6">
<div class="form-group">
<label>Entry No</label>
<input type="text" name="entry_no" id="entry_no" class="form-control"  required>
</div>  
</div>

<div class="col-md-3 col-sm-6 col-xs-6">
<?php  $vendors = $this->MyModel->get_all_and_single_vendor();?>
<div class="form-group">
<label>Supplier</label>
<select name="vendor_id" id="vendor" class="form-control" required>
<option value="">-Select Supplier-</option>';
<?php if(!empty($vendors)){
foreach($vendors as $vendor){?>
<option value='<?=$vendor->vendor_id?>'><?=ucwords($vendor->vendor_name)?></option>
<?php }
}?>
</select>

</div>
</div>


<div class="col-md-12">
<div class="form-group" style="clear:both;">
<label>Memo Note/Description</label>
<input type="text" name="ven_inv_desc" id="ven_inv_desc" class="form-control">
</div>
</div>
<div class="col-md-12 table-responsive" id="invoiceTableContainer"> 
<div>


<table class="table table-bordered invoiceTable" style="margin-bottom:0px;box-shadow:0px 0px 5px #dbdbdb;-webkit-box-shadow:0px 0px 5px #dbdbdb;-moz-box-shadow:0px 0px 5px #dbdbdb;-o-box-shadow:0px 0px 5px #dbdbdb;-ms-box-shadow:0px 0px 5px #dbdbdb;">

<tr style="background:#000;color:#FFF">
<th>Item</th>
<th>Stock</th>
<th>Qty</th>
<th>Rate</th>
<th>Amount</th>
</tr>
<tr>
<td>
<select  name="item_id[]" class="form-control item" required >
<option value="">Select Item</option>
<?php if(!empty($items)):
foreach ($items as $row):?>
<option value="<?=$row->item_id?>"><?=$row->item_name?></option>
<?php endforeach;endif;?>
</select>
</td>
<td><input type="number" step="any" class="form-control"  id="stock" value="0" /></td>
<td align="center"><input type="number" step="any" class="item_qty form-control"   name="inv_item_qty[]" /></td>
<td><input type="number" class="item_rate form-control" step="any"    name="inv_item_rate[]" required /></td>
<td><input type="number" class="item_amount form-control" step="any"  readonly /></td>
</tr>
<tbody class="items">
</tbody>  
</table>

<p align="right" style="margin-top:5px"><a href="javascript:void(0)" class="btn btn-info" style="padding:1px 6px" data-toggle="tooltip" title="Add More" onclick="addMore()"><i class="glyphicon glyphicon-plus"></i></a></p>
<div>
<p align='right'>
<span style="font-weight:bold;font-size:20px;">Sum:</span> <input type="number" style="width:150px;font-size:20px;font-weight:bold;" id="sum" name="sum" onfocus="this.blur()" readonly />
<br />
<span style="font-weight:bold;font-size:20px;">Amount Paid:</span> <input type="number" name="amount_paid" id="amount_paid" style="font-size:20px;font-weight:bold;width:150px;" />
<br />
<span style="font-weight:bold;font-size:20px;">Invoice Balance:</span> <input type="number" value="0" id="invoice_balance" onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;" />
<br />
<span style="font-weight:bold;font-size:20px;">Last Balance:</span> <input type="number" id="last_balance" onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;" value="" />
<br />
<span style="font-weight:bold;font-size:20px;">Net.Balance:</span> <input type="number" id="net_balance" onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;" />
</p>

</div> 
</div>
<div class="form-group">
<input  type="submit" name="submit" class="btn btn-raised btn-info ink-reaction pull-right" value="Save" style="margin-bottom:15px" />
<input  type="submit" name="full_paid" class="btn btn-raised btn-danger ink-reaction pull-right" value="Full Paid" style="margin-bottom:15px;margin-right:5px;" />
</div>
</div>


</form>
</div><!--card-body-container-->
</div><!--invoiceTableContainer-->
</div>
</div>
<
</div><!--end .col -->
</div><!--end .row -->
</section>
<script>
$(document).ready(function(){

$('body').tooltip({
selector: '[data-toggle="tooltip"]'});

$(document).on('click','.removeRow',function(){
var currentRow = $(this).parent().parent().remove();
var sum = 0;
$('.item_amount').each(function(){
sum += parseFloat($(this).val());

});
$('#sum').val(sum);
$('#invoice_balance').val(sum);
var last_balance = $('#last_balance').val();
if(last_balance == ''){
last_balance = 0;
}

$('#net_balance').val(parseFloat(sum) + parseFloat(last_balance));

});


$(document).on('keyup','.item_qty',function(){
var item_qty  = $(this).val();
var item_amount = $(this).parent().parent().children().find('.item_amount');
if(item_qty == ''){
item_qty = 0;
}
var item_rate = $(this).parent().next('td').children('.item_rate').val();
if(item_rate == ''){
item_rate = 0;
}

$(item_amount).prop('value',(parseFloat(item_rate) * parseFloat(item_qty)));
var sum = 0;
$('.item_amount').each(function(){
sum += parseFloat($(this).val());

});


$('#sum').val(sum);

$('#invoice_balance').val(sum);
var last_balance = $('#last_balance').val();
if(last_balance == ''){
last_balance = 0;
}

$('#net_balance').val(parseFloat(sum) + parseFloat(last_balance));

});


$(document).on('change','.item',function(){

var item_id     = $(this).val();


$.ajax({
url:"<?=base_url()?>index/load_ajax_items/"+item_id,
dataType:"json",
success:function(res){
$('#stock').val(res.stock_qty);
}

});
});

$(document).on('keyup','.item_rate',function(){
var item_rate = $(this).val();

if(item_rate == ''){
item_rate = 0;
}
var item_qty = $(this).parent().prev('td').children('.item_qty').val();


if(item_qty == ''){
item_qty = 0;
}

$(this).parent().parent().children().find('.item_amount').prop('value',parseFloat(item_qty) * parseFloat(item_rate));

var sum = 0;
$('.item_amount').each(function(){
sum += parseFloat($(this).val());

});

$('#sum').val(sum);
$('#invoice_balance').val(sum);
var last_balance = $('#last_balance').val();
if(last_balance == ''){
last_balance = 0;
}
$('#net_balance').val(parseFloat(sum) + parseFloat(last_balance));
});


$('#amount_paid').keyup(function(){
var amount_paid = $(this).val();
var sum = $('#sum').val();
if(amount_paid > 0){
$('#invoice_balance').val(parseFloat(sum) - parseFloat(amount_paid));
}else{
$('#invoice_balance').val(sum);
}


});

$(document).on('change','#vendor',function(){
var vendor_id = $(this).val();

$('#last_balance').val(0);
$.ajax({
url:"<?=base_url()?>index/ajax_get_vendor_last_balance/"+vendor_id,
success:function(res){

  if(res === ''){
    res = 0;
  }
$('#last_balance').val(res);

}
});
});


});



</script>

<script>
function delete_record(){
var  conf_del = confirm('Are you sure you want to DELETE this record?');
if(conf_del){
return true;
}else{
return false;
}
}

function addMore(){

var row = ` <tr>
<td>
<select  name="item_id[]" class="form-control" required >
<option value="">Select Item</option>
<?php if(!empty($items)):
foreach ($items as $row):?>
<option value="<?=$row->item_id?>"><?=$row->item_name?></option>
<?php endforeach;endif;?>
</select>
</td>
<td><input type="number" step="any" class="stock form-control" /></td>
<td align="center"><input type="number" step="any" class="item_qty form-control"   name="inv_item_qty[]" /></td>
<td><input type="number" class="item_rate form-control" step="any"  name="inv_item_rate[]" required /></td>
<td><input type="number" class="item_amount form-control"   readonly />   <a href="javascript:void(0)" class="btn btn-danger removeRow"style="padding:1px 6px;float:right; margin-top:5px;"  data-toggle="tooltip" title="Remove"><i class="glyphicon glyphicon-minus"></i></a></td>
</tr>`;

$('.items').append(row);
var sum = 0;
$('.item_amount').each(function(){
var item_amount = $(this).val();
if(item_amount == ''){
item_amount = 0;
}
sum += parseFloat(item_amount);

});
$('#sum').val(sum);
}

</script>






