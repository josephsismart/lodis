<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    public function index()
    {
        $page_data = $this->system();
        $uri = $this->session->schoolmis_login_uri;
        $page_data += [
            "page_title"        => "Reports",
            "current_location"  => "reports",
            "content"           =>  [$this->load->view('interface/' . $uri . '/Reports', [
                "getOnLoad" => $this->getOnLoad(),
                "getSHdboard" => $this->getSHdboard(),
            ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function getMFGradelvl()
    {
        $data = [];
        $sy = $this->getOnLoad()["sy_id"];
        $query = $this->db->query("SELECT t1.*,t2.four_ps FROM (
                                    SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,t1.sctn_nm,t1.grade,
                                            SUM(t2.below_11)below_11,SUM(t2.age_11)age_11,SUM(t2.age_12)age_12,SUM(t2.age_13)age_13,SUM(t2.age_14)age_14,SUM(t2.age_15)age_15,SUM(t2.age_16)age_16,SUM(t2.age_17)age_17,SUM(t2.age_18)age_18,SUM(t2.age_19)age_19,SUM(t2.above_20)above_20
                                    FROM building_sectioning.view_room_section t1
                                    LEFT JOIN (SELECT t1.*
                                                    ,SUM(CASE WHEN t1.age_gap<11 THEN 1 END) AS below_11 
                                                    ,SUM(CASE WHEN t1.age_gap=11 THEN 1 END) AS age_11 
                                                    ,SUM(CASE WHEN t1.age_gap=12 THEN 1 END) AS age_12 
                                                    ,SUM(CASE WHEN t1.age_gap=13 THEN 1 END) AS age_13 
                                                    ,SUM(CASE WHEN t1.age_gap=14 THEN 1 END) AS age_14 
                                                    ,SUM(CASE WHEN t1.age_gap=15 THEN 1 END) AS age_15 
                                                    ,SUM(CASE WHEN t1.age_gap=16 THEN 1 END) AS age_16 
                                                    ,SUM(CASE WHEN t1.age_gap=17 THEN 1 END) AS age_17 
                                                    ,SUM(CASE WHEN t1.age_gap=18 THEN 1 END) AS age_18 
                                                    ,SUM(CASE WHEN t1.age_gap=19 THEN 1 END) AS age_19 
                                                    ,SUM(CASE WHEN t1.age_gap>19 THEN 1 END) AS above_20
                                                FROM (SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,
                                                            date_part('YEAR',  AGE(t1.birthdate)) AS age_gap
                                                        FROM building_sectioning.view_enrollment$sy t1
                                                        WHERE t1.schl_yr_id=1 AND t1.status_id=5) t1
                                                        GROUP BY t1.rssaid,t1.age_gap) t2 ON t1.rm_sctn_sbjct_assgnmnt_id = t2.rssaid
                                    WHERE t1.schl_yr_id = 1
                                    GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t1.sctn_nm,t1.grade,t1.order_by
                                    ORDER BY t1.order_by,t1.sctn_nm) t1
                                    LEFT JOIN (SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,
                                                            SUM(CASE WHEN t1.four_ps = TRUE THEN 1 ELSE 0 END) four_ps
                                                        FROM building_sectioning.view_enrollment$sy t1
                                                        WHERE t1.schl_yr_id=1 AND t1.status_id=5
                                                        GROUP BY t1.rm_sctn_sbjct_assgnmnt_id) t2 ON t1.rssaid = t2.rssaid");

        foreach ($query->result() as $key => $value) {
            $data[]=[
                "sctn_nm" => $value->sctn_nm,
                "grade" => $value->grade,
                "below_11" => $value->below_11,
                "age_11" => $value->age_11,
                "age_12" => $value->age_12,
                "age_13" => $value->age_13,
                "age_14" => $value->age_14,
                "age_15" => $value->age_15,
                "age_16" => $value->age_16,
                "age_17" => $value->age_17,
                "age_18" => $value->age_18,
                "age_19" => $value->age_19,
                "above_20" => $value->above_20,
                "four_ps" => $value->four_ps,
            ];
        }

        echo json_encode($data);
    }
}