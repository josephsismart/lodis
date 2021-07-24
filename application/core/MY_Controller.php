<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $global_requestid=null;
    public $global_requestid_personnel=null;

    public function system() {
        $data = [
            "system_title"  => "Libertad National High School",
            "system_logo"   => base_url("assets/dist/img/icons/icon.png"),
            "system_svg"    => base_url("assets/dist/img/icons/icon_svg.png"),
        ];
        return $data;
    }
    
    public function public_create_page($data = []) {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        if ($level!="") {
            if($defaultPassword==1){
                return $this->load->view('interface/userpassword/layout/Page', $data, false);
            }else{
                return $this->load->view('interface/'.$uri.'/layout/Page', $data, false);
            }
        }
    }

    public function user_create_page($data = []) {
        return $this->load->view('interface/user/layout/Page', $data, false);
    }

    public function redirect() {
        $login = $this->session->schoolmis_login_id;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if(!$login) {
            redirect(base_url('/'));
        }
        if(isset($login) && $this->uri->segment(1)!=$uri) {
            if($defaultPassword==1){
                redirect(base_url('userpassword/changepassword'));
            }else{
                redirect(base_url($uri.'/'.$landing));
            }
        }
    }

    public function redirect_home() {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if(isset($this->session->schoolmis_login_id) && $this->uri->segment(1) == "" || $this->uri->segment(1) == "login" || $this->uri->segment(1) == "map") {
            if ($level!="") {
                if($defaultPassword==1){
                    redirect(base_url('userpassword/changepassword'));
                }else{
                    redirect(base_url($uri.'/'.$landing));
                }
            }
        }
    }

    public function removeCharacter($text){
        return preg_replace("/[^0-9]/", "", $text);
    }

    public function clean($string) {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }

    public function getBarangay(){
        $data = ["data1"=>[],"data2"=>[]];
        foreach ($this->db->query("SELECT * FROM butuan_city")->result() as $key => $value){
            $data["data1"][] = [
                "id" => $value->party_id,
                "text" => $value->description,
                "area" => $value->area,
                "lat" => $value->lat,
                "lon" => $value->lon,
            ];
        }
        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID' ORDER BY sequence")->result() as $key => $value){
            $data["data2"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }
        return $data;
    }

    public function getBarangayName($partyId){
        $query = $this->db->query("SELECT * FROM tbl_party WHERE id=$partyId");
        return $query->row("description");
    }

    public function getBarangayParty($brgyName){
        $query = $this->db->query("SELECT * FROM tbl_party WHERE description='$brgyName'");
        return $query->row("id");
    }

    public function getStatusName($statusId){
        $query = $this->db->query("SELECT * FROM tbl_statusitem WHERE id=$statusId");
        //$returnMe = "<span class='badge' style='background-color:".$query->row("color")."'>".$query->row("description")."</span></a>";
        $returnMe = $query->row("description");
        return $returnMe;
    }

    public function getStatusId($stattusName){
        $query = $this->db->query("SELECT * FROM tbl_statusitem WHERE description='$stattusName'");
        return $query->row("id");
    }

    public function getStatusIdCode($stattusName){
        $query = $this->db->query("SELECT * FROM tbl_statusitem WHERE code='$stattusName'");
        return $query->row("id");
    }

    public function getStatusColor($statusId){
        $query = $this->db->query("SELECT * FROM tbl_statusitem WHERE id=$statusId");
        $returnMe = $query->row("color");
        return $returnMe;
    }

    public function getStatusCode($statusId){
        $query = $this->db->query("SELECT * FROM tbl_statusitem WHERE id=$statusId");
        $returnMe = $query->row("code");
        return $returnMe;
    }

    // public function getTestCodeMaxNum(){
    //     $test_id = $this->session->schoolmis_testing_code;
    //     $query = $this->db->query("SELECT COALESCE(MAX(testing_number),0)+1 max_num FROM tbl_covid_details WHERE testing_code=$test_id");
    //     $seq = $query->row("max_num");
    //     $returnMe = ($seq<10?"0000".$seq:($seq<100?"000".$seq:($seq<1000?"00".$seq:($seq<10000?"0".$seq:$seq))));
    //     return $returnMe;
    // }

    // public function getTestCodeNum($seq){
    //     $returnMe = ($seq<10?"0000".$seq:($seq<100?"000".$seq:($seq<1000?"00".$seq:($seq<10000?"0".$seq:$seq))));
    //     return $returnMe;
    // }

    // public function getTestCodeMaxNumSave($statusId){
    //     $test_id = $this->session->schoolmis_testing_code;
    //     $query = $this->db->query("SELECT COALESCE(MAX(testing_number),0)+1 max_num FROM tbl_covid_details WHERE testing_code=$test_id");
    //     $returnMe = $query->row("max_num");
    //     return $returnMe;
    // }

    // public function getTestCodeMaxNumSaveImport($statusCode){
    //     $statusId = $this->getStatusIdCode($statusCode);
    //     $query = $this->db->query("SELECT COALESCE(MAX(testing_number),0)+1 max_num FROM tbl_covid_details WHERE testing_code=$statusId");
    //     $returnMe = $query->row("max_num");
    //     return $returnMe;
    // }

    public function getFullName($id){
        $query = $this->db->query("SELECT CONCAT(t1.fname,COALESCE(CONCAT(' ',t1.mname),''),' ',t1.lname,COALESCE(t1.extname,''))personname FROM tbl_person t1 WHERE t1.id=$id");
        return $query->row("personname");
    }

    public function returnNull($a){
        $return = !$a?NULL:$a;
        return $return;
    }

    public function returnDashed($a){
        $return =($a==0?'-':number_format($a));
        return $return;
    }

    public function getFullName2($id){
        $query = $this->db->query("SELECT CONCAT(t1.fname,COALESCE(CONCAT(' ',t1.mname),''),' ',t1.lname,COALESCE(t1.extname,''))personname FROM existing.tbl_person t1 WHERE t1.id=$id");
        return $query->row("personname");
    }

    public function getUserName($id){
        $query = $this->db->query("SELECT username FROM tbl_user t1 WHERE t1.id=$id");
        return $query->row("username");
    }

    public function getTestCode($number){
        $seq = $number;
        $sequence = ($seq<10?"000".$seq:($seq<100?"00".$seq:($seq<1000?"0".$seq:$seq)));
        return $sequence;
    }

    public function testingCode($code){
        $query = $this->db->query("SELECT testing_number AS num FROM tbl_covid_details WHERE testing_code=$code");
        return $query->row("num")+1;
    }

    public function get_ip() {
        $ip = "";
        if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif(!empty($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } elseif(!empty($_SERVER["REMOTE_ADDR"])){
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        if($ip == "::1") {
            $ip = "127.0.0.1";
        }
        return $ip;
    }

    public function confirmPassword($a){
        $pwd = md5($a);
        $login_id = $this->session->schoolmis_login_id;
        $query = $this->db->query("SELECT 1 AS pwd FROM tbl_user WHERE id=$login_id AND password='$pwd' LIMIT 1");
        return $query->row("pwd");
    }

    public function full_name($user_id) {
        $fn = ""; $mn = ""; $ln = ""; $ext = "";
        foreach ($this->db->query("SELECT firstname, lastname FROM users WHERE user_id=$user_id")->result() as $key => $value) {
            $fn = $value->firstname;    
            $ln = $value->lastname;
            
        }
        if(!empty($mn)) {
            $mn = $mn[0].". ";
        }
        return ucfirst($ln).", ".ucfirst($fn)." ".ucfirst($mn).ucfirst($ext);
    }

    public function personName($personId,$x){
        $query = $this->db->query("SELECT * FROM tbl_person WHERE id=$personId");
        $name = $query->row("fname")." ".$query->row("mname")." ".$query->row("lname");
        $position = $query->row("personal_title");
        return ($x=='n'?$name:($x=='p'?$position:''));
    }

    public function myParty($a){
        $query = $this->db->query("SELECT t1.description FROM tbl_party t1 WHERE t1.id=$a");
        $me = $query->row("description");
        return $me;
    }

    public function hasContact($a){
        $query = $this->db->query("SELECT COUNT(1) AS person FROM tbl_contact_trace t1 WHERE t1.primary=$a");
        $me = $query->row("person");
        return $me;
    }


    public function onload() {
        $ids = [
                    "pending"     => "",
                ];

        foreach ($this->db->query("SELECT COUNT(1) pending FROM requestdetail WHERE statusId='REQ_STAT_PENDING'")->result() as $key => $value) {
            $ids["pending"]    = $value->pending;
            break;
        }

        // foreach ($this->db->query("SELECT location_path FROM user_images WHERE user_id=".$ids["user_id"])->result() as $key => $value) {
        //     $ids["location_path"] = $value->location_path;
        //     break;
        // }

        return $ids;
    }

    public function now() {
        date_default_timezone_set("Asia/Manila");
        $now = date("Y-m-d H:i:s");
        return $now;
    }

    public function do_upload($input_name, $upload_path, $file_name) {
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
        if($upload) {
            $path = $file_name;
        }
        return $path;
    }

    public function userlog($action) {
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
        if($login_id){
            $this->db->insert("tbl_userlogs",$data);
        }
    }

    public function QRlog($personId,$in_out,$location){
        $login_id = $this->session->schoolmis_login_id;
        $login_alias = $this->session->schoolmis_login_uname;
        $now = $this->now();
        // $action = addslashes($action);
        $ip = $this->get_ip();
        $data = [
            "person_id" => $personId,
            "dateTime" => $now,
            "in_out" => $in_out,
            "location_id" => $location,
            "scanned_user_id" => $login_id,
            "user_name" => $login_alias,
            "ip" => $ip,
        ];
        if($login_id){
            $this->db->insert("tbl_scannedqr_logs",$data);
        }
    }

    public function dateFormat($a){
        $b="-";
        if($a!=null){
            $c=date_create($a);
            $b=date_format($c,"M d, Y");
        }
        return $b;
    }

    public function user_full_name($user_id)
    {
        $fn = ""; $mn = ""; $ln = ""; $ext = "";
        if ($user_id != null) {
            foreach ($this->db->query("SELECT firstname, lastname FROM users WHERE user_id = $user_id")->result() as $key => $value) {
                $fn = $value->firstname;            
                $ln = $value->lastname;
                
            }
        }
        if(!empty($mn)) {
            $mn = $mn[0].". ";
        }
        return ucfirst($ln).", ".ucfirst($fn)." ".ucfirst($mn).ucfirst($ext);
    }

    public function pprint($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    public function trim_str($str) {
        $str = trim($str);
        $str = strip_tags($str);
        $str = stripslashes($str);
        $str = str_replace("'", "\'", $str);
        return $str;
    }

    // others
    public function get_driver_info($driver_id){
        $data = "";
        foreach ($this->db->query("SELECT driver_name FROM drivers WHERE driver_id=$driver_id AND status = 1")->result() as $key => $value) {
            $data = $value->driver_name.'<br>';
        }
        return $data;
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */