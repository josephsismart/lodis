<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        //$this->redirect();

        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
        $dataR = [];
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

}