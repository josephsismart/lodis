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
        $uri = $this->session->schoolmis_login_uri;
        $page_data += [
            "page_title"        => "Dashboard",
            "current_location"  => "dashboard",
            "content"           =>  [$this->load->view('interface/'.$uri.'/Dashboard', [
                                        // "dashboard_data" => $this->get_covid_dashboard(),
                                        // "getYearMonth" => $this->getDateYearMonth(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function getMFGradelvl()
    {
        $data = ["data" => []];
        $c = 1;
        $sy = $this->getOnLoad()["sy_id"];
        // $query = $this->db->query("SELECT t1.lrn,t1.learner_id,t1.last_fullname,t1.sex,t1.birthdate,
        //                             t2.grade,t2.sctn_nm,t2.enrollment_date, t2.sy FROM profile.view_learner t1
        //                             LEFT JOIN building_sectioning.view_enrollment$sy t2 ON t1.learner_id=t2.learner_id
        //                             -- WHERE $w
        //                             ORDER BY t2.enrollment_date DESC
        //                             LIMIT 10");

        // foreach ($query->result() as $key => $value) {
            $data["male"][] = [
               20,20,20,30
            ];
            // name: 'Male',
            // color: "#007bff",
            // data: [49.9, 71.5, 106.4, 129.2]
        // }
        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */