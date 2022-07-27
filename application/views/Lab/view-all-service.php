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
                    <th>Service</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($services as $service){
                    $patient_id = $service->patient_id;
                    $service_name = $CI->Laboratory_model->service_name($service->service_id);
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); //70
                    
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
                        <td><?php echo $service_name; ?></td>
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