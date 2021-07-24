<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //$this->redirect();

        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    public function index()
    {
        $this->redirect_home();
        $data = $this->system();
        $data += [
            "page_title"    => "Change Password",
            "current_location"  => "changepassword",
        ];
        $this->load->view('interface/userpassword/Changepassword', $data);

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

    function updatePassword(){
        $userId = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $pass = $this->session->schoolmis_pass;
        $current = md5($this->input->post('current'));
        $password = $this->input->post('password');
        $confirm = $this->input->post('confirm');
        if(!$current||!$password||!$confirm){
            redirect(base_url().'changepassword?change_attempt='.md5(0));
        }else if($pass!=$current){
            redirect(base_url().'changepassword?change_attempt='.md5(1));
        }else if(strlen($password)<8){
            redirect(base_url().'changepassword?change_attempt='.md5(2));
        }else if($password!=$confirm){
            redirect(base_url().'changepassword?change_attempt='.md5(3));
        }else{
            $this->db->trans_begin();
            $data = [
                "password" => md5($password),
                "updated_at" => $dateNow,
                "change_password" => 0,
            ];
            if(!$this->mainModel->update("tbl_user",$data,"id",$userId)){
                $this->userlog("CHANGED PASSWORD OF USER ".$userId);
                $ret = ["success"   => true];
            }else{
                $ret = ["success"   => false];
            }

            if($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $this->session->schoolmis_change_password=0;
                $this->redirect();
            }
        }
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */