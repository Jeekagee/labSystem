<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Dashboard_model extends CI_Model 
{
    public function username()
    {
        $user_id = $this->session->user_id;
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->username;
    }
    
    public function pending_count()
    {
        $sql = "SELECT * FROM booking WHERE status = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function confirm_count()
    {
        $sql = "SELECT * FROM booking WHERE status = 1 AND action = 0 AND cancel = 0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        $result = $query->num_rows();

        return $result;
    }

    public function recent_orders(){
        $sql = "SELECT * FROM bill_item ORDER BY created DESC LIMIT 5";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function menu($user_level){
        $sql = "SELECT * FROM user_menu WHERE user_level = $user_level ORDER BY order_menu";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function sub_menu($user_level,$main_id){
        $sql = "SELECT * FROM user_sub_menu WHERE user_level = $user_level AND main_menu_id = $main_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function main_menu($menu_id){
        $sql = "SELECT * FROM main_menu WHERE id = $menu_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function sub_menu_data($sub_menu_id){
        $sql = "SELECT * FROM sub_menu WHERE id = $sub_menu_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function total_service_income(){
        $sql = "SELECT amount FROM order_service WHERE status = 1";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->amount;
            }
        }

        return $total;
    }

    public function total_item_income(){
        $sql = "SELECT amount FROM order_item WHERE status = 1";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->amount;
            }
        }

        return $total;
    }

    public function total_expense(){
        $sql = "SELECT amount FROM expense";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $total = $total+$amt->amount;
            }
        }

        return $total;
    }
    
    public function total_purchase(){
        $sql = "SELECT * FROM purchase_items";
        $query = $this->db->query($sql);
        $result = $query->result();
        $count = $query->num_rows();

        $total = 0;

        if ($count > 0) {
            foreach ($result as $amt) {
                $price = $amt->purchase_price*$amt->quantity;
                $total = $total+$price;
            }
        }

        return $total;
    }
                        
}


/* End of file Dashboard_model.php and path /application/models/Dashboard_model.php */

