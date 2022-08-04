<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laboratory extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $this->load->model('Booking_model');
        $this->load->model('Appoint_model');
        
        $data['username'] = $this->Dashboard_model->username();
        
        //Load Model
        $this->load->model('Laboratory_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
  }

  public function Add()
  {
        $data['page_title'] = 'Labortary';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['invoice_no'] = $this->Laboratory_model->invoice_no();
        $data['locations'] = $this->Laboratory_model->locations();
        $data['services'] = $this->Laboratory_model->services();
        $data['doctors'] = $this->Laboratory_model->doctors();

        $data['titles'] = $this->Laboratory_model->titles();

        $data['next_id'] = $this->Laboratory_model->next_id();

        $data['nav'] = "Lab Test";
        $data['subnav'] = "Add Services";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('Lab/add-service',$data);
        $this->load->view('Lab/footer');
  }

  public function AllServices()
  {
    $data['page_title'] = 'Labortary';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
        // Get All Services
        $data['services'] = $this->Laboratory_model->view_all_services(); //63

        $data['nav'] = "Lab Test";
        $data['subnav'] = "View";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('Lab/view-all-service',$data);
        $this->load->view('Lab/footer');
  }

  public function View($service_id)
  {
    $data['page_title'] = 'Labortary';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();
        // Get All Services
        $data['services'] = $this->Laboratory_model->view_services($service_id); //63

        $data['service_id'] = $service_id;
        $data['nav'] = "Lab Test";
        $data['subnav'] = "View";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('Lab/view-service',$data);
        $this->load->view('Lab/footer');
  }

  public function Service_charge(){
      $service = $this->input->post('service');
      //$location = $this->input->post('location');
      echo $this->Laboratory_model->service_charge($service);
  }

  public function insert(){
    //$this->form_validation->set_rules('nic', 'NIC Number', 'required');
    $this->form_validation->set_rules('pname', 'Patient Name', 'required');
    $this->form_validation->set_rules('date', 'Test Date', 'date');
    $this->form_validation->set_rules('pyear', 'Patient Age', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->Add();
        }
        else{
            $nic = $this->input->post('nic');
            $pname = $this->input->post('pname');
            $gender = $this->input->post('pgender');
            $ageyear = $this->input->post('pyear');
            $agemonth = $this->input->post('pmonth');

            $id = $this->input->post('invoice_no');
            $service_id = $this->input->post('service_id');
            $requested = $this->input->post('requestBy');
            $dr = $this->input->post('doctor');
            $center = $this->input->post('center');

            if ($this->Appoint_model->patient_available($nic) > 0 && $nic != '') {
                //$this->Appoint_model->update_patient($nic,$pname,$mobile,$address,$title,$ageyear,$agemonth,$gender);
            }
            else{
                $this->Appoint_model->insert_patient($nic,$pname,$ageyear,$agemonth,$gender);
            }

            if($nic != '')
            {
                $patient_id = $this->Appoint_model->get_patient_id($nic);
            }
            else
            {
                $patient_id = $this->Appoint_model->get_patient_id(0);
            }
            
            $this->Laboratory_model->insert_lab_service($id,$service_id,$patient_id,$test_date,$source,$requested,$dr,$center);
            
            $this->session->set_flashdata('labmsg',"<div class='alert alert-success'>Service Added Successfully!</div>");
            
            /*$abc = 3;
            $url = base_url() . "Laboratory/view_single/" . $id;
            redirect($url);*/

            $url = base_url() . "Laboratory/View/" . $service_id;
            redirect($url);
            //redirect('Laboratory/View');
        }
  }

  // Service for Lab test
  public function insert_service()
  {
    $nic = $this->input->post('nic');
    $name = $this->input->post('name');
    $dob = $this->input->post('dob');
    $gender = $this->input->post('gender');

    $service_id = $this->input->post('service_id');
    $year = $this->input->post('year');
    $month = $this->input->post('month');
    $test_date = '';//$this->input->post('test_date');
    $source = $this->input->post('source');
    $requested = $this->input->post('requested');
    $dr = $this->input->post('dr');
    $charge = $this->input->post('charge');
    $center = $this->input->post('center');
    $invoice_no = $this->input->post('invoice_no');

    if ($this->Appoint_model->patient_available($nic) > 0 && $nic != '')
    {
        $patient_id = $this->Appoint_model->get_patient_id($nic);
    }
    else
    {
        $ref_no = $this->Appoint_model->get_patient_ref_no();
        $this->Appoint_model->insert_patient($ref_no,$nic,$name,$dob,$gender);

        $patient_id = $this->Appoint_model->get_patient_id(0);
    }

    $this->Laboratory_model->insert_lab_service($invoice_no,$service_id,$patient_id,$year,$month,$test_date,$source,$requested,$dr,$charge,$center);
            
    //$this->session->set_flashdata('labmsg',"<div class='alert alert-success'>Service Added Successfully!</div>");

    //$this->Laboratory_model->insert_services($invoice_no,$service_id,$charge);
    $services = $this->Laboratory_model->addedServices($invoice_no);
    // Service List
    $this->service_list($services);
  }

  public function service_list($services)
  {
      ?>
      <table class="table">
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
                <td class="text-right text-danger" style="font-weight:900;"><?php echo $total; ?>.00</td>
            </tr>
            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                $('.delete_service').click(function() {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>Laboratory/deleteService", //490
                        data: ({
                            id: id
                        }),
                        cache: false,
                        success: function(html) {
                            //alert("hi");
                            $("#row" + id).fadeOut('slow');
                        }
                    });
                });
            });
        </script>
      <?php
  }

  public function update(){
    $service_id = $this->input->post('service_id');

    $patient_id = $this->input->post('patient_id');
    $lab_service_id = $this->input->post('lab_service_id');
    $labels = $this->input->post('labels');
    $result_value = $this->input->post('values');
    $values = explode('_', $result_value);

    $count = 0;
    foreach(explode('_',$labels) as $row)
    {
        $val = $values[$count];
        $this->Laboratory_model->insert_lab_service_result($patient_id,$lab_service_id,$row,$val);
        $count = $count + 1;
    }
    
    $this->Laboratory_model->update_status($lab_service_id);
    
    $data['service_data'] = $this->Laboratory_model->single_service($lab_service_id);

    $url = base_url() . "Laboratory/viewprintBill/" . $lab_service_id;
    redirect($url);

  }

  public function updateService(){
    $service_id = $this->input->post('service_id');
    $lab_service_id = $this->input->post('lab_service_id');

    $source = $this->input->post('source');
    $requested = $this->input->post('requested');
    $refer_dr = $this->input->post('refer_dr');
    $center = $this->input->post('center');
    
    $this->Laboratory_model->update_service($lab_service_id,$source,$requested,$refer_dr,$center);
    
    $data['services'] = $this->Laboratory_model->view_services($lab_service_id);

    $url = base_url() . "Laboratory/View/" . $service_id;
    redirect($url);

  }
  
  public function view_single($service_id){
        $data['page_title'] = 'View';
        $data['username'] = $this->Dashboard_model->username();
        // Customer List
        $data['pendings'] = $this->Booking_model->pending();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['invoice_no'] = $this->Laboratory_model->invoice_no();
        $data['locations'] = $this->Laboratory_model->locations();
        $data['services'] = $this->Laboratory_model->services();
        $data['doctors'] = $this->Laboratory_model->doctors();

        $data['titles'] = $this->Laboratory_model->titles();
        //Get Service Details by service id from url
        $data['service_data'] = $this->Laboratory_model->single_service($service_id); //103

        $data['nav'] = "Lap Service";
        $data['subnav'] = "View";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('Lab/view-single-service',$data);
        $this->load->view('Lab/footer');
  }

  public function edit($service_id){
    $data['page_title'] = 'View';
    $data['username'] = $this->Dashboard_model->username();
    // Customer List
    $data['pendings'] = $this->Booking_model->pending();

    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['invoice_no'] = $this->Laboratory_model->invoice_no();
    $data['locations'] = $this->Laboratory_model->locations();
    $data['services'] = $this->Laboratory_model->services();
    $data['doctors'] = $this->Laboratory_model->doctors();

    $data['titles'] = $this->Laboratory_model->titles();
    //Get Service Details by service id from url
    $data['service_data'] = $this->Laboratory_model->single_service($service_id); //103

    $data['nav'] = "Lap Service";
    $data['subnav'] = "View";

    $this->load->view('dashboard/layout/header',$data);
    $this->load->view('dashboard/layout/aside',$data);
    //$this->load->view('aside',$data);
    $this->load->view('Lab/edit-single-service',$data);
    $this->load->view('Lab/footer');
}

public function delete($service_id){
    $data['page_title'] = 'View';
    $data['username'] = $this->Dashboard_model->username();
    // Customer List
    $data['pendings'] = $this->Booking_model->pending();

    $data['pending_count'] = $this->Dashboard_model->pending_count();
    $data['confirm_count'] = $this->Dashboard_model->confirm_count();

    $data['invoice_no'] = $this->Laboratory_model->invoice_no();
    $data['locations'] = $this->Laboratory_model->locations();
    $data['services'] = $this->Laboratory_model->services();
    $data['doctors'] = $this->Laboratory_model->doctors();

    $data['titles'] = $this->Laboratory_model->titles();

    $data['nav'] = "Lap Service";
    $data['subnav'] = "View";

    $service = $this->Laboratory_model->delete_service($service_id);
    $data['services'] = $this->Laboratory_model->view_services($service);

    $url = base_url() . "Laboratory/View/" . $service;
    redirect($url);
}

  public function delete_service()
  {
    $id =  $this->input->post('id');
    $this->Laboratory_model->delete_service($id); //120
  }

    // Delete Added Services
  public function deleteService()
  {
        $id =  $this->input->post('id');
        $this->Laboratory_model->deleteService($id); //153
        
  }

  public function viewprintBill($id)
  {
    $data['service_data'] = $this->Laboratory_model->single_service($id); 
    $this->load->view('Lab/print_bill',$data);
  }

  public function printBill()
  {
    $data['service_data'] = $this->Laboratory_model->single_service_bill(); 
    $this->load->view('Lab/print_bill',$data);
  }

public function mobile_search()
{
    if ($this->input->post('mobile')) {
            
        $output = "";
        $mobile = $this->input->post('mobile');
        $result = $this->Laboratory_model->mobile_list($mobile);
        $output = '<ul class="list-unstyled">';	
        foreach ($result as $row)
        {
                $output .= '<li class="li-style">'.$row->mobile.'</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
}

public function patient_name(){
    $mobile = $this->input->post('mobile');
    echo $this->Laboratory_model->patient_name($mobile);
}

public function patient_nic(){
    $mobile = $this->input->post('mobile');
    echo $this->Laboratory_model->patient_nic($mobile);
}

public function patient_address(){
    $mobile = $this->input->post('mobile');
    echo $this->Laboratory_model->patient_address($mobile);
}

public function load_data()
{
    $services = $this->Laboratory_model->get_services($this->input->post('invoice'));
    $i = 1;
?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Name</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($services as $row)
                {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row->service; ?></td>
                <td>
                    <?php if($row->result_status == 0){ echo "Pending"; } else { echo "Completed"; } ?>
                </td>
                <td class="text-center">
                    <a href="<?php echo base_url(); ?>Laboratory/edit/<?php echo $row->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                    <a href="<?php echo base_url(); ?>Laboratory/delete/<?php echo $row->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                    <a href="<?php echo base_url(); ?>Laboratory/view_single/<?php echo $row->id; ?>" class="btn btn-info btn-xs"><i class="fa-solid fa-flask"></i></a>
                    <?php if($row->result_status == 0){ ?>
                    <a href="#" class="btn btn-success btn-xs" style="pointer-events: none;"><i class="fa fa-print"></i></a>
                    <?php } else { ?>
                    <a href="<?php echo base_url();?>Laboratory/viewprintBill/<?php echo $row->id;?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php
                $i = $i + 1;
                }
            ?>
        </tbody>
    </table>
<?php
}

}


/* End of file Laboratory.php */
/* Location: ./application/controllers/Laboratory.php */