<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataentry extends MY_Controller {

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
            "page_title"        => "User Account",
            "current_location"  => "useraccount",
            "content"           =>  [$this->load->view('interface/useradmin/Dataentry', [
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
        $data = ["data1"=>[],"data2"=>[],"data2"=>[]];
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
        foreach ($this->db->query("SELECT t1.id, t1.description FROM tbl_party t1
                                   WHERE t1.party_type_id=7")->result() as $key => $value){
            $data["data3"][] = [
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

    function saveDataUserAccount(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        
        $barangayAssignment = $this->input->post("barangayAssignment");
        $personTitle = strtoupper($this->input->post("personTitle"));
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $barangayName = $this->input->post("barangayName");
        $streetName = strtoupper($this->input->post("streetName"));
        $gender = $this->input->post("gender");
        $personAge = $this->input->post("personAge");
        $personNumber = $this->input->post("personNumber");

        if(!$barangayAssignment||!$personTitle||!$firstName||!$lastName||!$barangayName||!$streetName||$gender==""||!$personAge||!$personNumber){
           $ret = ["success"   => false];
        }else{
            $data = [
                "party_id" => ($barangayAssignment<100?93:($barangayAssignment==100?96:($barangayAssignment==102?104:($barangayAssignment==103?105:89)))),
                "fname" => $firstName,
                "mname" => $middleName,
                "lname" => $lastName,
                "gender" => $gender,
                "age" => $personAge,
                "contact_num" => $personNumber,
                "personal_title" => $personTitle,
                "created_at" => $dateNow,
                "created_by" => $login_id,
                "barangay_id" => $barangayName,
                "street" => $streetName,
            ];
            if($this->db->insert("tbl_person",$data)){
                $thisPerson = $this->db->insert_id();
                $username = strtoupper($firstName).".".strtoupper($lastName);

                $data2 = [
                    "person_id" => $thisPerson,
                    "username" => $username,
                    "password" => md5(12345678),
                    "role_type_id" => ($barangayAssignment==101?1:($barangayAssignment==100?4:($barangayAssignment==102?5:($barangayAssignment==103?6:3)))),
                    "created_at" => $dateNow,
                    "status" => 1,
                    "change_password" => 1,
                ];
                $this->db->insert("tbl_user",$data2);
                $userId = $this->db->insert_id();
                $this->userlog("INSERTED PERSON ".$thisPerson);
                $this->userlog("INSERTED USER ACCOUNT ".$this->db->insert_id());
                
                
                $data3 = [
                    "user_id" => $userId,
                    "district_id" => $barangayAssignment,
                ];

                $this->db->insert("tbl_user_barangay",$data3);
                $this->userlog("INSERTED ASSIGNMENT ".$this->db->insert_id()." FOR USER ".$userId);

                $ret = ["success"   => true];
            }else{
                $ret = ["success"   => false];
            }

            if($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
        echo json_encode($ret);
    }

    function saveUsername(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        $userId = $this->input->post("userName");
        $thisUserName = strtoupper($this->input->post("thisUserName"));

        if(!$thisUserName){
           $ret = ["success"   => false];
        }else{
            $exist = $this->db->query("SELECT id FROM tbl_user WHERE username='$thisUserName'");
            $thisExisted = $exist->row("id");
            if(!$thisExisted){
                $data = [
                    "username" => $thisUserName,
                    "updated_at" => $dateNow,
                ];
                if(!$this->mainModel->update("tbl_user",$data,"id",$userId)){
                    $this->userlog("UPDATED USERNAME OF ".$userId);
                    $ret = ["success"   => true,
                            "exist"   => false];
                }else{
                    $ret = ["success"   => false,
                            "exist"   => false];
                }

                if($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }else{
                $ret = ["success"   => false,
                        "exist"   => true];
            }
        }
        echo json_encode($ret);
    }

    function resetPassword(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        $userId = $this->input->post("value");

        $data = [
            "password" => md5(12345678),
            "updated_at" => $dateNow,
            "change_password" => 1,
        ];
        if(!$this->mainModel->update("tbl_user",$data,"id",$userId)){
            $this->userlog("RESET PASSWORD OF ".$userId);
            $ret = ["success"   => true];
        }else{
            $ret = ["success"   => false];
        }

        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        echo json_encode($ret);
    }

    function getPersonAccount(){
        $data = ["data" => []];
        // $user_id = $this->session->covid_tracker_login_id;
        $cc=1;
        foreach ($this->db->query("SELECT t2.id,t1.id AS person_id,t1.party_id,t1.personal_title,t1.contact_num,t1.barangay_id,t1.street,t1.gender,t1.age,t2.username,t2.password,t2.status,t5.description AS role,t6.description AS district
                                    FROM tbl_person t1
                                    LEFT JOIN tbl_user t2 ON t2.person_id=t1.id
                                    LEFT JOIN tbl_user_barangay t3 ON t3.user_id=t2.id
                                    LEFT JOIN tbl_party t4 ON t4.id=t3.district_id
                                    LEFT JOIN tbl_roletype t5 ON t5.id=t2.role_type_id
                                    LEFT JOIN tbl_party t6 ON t6.id=t3.district_id
                                    WHERE t1.party_id<>94 AND t1.party_id<>95")->result() as $key => $value) {
            $id = $value->id;
            $userName = $value->username;
            $p=$value->party_id;
            $color = ($p==93?"info":($p==96?"primary":"success"));

            $data["data"][] = [
                $cc++,
                "<center><a class='btn btn-xs bg-".($value->status==1?"lightblue":"danger")."' onclick='updateUsername($id,\"$userName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;'><i class='fa fa-folder-open'></i></a></center>",
                "<div><span class='badge bg-".$color."' style='white-space: nowrap;font-size:13px;'>".$this->getFullName($value->person_id)."</span><br/><small>".$value->personal_title."</small></div>",
                $value->district,
                $value->contact_num,
                $value->street.", ".$this->getBarangayName($value->barangay_id),
                "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                "<div style='text-align:center'>".$value->age."</div>",
                "<div>".$value->contact_num."</div>",
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
        $query = (!$personId==1?"":" WHERE t1.person_id=$personId ORDER BY t1.id DESC");
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