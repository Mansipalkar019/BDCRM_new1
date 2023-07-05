<?php

class Login_Model extends CI_Model{
    public function usercheck($username, $password)
    {

       $sql = "SELECT u.*,ds.designation_name,ds.id as designation_id FROM `users` as u 
                left join master_designation as ds on u.designation = ds.id where u.status=1 AND u.username='$username' AND u.password='$password'";
        return $this->model->getSqlData($sql);


        
    }
}
