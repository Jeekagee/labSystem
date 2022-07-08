
<style type="text/css">
  .li-style{
    border-bottom: medium;
    background-color:#f4f9f9;
    padding: 8px;
    color: #314e52;
  }
  .li-style:hover{
    background-color:#e7e6e1;
    color: #f2a154;
  }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Add New Order</h3>
        <div class="row mt">
          <div class="col-lg-8">
            <form action="<?php echo base_url(); ?>Orders/Update" method="post" enctype="multipart/form-data">
            <div class="form-panel">
              <h4 class="mb"></i> Order Profile
              </h4>
              <div class="form-horizontal style-form">

                <div id="validation">
                  <?php
                  if ($this->session->flashdata('editsuccess')) {
                    echo $this->session->flashdata('editsuccess');
                  }
                  ?>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Vehicle No <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" value="<?php echo $order->vehicle_no; ?>">
                      <div id="vehicle_no_list"></div>
                      <span style="color:red;"><?php echo form_error('vehicle_no'); ?></span>
                  </div>
                </div>

                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Contact No<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php echo $order->contact_no; ?>">
                      <span style="color:red;"><?php echo form_error('contact_no'); ?></span>
                  </div>
                </div>

                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Customer Name<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="cus_name" id="cus_name" value="<?php echo $order->customer_name; ?>">
                      <span style="color:red;"><?php echo form_error('cus_name'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Bill No <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" name="bill_no" id="bill_no" value="<?php echo $order->bill_no; ?>">
                    <span style="color:red;"><?php echo form_error('bill_no'); ?></span>
                  </div>
                </div>
                
                <?php
                    $originalDate = $order->bill_date;
                    $newDate = date("Y-m-d", strtotime($originalDate));
                ?>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Bill Date<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo $newDate; ?>">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-4 control-label">Type</label>
                  <div class="col-md-8">
                    <select class="form-control" name="type" id="type">
                      <?php
                        foreach($vehicle_types as $types){
                          $type = $types->type;
                            if ($type == $order->type) {
                                $stl = "selected";
                            }
                            else{
                                $stl = "";
                            }
                          echo "<option $stl value='$type'>$type</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label">Make</label>
                  <div class="col-md-8">
                    <select class="form-control" name="make" id="make">
                      <?php
                        foreach($vehicle_makes as $makes){
                          $make = $makes->make;
                            if ($make == $order->make) {
                                $stl = "selected";
                            }
                            else{
                                $stl = "";
                            }
                          echo "<option $stl value='$make'>$make</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class=" col-sm-4 control-label">Bays</label>
                  <div class="form-check-inline col-sm-8">
                        <?php echo $order->bay; ?>
                  </div>
                </div>

              <div class="form-group">
                      <div style="padding:10px;">
                        <table class="table table-striped">
                          <thead>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Action</th>
                          </thead>
                          <tbody>
                              <?php
                              $CI =& get_instance();
                                $services = $CI->Orders_model->order_service($order->bill_no); //530
                                $ser_total = 0;
                                foreach ($services as $ser) {
                                  ?>
                                  <tr>
                                    <td><?php echo $ser->service; ?></td>
                                    <td>LKR <?php echo $ser->amount; ?>.00</td>
                                    <td>
                                      <a href="<?php echo base_url(); ?>Orders/deleteService/<?php echo $ser->id; ?>/<?php echo $order->order_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                    </td>
                                  </tr>
                                  <?php
                                  $ser_total = $ser_total+($ser->amount);
                                }
                              ?>
                          </tbody>
                        </table>
                      </div>
                </div>

                <div class="form-group">
                      <div style="padding:10px;">
                        <table class="table table-striped">
                          <thead>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                          </thead>
                          <tbody>
                              <?php
                                $items = $CI->Orders_model->order_item($order->bill_no); //530
                                $itm_total = 0;
                                foreach ($items as $itm) {
                                  ?>
                                  <tr>
                                    <td><?php echo $itm->item_name; ?></td>
                                    <td><?php echo $itm->amount; ?>.00</td>
                                    <td><?php echo $itm->qty; ?></td>
                                    <td>LKR <?php echo $to = $itm->qty*$itm->amount; ?>.00</td>
                                    <td>
                                      <a href="<?php echo base_url(); ?>Orders/deleteItem/<?php echo $itm->id; ?>/<?php echo $order->order_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                    </td>
                                  </tr>
                                  <?php
                                  $itm_total = $itm_total+$to;
                                }
                              ?>
                          </tbody>
                        </table>
                      </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Discount</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="discount" id="discount" value="<?php echo $order->discount; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12 ">
                    <input type="submit" class="btn btn-primary pull-right mr-5" value="Update Order" name="submit">
                    <a href="<?php echo base_url(); ?>Orders" class="btn btn-danger pull-right" style="margin-right:5px">Back</a>
                  </div>

                </div>

              </div>
            </div>
              </form>
          </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->

