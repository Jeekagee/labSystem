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
  <?php 
    $CI =& get_instance();
    $CI->load->model('Laboratory_model');
  ?>
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12">
                <?php echo form_open('Laboratory/updateService'); ?>
                <input type="text" value="<?php echo $service_data->id; ?>" name="id" hidden >
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('updatemsg')) {
                            echo $this->session->flashdata('updatemsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Labortary Service</h4>
                        <div class="form-horizontal style-form">
                  <?php
                    $CI =& get_instance();
                    $patient_id = $service_data->patient_id;
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); //70
                  ?>
                  
                  <input type="hidden" value="<?php echo $service_data->id; ?>" name="lab_service_id" id="lab_service_id">
                  <input type="hidden" value="<?php echo $service_data->service_id; ?>" name="service_id" id="service_id">
                  
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Invoice No</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $service_data->invoice_no; ?>" class="form-control" name="invoice_no" id="invoice_no" readonly ></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">NIC No</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $nic = $patient->nic; ?>"  class="form-control" name="nic" id="nic" readonly></div>
                            <div class="col-sm-2"></div>
                            <label class="col-sm-2 control-label">Patient Name</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $patient->name; ?>" class="form-control" name="pname" id="pname" readonly></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sorce</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $service_data->test_source; ?>"  class="form-control" name="source" id="source"></div>
                            <div class="col-sm-2"></div>
                            <label class="col-sm-2 control-label">Requested By</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $service_data->request_by; ?>" class="form-control" name="requested" id="requested"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Refer Doctor</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $nic = $service_data->refer_doctor; ?>"  class="form-control" name="refer_dr" id="refer_dr"></div>
                            <div class="col-sm-2"></div>
                            <label class="col-sm-2 control-label">Center</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $service_data->center; ?>" class="form-control" name="center" id="center"></div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Update" name="save_item">
                            <a style="margin-right: 15px;" href="<?php echo base_url();?>Laboratory/AllServices" class="pull-right btn btn-danger">Cancel</a>
                          </div>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>