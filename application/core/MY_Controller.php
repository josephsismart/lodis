<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public $global_requestid = null;
    public $global_requestid_personnel = null;

    public function system()
    {
        $data = [
            "system_title"  => "Libertad National High School",
            "system_logo"   => base_url("dist/img/icons/icon.png"),
            "system_svg"    => base_url("dist/img/icons/icon_svg.png"),
            "system_op"    => base_url("dist/img/icons/icon_op.png"),
        ];
        return $data;
    }

    public function public_create_page($data = [])
    {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        if ($level != "") {
            if ($defaultPassword == 't') {
                return $this->load->view('interface/userpassword/layout/Page', $data, false);
            } else {
                return $this->load->view('interface/' . $uri . '/layout/Page', $data, false);
            }
        }
    }

    public function user_create_page($data = [])
    {
        return $this->load->view('interface/user/layout/Page', $data, false);
    }

    public function redirect()
    {
        $login = $this->session->schoolmis_login_id;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if (!$login) {
            redirect(base_url('/'));
        }
        if (isset($login) && $this->uri->segment(1) != $uri) {
            if ($defaultPassword == 1) {
                redirect(base_url('userpassword/changepassword'));
            } else {
                redirect(base_url($uri . '/' . $landing));
            }
        }
    }

    public function redirect_home()
    {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if (isset($this->session->schoolmis_login_id) && $this->uri->segment(1) == "" || $this->uri->segment(1) == "login" || $this->uri->segment(1) == "map") {
            if ($level != "") {
                if ($defaultPassword == 1) {
                    redirect(base_url('userpassword/changepassword'));
                } else {
                    redirect(base_url($uri . '/' . $landing));
                }
            }
        }
    }

    public function removeCharacter($text)
    {
        return preg_replace("/[^0-9]/", "", $text);
    }

    public function clean($string)
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }

    public function returnNull($a)
    {
        $return = !$a ? NULL : $a;
        return $return;
    }

    public function returnDashed($a)
    {
        $return = ($a == 0 ? '-' : number_format($a));
        return $return;
    }

    public function RegionList($filter, $default)
    {
        $data = ["data" => []];
        // $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_region t1 ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->regional_designation,
            ];
        }
        return $data;
    }

    public function ProvinceList($filter, $default)
    {
        $data = ["data" => []];
        $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_province t1 WHERE t1.region_id=$filter ORDER BY t1.id");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function CityMunList($filter, $default)
    {
        $data = ["data" => []];
        $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_citymun t1 WHERE t1.province_id=$filter ORDER BY $orby t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function BarangayList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_barangay t1 WHERE t1.citymun_id=$filter ORDER BY t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function PurokList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_purok t1 WHERE t1.barangay_id=$filter ORDER BY t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function PartyList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_party t1 
                                        WHERE t1.party_type_id=$filter 
                                        AND t1.is_active=true
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function PartyTypeList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_partytype t1 
                                        WHERE t1.group_id=$filter 
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function SchoolPersonnelList($filter)
    {
        $w = $filter ? "WHERE t1.employeeTypeId=$filter" : "";
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM profile.view_schoolpersonnel t1 $w ORDER BY t1.first_name");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->schoolpersonnel_id,
                "item" => $value->full_name,
            ];
        }
        return $data;
    }

    public function StatusList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_status t1 
                                        WHERE t1.status_type_id=$filter 
                                        AND t1.is_active=true
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function getOnLoad()
    {
        $query = $this->db->query("SELECT * FROM global.tbl_sy t1 WHERE t1.is_active=true");
        $row = $query->row();
        $sy_id = $row->id;
        $sy = $row->description;
        $qrtr = $row->qrtr;
        $enroll_stat = $row->enrollment_stat;
        $enroll_dl = $row->enrollment_deadline;
        $grade_stat = $row->grading_stat;
        $grade_dl = $row->grading_deadline;
        $data = [
            "sy_id" => $sy_id,
            "sy" => $sy,
            "qrtr" => $qrtr,
            "enroll_stat" => $enroll_stat,
            "enroll_dl" => $enroll_dl,
            "grade_stat" => $grade_stat,
            "grade_dl" => $grade_dl,
        ];
        return $data;
    }

    public function get_ip()
    {
        $ip = "";
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        if ($ip == "::1") {
            $ip = "127.0.0.1";
        }
        return $ip;
    }

    public function confirmPassword($a)
    {
        $pwd = md5($a);
        $login_id = $this->session->schoolmis_login_id;
        $query = $this->db->query("SELECT 1 AS pwd FROM tbl_user WHERE id=$login_id AND password='$pwd' LIMIT 1");
        return $query->row("pwd");
    }

    public function now()
    {
        date_default_timezone_set("Asia/Manila");
        $now = date("Y-m-d H:i:s");
        return $now;
    }

    public function do_upload($input_name, $upload_path, $file_name)
    {
        $path = "";
        // $num = mt_rand(1, 1000000);

        $config['upload_path']      = $upload_path;
        $config['allowed_types']    = 'pdf|docx|xls|ppt|jpg|png|jpeg|txt';
        $config['max_size']         = '100000';
        $config['overwrite']        = true;
        $config['file_name']        = $file_name;
        // $config['max_width']         = '5000';
        // $config['max_height']        = '5000';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $upload = $this->upload->do_upload($input_name);
        if ($upload) {
            $path = $file_name;
        }
        return $path;
    }

    public function userlog($action)
    {
        $login_id = $this->session->schoolmis_login_id;
        $login_alias = $this->session->schoolmis_login_uname;
        $now = $this->now();
        $action = addslashes($action);
        $ip = $this->get_ip();
        $data = [
            "date" => $now,
            "action" => $action,
            "user_id" => $login_id,
            "user_name" => $login_alias,
            "ip" => $ip,
        ];
        if ($login_id) {
            $this->db->insert("global.tbl_userlogs", $data);
        }
    }

    public function learnerlog($action)
    {
        $sy = $this->getOnLoad()["sy_id"];
        $login_id = $this->session->schoolmis_login_id;
        $login_alias = $this->session->schoolmis_login_uname;
        $now = $this->now();
        $action = addslashes($action);
        $ip = $this->get_ip();
        $data = [
            "date_time" => $now,
            "action" => $action,
            "user_id" => $login_id,
            "user_name" => $login_alias,
            "ip" => $ip,
        ];
        if ($login_id) {
            $this->db->insert("global.tbl_userlogs_learner$sy", $data);
        }
    }

    public function basicInfoChecker($f, $m, $l, $b, $s)
    {
        $sex = $s == 1 ? 'true' : 'false';
        $query = $this->db->query("SELECT t1.id FROM profile.tbl_basicinfo t1
                                    WHERE t1.first_name='$f' AND t1.middle_name='$m' AND t1.last_name='$l' AND t1.birthdate='$b' AND t1.sex=$sex");
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function learnerChecker($lrn, $binfoId)
    {
        $where = !$binfoId && $lrn ? "WHERE t1.lrn='$lrn'" : ($binfoId && !$lrn ? "WHERE t1.basic_info_id=$binfoId" : "WHERE t1.lrn='$lrn' AND t1.basic_info_id=$binfoId");
        $query = $this->db->query("SELECT t1.id FROM profile.tbl_learners t1 $where");
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function enrollmentChecker($a)
    {
        $sy = $this->getOnLoad()["sy_id"];
        $query = $this->db->query("SELECT t1.id FROM building_sectioning.tbl_learner_enrollment$sy t1 WHERE t1.learner_id=$a");
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function gradeColor($a)
    {

        if ($a) {
            $grade = (int) $a;
            $color = "";
            if ($grade >= 90) {
                $color = "success";
            } else if ($grade >= 80) {
                $color = "orange";
            } else {
                $color = "danger";
            }
            return "<b class='text-lg text-" . $color . "'>" . $a . "</b>";
        } else {
            return "--";
        }
    }



    // public function QRlog($personId,$in_out,$location){
    //     $login_id = $this->session->schoolmis_login_id;
    //     $login_alias = $this->session->schoolmis_login_uname;
    //     $now = $this->now();
    //     // $action = addslashes($action);
    //     $ip = $this->get_ip();
    //     $data = [
    //         "person_id" => $personId,
    //         "dateTime" => $now,
    //         "in_out" => $in_out,
    //         "location_id" => $location,
    //         "scanned_user_id" => $login_id,
    //         "user_name" => $login_alias,
    //         "ip" => $ip,
    //     ];
    //     if($login_id){
    //         $this->db->insert("tbl_scannedqr_logs",$data);
    //     }
    // }

    public function dateFormat($a)
    {
        $b = "-";
        if ($a != null) {
            $c = date_create($a);
            $b = date_format($c, "M d, Y");
        }
        return $b;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */