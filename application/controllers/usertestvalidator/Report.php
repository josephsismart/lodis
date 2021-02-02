<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

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
            "page_title"        => "Report",
            "current_location"  => "report",
            "content"           =>  [$this->load->view('interface/usertestvalidator/Report', [
                                        "getBarangay" => $this->getBarangayAssigned(),
                                        "getStatus" => $this->getStatus(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }


    function getBarangayAssigned(){
        $district_id = $this->session->covid_tracker_login_district;
        $data = ["data1"=>[],"data2"=>[]];
        foreach ($this->db->query("SELECT t2.id, t2.description FROM tbl_user_barangay_district t1
                                   LEFT JOIN tbl_party t2 ON t1.barangay_id=t2.id
                                   WHERE t1.party_id=$district_id")->result() as $key => $value){
            $data["data1"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }
        foreach ($this->db->query("SELECT t1.id, t1.description FROM tbl_party t1
                                   WHERE t1.party_type_id=2")->result() as $key => $value){
            $data["data2"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }
        return $data;
    }

    function getStatus(){
        $data = ["data1"=>[],"data2"=>[],"data3"=>[],"data4"=>[],"data5"=>[],"data6"=>[],"data7"=>[],"data8"=>[],"data9"=>[],"data10"=>[]];
        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID' ORDER BY sequence")->result() as $key => $value){
            $data["data1"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='RELATION' ORDER BY sequence")->result() as $key => $value){
            $data["data2"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID_REMARKS' ORDER BY sequence")->result() as $key => $value){
            $data["data3"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID_TEST' ORDER BY sequence")->result() as $key => $value){
            $data["data4"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID_SYMPTOMS' ORDER BY sequence")->result() as $key => $value){
            $data["data5"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID_RESULT' ORDER BY sequence")->result() as $key => $value){
            $data["data6"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT CONCAT(t1.testing_code,CASE WHEN t1.testing_code IS NULL THEN '' ELSE ' - ' END) code,t2.id personid FROM tbl_covid_details t1
                                    LEFT JOIN tbl_person t2 ON t1.person_id=t2.id ORDER BY t2.fname ASC")->result() as $key => $value){
            $data["data7"][] = [
                "id" => $value->personid,
                "text" => $value->code.$this->getFullName($value->personid),
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='CATEGORY' ORDER BY sequence")->result() as $key => $value){
            $data["data8"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='QSTATUS' ORDER BY sequence")->result() as $key => $value){
            $data["data9"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        foreach ($this->db->query("SELECT * FROM tbl_party WHERE party_type_id=10 ORDER BY id")->result() as $key => $value){
            $data["data10"][] = [
                "id" => $value->id,
                "text" => $value->description,
            ];
        }

        return $data;
    }

    function getTestReport(){
        $data = ["data" => [],"data1" => [],"data2" => [],"data3" => [],"data4" => []];
        $user_id = $this->session->covid_tracker_login_id;
        $district_id = $this->session->covid_tracker_login_district;

        parse_str($this->input->post("a"),$filter);
        $fromDate = $filter['fromDate'];
        $toDate = $filter['toDate'];
        $testCOVIDFilter = $filter['testCOVIDFilter'];
        $resultCOVIDFilter = $filter['resultCOVIDFilter'];
        $barangayNameFilter = $filter['barangayNameFilter'];

        $c_rdt_cc_n=0;
        $c_rdt_cc_p=0;
        $c_pcr_cc_n=0;
        $c_pcr_cc_p=0;
        $c_total_cc=0;

        $g_rdt_cc_n=0;
        $g_rdt_cc_p=0;
        $g_pcr_cc_n=0;
        $g_pcr_cc_p=0;
        $g_total_cc=0;

        $b_rdt_cc_n=0;
        $b_rdt_cc_p=0;
        $b_pcr_cc_n=0;
        $b_pcr_cc_p=0;
        $b_total_cc=0;

        $a_rdt_cc_n=0;
        $a_rdt_cc_p=0;
        $a_pcr_cc_n=0;
        $a_pcr_cc_p=0;
        $a_total_cc=0;

        $and = "";

        $brgy = (!$barangayNameFilter?"":" AND t1.barangay_id=$barangayNameFilter");
        $and.=(!$fromDate?"":"AND TO_CHAR(t4.date_test :: DATE, 'yyyy-mm-dd') BETWEEN '$fromDate' AND '$toDate'");
        $and.=(!$testCOVIDFilter?"":"AND t4.test_id=$testCOVIDFilter");
        $and.=(!$resultCOVIDFilter?"":"AND t4.result_id=$resultCOVIDFilter");

        $cc=1;
        foreach ($this->db->query("SELECT t1.*,t3.testing_code,t3.category,t4.test_id,to_char(t4.date_test, 'MON dd, YYYY') as date_test2,t4.result_id FROM tbl_person t1
                                       LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                       LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                       WHERE t1.party_id BETWEEN 94 AND 95 $and $brgy
                                       ORDER BY t1.id DESC")->result() as $key => $value) {
            $id = $value->id;
            $fullName = $this->getFullName($value->id);

            $data["data"][] = [
                $cc++,
                '<div style="white-space: nowrap;">'.(!$value->category?"-":$this->getStatusName($value->category)).'</div>',
                '<center style="white-space: nowrap;">'.(!$value->testing_code?"-":$value->testing_code).'</center>',
                '<div style="white-space: nowrap;">'.$fullName.'</div>',
                '<center>'.($value->gender==1?"M":"F").'</center>',
                '<center>'.(!$value->age?"-":$value->age).'</center>',
                ($value->barangay_id!="" && $value->barangay_id!=106?$this->getBarangayName($value->barangay_id):(!$value->street?"-":$value->street)),
                (!$value->test_id?"-":$this->getStatusCode($value->test_id)),
                (!$value->result_id?"-":$this->getStatusName($value->result_id)),
                '<div style="white-space: nowrap;">'.(!$value->date_test2?"-":$value->date_test2).'</div>',
            ];
        }

        foreach ($this->db->query("SELECT t1.category,t1.total_cc,t2.rdt_cc_n,t3.rdt_cc_p,t4.pcr_cc_n,t5.pcr_cc_p FROM (SELECT COALESCE(t3.category,'NS')AS category,COUNT(COALESCE(t3.category,'1')) AS total_cc FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id IS NOT NULL AND t4.result_id IS NOT NULL $and $brgy
                                                                           GROUP BY t3.category) t1

                                    LEFT JOIN(SELECT COALESCE(t3.category,'NS')AS category,COUNT(COALESCE(t3.category,'1')) AS rdt_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t3.category)t2 ON t2.category=t1.category   

                                    LEFT JOIN(SELECT COALESCE(t3.category,'NS')AS category,COUNT(COALESCE(t3.category,'1')) AS rdt_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t3.category)t3 ON t3.category=t1.category   

                                    LEFT JOIN(SELECT COALESCE(t3.category,'NS')AS category,COUNT(COALESCE(t3.category,'1')) AS pcr_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t3.category)t4 ON t4.category=t1.category

                                    LEFT JOIN(SELECT COALESCE(t3.category,'NS')AS category,COUNT(COALESCE(t3.category,'1')) AS pcr_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t3.category)t5 ON t5.category=t1.category")->result() as $key => $value) {
            $c_rdt_cc_n = $c_rdt_cc_n+$value->rdt_cc_n;
            $c_rdt_cc_p = $c_rdt_cc_p+$value->rdt_cc_p;
            $c_pcr_cc_n = $c_pcr_cc_n+$value->pcr_cc_n;
            $c_pcr_cc_p = $c_pcr_cc_p+$value->pcr_cc_p;
            $c_total_cc = $c_total_cc+$value->total_cc;

            $data["data1"][] = [
                ($value->category=="NS"?"NOT SPECIFIED":$this->getStatusName($value->category)),
                $this->returnDashed($value->rdt_cc_n),
                $this->returnDashed($value->rdt_cc_p),
                $this->returnDashed($value->pcr_cc_n),
                $this->returnDashed($value->pcr_cc_p),
                $this->returnDashed($value->total_cc),
            ];

        }
        $data["data1"][] = [
            "<b>TOTAL</b>",
            "<b>".$this->returnDashed($c_rdt_cc_n)."</b>",
            "<b>".$this->returnDashed($c_rdt_cc_p)."</b>",
            "<b>".$this->returnDashed($c_pcr_cc_n)."</b>",
            "<b>".$this->returnDashed($c_pcr_cc_p)."</b>",
            "<b>".$this->returnDashed($c_total_cc)."</b>",
        ];

        foreach ($this->db->query("SELECT t7.gender,t7.total_cc,COALESCE(t1.rdt_cc_n,0) AS rdt_cc_n,COALESCE(t2.rdt_cc_p,0) AS rdt_cc_p,COALESCE(t3.pcr_cc_n,0) AS pcr_cc_n,COALESCE(t4.pcr_cc_p,0) AS pcr_cc_p FROM (SELECT t1.gender,COUNT(COALESCE(t1.gender,'1')) AS total_cc FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 $and $brgy
                                                                           GROUP BY t1.gender)t7
                                    LEFT JOIN(SELECT t1.gender,COUNT(COALESCE(t1.gender,'1')) AS rdt_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.gender)t1 ON t7.gender=t1.gender

                                    LEFT JOIN(SELECT t1.gender,COUNT(COALESCE(t1.gender,'1')) AS rdt_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.gender)t2 ON t7.gender=t2.gender

                                    LEFT JOIN(SELECT t1.gender,COUNT(COALESCE(t1.gender,'1')) AS pcr_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.gender)t3 ON t7.gender=t3.gender

                                    LEFT JOIN(SELECT t1.gender,COUNT(COALESCE(t1.gender,'1')) AS pcr_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.gender)t4 ON t7.gender=t4.gender")->result() as $key => $value) {
            $g_rdt_cc_n = $g_rdt_cc_n+$value->rdt_cc_n;
            $g_rdt_cc_p = $g_rdt_cc_p+$value->rdt_cc_p;
            $g_pcr_cc_n = $g_pcr_cc_n+$value->pcr_cc_n;
            $g_pcr_cc_p = $g_pcr_cc_p+$value->pcr_cc_p;
            $g_total_cc = $g_total_cc+$value->total_cc;

            $data["data2"][] = [
                ($value->gender==1?"MALE":"FEMALE"),
                $this->returnDashed($value->rdt_cc_n),
                $this->returnDashed($value->rdt_cc_p),
                $this->returnDashed($value->pcr_cc_n),
                $this->returnDashed($value->pcr_cc_p),
                $this->returnDashed($value->total_cc),
            ];

        }
        $data["data2"][] = [
            "<b>TOTAL</b>",
            "<b>".$this->returnDashed($g_rdt_cc_n)."</b>",
            "<b>".$this->returnDashed($g_rdt_cc_p)."</b>",
            "<b>".$this->returnDashed($g_pcr_cc_n)."</b>",
            "<b>".$this->returnDashed($g_pcr_cc_p)."</b>",
            "<b>".$this->returnDashed($g_total_cc)."</b>",
        ];

        foreach ($this->db->query("SELECT t7.barangay_id,t7.total_cc,COALESCE(t1.rdt_cc_n,0) AS rdt_cc_n,COALESCE(t2.rdt_cc_p,0) AS rdt_cc_p,COALESCE(t3.pcr_cc_n,0) AS pcr_cc_n,COALESCE(t4.pcr_cc_p,0) AS pcr_cc_p FROM (SELECT t1.barangay_id,COUNT(COALESCE(t1.barangay_id,'1')) AS total_cc FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 $and $brgy
                                                                           GROUP BY t1.barangay_id ORDER BY t1.barangay_id)t7
                                    LEFT JOIN(SELECT t1.barangay_id,COUNT(COALESCE(t1.barangay_id,'1')) AS rdt_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.barangay_id)t1 ON t7.barangay_id=t1.barangay_id

                                    LEFT JOIN(SELECT t1.barangay_id,COUNT(COALESCE(t1.barangay_id,'1')) AS rdt_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.barangay_id)t2 ON t7.barangay_id=t2.barangay_id

                                    LEFT JOIN(SELECT t1.barangay_id,COUNT(COALESCE(t1.barangay_id,'1')) AS pcr_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.barangay_id)t3 ON t7.barangay_id=t3.barangay_id

                                    LEFT JOIN(SELECT t1.barangay_id,COUNT(COALESCE(t1.barangay_id,'1')) AS pcr_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.barangay_id)t4 ON t7.barangay_id=t4.barangay_id")->result() as $key => $value) {
            $b_rdt_cc_n = $b_rdt_cc_n+$value->rdt_cc_n;
            $b_rdt_cc_p = $b_rdt_cc_p+$value->rdt_cc_p;
            $b_pcr_cc_n = $b_pcr_cc_n+$value->pcr_cc_n;
            $b_pcr_cc_p = $b_pcr_cc_p+$value->pcr_cc_p;
            $b_total_cc = $b_total_cc+$value->total_cc;

            $data["data3"][] = [
                (!$value->barangay_id?"NOT SPECIFIED":$this->getBarangayName($value->barangay_id)),
                $this->returnDashed($value->rdt_cc_n),
                $this->returnDashed($value->rdt_cc_p),
                $this->returnDashed($value->pcr_cc_n),
                $this->returnDashed($value->pcr_cc_p),
                $this->returnDashed($value->total_cc),
            ];

        }
        $data["data3"][] = [
            "<b>TOTAL</b>",
            "<b>".$this->returnDashed($b_rdt_cc_n)."</b>",
            "<b>".$this->returnDashed($b_rdt_cc_p)."</b>",
            "<b>".$this->returnDashed($b_pcr_cc_n)."</b>",
            "<b>".$this->returnDashed($b_pcr_cc_p)."</b>",
            "<b>".$this->returnDashed($b_total_cc)."</b>",
        ];

        foreach ($this->db->query("SELECT t7.age,t7.total_cc,COALESCE(t1.rdt_cc_n,0) AS rdt_cc_n,COALESCE(t2.rdt_cc_p,0) AS rdt_cc_p,COALESCE(t3.pcr_cc_n,0) AS pcr_cc_n,COALESCE(t4.pcr_cc_p,0) AS pcr_cc_p FROM (SELECT COALESCE(t1.age,'NS')AS age,COUNT(COALESCE(t1.age,'1')) AS total_cc FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id IS NOT NULL AND t4.result_id IS NOT NULL $and $brgy
                                                                           GROUP BY t1.age ORDER BY t1.age)t7
                                    LEFT JOIN(SELECT COALESCE(t1.age,'NS')AS age,COUNT(COALESCE(t1.age,'1')) AS rdt_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.age)t1 ON t7.age=t1.age

                                    LEFT JOIN(SELECT COALESCE(t1.age,'NS')AS age,COUNT(COALESCE(t1.age,'1')) AS rdt_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=27 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.age)t2 ON t7.age=t2.age

                                    LEFT JOIN(SELECT COALESCE(t1.age,'NS')AS age,COUNT(COALESCE(t1.age,'1')) AS pcr_cc_n FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=37 $and $brgy
                                                                           GROUP BY t1.age)t3 ON t7.age=t3.age

                                    LEFT JOIN(SELECT COALESCE(t1.age,'NS')AS age,COUNT(COALESCE(t1.age,'1')) AS pcr_cc_p FROM tbl_person t1
                                                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                                                           LEFT JOIN tbl_covid_test_history t4 ON t1.id=t4.person_id
                                                                           WHERE t1.party_id BETWEEN 94 AND 95 AND t4.test_id=28 AND t4.result_id=38 $and $brgy
                                                                           GROUP BY t1.age)t4 ON t7.age=t4.age")->result() as $key => $value) {
            $a_rdt_cc_n = $a_rdt_cc_n+$value->rdt_cc_n;
            $a_rdt_cc_p = $a_rdt_cc_p+$value->rdt_cc_p;
            $a_pcr_cc_n = $a_pcr_cc_n+$value->pcr_cc_n;
            $a_pcr_cc_p = $a_pcr_cc_p+$value->pcr_cc_p;
            $a_total_cc = $a_total_cc+$value->total_cc;

            $data["data4"][] = [
                ($value->age=="NS"?"NOT SPECIFIED":$value->age),
                $this->returnDashed($value->rdt_cc_n),
                $this->returnDashed($value->rdt_cc_p),
                $this->returnDashed($value->pcr_cc_n),
                $this->returnDashed($value->pcr_cc_p),
                $this->returnDashed($value->total_cc),
            ];

        }
        $data["data4"][] = [
            "<b>TOTAL</b>",
            "<b>".$this->returnDashed($a_rdt_cc_n)."</b>",
            "<b>".$this->returnDashed($a_rdt_cc_p)."</b>",
            "<b>".$this->returnDashed($a_pcr_cc_n)."</b>",
            "<b>".$this->returnDashed($a_pcr_cc_p)."</b>",
            "<b>".$this->returnDashed($a_total_cc)."</b>",
        ];
        echo json_encode($data);
    }

    function getStatusReport(){
        $data = ["data" => []];
        $user_id = $this->session->covid_tracker_login_id;
        $district_id = $this->session->covid_tracker_login_district;

        parse_str($this->input->post("a"),$filter);
        $fromDate = $filter['fromDate'];
        $toDate = $filter['toDate'];
        $statusCOVIDFilter = $filter['statusCOVIDFilter'];
        $qstatusCOVIDFilter = $filter['qstatusCOVIDFilter'];
        $barangayNameFilter = $filter['barangayNameFilter'];

        $and = "";

        $brgy = (!$barangayNameFilter?"":" AND t1.barangay_id=$barangayNameFilter");
        $and.=(!$fromDate?"":"AND TO_CHAR(t2.date_status :: DATE, 'yyyy-mm-dd') BETWEEN '$fromDate' AND '$toDate'");
        $and.=(!$statusCOVIDFilter?"":"AND t2.status_id=$statusCOVIDFilter");
        $and.=(!$qstatusCOVIDFilter?"":"AND t5.qstatus_id=$qstatusCOVIDFilter");

        $cc=1;
        foreach ($this->db->query("SELECT t1.*,t3.testing_code,t3.category,t2.status_id,to_char(t2.date_status, 'MON dd, YYYY') as date_status2,t5.qstatus_id,to_char(t5.date_status, 'MON dd, YYYY') as date_status3 FROM tbl_person t1
                                       LEFT JOIN tbl_covid_status_history t2 ON t1.id=t2.person_id
                                       LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                       LEFT JOIN covid_qstatus_history t5 ON t1.id=t5.person_id
                                       WHERE t1.party_id BETWEEN 94 AND 95 $and  $brgy
                                       ORDER BY t1.id DESC")->result() as $key => $value) {
                $id = $value->id;
                $fullName = $this->getFullName($value->id);

                $data["data"][] = [ 
                    $cc++,
                    '<div style="white-space: nowrap;">'.(!$value->category?"-":$this->getStatusName($value->category)).'</div>',
                    '<center style="white-space: nowrap;">'.(!$value->testing_code?"-":$value->testing_code).'</center>',
                    '<div style="white-space: nowrap;">'.$fullName.'</div>',
                    '<center>'.($value->gender==1?"M":"F").'</center>',
                    '<center>'.$value->age.'</center>',
                    ($value->barangay_id==106?$value->street:$this->getBarangayName($value->barangay_id)),
                    (!$value->status_id?"-":$this->getStatusName($value->status_id)),
                    '<div style="white-space: nowrap;">'.(!$value->date_status2?"-":$value->date_status2).'</div>',
                    (!$value->qstatus_id?"-":$this->getStatusName($value->qstatus_id)),
                    '<div style="white-space: nowrap;">'.(!$value->date_status3?"-":$value->date_status3).'</div>',
                ];
        }
        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */