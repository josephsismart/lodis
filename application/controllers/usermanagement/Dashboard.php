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

    function covidGraph(){

        $dateNow = $this->now();
        $acc=0;
        $acr=0;
        $acd=0;
        $dc=0;
        $end_date = '2020-12-31';
        $d = $this->db->query("SELECT date_status FROM tbl_covid_status_history WHERE status_id = 6 ORDER BY date_status LIMIT 1");
        $dd = $d->row("date_status");
        $date = date ("Y-m-d", strtotime("-1 day", strtotime($dd)));;
        while (strtotime($date) <= strtotime($dateNow)) {
            $query_c=$this->db->query("SELECT t1_1.date_status date_c, COUNT(t1_1.date_status) cc_c
                                    FROM (tbl_covid_status_history t1_1
                                        LEFT JOIN tbl_person t2_1 ON (((t1_1.person_id)::numeric = t2_1.id)))
                                    WHERE ((t1_1.status_id = 6) AND (t2_1.is_deleted IS NULL) AND t1_1.date_status='$date')
                                    GROUP BY t1_1.date_status
                                    ORDER BY t1_1.date_status");
            $query_r=$this->db->query("SELECT t1_1.date_status date_c, COUNT(t1_1.date_status) cc_r
                                    FROM (tbl_covid_status_history t1_1
                                        LEFT JOIN tbl_person t2_1 ON (((t1_1.person_id)::numeric = t2_1.id)))
                                    WHERE ((t1_1.status_id = 4) AND (t2_1.is_deleted IS NULL) AND t1_1.date_status='$date')
                                    GROUP BY t1_1.date_status
                                    ORDER BY t1_1.date_status");
            $query_d=$this->db->query("SELECT t1_1.date_status date_c, COUNT(t1_1.date_status) cc_d
                                    FROM (tbl_covid_status_history t1_1
                                        LEFT JOIN tbl_person t2_1 ON (((t1_1.person_id)::numeric = t2_1.id)))
                                    WHERE ((t1_1.status_id = 3) AND (t2_1.is_deleted IS NULL) AND t1_1.date_status='$date')
                                    GROUP BY t1_1.date_status
                                    ORDER BY t1_1.date_status");

            $acc=$acc+intval($query_c->row("cc_c"));
            $acr=$acr+intval($query_r->row("cc_r"));
            $acd=$acd+intval($query_d->row("cc_d"));

            $data["confirmed"][] = [
                'y'=>$acc,
                'a'=>intval($query_c->row("cc_c")),
                'day'=>$dc,
            ];

            $data["recovered"][] = [
                'y'=>$acr,
                'a'=>intval($query_r->row("cc_r")),
            ];

            $data["deaths"][] = [
                'y'=>$acd,
                'a'=>intval($query_d->row("cc_d")),
            ];

            $data["date"][] = [
                $date,
            ];

            // $data["date"][] = [
            //     'k'=>$date,
            //     'day'=>1,
            // ];
            $dc=$dc+1;
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
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