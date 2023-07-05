<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   
    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Menu
    if (!function_exists('get_sidebar_menu')) {
        function get_sidebar_menu()
        {
            $ci =& get_instance();
            $ci->load->database();  
            
             $designation_id = $ci->session->userdata('designation_id'); 
             $sql = "SELECT bm.id as menu_id,bm.menu_name,bm.url,bm.fa_fa_icons from bdscrm_menu_access as bma 
                    left join bdscrm_menus as bm on bma.menu_id = bm.id
                    WHERE bma.status=1 AND bma.access=1 AND bm.status=1 AND bma.designation='$designation_id' GROUP BY 1;"; 
            $query = $ci->db->query($sql);
            $row = $query->result_array();
            foreach ($row as $key => $menus) {
                $id = $menus['menu_id'];

                $submenu = "SELECT bs.* from bdscrm_submenu_access as bsa 
                left join bdscrm_submenus as bs on bsa.submenu_id = bs.id
                WHERE bs.status=1 AND bs.menu_id=$id AND bsa.designation_id = $designation_id";


                $querys = $ci->db->query($submenu);
                $submenu = $querys->result_array();
                $menu[] = $menus;
                $menu[$key]['submenu'] = $submenu;    
            }

            return $menu;

        }
    }


     if (!function_exists('getMenus')) {
        function getMenus()
        {
            $ci =& get_instance();
            $ci->load->database();   
            $designation_id = $ci->session->userdata('designation_id');
            $sql = "SELECT bm.id as menu_id,bm.menu_name,bm.url,bm.fa_fa_icons from bdscrm_menu_access as bma 
                    left join bdscrm_menus as bm on bma.menu_id = bm.id
                    WHERE bma.status=1 AND bma.access=1 AND bm.status=1 GROUP BY 1;"; 
            $query = $ci->db->query($sql);
            $row = $query->result_array();
            foreach ($row as $key => $menus) {
                $id = $menus['menu_id'];
                $submenu = "SELECT * FROM `bdscrm_submenus` WHERE status =1 AND menu_id=$id"; 
                $querys = $ci->db->query($submenu);
                $submenu = $querys->result_array();
                $menu[] = $menus;
                $menu[$key]['submenu'] = $submenu;    
            }

            return $menu;
        }
    }


    if (!function_exists('getRolesByMenuId')) {
        function getRolesByMenuId($designation_id,$menu_id)
        {
            $ci =& get_instance();
            $ci->load->database();   
            $sql = "select * from bdscrm_menu_access where menu_id='$menu_id' AND designation = '$designation_id' AND status=1 AND access=1"; 
            $query = $ci->db->query($sql);
            $row = $query->result_array();
            return $row;
        }
    }


    if (!function_exists('getRolesBySubMenuId')) {
        function getRolesBySubMenuId($designation_id,$submenu_id)
        {
            $ci =& get_instance();
            $ci->load->database();   
            $sql = "select * from bdscrm_submenu_access where  
            designation_id = '$designation_id' AND submenu_id='$submenu_id' AND status=1 AND access=1"; 
            $query = $ci->db->query($sql);
            $row = $query->result_array();
            return $row;
        }
    }



    if (!function_exists('getFeildsAccess')) {
        function getFeildsAccessByTaskType($feild_id,$task_type_id)
        {
            $ci =& get_instance();
            $ci->load->database();   
            $sql = "select id from bdcrm_default_feilds_access where feild_id='$feild_id' AND task_type_id='$task_type_id'"; 
            $query = $ci->db->query($sql);
            $row = $query->result_array();
            return count($row);
        }
    }

    if (!function_exists('div_access')) {
        function div_access($all_data,$check_data)
        {
           $data=count(array_intersect($all_data,$check_data));
           return $data;
        }
    }


    








     

    




?>