<?php

class Department_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDepartments()
    {
        try {
            $query = $this->db->select("*")
                ->from("master_department")
                ->where("status", 0)
                ->get();
                
            if ($query->num_rows() > 0) {
                $rows = $query->result_array();
                return $rows;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
