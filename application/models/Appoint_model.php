<?php
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Appoint_model extends CI_Model 
{
    public function insert_appoint($id,$nic,$pname,$mobile,$address,$area,$doctor,$dcharge,$app_date,$tym,$comment,$location){
        $data = array(
            'nic' => $nic,
            'name' => $pname,
            'mobile' => $mobile,
            'area' => $area,
            'doctor' => $doctor,
            'time' => $tym,
            'comment' => $comment,
            'id' => $id,
            'address' => $address,
            'doc_charge' => $dcharge,
            'app_date' => $app_date,
            'user_location' => $location
        );
    
        $this->db->insert('appoint', $data);
    }

    public function appoints(){
        $sql = "SELECT * FROM appoint ORDER BY created DESC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function specials(){
        $sql = "SELECT * FROM specialization ORDER BY specialization ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function doctors($area){
        $sql = "SELECT * FROM doctor WHERE specialization = $area ORDER BY name ASC";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function doctors_charge($doctor){
        $sql = "SELECT charge FROM doctor WHERE id = $doctor";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->charge;
    }

    public function invoice_no(){
        $sql = "SELECT id FROM appoint ORDER BY created DESC";
        $query = $this->db->query($sql);
        $conut = $query->num_rows();
        $row = $query->first_row();

        if ($conut == 0) {
            return 1;
        }
        else{
            return $row->id+1;
        }
    }

    public function insert_other($other,$amount,$invoice_no){
        $data = array(
            'description' => $other,
            'charge' => $amount,
            'invoice_no' => $invoice_no
        );
    
        $this->db->insert('other_charge', $data);
    }

    public function other_charges($invoice_no){
        $sql = "SELECT * FROM other_charge WHERE invoice_no = $invoice_no";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function nic_list($nic){
        $sql = "SELECT * FROM patient WHERE nic LIKE '%$nic%'";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function patient_available($nic){
        $sql = "SELECT nic FROM patient WHERE nic = '$nic'";
        $query = $this->db->query($sql);
        return $conut = $query->num_rows();
    }

    public function insert_patient($ref_no,$nic,$name,$dob,$gender,$mobile){
        $data = array(
            'ref_no' => $ref_no,
            'nic' => $nic,
            'name' => $name,
            'dob' => $dob,
            'gender' => $gender,
            'mobile_no' => $mobile,
        );
    
        $this->db->insert('patient', $data);
    }

    public function update_patient($nic,$pname,$mobile,$address,$title,$ageyear,$agemonth,$gender){
        $data = array(
            'name' => $pname,
            'mobile' => $mobile,
            'address' => $address,
            'title' => $title,
            'ageyear' => $ageyear,
            'agemonth' => $agemonth,
            'gender' => $gender
        );
        
        $this->db->where('nic', $nic);
        $this->db->update('patient', $data);
    }

    public function patient_name($nic){
        $sql = "SELECT name FROM patient WHERE nic = '$nic'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->name;
    }

    public function patient_mobile($nic){
        $sql = "SELECT mobile_no FROM patient WHERE nic = '$nic'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->mobile_no;
    }

    public function patient_gender($nic){
        $sql = "SELECT gender FROM patient WHERE nic = '$nic'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        if($row->gender == 1)
        {
            return "male";
        }
        else
        {
            return "female";
        }
    }

    public function patient_dob($nic){
        $sql = "SELECT dob FROM patient WHERE nic = '$nic'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->dob;
    }

    public function doctor_name($id){
        $sql = "SELECT name FROM doctor WHERE id = $id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->name;
    }

    public function area_name($area){
        $sql = "SELECT specialization FROM specialization WHERE id = $area";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->specialization;
    }

    public function view($id){
        $sql = "SELECT * FROM appoint WHERE id = $id";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    public function doctor_for_area($area){
        $sql = "SELECT * FROM doctor WHERE specialization = $area";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }

    public function update_appoint($id,$nic,$pname,$mobile,$address,$area,$doctor,$dcharge,$app_date,$tym,$comment){
        $data = array(
            'nic' => $nic,
            'name' => $pname,
            'mobile' => $mobile,
            'area' => $area,
            'doctor' => $doctor,
            'time' => $tym,
            'comment' => $comment,
            'address' => $address,
            'doc_charge' => $dcharge,
            'app_date' => $app_date
        );
    
        $this->db->where('id', $id);
        $this->db->update('appoint', $data);
    }

    public function insert_area($area){
        $data = array(
            'specialization' => $area
        );
    
        $this->db->insert('specialization', $data);
    }

    public function get_patient_id($nic){
        if($nic != 0)
        {
            $sql = "SELECT id FROM patient WHERE nic = '$nic' ORDER BY id DESC";
        }
        else
        {
            $sql = "SELECT id FROM patient ORDER BY id DESC";
        }
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row->id;
    }

    public function get_patient_ref_no(){
        $sql = "SELECT ref_no FROM patient ORDER BY id DESC";
        $query = $this->db->query($sql);
        $conut = $query->num_rows();
        $row = $query->first_row();
        if($conut > 0)
        {
            $ref_no = $row->ref_no + 1;
        }
        else
        {
            $ref_no = 00001;
        }
        
        return $ref_no;
    }
}