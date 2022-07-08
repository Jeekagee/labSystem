<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Report_model extends CI_Model 
{
    public function inventory(){
        $sql = "SELECT id, item_id, purchase_id, SUM(qty) as totalqty FROM int_qty WHERE item_id  IN (SELECT item_id FROM int_items) GROUP BY item_id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    function fetch_data()
    {
    $this->db->order_by("item_id", "DESC");
    $query = $this->db->get("int_qty");
    return $query->result();
    }

    public function purchase_summary(){
        $sql = "SELECT id, purchase_id, item_id, purchase_price, quantity, selling_price, created_at FROM purchase_items WHERE created_at >= CURRENT_DATE() ORDER BY item_id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
      public function purchase_data($pur_id){
        $sql = "SELECT id, rec_date, ref_no, supplier FROM purchase WHERE id = $pur_id";
        $query = $this->db->query($sql);
        $row = $query->first_row();

        return $row;
    
    }
    
    public function customer()
    {
        $sql = "SELECT * FROM customer";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }  
    
    public function suppiler()
    {
        $sql = "SELECT * FROM supplier";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }  

    public function expense_report(){
        $sql = "SELECT id, ex_date, location, payee_name, description, method, amount FROM expense ORDER BY payee_name DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    public function data_transfer(){
        $sql = "SELECT id, item_id, quantity FROM purchase_items";
        $query = $this->db->query($sql);
        //$result = $query->num_rows();
        $result = $query->result();
        foreach ($result as $i) {
            $data = array(
                'purchase_id' => $i->id,
                'item_id' => $i->item_id,
                'qty' => $i->quantity,
            );
    
            $this->db->insert('int_qty', $data);
            # code...
        }
    }

    public function item_name($item_id){
        $sql = "SELECT item_name FROM int_items WHERE item_id='$item_id'";
        $query = $this->db->query($sql);
        return $row = $query->first_row();
    }
    
    public function delete_inventory($id)
    {
        $sql = "DELETE FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function edit_inventory($id)
    {
        $sql = "SELECT * FROM purchase_items WHERE id=$id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function total_qty(){
        $sql = "SELECT COUNT(item_id), item_name * FROM int_aty GROUP BY qty ORDER BY(item_id) DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        return $result;
    } 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }                  
}


/* End of file Report_model.php and path /application/models/Report_model.php */

