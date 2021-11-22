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
                        <a href="<?=base_url()?>config_admin/vendors">Vendors</a>
                        <a href="#" class="active_">Vendor Ledger</a>
                      </div>

                    <div class="buttons" >   
                       <a href="#" style="float:right !important;" data-toggle="modal" data-target="#add_recipt" class="btn btn-outline-primary btn_" title="Add Recipt"><i class="fas fa-plus"></i></a> 

                        <a href="#" style="float:right !important;" data-toggle="modal" data-target="#add" class="btn btn-icon btn-primary btn_" title="Add Invoice"><i class="fas fa-plus"></i></a> 


                <?php 
                $invoice_total_amount = 0;
                if(!empty($invoices)){
                  foreach($invoices as $invoice){
                    $invoice_total_amount += ($invoice->ven_item_rate * $invoice->ven_item_qty);
                  }
                }
                ?> 
                      
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Inv#</th>
                            <th>Ref#</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Received</th>
                            <th>Balance</th>
                            <th>Options</th>
                          </tr>
                        </thead>
                        <tbody>
                         <?php 

                            $balance    = 0;
                            $total_paid = 0;

                          if(!empty($receipts)){
                            foreach($receipts as $row){
                              $total_paid += $row->ven_rec_amount;
                          ?>
                        <tr>
                            <td><?=date('d-m-Y',strtotime($row->ven_rec_date))?></td>  
                            <td><?php if($row->ven_inv_id > 0){
                                  $invoice_detail = $this->MyModel->get_vendor_invoice_detail($row->ven_inv_id);
                                      echo $invoice_detail['ven_inv_no'];
                                    }
                                      else{
                                        echo '---';
                            }?></td> 
                            <td><?=$row->ven_rec_refno?></td>
                            <td>
                          <?php if($row->ven_inv_id > 0){?>
                          <table class="table table-striped invoice_table table-responsive" id="table-1"  style="margin-bottom:0px;">
                            <thead style="background:#000 !important;">
                              <tr>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th style="width:40% !important">Options</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $get_invoice_items = $this->MyModel->get_invoice_items($row->ven_inv_id);
                                if(!empty($get_invoice_items)){
                                  foreach($get_invoice_items as $item){
                              ?>
                                <tr>
                                  <td style="display:none;"><?=$item->ven_item_name?></td>
                                  <td style="display:none;"><?=$item->ven_item_desc?></td>
                                  <td style="display:none;"><?=$item->ven_item_qty?></td>
                                  <td style="display:none;"><?=number_format($item->ven_item_rate)?></td>
                                  <td style="display:none;"><?=number_format($item->ven_item_qty * $item->ven_item_rate)?></td>
                                  <td style="display:none;">
                                    
                                  <a data-ven_item_id="<?=$item->ven_item_id?>"  data-toggle="modal" data-target="#myModal"><i class="far fa-edit" style="color:blue;"></i></a>

                                  <a href="config_admin/delete_invoice_item/<?=$item->ven_item_id?>/<?=$item->vendor_id?>" onclick="return delete_record()"><i class="fas fa-trash"></i></a>
                                  </td>
                                </tr>
                              <?php } }?>
                                  </tbody>
                                  </table>
                                  <p align="right"><a  class="collapase_icon" style="font-size:10px;padding:8px 10px;float:right;border-radius:50px;margin-top:4px;" class="btn btn-icon btn-success btn_"><i class="fas fa-plus"></a></p>
                                  <?php }?>
                      
                            </td>
                            <td><?php 
                            $receivable = 0;
                            $received   = $row->ven_rec_amount;

                            if($row->ven_inv_id == 0){
                              echo 0;
                            }
                            else{
                              if(!empty($get_invoice_items)){

                                foreach ($get_invoice_items as $item_rows){
                                $receivable +=$item_rows->ven_item_rate * $item_rows->ven_item_qty;

                              }
                            }
                              echo number_format($receivable);
                            }
                            ?></td>
                            <td><?php 
                                if($row->ven_rec_desc == ''){
                                echo 'NIL';
                                }else{
                                echo $row->ven_rec_desc;
                                }?></td>

                            <td><?php echo number_format($received);?></td>
                            <td><?php $balance += $receivable - $received;
                                 echo number_format($balance);?>
                            </td>
                            <td>
                        <?php if($row->ven_inv_id > 0):?>
                        <a href="config_admin/delete_vendor_invoice/<?=$row->ven_inv_id?>/<?=$row->vendor_id?>" onclick="return delete_record()" data-toggle="tooltip" title="Delete Invoice"class="btn btn-icon btn-danger btn_"><i class="fas fa-trash"></i></a>
                        <?php else:?>

                        <a href="config_admin/delete_vendor_receipt/<?=$row->ven_rec_id?>/<?=$row->vendor_id?>" onclick="return delete_record()" data-toggle="tooltip" title="Delete Receipt" class="btn btn-icon btn-danger btn_"><i class="fas fa-trash"></i></a>
                        <?php endif;?>
                    </td>
                        </tr>
                <?php } }?> 
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
          <div class="modal-dialog" role="document" style=" max-width: 1200px !important;margin: 1.75rem auto;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" >
                   <div class="container-fluid">
                    <div class="row">
                  <div class="col-6">
                  <div class="form-group">
                    <label>Date</label>
                    <div class="input-group">
                      <input type="text" name="ven_inv_date" id="ven_inv_date" class="form-control date" value="<?=date('d-m-Y')?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Ref#</label>
                    <div class="input-group">
                      <input type="text" name="ven_inv_refno" id="ven_inv_refno" class="form-control" required>
                    </div>
                  </div>
                </div>
                 <div class="col-12">
                  <div class="form-group">
                    <label>Memo Note/Descption</label>
                    <div class="input-group">
                     <input type="text" name="ven_inv_desc" id="ven_inv_desc" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                           <th>Item Name</th>
                           <th>Description</th>
                           <th>Qty</th>
                           <th>Rate</th>
                           <th>Amount</th>
                        </tr>
                        </thead>
                          <tr>
                            <td><input type="text"   name="inv_item_name[]" required ></td>
                            <td><input type="text"   name="inv_item_desc[]" /></td>
                            <td><input type="number" step="any" class="item_qty"    name="inv_item_qty[]"   required /></td>
                            <td><input type="number" step="any" class="item_rate"   name="inv_item_rate[]" required /></td>
                            <td><input type="number" step="any" class="item_amount" readonly /></td>     
                          </tr>
                          <tbody class="items">
                          </tbody>
                  
                  </table>
                        <p align="right"><a  class="btn btn-icon btn-sm btn-primary collapase_icon" data-toggle="tooltip" title="Add More" style="color:#fff; border-radius:50%" onclick="AddMore()"><span class="fas fa-plus"></span></a>
                        </p> 
                        <div>
                            <p align='right' style="color:black">
                              <span style="font-weight:bold;font-size:20px;">Sum:</span> <input type="number" step="any" style="width:150px;font-size:20px;font-weight:bold;" id="sum" onfocus="this.blur()" readonly />
                               <br />
                              <span style="font-weight:bold;font-size:20px;">Amount Paid:</span> <input type="number"step="any" name="amount_paid" id="amount_paid" style="font-size:20px;font-weight:bold;width:150px;" />
                              <br />
                              <span style="font-weight:bold;font-size:20px;">Invoice Balance:</span> <input type="number" step="any" value="0" id="invoice_balance" onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;" />
                              <br />
                              <span style="font-weight:bold;font-size:20px;">Last Balance:</span> <input type="number" step="any" id="last_balance" value="<?=$invoice_total_amount - $total_paid?>"  onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;"/>
                                <br />
                              <span style="font-weight:bold;font-size:20px;">Net.Balance:</span> <input type="number" step="any" id="net_balance" onfocus="this.blur()" readonly style="width:150px;font-size:20px;font-weight:bold;" />
                            </p>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary" style="float:right !important;">Save</button>
                  </div>
                </div>
                </div>
              </div>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <!--- Add Model End---->

        <!-- Add Modal with form -->
       <div class="modal fade" id="add_recipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document" style=" max-width: 600px !important;margin: 1.75rem auto;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" action="config_admin/add_vendor_receipt">
                   <div class="container-fluid">
                    <div class="row">
                  <div class="col-12">
                  <div class="form-group">
                    <label>Date</label>
                    <div class="input-group">
                      <input type="hidden" name="vendor_id" value="<?=$vendor_id?>" />
                      <input type="text" name="ven_rec_date" id="ven_rec_date" class="form-control date" value="<?=date('d-m-Y')?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Ref#</label>
                    <div class="input-group">
                      <input type="text" name="ven_rec_refno" id="ven_rec_refno" class="form-control" required>
                    </div>
                  </div>
                </div>
                 <div class="col-12">
                  <div class="form-group">
                    <label>Memo Note/Descption</label>
                    <div class="input-group">
                     <input type="text" name="ven_rec_desc" id="ven_rec_desc" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Amount</label>
                    <div class="input-group">
                     <input type="text" name="ven_rec_amount" id="ven_rec_amount" class="form-control">
                    </div>
                  </div>
                </div>
                
                </div>
                <div class="col-12">
                  <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary" style="float:right !important;">Save</button>
                  </div>
                </div>
                </div>
                </form>
              </div>
              </div>
              
            </div>
          </div>
        </div>
        <!--- Add Model End---->
  <script> 
    $(document).ready(function(){
      $('.collapase_icon').click(function(){
        var check_status = $(this).children('i').attr('class');
        if(check_status == 'fas fa-plus'){
          $(this).children('i').removeClass('fa-plus');
          $(this).children('i').addClass('fa-minus');
          $(this).parent().prev('.invoice_table').find('tbody td').show();
        }
        if(check_status == 'fas fa-minus'){
          $(this).children('i').removeClass('fa-minus');
          $(this).children('i').addClass('fa-plus');
          $(this).parent().prev('.invoice_table').find('tbody td').hide();
        }
    });
});
</script>

<script>

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
    var item_qty = parseFloat($(this).val());

    if(item_qty == ''){
      item_qty = 0;
    }
    var item_rate = $(this).parent().next('td').children('.item_rate').val();

    if(item_rate == ''){
      item_rate = 0;
    }
     $(this).parent().parent().children().find('.item_amount').prop('value',parseFloat(item_qty*item_rate));

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

   $(document).on('keyup','.item_rate',function(){
    var item_rate = parseFloat($(this).val());

    if(item_rate == ''){
      item_rate = 0;
    }
    var item_qty = $(this).parent().parent().children().find('.item_qty').val();

    if(item_qty == ''){
      item_qty = 0;
    }

    $(this).parent().parent().children().find('.item_amount').prop('value',parseFloat(item_qty*item_rate));

    var sum = 0;
     $('.item_amount').each(function(){
       sum+= parseFloat($(this).val());
     });

    $('#sum').val(sum);
    $('#invoice_balance').val(sum);

     var last_balance = $('#last_balance').val();
       if(last_balance == ''){
         last_balance = 0;
       }

       $('#net_balance').val(parseFloat(sum) + parseFloat(last_balance));

  });

   $(document).on('change','#vendor',function(){

    var vendor_id = $(this).val();
    $('#last_balance').val(0);
    $.ajax({
      url:"<?=base_url()?>index/ajax_get_vendor_last_balance/"+vendor_id,
      success:function(res){
        console.log(res);

      $('#last_balance').val(res);

            }
    });
  });

   function AddMore(){
       var row =`<tr>
                  <td><input type="text"   name="inv_item_name[]" required ></td>
                  <td><input type="text"   name="inv_item_desc[]" /></td>
                  <td><input type="number" step="any" class="item_qty"    name="inv_item_qty[]"   required /></td>
                  <td><input type="number" step="any" class="item_rate"   name="inv_item_rate[]" required /></td>
                  <td><input type="number" step="any" class="item_amount" readonly />  <a  class="btn btn-icon btn-sm btn-danger removeRow"  data-toggle="tooltip" title="Remove" style="color:#fff; border-radius:50%"><i class="fas fa-minus"></i></a></td>     
                </tr>`
                $('.items').append(row);
   }
  
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
                
