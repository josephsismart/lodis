<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends MY_Controller {

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
        $this->redirect_home();
        $data = $this->system();
        $data += [
            "page_title"    => "Map",
            "current_location"  => "map",
            "my_url"      => 'http://'.$_SERVER['HTTP_HOST'].':8080/geoserver/ows?',
            "getStatusCount" => $this->getStatusCount(),
            "getNational" => $this->getNational(),
            "getBarangay" => $this->getBarangay(),
            // "chart1" => $this->chart1(),
            // "chart2" => $this->chart2(),
            // "chart3" => $this->chart3(),
            // "chart4" => $this->chart4(),
        ];
        $this->load->view('interface/usermanagement/Map', $data);
    }

    function getStatusCount(){
        $data = [];
        foreach($this->db->query("SELECT * FROM total_status")->result() as $key => $value){
            $data[] = [
                "code" => $value->description,
                "count" => $value->cc,
            ];
        }
        return $data;
    }

    function getMap(){
        $data = [];
        $point = $this->input->post("point");
        $query = $this->db->query("SELECT t1.*,COALESCE(t3.cc,0) SUS,COALESCE(t4.cc,0) PRO,COALESCE(t5.cc,0) TPS,COALESCE(t6.cc,0) REC,COALESCE(t7.cc,0) DED,COALESCE(t8.cc,0) CLR,COALESCE(t9.cc,0) PUM
                                    FROM butuan_city t1
                                    LEFT JOIN covid19_suspected t3 ON t1.party_id=t3.barangay_id
                                    LEFT JOIN covid19_probable t4 ON t1.party_id=t4.barangay_id
                                    LEFT JOIN covid19_confirmed t5 ON t1.party_id=t5.barangay_id
                                    LEFT JOIN covid19_recovered t6 ON t1.party_id=t6.barangay_id
                                    LEFT JOIN covid19_dead t7 ON t1.party_id=t7.barangay_id
                                    LEFT JOIN covid19_cleared t8 ON t1.party_id=t8.barangay_id
                                    LEFT JOIN covid19_pum t9 ON t1.party_id=t9.barangay_id,
                                    (SELECT st_astext (st_transform (st_setsrid (st_geometryfromtext ('$point'),4326),32651)) AS geom)t2
                                    WHERE st_intersects (
                                                        st_geometryfromtext (st_astext(t2.geom), 4326),
                                                        st_geometryfromtext (
                                                                st_astext (t1.st_transform),
                                                                4326
                                                        )
                                                )='t'");
        $data = [
            "id" => $query->row("party_id"),
            "barangay" => $query->row("description"),
            "tps" => $query->row("tps"),
            "rec" => $query->row("rec"),
            "ded" => $query->row("ded"),
            "sus" => $query->row("sus"),
            "pro" => $query->row("pro"),
            "clr" => $query->row("clr"),
            "pum" => $query->row("pum"),
        ];
        echo json_encode($data);
    }

    function getContact(){
        // $contact = [];
        $data = [];
        $contactSearch = [];
        $tmp = "";
        foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=1")->result() as $key => $value){;
            $data[] = [
                $this->getCovid19Details($value->primary),
                $this->getCovid19Details($value->contact),
            ];
            $contactSearch[] = [
                $value->contact,
            ];
        }

        // $searchMe = ($tmp==""?$value->contact:$contact);
        for($x=0;$x<sizeof($contactSearch);$x++){
            $findMe = intval($contactSearch[$x][0]);
            foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe")->result() as $key => $value){;
                $data[] = [
                    $this->getCovid19Details($value->primary),
                    $this->getCovid19Details($value->contact),
                ];
                // $query = $this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe");
                $contactSearch[] = [
                    $value->contact,
                ];
            }
        }
        // echo json_encode($contactSearch[0][0]);
        echo json_encode($data);
    }

    function getChild($a){
        //foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$a")->result() as $key => $value2){;
            // $dataR[] = [
            //     "primary" => 1,
            //     "contact" => 2,
            // ];
        //}
        //return json_encode($dataR);
    }

    function getNational(){
        $data = [];
        $query = $this->db->query("SELECT * FROM tbl_national ORDER BY id DESC LIMIT 1");
        $n = $query->row("national_data");
        $b = explode(",",$n);
        $con = $this->removeCharacter($b[0]);
        $tst = $this->removeCharacter($b[1]);
        $pui = $this->removeCharacter($b[2]);
        $pum = $this->removeCharacter($b[3]);
        $dts = $this->removeCharacter($b[4]);
        $rcv = $this->removeCharacter($b[5]);
        $data = [
            "con" => number_format($con),
            "tst" => number_format($tst),
            "pui" => number_format($pui),
            "pum" => number_format($pum),
            "dts" => number_format($dts),
            "rcv" => number_format($rcv),
        ];
        return $data;
    }

    function chart1(){
        $data = ["PUI"=>[],"PUM"=>[],"REC"=>[],"CLR"=>[],"TPS"=>[],"TNE"=>[],"DED"=>[],"title"=>[],];
        $PUI_total = 0;
        $PUM_total = 0;
        $CLR_total = 0;
        $TNE_total = 0;
        $TPS_total = 0;
        $REC_total = 0;
        $DED_total = 0;
        $day = 0;


        $data["PUI"][]=[
            'y'=>$PUI_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["PUM"][]=[
            'y'=>$PUM_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["CLR"][]=[
            'y'=>$CLR_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["TNE"][]=[
            'y'=>$TNE_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["TPS"][]=[
            'y'=>$TPS_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["REC"][]=[
            'y'=>$REC_total,
            'a'=>0,
            'd'=>$day,
        ];

        $data["DED"][]=[
            'y'=>$DED_total,
            'a'=>0,
            'd'=>$day,
        ];

        foreach($this->db->query("SELECT * FROM chart1_2")->result() as $key => $value){
                $data["title"] = $value->date_text;
                $y = intval($value->PUI);
                $PUI_total += $y;
                $data["PUI"][]=[
                    'y'=>$PUI_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->PUM);
                $PUM_total += $y;
                $data["PUM"][]=[
                    'y'=>$PUM_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->CLR);
                $CLR_total += $y;
                $data["CLR"][]=[
                    'y'=>$CLR_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->TNE);
                $TNE_total += $y;
                $data["TNE"][]=[
                    'y'=>$TNE_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->TPS);
                $TPS_total += $y;
                $data["TPS"][]=[
                    'y'=>$TPS_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->REC);
                $REC_total += $y;
                $data["REC"][]=[
                    'y'=>$REC_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $y = intval($value->DED);
                $DED_total += $y;
                $data["DED"][]=[
                    'y'=>$DED_total,
                    'a'=>$y,
                    'd'=>$day,
                ];

                $day=intval($day)+1;

        }
        return json_encode($data);
    }

    function chart2(){
        $data = ["data"=>[],"drilldown"=>[],];
        foreach($this->db->query('SELECT t1.* FROM chart2 t1')->result() as $key => $value){
            $y  = intval($value->cc);
            $data["data"][]=[
                'name'=>$value->status_name,
                'y'=>$y,
                'color'=>$value->color,
                'drilldown'=>$value->status_id,
            ];
            $drilldown = [];
            foreach($this->db->query("SELECT t1.* FROM chart2_1 t1 WHERE t1.status_id=$value->status_id")->result() as $key => $value2){
                $y  = intval($value2->cc);
                $drilldown[]=[
                    'name'=>$value2->barangay_name,
                    'y'=>$y,
                ];
            }
            $data["drilldown"][] = [
                'name'=>$value->status_name,
                'id'=>$value->status_id,
                'type'=>'bar',
                'data'=>$drilldown
            ];
            //$drilldown = [];
        }
        return json_encode($data);
    }

    function chart3(){
        $data = ["data_male"=>[],"data_female"=>[],"drillMale"=>[],"drillFemale"=>[],"drilldown"=>[],];
        foreach($this->db->query('SELECT t1.* FROM chart3 t1')->result() as $key => $value){
            if($value->gender==1){
                $yM  = intval($value->cc);
                $data["data_male"][]=[
                    'name'=>$value->status_name,
                    'y'=>$yM,
                    'color'=>$value->color,
                    'drilldown'=>$value->status_id.'M',
                ];

                $drillMale = [];
                foreach($this->db->query("SELECT t1.* FROM chart3_1 t1 WHERE t1.gender=1 AND t1.status_id=$value->status_id")->result() as $key => $value2){
                    $yMM  = intval($value2->cc);
                    $drillMale[]=[
                        'name'=>$value2->barangay_name,
                        'y'=>$yMM,
                    ];
                }
                $data["drillMale"][] = [
                    'name'=>$value->status_name,
                    'id'=>$value->status_id.'M',
                    'type'=>'bar',
                    'data'=>$drillMale
                ];
                $drillMale = [];
            }

            if($value->gender==0){
                $yF  = intval($value->cc);
                $data["data_female"][]=[
                    'name'=>$value->status_name,
                    'y'=>$yF,
                    'color'=>$value->color,
                    'drilldown'=>$value->status_id.'F',
                ];

                $drillFemale = [];
                foreach($this->db->query("SELECT t1.* FROM chart3_1 t1 WHERE t1.gender=0 AND t1.status_id=$value->status_id")->result() as $key => $value2){
                    $yFF  = intval($value2->cc);
                    $drillFemale[]=[
                        'name'=>$value2->barangay_name,
                        'y'=>$yFF,
                    ];
                }
                $data["drillFemale"][] = [
                    'name'=>$value->status_name,
                    'id'=>$value->status_id.'F',
                    'type'=>'bar',
                    'data'=>$drillFemale
                ];
                $drillFemale = [];
            }

            $data["drilldown"] = array_merge($data["drillMale"],$data["drillFemale"]);

        }
        return json_encode($data);
    }

    function chart4(){
        $data = ["data"=>[],"drilldown"=>[],];
        foreach($this->db->query('SELECT t1.* FROM chart4 t1')->result() as $key => $value){
            $y  = intval($value->cc);
            $data["data"][]=[
                'name'=>$value->status_name,
                'y'=>$y,
                'color'=>$value->color,
                'drilldown'=>$value->code,
            ];
            $drilldown = [];
            foreach($this->db->query("SELECT t1.* FROM chart4_1 t1 WHERE t1.status_id=$value->status_id")->result() as $key => $value2){
                $y  = intval($value2->cc);
                $drilldown[]=[
                    'name'=>'Age: '.$value2->age,
                    'y'=>$y,
                    //'drilldown'=>'age'.$value2->age,
                ];
                // $drilldown2 = [];
                // foreach($this->db->query("SELECT t1.* FROM chart4_2 t1 WHERE t1.status_id=$value->status_id AND t1.age=$value2->age")->result() as $key => $value3){
                //     $y  = intval($value3->cc);
                //     $drilldown2[]=[
                //         'name'=>$value3->age.' '.$value3->barangay_name,
                //         'y'=>$y,
                //     ];
                // }
                // $data["drilldown"][] = [
                //     'name'=>$value->status_name,
                //     'id'=>'age'.$value2->age,
                //     'type'=>'bar',
                //     'data'=>$drilldown2
                // ];
                // $drilldown2 = [];
            }
            $data["drilldown"][] = [
                'name'=>$value->status_name,
                'id'=>$value->code,
                'type'=>'column',
                'data'=>$drilldown
            ];
            $drilldown = [];
        }
        return json_encode($data);
    }
}

/* End of file Login_admin.php */
/* Location: ./application/controllers/system/Login_admin.php */