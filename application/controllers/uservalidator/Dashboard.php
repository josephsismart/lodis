<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->redirect();
    }

    public function index()
    {       
        $page_data = $this->system();
        $page_data += [
            "page_title"        => "Dashboard",
            "current_location"  => "dashboard",
            "content"           =>  [$this->load->view('interface/uservalidator/Dashboard', [
                                        //"accomplished"      => $this->get_accomplished(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function get_accomplished(){
        $data = "";
        foreach ($this->db->query("SELECT COUNT(1) accomplished FROM requestdetail WHERE statusId='REQ_STAT_DONE'")->result() as $key => $value) {
            $data = number_format($value->accomplished);
        }
        return $data;
    }
    function get_useraccount(){
        $data = "";
        foreach ($this->db->query("SELECT COUNT(1) useraccount FROM userlogin WHERE enabled=1")->result() as $key => $value) {
            $data = number_format($value->useraccount);
        }
        return $data;
    }
    function get_pending(){
        $data = "";
        foreach ($this->db->query("SELECT COUNT(1) pending FROM requestdetail WHERE statusId='REQ_STAT_PENDING'")->result() as $key => $value) {
            $data = number_format($value->pending);
        }
        return $data;
    }
    function get_documents(){
        $data = "";
        foreach ($this->db->query("SELECT COUNT(1) documents FROM documentinfo")->result() as $key => $value) {
            $data = number_format($value->documents);
        }
        return $data;
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */