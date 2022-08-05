<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Print Bill</title>

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

</head>
<body>
<section id="main-content">
  <?php 
    $CI =& get_instance();
    $CI->load->model('Laboratory_model');
  ?>
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12">
                <input type="text" value="<?php echo $service_data->id; ?>" name="id" hidden >
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('updatemsg')) {
                            echo $this->session->flashdata('updatemsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb"></h4>
                        <div class="form-horizontal style-form">
                  <?php
                    $CI =& get_instance();
                    $patient_id = $service_data->patient_id;
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); //70
                  ?>

                        <div class="form-group row">
                            <div class="col-sm-2"><h4>Invoice No</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->invoice_no; ?></h4></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"><h4>NIC No</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $patient->nic; ?></h4></div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3"><h4>Patient Name</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $patient->name; ?></h4></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"><h4>Gender</h4></div>
                            <div class="col-sm-3">
                              <h4>: 
                              <?php if($patient->gender == 1){ echo "Male"; } else { echo "Female"; } ?>
                              </h4>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3"><h4>Age</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->patient_ageyear." Years ".$service_data->patient_agemonth. " Months"; ?></h4></div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-2"><h4>Test Date</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->test_date; ?></h4></div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3"><h4>Source</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->test_source; ?></h4></div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-2"><h4>Refer Dr</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo ""; ?></h4></div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3"><h4>Requested By</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->request_by; ?></h4></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"><h4>Center</h4></div>
                            <div class="col-sm-3"><h4>: <?php echo $service_data->center; ?></h4></div>
                        </div>

                        <hr><br>

                        <div class="form-group row">
                          <div class="col-sm-5"><h2>Test Description</h2></div>
                          <div class="col-sm-1"></div>
                          <div class="col-sm-3"><h2>Result</h2></div>
                          <div class="col-sm-3"><h2></h2></div>
                        </div>
                      
                        <?php
                          $result_labels = $CI->Laboratory_model->get_result($service_data->service_id, $service_data->id);
                          $ref_labels = $CI->Laboratory_model->get_ref_labels($service_data->service_id);
                          
                          foreach($result_labels as $row)
                          {
                        ?>
                        <div class="form-group row">
                          <?php
                            if($row->is_input == 0)
                            {
                          ?>
                              <div class="col-sm-5"><h4><?php echo $row->result_label ; ?></h4></div>
                          <?php
                            }
                            else
                            {
                          ?>
                              <div class="col-sm-5"><h4><?php echo $row->result_label ; ?></h4></div>
                              <div class="col-sm-1"><h4> : </h4></div>
                              <div class="col-sm-3"><h4><?php echo $row->result_value ; ?></h4></div>
                              <div class="col-sm-3"><h4></h4></div>
                          <?php
                            }
                          ?>
                            
                        </div>
                        <?php
                          }
                        ?>

                          <hr><br>
                          <div class="form-group row">
                            <div class="col-sm-5"><h2>Reference Range</h2></div>
                          </div>
                        <?php
                          foreach($ref_labels as $row)
                          {
                        ?>
                        <div class="form-group row">
                            <div class="col-sm-5"><h4><?php echo $row->ref_label ; ?></h4></div>
                            <div class="col-sm-1"><h4> : </h4></div>
                            <div class="col-sm-3"><h4><?php echo $row->ref_value." ".$row->ref_unit ; ?></h4></div>
                            <div class="col-sm-3"><h4></h4></div>
                        </div>
                        <?php
                          }
                        ?>

                      </div>
                    </div>
            </div>
        </div>
    </section>
</section>

<script>
    $(document).ready(function(){
        window.print();
    });
</script>

</body>
</html>