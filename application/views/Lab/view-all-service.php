<!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  padding-top: 120px; /* Location of the box */
  margin-left: 25%;
  left: 0;
  top: 0;
  width: 50%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

    <section id="main-content">
      <section class="wrapper">
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
        <div class="row mb" style="padding:10px;">
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Invoice No</th>
                    <th>NIC</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th style="text-align:center;">Service</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($services as $service){
                    $patient_id = $service->patient_id;
                    //$service_name = $CI->Laboratory_model->service_name($service->service_id);
                    $patient = $CI->Laboratory_model->patient_detail_by_id($patient_id); //70
                    
                  ?>
                      <tr id="service<?php echo $service->id; ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $service->invoice_no; ?></td>
                        <td><?php echo $patient->nic; ?></td>
                        <td><?php echo $patient->name; ?></td>
                        <td><?php echo $service->patient_ageyear. " Years " . $service->patient_agemonth. " Months"; ?></td>
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
                        <td style="text-align:center;">
                          <button type="button" class="btn btn-xs btn-primary openDialog" data-invoice="<?php echo $service->invoice_no;?>" data-keyboard="false" data-toggle="modal" data-target="#exampleModal"><?php echo $service->counts; ?></button>
                        </td>
                        <td>
                          <?php 
                            $pending_count = $CI->Laboratory_model->services_status($service->invoice_no, 0); 
                            $completed_count = $CI->Laboratory_model->services_status($service->invoice_no, 1); 
                          ?>
                          <font color="red"><?php if($pending_count > 0){ echo $pending_count . " Pending "; } ?></font>
                          <?php if($completed_count > 0){ echo $completed_count . " Completed"; } ?>
                        </td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content" id="load_data_table"></div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
  </section>