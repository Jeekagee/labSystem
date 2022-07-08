<?php     
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function index()
    {
        $data['page_title'] = 'Dashboard';
        $data['username'] = $this->Dashboard_model->username();
        
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['recent_orders'] = $this->Dashboard_model->recent_orders();

        $data['main_menu'] = $this->Dashboard_model->recent_orders();

        $data['nav'] = "";
        $data['subnav'] = "";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('dashboard/index',$data);
        $this->load->view('footer');
        $this->load->view('dashboard/layout/footer');
    }

    public function db_script(){
        /*patient_ni
        ALTER TABLE lab_service Modify column patient_nic varchar(10);  
        */
    }
}

/* End of file DashboardController.php and path /application/controllers/DashboardController.php */


