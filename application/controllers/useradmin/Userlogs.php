<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlogs extends MY_Controller {

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
        $page_data += [
            "page_title"        => "User Logs",
            "current_location"  => "userlogs",
            "content"           =>  [$this->load->view('interface/useradmin/Userlogs', [
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function getPersonLogs(){
        $data = ["data" => []];
        $cc=1;
        foreach ($this->db->query("SELECT * FROM tbl_userlogs ORDER BY id DESC")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                $value->date,
                $value->user_id.' '.$value->user_name,
                $value->action,
                $value->ip,
            ];
        }
        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */