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
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); 
                    $patient_current_age = $CI->Laboratory_model->patient_current_age($service_data->invoice_no);
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
                            <div class="col-sm-3"><h4>: <?php echo $patient_current_age->patient_ageyear." Years ".$patient_current_age->patient_agemonth. " Months"; ?></h4></div>
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

                        <div class="form-group">
                            <?php
                            $CI =& get_instance();
                              $services = $CI->Laboratory_model->addedServices($service_data->invoice_no);
                              ?>
                              <table class="table table-hover">
                                <thead>
                                <th class="text-center">No</th>
                                <th class="text-center">Service</th>
                                <th class="text-right">Amount</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $total = 0;
                                    foreach ($services as $service) {
                                      ?>
                                      <tr id="row<?php echo $service->id; ?>">
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td class="text-center">
                                          <?php 
                                          $service_id = $service->service_id;
                                          echo $this->Laboratory_model->get_service($service_id);
                                          ?>
                                        </td>
                                        <td class="text-right"><?php echo $charge = $service->charge; ?></td>
                                        </tr>
                                      <?php
                                      $i++;
                                      $total = $total+$charge;
                                    }
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td class="text-center text-danger" style="font-weight:900;">Total</td>
                                        <td class="text-right text-danger" style="font-weight:900;"><?php echo $total; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
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