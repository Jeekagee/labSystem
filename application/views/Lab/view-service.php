<!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px; margin-top:10px;" >
                <a href="<?php echo base_url(); ?>Laboratory/Add/<?php echo $service_id; ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Nic</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Requested By</th>
                    <th>Refer Doctor</th>
                    <th>Center</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($services as $service){
                    $patient_id = $service->patient_id;
                    //$location_id = $service->location_id;
                    $doctor_id = $service->refer_doctor;
                    // Get Patient Detail by nic
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); //70
                    // Get Location Detail by location_id
                    //$location = $CI->Laboratory_model->get_location($location_id); //77
                    // Get Doctor name by doctor_id
                    if($doctor_id > 0)
                    {
                      $doctor_name = $CI->Laboratory_model->get_doctor($doctor_id); //91
                      $dr = $doctor_name->name;
                    }
                    else{
                      $dr = '';
                    }
                    
                  ?>
                      <tr id="service<?php echo $service->id; ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $patient->nic; ?></td>
                        <td><?php echo $patient->name; ?></td>
                        <td><?php echo $patient->ageyear. " Years " . $patient->agemonth. " Months"; ?></td>
                        <td>
                          <?php
                            if ($patient->gender == 1) 
                            {
                              echo "Male";
                            }
                            else
                            {
                              echo "Female";
                            }
                          ?>
                        </td>
                        <td><?php echo $service->test_date; ?></td>
                        <td><?php echo $service->test_source; ?></td>
                        <td><?php echo $service->request_by; ?></td>
                        <td><?php echo $dr; ?></td>
                        <td><?php echo $service->center; ?></td>
                        <td>
                          <?php
                            if ($service->result_status == 0) 
                            {
                              echo "Pending";
                            }
                            else
                            {
                              echo "Completed";
                            }
                          ?>
                        </td>
                        <td class="text-center">
                          <a href="#" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="<?php echo base_url(); ?>Laboratory/view_single/<?php echo $service->id; ?>" class="btn btn-info btn-xs"><i class="fa-solid fa-flask"></i></a>
                          <?php if($service->result_status == 0){ ?>
                            <a href="#" class="btn btn-success btn-xs" style="pointer-events: none;"><i class="fa fa-print"></i></a>
                          <?php } else { ?>
                            <a href="<?php echo base_url();?>Laboratory/viewprintBill/<?php echo $service->id;?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
                          <?php } ?>
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