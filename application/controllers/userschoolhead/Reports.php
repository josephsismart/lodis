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
        $data = ["data"=>[]];
        $sy = $this->getOnLoad()["sy_id"];
        $tmpG = "";
        $tmpG2 = "";
        $tb11_m = 0;
        $tb11_f = 0;
        $t11_m = 0;
        $t11_f = 0;
        $t12_m = 0;
        $t12_f = 0;
        $t13_m = 0;
        $t13_f = 0;
        $t14_m = 0;
        $t14_f = 0;
        $t15_m = 0;
        $t15_f = 0;
        $t16_m = 0;
        $t16_f = 0;
        $t17_m = 0;
        $t17_f = 0;
        $t18_m = 0;
        $t18_f = 0;
        $t19_m = 0;
        $t19_f = 0;
        $t20_m = 0;
        $t20_f = 0;
        $query = $this->db->query("SELECT t1.*,t2.four_ps_m,t2.four_ps_f FROM (
                                    SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,t1.sctn_nm,t1.grade,
                                    SUM(t2.below_11_m) AS below_11_m,
                                    SUM(t2.below_11_f) AS below_11_f,
                                    SUM(t2.age_11_m) AS age_11_m,
                                    SUM(t2.age_11_f) AS age_11_f,
                                    SUM(t2.age_12_m) AS age_12_m,
                                    SUM(t2.age_12_f) AS age_12_f,
                                    SUM(t2.age_13_m) AS age_13_m,
                                    SUM(t2.age_13_f) AS age_13_f,
                                    SUM(t2.age_14_m) AS age_14_m,
                                    SUM(t2.age_14_f) AS age_14_f,
                                    SUM(t2.age_15_m) AS age_15_m,
                                    SUM(t2.age_15_f) AS age_15_f,
                                    SUM(t2.age_16_m) AS age_16_m,
                                    SUM(t2.age_16_f) AS age_16_f,
                                    SUM(t2.age_17_m) AS age_17_m,
                                    SUM(t2.age_17_f) AS age_17_f,
                                    SUM(t2.age_18_m) AS age_18_m,
                                    SUM(t2.age_18_f) AS age_18_f,
                                    SUM(t2.age_19_m) AS age_19_m,
                                    SUM(t2.age_19_f) AS age_19_f,
                                    SUM(t2.above_20_m) AS above_20_m,
                                    SUM(t2.above_20_f) AS above_20_f
                                    FROM building_sectioning.view_room_section t1
                                    LEFT JOIN (SELECT t1.*
                                    ,SUM(CASE WHEN t1.age_gap<11 AND t1.sex_bool=TRUE THEN 1 END) AS below_11_m 
													,SUM(CASE WHEN t1.age_gap<11 AND t1.sex_bool=FALSE THEN 1 END) AS below_11_f 
													,SUM(CASE WHEN t1.age_gap=11 AND t1.sex_bool=TRUE THEN 1 END) AS age_11_m 
													,SUM(CASE WHEN t1.age_gap=11 AND t1.sex_bool=FALSE THEN 1 END) AS age_11_f 
													,SUM(CASE WHEN t1.age_gap=12 AND t1.sex_bool=TRUE THEN 1 END) AS age_12_m 
													,SUM(CASE WHEN t1.age_gap=12 AND t1.sex_bool=FALSE THEN 1 END) AS age_12_f 
													,SUM(CASE WHEN t1.age_gap=13 AND t1.sex_bool=TRUE THEN 1 END) AS age_13_m 
													,SUM(CASE WHEN t1.age_gap=13 AND t1.sex_bool=FALSE THEN 1 END) AS age_13_f 
													,SUM(CASE WHEN t1.age_gap=14 AND t1.sex_bool=TRUE THEN 1 END) AS age_14_m 
													,SUM(CASE WHEN t1.age_gap=14 AND t1.sex_bool=FALSE THEN 1 END) AS age_14_f 
													,SUM(CASE WHEN t1.age_gap=15 AND t1.sex_bool=TRUE THEN 1 END) AS age_15_m 
													,SUM(CASE WHEN t1.age_gap=15 AND t1.sex_bool=FALSE THEN 1 END) AS age_15_f 
													,SUM(CASE WHEN t1.age_gap=16 AND t1.sex_bool=TRUE THEN 1 END) AS age_16_m 
													,SUM(CASE WHEN t1.age_gap=16 AND t1.sex_bool=FALSE THEN 1 END) AS age_16_f 
													,SUM(CASE WHEN t1.age_gap=17 AND t1.sex_bool=TRUE THEN 1 END) AS age_17_m 
													,SUM(CASE WHEN t1.age_gap=17 AND t1.sex_bool=FALSE THEN 1 END) AS age_17_f 
													,SUM(CASE WHEN t1.age_gap=18 AND t1.sex_bool=TRUE THEN 1 END) AS age_18_m 
													,SUM(CASE WHEN t1.age_gap=18 AND t1.sex_bool=FALSE THEN 1 END) AS age_18_f 
													,SUM(CASE WHEN t1.age_gap=19 AND t1.sex_bool=TRUE THEN 1 END) AS age_19_m 
													,SUM(CASE WHEN t1.age_gap=19 AND t1.sex_bool=FALSE THEN 1 END) AS age_19_f 
													,SUM(CASE WHEN t1.age_gap>19 AND t1.sex_bool=TRUE THEN 1 END) AS above_20_m
													,SUM(CASE WHEN t1.age_gap>19 AND t1.sex_bool=FALSE THEN 1 END) AS above_20_f
                                                FROM (SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,
                                                            date_part('YEAR',  AGE(t1.birthdate)) AS age_gap,
                                                            t1.sex_bool
                                                        FROM building_sectioning.view_enrollment1 t1
                                                        WHERE t1.schl_yr_id=1 AND t1.status_id=5) t1
                                                        GROUP BY t1.rssaid,t1.age_gap,t1.sex_bool) t2 ON t1.rm_sctn_sbjct_assgnmnt_id = t2.rssaid
                                    WHERE t1.schl_yr_id = 1
                                    GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t1.sctn_nm,t1.grade,t1.order_by
                                    ORDER BY t1.order_by,t1.sctn_nm) t1
                                    LEFT JOIN (SELECT t1.rssaid, SUM(t1.four_ps_m) AS four_ps_m,SUM(t1.four_ps_f) AS four_ps_f FROM(
                                                    SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssaid,
                                                        SUM(CASE WHEN t1.four_ps = TRUE AND t1.sex_bool=TRUE THEN 1 ELSE 0 END) four_ps_m,
                                                        SUM(CASE WHEN t1.four_ps = TRUE AND t1.sex_bool=FALSE THEN 1 ELSE 0 END) four_ps_f
                                                    FROM building_sectioning.view_enrollment$sy t1
                                                    WHERE t1.schl_yr_id=1 AND t1.status_id=5
                                                    GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t1.sex)t1    
                                                GROUP BY t1.rssaid) t2 ON t1.rssaid = t2.rssaid");

        foreach ($query->result() as $key => $value) {
            if (($tmpG !="") && ($tmpG != $value->grade)){
                // if($tmpG2==""){
                    $data["data"][]=[
                        "<center><b>TOTAL".$value->sctn_nm."</b></center>",
                        $tb11_m,
                        $tb11_f,
                        $t11_m,
                        $t11_f,
                        $t12_m,
                        $t12_f,
                        $t13_m,
                        $t13_f,
                        $t14_m,
                        $t14_f,
                        $t15_m,
                        $t15_f,
                        $t16_m,
                        $t16_f,
                        $t17_m,
                        $t17_f,
                        $t18_m,
                        $t18_f,
                        $t19_m,
                        $t19_f,
                        $t20_m,
                        $t20_f,
                        "","","",""
                    ];
                    $tb11_m = 0;
                    $tb11_f = 0;
                    $t11_m = 0;
                    $t11_f = 0;
                    $t12_m = 0;
                    $t12_f = 0;
                    $t13_m = 0;
                    $t13_f = 0;
                    $t14_m = 0;
                    $t14_f = 0;
                    $t15_m = 0;
                    $t15_f = 0;
                    $t16_m = 0;
                    $t16_f = 0;
                    $t17_m = 0;
                    $t17_f = 0;
                    $t18_m = 0;
                    $t18_f = 0;
                    $t19_m = 0;
                    $t19_f = 0;
                    $t20_m = 0;
                    $t20_f = 0;
                    $data["data"][]=[
                        " ","","","","","","","","","","","","","","","","","","","","","","","","","","","",
                    ];
                // }else{
                // }
                // $tmpG2 = "";
            }

            if ($tmpG != $value->grade){
                $data["data"][]=[
                    "<center><b>GRADE - ".$value->grade."</b></center>","","","","","","","","","","","","","","","","","","","","","","","","","","","",
                ];
            }
            $data["data"][]=[
                $value->sctn_nm,
                $value->below_11_m,
                $value->below_11_f,
                $value->age_11_m,
                $value->age_11_f,
                $value->age_12_m,
                $value->age_12_f,
                $value->age_13_m,
                $value->age_13_f,
                $value->age_14_m,
                $value->age_14_f,
                $value->age_15_m,
                $value->age_15_f,
                $value->age_16_m,
                $value->age_16_f,
                $value->age_17_m,
                $value->age_17_f,
                $value->age_18_m,
                $value->age_18_f,
                $value->age_19_m,
                $value->age_19_f,
                $value->above_20_m,
                $value->above_20_f,
                $value->four_ps_m,
                $value->four_ps_f,
                $value->grade,
                $value->grade,
                $value->grade,
            ];
            $tb11_m += (int) $value->below_11_m;
            $tb11_f += (int) $value->below_11_f;
            $t11_m += (int) $value->age_11_m;
            $t11_f += (int) $value->age_11_f;
            $t12_m += (int) $value->age_12_m;
            $t12_f += (int) $value->age_12_f;
            $t13_m += (int) $value->age_13_m;
            $t13_f += (int) $value->age_13_f;
            $t14_m += (int) $value->age_14_m;
            $t14_f += (int) $value->age_14_f;
            $t15_m += (int) $value->age_15_m;
            $t15_f += (int) $value->age_15_f;
            $t16_m += (int) $value->age_16_m;
            $t16_f += (int) $value->age_16_f;
            $t17_m += (int) $value->age_17_m;
            $t17_f += (int) $value->age_17_f;
            $t18_m += (int) $value->age_18_m;
            $t18_f += (int) $value->age_18_f;
            $t19_m += (int) $value->age_19_m;
            $t19_f += (int) $value->age_19_f;
            $t20_m += (int) $value->above_20_m;
            $t20_f += (int) $value->above_20_f;
            
            $tmpG = $value->grade;
        }

        echo json_encode($data);
    }
}