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
            "content"           =>  [$this->load->view('interface/usermanagement/Dashboard', [
                                        "dashboard_data" => $this->get_covid_dashboard(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function get_covid_dashboard(){
        //$data = "";
        foreach ($this->db->query("SELECT * FROM covid_dashboard")->result() as $key => $value) {
            $data[] = [
                "stat" => $value->stat,
                "cc" => number_format($value->cc),
                "cc2" => $value->cc,
            ];
        }
        return $data;
    }

    function getCovid19Confirmed(){
        $data = ["data" => []];
        $cc=1;
            foreach ($this->db->query("SELECT * FROM butuan_barangay_covid")->result() as $key => $value) {
                $active = (($value->t_c-$value->t_r)-$value->t_d);
                $data["data"][] = [
                    $cc++,
                    "<span class='badge bg-gradient-gray-dark text-lg'>".$this->getBarangayName($value->barangay_id)."</span>",
                    "<div style='text-align:right;'>".($value->t_c<1?"-":"<span class='badge bg-gradient-orange text-lg text-white'>".number_format($value->t_c))."</span></div>",
                    "<div style='text-align:right;'>".($active<1?"-":"<span class='badge bg-gradient-orange text-sm text-white'>".number_format($active))."</span></div>",
                    "<div style='text-align:right;'>".($value->t_r<1?"-":"<span class='badge bg-gradient-success text-sm text-white'>".number_format($value->t_r))."</span></div>",
                    "<div style='text-align:right;'>".($value->t_d<1?"-":"<span class='badge bg-gradient-danger text-sm text-white'>".number_format($value->t_d))."</span></div>",
                ];
            }
        echo json_encode($data);
    }

    // function covidGraph(){
    //     //$year=$this->input->post("value");
    //     foreach ($this->db->query("SELECT T1.*,COALESCE(T2.mcc,0)mcc,COALESCE(T3.hcc,0)hcc FROM(SELECT DATE_FORMAT(T1.dateIssued,'%M') `month`,DATE_FORMAT(T1.dateIssued,'%Y') `year` FROM tbl_issuecertificate T1
    //                                                                 WHERE T1.status<>'DELETED'
    //                                                                 GROUP BY DATE_FORMAT(T1.dateIssued,'%M'),DATE_FORMAT(T1.dateIssued,'%Y')
    //                                                                 ORDER BY T1.dateIssued)T1
    //                                 LEFT JOIN (SELECT COUNT(1) `mcc`,DATE_FORMAT(T1.dateIssued,'%M') `month`,DATE_FORMAT(T1.dateIssued,'%Y') `year` FROM tbl_issuecertificate T1
    //                                                         LEFT JOIN tbl_certificates T2 ON T1.certificateId=T2.id
    //                                                         WHERE T2.description='MEDICAL' AND T1.status<>'DELETED'
    //                                                         GROUP BY DATE_FORMAT(T1.dateIssued,'%M'),DATE_FORMAT(T1.dateIssued,'%Y')) T2 ON T1.month=T2.month AND T1.year=T2.year
    //                                 LEFT JOIN (SELECT COUNT(1) `hcc`,DATE_FORMAT(T1.dateIssued,'%M') `month`,DATE_FORMAT(T1.dateIssued,'%Y') `year` FROM tbl_issuecertificate T1
    //                                                         LEFT JOIN tbl_certificates T2 ON T1.certificateId=T2.id
    //                                                         WHERE T2.description='HEALTH' AND T1.status<>'DELETED'
    //                                                         GROUP BY DATE_FORMAT(T1.dateIssued,'%M'),DATE_FORMAT(T1.dateIssued,'%Y')) T3 ON T1.month=T3.month AND T1.year=T3.year
    //                                 ")->result() as $key => $value) {


    //         $data["category"][] = [
    //             $value->month,
    //         ];
    //         $data["medical"][] = [
    //             intval($value->mcc),
    //         ];
    //         $data["health"][] = [
    //             intval($value->hcc),
    //         ];
    //     }
    //     echo json_encode($data);
    // }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */