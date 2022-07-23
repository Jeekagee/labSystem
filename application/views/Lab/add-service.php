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
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Laboratory/insert'); ?>
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('labmsg')) {
                            echo $this->session->flashdata('labmsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Labortary Service</h4>
                        <div class="form-horizontal style-form">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Invoice No</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $invoice_no; ?>" class="form-control" name="invoice_no" id="invoice_no" readonly >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Patient NIC No<span style="color: red;"></span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('nic'); ?>" class="form-control" name="nic" id="nic">
                            <div id="nic_list"></div>
                            <span class="text-danger"><?php echo form_error('nic'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Patient Name<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('pname'); ?>" class="form-control" name="pname" id="pname">
                            <span class="text-danger"><?php echo form_error('pname'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Gender<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <input type="radio" id="male" name="pgender" value="1">
                              <label for="pmale">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" id="female" name="pgender" value="2">
                              <label for="pfemale">Female</label>
                              <span class="text-danger"><?php echo form_error('pgender'); ?></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Age<span style="color: red;"> *</span></label>
                            <div class="col-sm-4">
                            <input type="number" value="<?php echo set_value('pyear'); ?>" class="form-control" name="pyear" id="pyear">
                            <label for="pyear">Years</label>
                            </div>
                            <div class="col-sm-4">  
                            <input type="number" value="<?php echo set_value('pmonth'); ?>" class="form-control" name="pmonth" id="pmonth" max="12">
                            <label for="pmonth">Months</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Test Date<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="date" value="<?php echo set_value('date'); ?>" class="form-control" name="date" id="date">
                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Source</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('source'); ?>" class="form-control" name="source" id="source">
                            <span class="text-danger"><?php echo form_error('source'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Requested By</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('requestBy'); ?>" class="form-control" name="requestBy" id="requestBy">
                            <span class="text-danger"><?php echo form_error('requestBy'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Refer Doctor</label>
                          <div class="col-sm-8">
                              <select id="doctor" class="form-control" name="doctor">
                                <option value="">Select Doctor</option>
                                <?php
                                foreach ($doctors as $doctor) {
                                    echo "<option value='$doctor->id'>$doctor->name</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('doctor'); ?></span>
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                             <a href="<?php echo base_url(); ?>Doctor/Add">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_dr">
                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                             </a>
                          </div>
                        </div>

                        <?php
                          $month = date('m');
                          $day = date('d');
                          $year = date('Y');
                          
                          $today = $year . '-' . $month . '-' . $day;
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Center</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('center'); ?>" class="form-control" name="center" id="center">
                            <span class="text-danger"><?php echo form_error('center'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Save" name="save_item">
                            <a style="margin-right: 15px;" href="" class="pull-right btn btn-danger">Cancel</a>
                          </div>
                        </div>

                      </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>

<!-- Modal -->
<div id="add_area" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Specialization</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Appoint/add_area">
        <div class="modal-body">
          <div>
              <label>Specialization</label>
            </div>
            <div>
              <input class="form-control" type="text" name="area">
            </div>
          
        </div>
        <div class="modal-footer">
          <input type="submit" name="save_catogery" value="Save" class="btn btn-success">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->

<!-- Sub Cat Modal -->
<div id="sub_catogery" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Sub Catogery</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_sub_catogery">
      <div class="modal-body">
          <div>
            <label>Catogery</label>
          </div>
          <div>
            <select class="form-control" id="main_catogery" name="catogery">
            <?php
              foreach ($catogories as $catogery) {
                echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
              }
            ?>
            </select>
          </div>

          <div>
            <label>Sub Catogery</label>
          </div>
          <div>
            <input class="form-control" type="text" name="sub_catogery">
          </div>
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="save_sub_catogery" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->

<!-- Filter Range Modal -->
<div id="filter_range" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Filter Range</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_frange">

      <div class="modal-body">
          <div>
            <label>Catogery</label>
          </div>
          <div>
            <select class="form-control" id="main_catogery" name="catogery">
            <?php
              foreach ($catogories as $catogery) {
                echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
              }
            ?>
            </select>
          </div>
          <div>
            <label>Filter Range</label>
          </div>
          <div>
            <input class="form-control" type="text" name="filter_range">
          </div>
      </div>

      <div class="modal-footer">
        <input type="submit" name="save_filter_range" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Filter Modal -->

<!-- Modal -->
<div id="brand" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Brand</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_brand">
      <div class="modal-body">
          <div>
            <label>Catogery</label>
          </div>
          <div>
            <select class="form-control" id="main_catogery" name="catogery">
              <?php
                foreach ($catogories as $catogery) {
                  echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
                }
              ?>
            </select>
          </div>

          <div>
            <label>Brand</label>
          </div>
          <div>
            <input class="form-control" type="text" name="brand">
          </div>
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="save_brand" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->