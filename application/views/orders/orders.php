
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Orders</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Orders/insert" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <div style="margin-bottom: 10px;" >
                
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Ivoice ID</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Payment</th>
                    <th class="text-right">Net Amount</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($orders as $order){
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $order->bill_no; ?></td>
                        <td class="text-right"><?php echo $total = $order->total; ?>.00</td>
                        <td class="text-right"><?php echo $discount = $order->discount; ?>.00</td>
                        <td class="text-right"><?php echo $order->payment; ?>.00</td>
                        
                      
                        <td class="text-right"><?php echo $total-$discount; ?>.00</td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Orders/print_bill/<?php echo $bill_no = $order->bill_no; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                        </td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
            </div>

            
          </div>
          <!-- page end-->
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  