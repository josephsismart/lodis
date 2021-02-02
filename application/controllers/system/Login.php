<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->redirect_home();
        $data = $this->system();
        $data += [
            "page_title"    => "Login",
            "current_location"  => "login",
        ];
        $this->load->view('interface/system/Login', $data);

        // $page_data = $this->system();
        // $page_data += [
        //     "page_title"        => "Login",
        //     "current_location"  => "login",
        //     "content"           =>  [$this->load->view('interface/system/Login', [
        //                                 // "accomplished"      => $this->get_accomplished(),
        //                                 // "useraccount"      => $this->get_useraccount(),
        //                                 // "pending"      => $this->get_pending(),
        //                                 // "documents"      => $this->get_documents(),
        //                             ], TRUE)]
        // ];
        // $this->public_create_page($page_data);
    }

    public function request_login() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password')); //md5($this->input->post('password'));
        
        $query = $this->db->query("SELECT t1.*,t2.level,t3.district_id,t3.testing_code FROM tbl_user t1
                                    LEFT JOIN tbl_roletype t2 ON t1.role_type_id=t2.id
                                    LEFT JOIN tbl_user_barangay t3 ON t3.user_id=t1.id
                                    WHERE t1.status=1 AND t1.username='$username' AND t1.password='$password'");
        if($query->row('id')){
            $data = [
                    "covid_tracker_login_id"      => $query->row('id'),
                    "covid_tracker_login_uname"   => $query->row('username'),
                    "covid_tracker_login_level"   => $query->row('level'),
                    "covid_tracker_login_uri"     => ($query->row('level')==1?"useradmin":($query->row('level')==2?"uservalidator":($query->row('level')==3?"userhealthworker":($query->row('level')==4?"usermanagement":($query->row('level')==5?"usercheckpoint":($query->row('level')==6?"usertestvalidator":"")))))),
                    "covid_tracker_login_name"    => $this->personName($query->row('person_id'),'n'),
                    "covid_tracker_login_title"   => $this->personName($query->row('person_id'),'p'),
                    "covid_tracker_login_district"   => $query->row('district_id'),
                    //"covid_tracker_testing_code"  => $query->row('testing_code'),
                    "covid_tracker_pass"             => $query->row('password'),
                    "covid_tracker_change_password"  => $query->row('change_password'),
                    "covid_tracker_person_exist"  => 0,
            ];
            
            $this->session->set_userdata($data);    
            $this->userlog("USER HAS LOGGED IN.");
            $level = $this->session->covid_tracker_login_level;
            $defaultPassword = $this->session->covid_tracker_change_password;
            $uri = $this->session->covid_tracker_login_uri;
            if ($level!="") {
                if($defaultPassword==1){
                    redirect(base_url('userpassword/changepassword'));
                }else{
                    ($query->row('level')==1?redirect(base_url($uri.'/dataentry')):redirect(base_url($uri.'/dashboard')));
                }
            }
        }else{
            redirect(base_url().'login?login_attempt='.md5(0));
        }
    }

    public function request_logout() {
        $this->userlog("USER HAS LOGGED OUT.");
        $array_logout = [
                    "covid_tracker_login_id"         => '',
                    "covid_tracker_login_uname"      => '',
                    "covid_tracker_login_level"      => '',
                    "covid_tracker_login_uri"        => '',
                    "covid_tracker_login_name"       => '',
                    "covid_tracker_login_title"      => '',
                    "covid_tracker_login_district"   => '',
                    //"covid_tracker_testing_code"     => '',
                    "covid_tracker_pass"             => '',
                    "covid_tracker_change_password"  => '',
                    "covid_tracker_person_exist"  => 0,
            ];
        $this->session->unset_userdata($array_logout);
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

}

/* End of file Login_admin.php */
/* Location: ./application/controllers/system/Login_admin.php */