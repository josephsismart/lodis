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
            "content"           =>  [$this->load->view('interface/usertestvalidator/Dashboard', [
                                        "dashboard_data" => $this->get_covid_dashboard(),
                                        "getYearMonth" => $this->getDateYearMonth(),
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
        $data = ["confirmed"=>[],"recovered"=>[],"deaths"=>[],"date"=>[]];
        $acc=0;
        $acr=0;
        $acd=0;
        $dc=0;
        //$end_date = '2020-12-31';
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

    function testGraph(){
        $dateNow = $this->now();
        $data = ["category" => [],"RDT" => [],"PCR" => [],"drillRDT" => [],"drillPCR" => [],"drilldown" => [],"testTotal"=> []];
        $cc=1;
        $cc_rdt=0;
        $cc_pcr=0;
        $query1 = $this->db->query("SELECT t1.*,t2.my AS my_rdt,t2.cc AS cc_rdt,t3.my AS my_pcr,t3.cc AS cc_pcr FROM(
                                    SELECT to_number(to_char(t1.date_test, 'mm'),'00') as m,to_number(to_char(t1.date_test, 'yy'),'99') as y,to_char(t1.date_test, 'MON YYYY') AS my, COUNT(t1.id) AS cct FROM tbl_covid_test_history t1
                                    WHERE test_id IS NOT NULL AND t1.date_test IS NOT NULL
                                    GROUP BY to_number(to_char(t1.date_test, 'mm'),'00'),to_number(to_char(t1.date_test, 'yy'),'99'),to_char(t1.date_test, 'MON YYYY'))t1
                                    LEFT JOIN(SELECT to_number(to_char(date_test, 'mm'),'00') as m,to_number(to_char(date_test, 'yy'),'99') as y,to_char(date_test, 'MON YYYY') AS my,COUNT(id) AS cc FROM tbl_covid_test_history
                                                        WHERE test_id IS NOT NULL AND date_test IS NOT NULL AND test_id=27
                                                        GROUP BY to_number(to_char(date_test, 'mm'),'00'),to_number(to_char(date_test, 'yy'),'99'),to_char(date_test, 'MON YYYY'))t2 ON t1.my=t2.my
                                    LEFT JOIN(SELECT to_number(to_char(date_test, 'mm'),'00') as m,to_number(to_char(date_test, 'yy'),'99') as y,to_char(date_test, 'MON YYYY') AS my,COUNT(id) AS cc FROM tbl_covid_test_history
                                                        WHERE test_id IS NOT NULL AND date_test IS NOT NULL AND test_id=28
                                                        GROUP BY to_number(to_char(date_test, 'mm'),'00'),to_number(to_char(date_test, 'yy'),'99'),to_char(date_test, 'MON YYYY'))t3 ON t1.my=t3.my
                                    ORDER BY t1.y,t1.m");

        foreach ($query1->result() as $key => $value) {
            $cc_rdt=$cc_rdt+$value->cc_rdt;
            $cc_pcr=$cc_pcr+$value->cc_pcr;
            $data["RDT"][] = [
                "name" => $value->my,
                "y" => intval($value->cc_rdt),
                "b" => number_format($value->cc_rdt),
                "drilldown" =>$value->my_rdt.'RDT',
            ];
            $data["PCR"][] = [
                "name" => $value->my,
                "y" => intval($value->cc_pcr),
                "b" => number_format($value->cc_pcr),
                "drilldown" =>$value->my_pcr.'PCR',
            ];

            if($value->my_rdt!=""){
                $drillRDT = [];
                foreach($this->db->query("SELECT t1.* FROM(
                                            SELECT to_number(to_char(date_test, 'mm'),'00') as m,to_number(to_char(date_test, 'dd'),'00') as d,to_number(to_char(date_test, 'yy'),'99') as y,to_char(date_test, 'MON YYYY') AS my,to_char(date_test, 'MON DD, YY') AS mdy,COUNT(id) AS cc FROM tbl_covid_test_history
                                            WHERE test_id IS NOT NULL AND date_test IS NOT NULL AND test_id=27
                                            GROUP BY to_number(to_char(date_test, 'mm'),'00'),to_number(to_char(date_test, 'dd'),'00'),to_number(to_char(date_test, 'yy'),'99'),to_char(date_test, 'MON YYYY'),to_char(date_test, 'MON DD, YY'))t1
                                            WHERE t1.my='$value->my_rdt'
                                            ORDER BY t1.y,t1.m,t1.d")->result() as $key => $value2){
                    $drillRDT[]=[
                        'name'=>$value2->mdy,
                        'y'=>intval($value2->cc),
                        'b'=>number_format($value2->cc),
                    ];
                }
                $data["drillRDT"][] = [
                    'name'=>$value->my_rdt,
                    'id'=>$value->my_rdt.'RDT',
                    'type'=>'bar',
                    'data'=>$drillRDT
                ];
                $drillRDT = [];
            }

            if($value->my_pcr!=""){
                $drillPCR = [];
                foreach($this->db->query("SELECT t1.* FROM(
                                            SELECT to_number(to_char(date_test, 'mm'),'00') as m,to_number(to_char(date_test, 'dd'),'00') as d,to_number(to_char(date_test, 'yy'),'99') as y,to_char(date_test, 'MON YYYY') AS my,to_char(date_test, 'MON DD, YY') AS mdy,COUNT(id) AS cc FROM tbl_covid_test_history
                                            WHERE test_id IS NOT NULL AND date_test IS NOT NULL AND test_id=28
                                            GROUP BY to_number(to_char(date_test, 'mm'),'00'),to_number(to_char(date_test, 'dd'),'00'),to_number(to_char(date_test, 'yy'),'99'),to_char(date_test, 'MON YYYY'),to_char(date_test, 'MON DD, YY'))t1
                                            WHERE t1.my='$value->my_pcr'
                                            ORDER BY t1.y,t1.m,t1.d")->result() as $key => $value2){
                    $drillPCR[]=[
                        'name'=>$value2->mdy,
                        'y'=>intval($value2->cc),
                        'b'=>number_format($value2->cc),
                    ];
                }
                $data["drillPCR"][] = [
                    'name'=>$value->my_pcr,
                    'id'=>$value->my_pcr.'PCR',
                    'type'=>'bar',
                    'data'=>$drillPCR
                ];
                $drillPCR = [];
            }

            $data["drilldown"] = array_merge($data["drillRDT"],$data["drillPCR"]);
        }
    
        $data["testTotal"][] = [
            "TOTALRDT"=>number_format($cc_rdt),
            "TOTALPCR"=>number_format($cc_pcr),
        ];
        
        echo json_encode($data);
    }

    function covidGraphGender(){
        $dateNow = $this->now();
        $data = ["GENDER" => [],"drill" => [],"drilldown" => []];
        $cc=1;
        $tGender=0;
        $tGender2=0;
        $p=0;
        $p2=0;
        $query1 = $this->db->query("SELECT CASE WHEN(t2.gender='1') THEN 'MALE' ELSE 'FEMALE' END AS gender,t2.gender AS gen,
                                    COALESCE(count(DISTINCT t1_1.person_id), (0)::bigint) AS cc
                                    FROM tbl_covid_status_history t1_1
                                    LEFT JOIN tbl_person t2 ON t1_1.person_id=t2.id
                                    WHERE (t1_1.status_id = 6 AND t2.gender IS NOT NULL)
                                    GROUP BY t2.gender");

        foreach ($query1->result() as $key => $value) {
            $tGender=$value->cc+$tGender;
        }
        foreach ($query1->result() as $key => $value) {
            $p = ($value->cc/$tGender)*100;
            $data["GENDER"][] = [
                "name" => $value->gender,
                "y" => intval($value->cc),
                "b" => number_format($value->cc),
                "p" => $p,
                "color" => ($value->gender=='MALE'?'#3c8dbc':'#e83e8c'),
                "drilldown" =>$value->gen,
            ];

            $drill = [];
            $query2 = $this->db->query("SELECT CASE WHEN(t2.gender='1') THEN 'MALE' ELSE 'FEMALE' END AS gender,
                                        COALESCE(count(DISTINCT t1_1.person_id), (0)::bigint) AS cc,t2.barangay_id
                                        FROM tbl_covid_status_history t1_1
                                        LEFT JOIN tbl_person t2 ON t1_1.person_id=t2.id
                                        WHERE (t1_1.status_id = 6 AND t2.gender IS NOT NULL) AND t2.gender='$value->gen'
                                        GROUP BY t2.gender,t2.barangay_id");

            foreach($query2->result() as $key => $value2){
                $tGender2=$value2->cc+$tGender2;
            }

            foreach($query2->result() as $key => $value2){
                $p2 = ($value2->cc/$tGender2)*100;
                $drill[]=[
                    'name'=>$this->getBarangayName($value2->barangay_id),
                    'y'=>intval($value2->cc),
                    'b'=>number_format($value2->cc),
                    "p" => $p2,
                ];
            }
            $data["drill"][] = [
                'name'=>$value->gender,
                'id'=>$value->gen,
                'type'=>'bar',
                'data'=>$drill
            ];
            $drill = [];

            $data["drilldown"] = $data["drill"];
        }
        
        echo json_encode($data);
    }

    function covidGraphCategory(){
        $dateNow = $this->now();
        $data = ["CATEGORY" => [],"drill" => [],"drilldown" => []];
        $cc=1;
        $tCategory=0;
        $tCategory2=0;
        $p=0;
        $p2=0;
        $query1 = $this->db->query("SELECT t3.category,
                                    COALESCE(count(DISTINCT t1_1.person_id), (0)::bigint) AS cc
                                    FROM tbl_covid_status_history t1_1
                                    LEFT JOIN tbl_person t2 ON t1_1.person_id=t2.id
                                    LEFT JOIN tbl_covid_details t3 ON t2.id=t3.person_id
                                    WHERE (t1_1.status_id = 6 AND t3.category IS NOT NULL)
                                    GROUP BY t3.category");

        foreach ($query1->result() as $key => $value) {
            $tCategory=$value->cc+$tCategory;
        }
        foreach ($query1->result() as $key => $value) {
            $p = ($value->cc/$tCategory)*100;
            $data["CATEGORY"][] = [
                "name" => $this->getStatusName($value->category),
                "y" => intval($value->cc),
                "b" => number_format($value->cc),
                "p" => $p,
                "drilldown" =>$value->category,
            ];

            $drill = [];
            $query2 = $this->db->query("SELECT t3.category,
                                        COALESCE(count(DISTINCT t1_1.person_id), (0)::bigint) AS cc,t2.barangay_id
                                        FROM tbl_covid_status_history t1_1
                                        LEFT JOIN tbl_person t2 ON t1_1.person_id=t2.id
                                        LEFT JOIN tbl_covid_details t3 ON t2.id=t3.person_id
                                        WHERE (t1_1.status_id = 6 AND t3.category IS NOT NULL) AND t3.category='$value->category'
                                        GROUP BY t3.category,t2.barangay_id");

            foreach($query2->result() as $key => $value2){
                $tCategory2=$value2->cc+$tCategory2;
            }

            foreach($query2->result() as $key => $value2){
                $p2 = ($value2->cc/$tCategory2)*100;
                $drill[]=[
                    'name'=>$this->getBarangayName($value2->barangay_id),
                    'y'=>intval($value2->cc),
                    'b'=>number_format($value2->cc),
                    "p" => $p2,
                ];
            }
            $data["drill"][] = [
                'name'=>$this->getStatusName($value->category),
                'id'=>$value->category,
                'type'=>'bar',
                'data'=>$drill
            ];
            $drill = [];

            $data["drilldown"] = $data["drill"];
        }
        
        echo json_encode($data);
    }

    function getDateYearMonth(){
        $data = ["data1"=>[],"data2"=>[],"data3"=>[],"data4"=>[],"data5"=>[],"data6"=>[],"data7"=>[],"data8"=>[],"data9"=>[],"data10"=>[],"data11"=>[]];
        foreach ($this->db->query("SELECT DISTINCT(to_char(date_test, 'YYYY')) as year FROM tbl_covid_test_history
                                    WHERE test_id IS NOT NULL AND date_test IS NOT NULL
                                    ORDER BY to_char(date_test, 'YYYY') DESC")->result() as $key => $value){
            $data["data1"][] = [
                "id" => $value->year,
                "text" => $value->year,
            ];
        }

        return $data;
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */