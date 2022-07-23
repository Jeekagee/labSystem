<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Orders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Model
        $this->load->model('Dashboard_model');
        $data['username'] = $this->Dashboard_model->username();
        //Load Model
        $this->load->model('Orders_model');
        //Already logged In
        if (!$this->session->has_userdata('user_id')) {
            redirect('/LoginController/logout');
        }
    }
    public function index()
    {
        $data['page_title'] = 'Orders';
        $data['username'] = $this->Dashboard_model->username();

        // $data['orders'] = $this->Orders_model->orders();
        

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Orders";

        $data['lab_services'] = $this->Orders_model->all_services();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/lab_dashboard',$data);
        $this->load->view('orders/footer');
    }

    public function insert(){

        $data['page_title'] = 'Add Order';
        $data['nav'] = 'Orders';

        $data['username'] = $this->Dashboard_model->username();

        $data['items'] = $this->Orders_model->purchase_items();

        //create a order
        $this->Orders_model->create_order(); //20

        // Order items
        $data['order_items'] = $this->Orders_model->order_items(); //36

        //current order id
        $data['order_id'] = $this->Orders_model->last_order_id();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Add Order";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/add-order',$data);
        $this->load->view('orders/footer');
    }

    public function insert_order_item(){
        $p_id =  $this->uri->segment('3');
        $order_id =  $this->uri->segment('4');

        //Get item id from purchase_items table
        $purchase_data = $this->Orders_model->purchase_data($p_id);
        $item_id = $purchase_data->item_id;

        // Insert into order_items
        $order_item_insert = $this->Orders_model->insert_order_item($item_id,$order_id,$p_id);//50

        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function delete_order_item(){
        $id =  $this->uri->segment('3');
        $this->Orders_model->delete_order_item($id); //90
        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function clear_items(){
        $order_id =  $this->uri->segment('3');
        $this->Orders_model->clear_items($order_id);
        // Redirect to Add Order //95
        redirect('/Orders/insert');
    }

    public function add_discount(){
        $order_id =  $this->input->post('order_id');
        $discount =  $this->input->post('discount');
        $type =  $this->input->post('discount_type');
        $this->Orders_model->add_discount($order_id,$discount,$type); //107
        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function hold_order(){
        $order_id =  $this->uri->segment('3');
        $this->Orders_model->hold_order($order_id); //124
        // Redirect to Add Order //95
        redirect('/Orders/insert');
    }

    public function add_bill(){
        $order_id =  $this->input->post('p_order_id');
        $sub_total =  $this->input->post('sub_total');
        $discount =  $this->input->post('discount');
        $p_amount =  $this->input->post('p_amount');
        $p_method =  $this->input->post('p_method');

        // Bill No
        $bill_no = $this->Orders_model->last_bill_no()+1; //133
        // Insert New Bill
        $this->Orders_model->insert_order($order_id,$bill_no,$sub_total,$discount,$p_amount,$p_method);
        // Update Order Table
        $this->Orders_model->paid_order($order_id); //148

        // Redirect to Add Order //95
        redirect('/Orders/print_bill/'.$bill_no); // 137

    }

    public function print_bill(){
        $bill_no =  $this->uri->segment('3');
        $data['bill_data'] = $this->Orders_model->bill_data($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    public function edit(){
        $bill_no =  $this->uri->segment('3');
        $data['page_title'] = 'Edit Order';
        $data['username'] = $this->Dashboard_model->username();
        $data['vehicle_types'] = $this->Orders_model->vehicle_types();
        $data['vehicle_makes'] = $this->Orders_model->vehicle_makes();
        $data['services'] = $this->Orders_model->services();
        
        // Labours
        $data['bays'] = $this->Orders_model->bays();

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['order'] = $this->Orders_model->edit_order($bill_no);

        $data['nav'] = "Orders";
        $data['subnav'] = "Add Order";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/edit',$data);
        $this->load->view('orders/footer');
    }

    public function update(){
        
        $order_id = $this->input->post('order_id');
        $vehicle_no = $this->input->post('vehicle_no');
        $contact_no = $this->input->post('contact_no');
        $cus_name = $this->input->post('cus_name');
        $bill_no = $this->input->post('bill_no');
        $bill_date = $this->input->post('bill_date');
        $type = $this->input->post('type');
        $make = $this->input->post('make');
        $discount = $this->input->post('discount');


        $this->Orders_model->update_order($cus_name,$vehicle_no,$contact_no,$bill_no,$bill_date,$type,$make,$discount);
        //New Vehicle for Order
        if ($this->Orders_model->new_vehicle($vehicle_no) == 0) {
            //Insert Vehicle
            $this->Orders_model->insert_vehicle($vehicle_no, $contact_no,$cus_name);
        }
        else{
            // Update Contact Number
            $this->Orders_model->update_contact_no($vehicle_no,$contact_no,$cus_name);
        }
        
        redirect('Orders');
    }

    public function vehicle_search(){

        if ($this->input->post('vehicle_no')) {
            
            $output = "";
            $vehicle_no = $this->input->post('vehicle_no');
            $result = $this->Orders_model->vehicle_list($vehicle_no);
            $output = '<ul class="list-unstyled">';	
            foreach ($result as $row)
            {
                    $output .= '<li class="li-style">'.$row->vehicle_no.'</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function contact_no(){
        $v_no = $this->input->post('v_no');
        echo $contact_no = $this->Orders_model->get_contact_no($v_no);
    }

    public function customername(){
        $v_no = $this->input->post('v_no');
        echo $customername = $this->Orders_model->get_customername($v_no);
    }

    public function do_upload(){
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 3000;
                $config['max_width']            = 2000;
                $config['max_height']           = 2000;
                $config['file_name'] = "order_".$bill_no;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload_success', $data);
                }
    }

    public function validation(){

        $this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact Number', 'required|numeric|max_length[10]');
        $this->form_validation->set_rules('discount', 'Discount', 'numeric');
        if ($this->input->post('ckm')) {
            $this->form_validation->set_rules('ckm', 'Current km', 'numeric');
        }
        if ($this->input->post('nkm')) {
            $this->form_validation->set_rules('nkm', 'Next km', 'numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->insert();
        }
        else{

            //Set Bill No
            $last_bill_no = $this->Orders_model->last_bill();

            $bill_no = $last_bill_no+1;

            $vehicle_no = $this->input->post('vehicle_no');
            $cus_name = $this->input->post('customer_name');
            $contact_no = $this->input->post('contact_no');
            $bill_date = $this->input->post('bill_date');
            $type = $this->input->post('type');
            $make = $this->input->post('make');

            if ($this->input->post('ckm')) {
                $ckm = $this->input->post('ckm');
            }
            else{
                $ckm = 0;
            }

            if ($this->input->post('nkm')) {
                $nkm = $this->input->post('nkm');
            }
            else{
                $nkm = 0;
            }
            
            
            $reminder = $this->input->post('reminder');
            $discount = $this->input->post('discount');
            $bay = implode(",",$this->input->post('bay'));

            if ($this->Orders_model->insert_order($vehicle_no,$cus_name,$contact_no,$bill_no,$bill_date,$type,$make,$bay,$discount,$reminder,$ckm,$nkm)) {
                //Line 104

                //Image Upload
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 3000;
                $config['max_width']            = 2000;
                $config['max_height']           = 2000;
                $config['file_name'] = "order_".$bill_no;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                       
                }
                else
                {
                        $order_img = $this->upload->data('file_name');
                        $this->Orders_model->update_img($bill_no,$order_img);
                }
               
                //Confirm Services and Items
                $this->Orders_model->update_order_service($bill_no); //545
                $this->Orders_model->update_order_item($bill_no); //554

                // Reduce from purchase items
                $this->Orders_model->update_quantity($bill_no); //661

                //Reminder Table
                if ($this->Orders_model->reminder_available($vehicle_no,$contact_no) > 0) {
                    //Update Reminder Table
                    $this->Orders_model->update_reminder($vehicle_no,$reminder);
                }
                else{
                    // Inser New Row
                    $this->Orders_model->insert_reminder($vehicle_no,$contact_no,$reminder);
                }
                
                //New Vehicle for Order
                if ($this->Orders_model->new_vehicle($vehicle_no) == 0) {
                    //Insert Vehicle
                    $this->Orders_model->insert_vehicle($vehicle_no, $contact_no,$cus_name); //198
                }
                else{
                    // Update Contact Number
                    $this->Orders_model->update_contact_no($vehicle_no, $contact_no,$cus_name);
                }

                $this->session->set_flashdata('addordersuccess',"<div class='alert alert-success'>Order Added Successfully!</div>");
                redirect('Orders/View/'.$bill_no);
            }

        }
    }

    public function printBill($bill_no){
        $data['basic'] = $this->Orders_model->order_data($bill_no);
        $data['services'] = $this->Orders_model->order_service($bill_no);
        $data['items'] = $this->Orders_model->order_item($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    public function viewprintBill(){
        $bill_no =  $this->uri->segment('3');
        $data['basic'] = $this->Orders_model->order_data($bill_no);
        $data['services'] = $this->Orders_model->order_service($bill_no);
        $data['items'] = $this->Orders_model->order_item($bill_no);
        $this->load->view('orders/print_bill',$data);
    }

    //Service Amount for Order
    public function service_amount(){
        $service = $this->input->post('service');
        echo $this->Orders_model->service_amount($service); //138

    }

   

    public function view(){

        $bill_no =  $this->uri->segment('3');

        $data['page_title'] = 'View Order';
        $data['username'] = $this->Dashboard_model->username();

        $data['order'] = $this->Orders_model->view_order($bill_no);

        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['nav'] = "Orders";
        $data['subnav'] = "Orders";

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/view-order');
        $this->load->view('footer');
        $this->load->view('orders/footer');
    }

    public function Confirm_Bills(){
        $data['page_title'] = 'Confirm Bills';
        $data['username'] = $this->Dashboard_model->username();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        $data['bills'] = $this->Orders_model->bills_confirmed();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        //$this->load->view('aside',$data);
        $this->load->view('orders/confirm_bills',$data);
        $this->load->view('orders/footer');
    }

    public function AddExpenses(){
        $data['page_title'] = 'Add Expenses';
        $data['username'] = $this->Dashboard_model->username();
        $data['pending_count'] = $this->Dashboard_model->pending_count();
        $data['confirm_count'] = $this->Dashboard_model->confirm_count();

        //Load Model
        $this->load->model('Inventory_model');

        //Item Catogiries
        $data['catogories'] = $this->Inventory_model->item_catogories();

        $data['location'] = $this->Orders_model->locations();

        $this->load->view('dashboard/layout/header',$data);
        $this->load->view('dashboard/layout/aside',$data);
        $this->load->view('orders/add-expenses',$data);
        $this->load->view('orders/footer');
    }

    public function insert_expense(){

        $this->form_validation->set_rules('ex_date', 'Date', 'required');
        $this->form_validation->set_rules('ref_no', 'Ref_No', 'required|is_unique[expense.ref_no]');
        $this->form_validation->set_rules('name', 'Payee Name', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->AddExpenses();
        }
        else{

            $ex_date = $this->input->post('ex_date');
            $location = $this->input->post('location');
            $ref_no = $this->input->post('ref_no');
            $name = $this->input->post('name');
            $des = $this->input->post('des');
            $cat = $this->input->post('cat');
            $sub_cat = $this->input->post('subcat');
            $method = $this->input->post('method');
            $check_date = $this->input->post('check_date');
            $amount = $this->input->post('amount');

            if ($method == "cheque") {
                $paid = 0;
            }
            else{
                $paid = 1;
            }
            
            $this->Orders_model->insert_expense($ex_date,$location,$ref_no,$name,$des,$cat,$sub_cat,$method,$amount,$check_date,$paid);

            $this->session->set_flashdata('success',"<div class='alert alert-success'>Expense Added Successfully!</div>");
            redirect('Orders/AddExpenses');
        }

    }

    public function Add_Service(){
        if ($this->input->post('service')) {
            $service_id = $this->input->post('service');
        }
        $bill_no = $this->input->post('bill_no');
        //insert order service into temperary table
        if ($this->input->post('service')) {
            if ($this->Orders_model->order_service_available($service_id,$bill_no) > 0) { //562
                echo "<div class='alert alert-warning'>Please Add New Service</div>"; //for show error
            }
            else{
                $this->Orders_model->insert_order_service($service_id,$bill_no); //452
            }
        }
        
        //Show selected service
        if ($this->Orders_model->is_selected_services($bill_no) > 0) { //476

            $order_service = $this->Orders_model->order_service($bill_no);
            ?>

                <table class="table table-striped">
                    <thead>
                        <th>Service</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                            foreach ($order_service as $order_ser) {
                        ?>
                            <tr id="row<?php echo $order_ser->id; ?>">
                                <td><?php echo $order_ser->service; ?></td>
                                <td class="text-right"><?php echo $order_ser->amount; ?>.00</td>
                                <td class="text-center">
                                    <a class="btn btn-danger delete_service" id="<?php echo $order_ser->id; ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('.delete_service').click(function() {
                            var id = $(this).attr("id");
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>Orders/deleteOrderService", //490
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
    }

    public function deleteOrderService(){
        $id = $this->input->post('id');
        $this->Orders_model->deleteOrderService($id); // 490
    }

    public function deleteService(){
        $id =  $this->uri->segment('3');
        $orderid =  $this->uri->segment('4');
        $this->Orders_model->deleteOrderService($id); // 490
        // Redirect to Orders
        redirect('Orders/edit/'.$orderid);

    }

    public function deleteItem(){
        $id =  $this->uri->segment('3');
        $orderid =  $this->uri->segment('4');
        $this->Orders_model->deleteOrderItem($id); // 490
        // Redirect to Orders
        redirect('Orders/edit/'.$orderid);

    }

    public function Add_item(){
        if ($this->input->post('p_id')) {
            $p_id = $this->input->post('p_id');
            $item_id = $this->Orders_model->get_item_id($p_id);
        }
        $bill_no = $this->input->post('bill_no');
        $qty = $this->input->post('qty');

        //insert order service into temperary table
        if ($this->input->post('p_id')) {
            if ($this->Orders_model->order_item_available($item_id,$bill_no) > 0) { //568
                $this->Orders_model->update_qty($item_id,$bill_no,$qty); //582
            }
            else{
                $this->Orders_model->insert_order_item($item_id,$bill_no,$qty,$p_id); //503
            }
            
        }
        
        if ($this->Orders_model->is_selected_item($bill_no) > 0) { //521

            $order_item = $this->Orders_model->order_item($bill_no);//531

            ?>

                <table class="table table-striped">
                    <thead>
                        <th>Item</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                            foreach ($order_item as $order_itm) {
                        ?>
                            <tr id="item<?php echo $order_itm->id; ?>">
                                <td><?php echo $order_itm->item_name; ?></td>
                                <td class="text-right"><?php echo $order_itm->amount; ?>.00</td>
                                <td class="text-center"><?php echo $order_itm->qty; ?></td>
                                <td class="text-right"><?php echo $order_itm->qty*$order_itm->amount; ?>.00</td>
                                <td class="text-center">
                                    <a class="btn btn-danger delete_item" id="<?php echo $order_itm->id; ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('.delete_item').click(function() {
                            var id = $(this).attr("id");
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>Orders/deleteOrderItem", //629
                                    data: ({
                                        id: id
                                    }),
                                    cache: false,
                                    success: function(html) {
                                        //alert("hi");
                                        $("#item" + id).fadeOut('slow');
                                    }
                                });
                        });
                    });
                </script>
            <?php
            
        }
    }

    public function deleteOrderItem(){
        $id = $this->input->post('id');
        $this->Orders_model->deleteOrderItem($id); // 539
    }

    public function add_vehicle_type(){
        $v_type = $this->input->post('v_type');

        if ($v_type != "") {
            $this->Orders_model->insert_vehicle_type($v_type); //688
        }

        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function add_vehicle_make(){
        $v_make = $this->input->post('v_make');

        if ($v_make != "") {
            $this->Orders_model->insert_vehicle_make($v_make); //695
        }

        // Redirect to Add Order
        redirect('/Orders/insert');
    }

    public function item_search(){

        if ($this->input->post('search_text')) {
            $search_text = $this->input->post('search_text');
            $order_id = $this->Orders_model->last_order_id();
            if ($search_text == "") {
                $items = $this->Orders_model->purchase_items();
                foreach ($items as $row)
                {
                    $p_id = $row->id;
                        ?>
                        <a href="<?php echo base_url(); ?>Orders/insert_order_item/<?php echo $p_id; ?>/<?php echo $order_id; ?>">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="item_box">
                                    <div class="item_m">
                                    <?php echo $item_id = $row->item_id; ?>
                                    </div>
                                    <div class="item_m">
                                    <?php echo $this->Orders_model->item_name($item_id); ?>
                                    </div>
                                    <div class="item_m">
                                    Qty : <?php echo $item_id = $row->quantity; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                }
            }
            else{
                $result = $this->Orders_model->search_items($search_text);
                foreach ($result as $row)
                {
                    $p_id = $row->id;
                        ?>
                            <a href="<?php echo base_url(); ?>Orders/insert_order_item/<?php echo $p_id; ?>/<?php echo $order_id; ?>">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="item_box">
                                        <div class="item_m">
                                        <?php echo $item_id = $row->item_id; ?>
                                        </div>
                                        <div class="item_m">
                                        <?php echo $this->Orders_model->item_name($item_id); ?>
                                        </div>
                                        <div class="item_m">
                                        Qty : <?php echo $item_id = $row->quantity; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php
                }
            }
        }
    }


}

/* End of file Orders.php and path /application/controllers/Orders.php */


