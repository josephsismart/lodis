<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataentry2 extends MY_Controller {

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
            "page_title"        => "Dataentry2",
            "current_location"  => "dataentry2",
            "content"           =>  [$this->load->view('interface/useradmin/Dataentry2', [
                                        "getBarangay" => $this->getBarangayAssigned(),
                                        "getStatus" => $this->getStatus(),
                                        //"accomplished"      => $this->get_accomplished(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function getBarangayAssigned(){
        $user_id = $this->session->covid_tracker_login_id;
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
        $data = ["data1"=>[],"data2"=>[],"data3"=>[],"data4"=>[],"data5"=>[],"data6"=>[]];
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

        return $data;
    }

    function getPersonCovid(){
        $data = ["data" => []];
        $user_id = $this->session->covid_tracker_login_id;
        foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.remarks,t3.symptoms,t4.test_id,t4.result_id FROM tbl_person t1
                                   LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                   LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                   LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                   WHERE t1.party_id BETWEEN 94 AND 95")->result() as $key => $value) {
            $id = $value->id;
            $fullName = $this->getFullName($value->id);
            $tree = $this->hasContactAll($id)>0?"<center><a class='btn btn-success btn-xs btn-default' onclick='myContact($id)'><span class='badge bg-danger'>".$this->hasContactAll($id)."</span></a></center>":"";
            $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
            $test = (!$value->test_id?"":"<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".$this->getStatusName($value->test_id)."<br/>".$result."</center></a></center>");

            $data["data"][] = [
                // "<a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>",
                $tree,
                "<span class='badge bg-gradient-gray-dark text-lg'>".$this->getFullName($value->id)."</span>",
                "<center><a class='btn btn-xs bg-lightblue' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;'><b>".$this->getStatusName($value->status_id)."</b></a></center>",
                $test,
                "<div style='text-align:center'>".$value->contact_num."</div>",
                "<center><span class='badge bg-gradient-success text-lg'>".$this->getBarangayName($value->barangay_id)."</span></center>",
                "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                "<div style='text-align:center'>".$value->age."</div>",
                "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                "<center style='font-size:10px;'>".$value->remarks."</center>",
                "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidStatus(){
        $data = ["data" => []];
        $personId=$this->input->post("personId");
        $cc=1;
        $query = (!$personId?"":" WHERE t1.person_id=$personId ORDER BY t1.id DESC");
        foreach ($this->db->query("SELECT t1.* FROM tbl_covid_status_history t1 $query")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                $this->getStatusName($value->status_id),
                $value->date_status,
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidTest(){
        $data = ["data" => []];
        $personId=$this->input->post("personId");
        $cc=1;
        $query = (!$personId?"":" WHERE t1.person_id=$personId ORDER BY t1.id DESC");
        foreach ($this->db->query("SELECT t1.* FROM tbl_covid_test_history t1 $query")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                $this->getStatusName($value->test_id),
                $this->getStatusName($value->result_id),
                $value->date_test,
            ];
        }
        echo json_encode($data);
    }

    function hasContact($a){
        $query = $this->db->query("SELECT COUNT(1) AS person FROM tbl_contact_trace t1 WHERE t1.primary=$a");
        $me = $query->row("person");
        return $me;
    }

    function hasContactAll($a){
        $cc=0;
        $data = [];
        $contactSearch = [];
        $tmp = "";
        foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$a")->result() as $key => $value){;
            $cc=$cc+1;
            $contactSearch[] = [
                $value->contact,
            ];
        }

        for($x=0;$x<sizeof($contactSearch);$x++){
            $findMe = intval($contactSearch[$x][0]);
            foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe")->result() as $key => $value){;
                $cc=$cc+1;
                $contactSearch[] = [
                    $value->contact,
                ];
            }
        }
        return $cc;
    }


    function myParty($a){
        $query = $this->db->query("SELECT t1.description FROM tbl_party t1 WHERE t1.id=$a");
        $me = $query->row("description");
        return $me;
    }

    function getMyContact(){
        // $contact = [];
        $val = $this->input->post("value");
        $data = [];
        $contactSearch = [];
        $tmp = "";
        foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$val")->result() as $key => $value){;
            $data[] = [
                $this->getCovid19Details($value->primary),
                $this->getCovid19Details($value->contact),
            ];
            $contactSearch[] = [
                $value->contact,
            ];
        }

        // $searchMe = ($tmp==""?$value->contact:$contact);
        // for($x=0;$x<sizeof($contactSearch);$x++){
        //     $findMe = intval($contactSearch[$x][0]);
        //     foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe")->result() as $key => $value){;
        //         $data[] = [
        //             $this->getCovid19Details($value->primary),
        //             $this->getCovid19Details($value->contact),
        //         ];
        //         // $query = $this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe");
        //         $contactSearch[] = [
        //             $value->contact,
        //         ];
        //     }
        // }
        // echo json_encode($contactSearch[0][0]);
        echo json_encode($data);
    }

    function getContact(){
        // $contact = [];
        $data = ["data1"=>[],"data2"=>[]];
        $val = $this->input->post("value");
        $data = [];
        $contactSearch = [];
        $tmp = "";
        foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$val")->result() as $key => $value){;
            $data["data1"][] = [
                $this->getCovid19Details($value->primary),
                $this->getCovid19Details($value->contact),
            ];
            $data["data2"][] = [
                $value->primary,
                $value->contact,
            ];
            $contactSearch[] = [
                $value->contact,
            ];
        }

        // $searchMe = ($tmp==""?$value->contact:$contact);
        for($x=0;$x<sizeof($contactSearch);$x++){
            $findMe = intval($contactSearch[$x][0]);
            foreach($this->db->query("SELECT t1.* FROM tbl_contact_trace t1 WHERE t1.primary=$findMe")->result() as $key => $value){;
                $data["data1"][] = [
                    $this->getCovid19Details($value->primary),
                    $this->getCovid19Details($value->contact),
                ];
                $data["data2"][] = [
                    $value->primary,
                    $value->contact,
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

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */