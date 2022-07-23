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
                <?php echo form_open('Laboratory/update'); ?>
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
                  <input type="hidden" value="<?php echo $service_data->id; ?>" name="service_id" id="service_id">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Invoice No</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $invoice_no = $service_data->invoice_no; ?>" class="form-control" name="invoice_no" id="invoice_no" readonly ></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">NIC No</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $nic = $patient->nic; ?>"  class="form-control" name="nic" id="nic" readonly></div>
                            <div class="col-sm-2"></div>
                            <label class="col-sm-2 control-label">Patient Name</label>
                            <div class="col-sm-3"><input type="text" value="<?php echo $patient->name; ?>" class="form-control" name="pname" id="pname" readonly></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><b>Test Description</b></label>
                            <label class="col-sm-2 control-label"></label>
                            <label class="col-sm-3 control-label"><b>Result</b></label>
                            <label class="col-sm-3 control-label"><b>Unit</b></label>
                        </div>
                      
                        <?php
                          $result_labels = $CI->Laboratory_model->get_result_labels($service_data->service_id);
                          $ref_labels = $CI->Laboratory_model->get_ref_labels($service_data->service_id);
                          foreach($result_labels as $row)
                          {
                        ?>
                        <div class="form-group">
                          <?php
                            if($row->is_input == 0)
                            {
                          ?>
                              <label class="col-sm-2 control-label"><b><?php echo $row->result_label ; ?></b></label>
                          <?php
                            }
                            else
                            {
                          ?>
                              <label class="col-sm-2 control-label"><?php echo $row->result_label ; ?></label>
                              <label class="col-sm-2 control-label">:</label>
                              <div class="col-sm-3"><input type="text" value="" class="form-control"></div>
                              <label class="col-sm-3 control-label"><?php echo $row->result_unit ; ?></label>
                          <?php
                            }
                          ?>
                            
                        </div>
                        <?php
                          }
                        ?>
                          <div class="form-group">
                            <label class="col-sm-2 control-label"><b>Reference Range</b></label>
                          </div>
                        <?php
                          foreach($ref_labels as $row)
                          {
                        ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo $row->ref_label ; ?></label>
                            <label class="col-sm-2 control-label">:</label>
                            <label class="col-sm-3 control-label"><?php echo $row->ref_value ; ?></label>
                            <label class="col-sm-3 control-label"><?php echo $row->ref_unit ; ?></label>
                        </div>
                        <?php
                          }
                        ?>
                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Submit" name="save_item">
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


