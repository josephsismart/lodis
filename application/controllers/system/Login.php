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
    }

    public function request_login() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password')); //md5($this->input->post('password'));
        // $password = $this->input->post('password'); //md5($this->input->post('password'));
        
        if($result = $this->db->query("SELECT t1.* FROM account.view_useraccount t1
                                        WHERE t1.password='$password'
                                        AND t1.username='$username'
                                        AND t1.is_active=true")->result()) {
            foreach ($result as $key => $value) {
                if ($value->isActive == 1) {

                    $data = [
                        "schoolmis_login_id"         => $value->id,// $query->row('id'),
                        "schoolmis_login_uname"      => $value->username,// $query->row('username'),
                        "schoolmis_login_level"      => $value->level,// $value->level,
                        "schoolmis_login_uri"        => ($value->level==1?"usersuperadmin":
                                                        ($value->level==2?"useradmin":
                                                        ($value->level==3?"userdivisionhead":
                                                        ($value->level==4?"userschoolhead":
                                                        ($value->level==5?"userschoolplanning":
                                                        ($value->level==6?"userschooladmin":
                                                        ($value->level==7?"userteacher":
                                                        ($value->level==7?"userstudent":"")))))))),
                        "schoolmis_login_landing"    => "dataentry",//($value->level==2?"dataentry":"dashboard"),
                        "schoolmis_login_name"       => $value->fullname,// $this->personName($query->row('person_id'),'n'),
                        "schoolmis_login_title"      => $value->userid,// $this->personName($query->row('person_id'),'p'),
                        "schoolmis_login_district"   => $value->userid,// $query->row('district_id'),
                        "schoolmis_pass"             => $value->password,// $query->row('password'),
                        "schoolmis_change_password"  => $value->changePwd,// $query->row('change_password'),
                        // "schoolmis_person_exist"     => $value->userid,// 0,
                    ];
                    
                    // $this->session->set_userdata($data);    
                    // $this->userlog("USER HAS LOGGED IN");
                    // redirect(base_url($this->session->schoolmis_login_uri.'/dashboard'));

                    $this->session->set_userdata($data);    
                    $this->userlog("USER HAS LOGGED IN.");
                    $level = $this->session->schoolmis_login_level;
                    $defaultPassword = $this->session->schoolmis_change_password;
                    $uri = $this->session->schoolmis_login_uri;
                    $landing = $this->session->schoolmis_login_landing;
                    if ($level!="") {
                        if($defaultPassword==true){
                            redirect(base_url('userpassword/changepassword'));
                        }else{
                            redirect(base_url($uri.'/'.$landing));
                            // ($query->row('level')==1?redirect(base_url($uri.'/dataentry')):redirect(base_url($uri.'/dashboard')));
                        }
                    }

                } else if ($value->isActive == 0) {
                    redirect(base_url().'login?login_attempt='.md5(1));
                }
            }
        } else {
            redirect(base_url().'login?login_attempt='.md5(0));
        }

    }

    public function request_logout() {
        $this->userlog("USER HAS LOGGED OUT.");
        $array_logout = [
                    "schoolmis_login_id"         => '',
                    "schoolmis_login_uname"      => '',
                    "schoolmis_login_level"      => '',
                    "schoolmis_login_uri"        => '',
                    "schoolmis_login_name"       => '',
                    "schoolmis_login_title"      => '',
                    "schoolmis_login_district"   => '',
                    //"schoolmis_testing_code"     => '',
                    "schoolmis_pass"             => '',
                    "schoolmis_change_password"  => '',
                    // "schoolmis_person_exist"  => 0,
            ];
        $this->session->unset_userdata($array_logout);
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}

/* End of file Login_admin.php */
/* Location: ./application/controllers/system/Login_admin.php */