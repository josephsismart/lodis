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
            "page_title"        => "Dataentry",
            "current_location"  => "dataentry",
            "content"           =>  [$this->load->view('interface/userhealthworker/Dataentry', [
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
        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='COVID' AND (id=61 OR id=39) ORDER BY sequence")->result() as $key => $value){
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

        foreach ($this->db->query("SELECT * FROM tbl_statusitem WHERE type='CATEGORY' ORDER BY sequence")->result() as $key => $value){
            $data["data8"][] = [
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

    function saveDataPrimary(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        
        $statusCOVID = $this->input->post("statusCOVID");
        $dateEntried = $this->input->post("dateEntried");
        $barangayName = $this->input->post("barangayName");
        $streetName = strtoupper($this->input->post("streetName"));
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $gender = $this->input->post("gender");
        $personAge = $this->input->post("personAge");
        $personNumber = $this->input->post("personNumber");
        // $symptomsCOVID = $this->input->post("symptomsCOVID");
        $remarksCOVID = strtoupper($this->input->post("remarksCOVID"));
        $travelHistory = strtoupper($this->input->post("travelHistory"));
        $dateArrival = $this->input->post("dateArrival");
        $whereaboutsCOVID = strtoupper($this->input->post("whereaboutsCOVID"));
        $categoryCOVID = $this->input->post("categoryCOVID");
        $contactCode = $this->input->post("contactCode");
        $relation = $this->input->post("relation");
        $specifyOffice = $this->input->post("specifyOffice");
        $specifyAgency = strtoupper($this->input->post("specifyAgency"));
        if(!$statusCOVID||!$dateEntried||!$barangayName||!$streetName||!$firstName||!$lastName||$gender==""||!$personAge||!$personNumber){
           $ret = ["success"   => false];
        }else if($travelHistory!="" && !$dateArrival){
           $ret = ["success"   => false];
        }else if($categoryCOVID==44 && !$specifyOffice){
           $ret = ["success"   => false];
        }else if($categoryCOVID==45 && !$specifyAgency){
           $ret = ["success"   => false];
        }else{
            $exist = $this->db->query("SELECT id FROM tbl_person WHERE fname='$firstName' AND mname='$middleName' AND lname='$lastName'");
            $thisExisted = $exist->row("id");
            if(!$thisExisted){
                $data = [
                    "party_id" => 94,
                    "fname" => $firstName,
                    "mname" => $middleName,
                    "lname" => $lastName,
                    "gender" => $gender,
                    "age" => $personAge,
                    "contact_num" => $personNumber,
                    "created_at" => $dateNow,
                    "created_by" => $login_id,
                    "barangay_id" => $barangayName,
                    "street" => $streetName,
                ];
                if($this->db->insert("tbl_person",$data)){
                    $thisPerson = $this->db->insert_id();
                    $data2 = [
                        "person_id" => $thisPerson,
                        "created_date" => $dateNow,
                        "created_by" => $login_id,
                        "remarks" => $remarksCOVID,
                        // "symptoms" => $symptomsCOVID,
                        "travel_history" => $this->returnNull($travelHistory),
                        "date_arrival" => $this->returnNull($dateArrival),
                        "whereabouts" => $this->returnNull($whereaboutsCOVID),
                        "category" => $categoryCOVID,
                        "office_id" => $this->returnNull($specifyOffice),
                        "agency" => $this->returnNull($specifyAgency),
                    ];
                    $this->db->insert("tbl_covid_details",$data2);
                    $this->userlog("INSERTED PERSON ".$thisPerson);


                    $data3 = [
                        "person_id" => $thisPerson,
                        "status_id" => $statusCOVID,
                        "date_status" => $dateEntried,
                        "created_date" => $dateNow,
                        "created_by" => $login_id,
                    ];

                    if($statusCOVID!=61){
                        $this->db->insert("tbl_covid_status_history",$data3);
                        $this->userlog("INSERTED COVID STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                    }


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
                $ret = ["success"  => false,
                        "exist"   => true];
            }
        }
        echo json_encode($ret);
    }

    function saveDataContact(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        
        $personRootId = $this->input->post("personRootId");

        $statusCOVID = $this->input->post("statusCOVID");
        $dateEntried = $this->input->post("dateEntried");
        $barangayName = $this->input->post("barangayName");
        $streetName = strtoupper($this->input->post("streetName"));
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $gender = $this->input->post("gender");
        $personAge = $this->input->post("personAge");
        $personNumber = $this->input->post("personNumber");
        $relation = $this->input->post("relation");
        //$symptomsCOVID = $this->input->post("symptomsCOVID");
        $remarksCOVID = strtoupper($this->input->post("remarksCOVID"));
        $travelHistory = strtoupper($this->input->post("travelHistory"));
        $dateArrival = $this->input->post("dateArrival");
        $whereaboutsCOVID = strtoupper($this->input->post("whereaboutsCOVID"));
        $categoryCOVID = $this->input->post("categoryCOVID");
        $contactCode = $this->input->post("contactCode");
        $relation = $this->input->post("relation");
        $specifyOffice = $this->input->post("specifyOffice");
        $specifyAgency = strtoupper($this->input->post("specifyAgency"));

        if(!$statusCOVID||!$dateEntried||!$barangayName||!$streetName||!$firstName||!$lastName||$gender==""||!$personAge||!$personNumber||!$relation){
           $ret = ["success"   => false];
        }else if($travelHistory!="" && !$dateArrival){
           $ret = ["success"   => false];
        }else if($categoryCOVID==44 && !$specifyOffice){
           $ret = ["success"   => false];
        }else if($categoryCOVID==45 && !$specifyAgency){
           $ret = ["success"   => false];
        }else{
            $exist = $this->db->query("SELECT id FROM tbl_person WHERE fname='$firstName' AND mname='$middleName' AND lname='$lastName'");
            $thisExisted = $exist->row("id");
            if(!$thisExisted){
                $data = [
                    "party_id" => 95,
                    "fname" => $firstName,
                    "mname" => $middleName,
                    "lname" => $lastName,
                    "gender" => $gender,
                    "age" => $personAge,
                    "contact_num" => $personNumber,
                    "created_at" => $dateNow,
                    "created_by" => $login_id,
                    "barangay_id" => $barangayName,
                    "street" => $streetName,
                ];
                if($this->db->insert("tbl_person",$data)){
                    $thisPerson = $this->db->insert_id();
                    $data2 = [
                        "person_id" => $thisPerson,
                        "created_date" => $dateNow,
                        "created_by" => $login_id,
                        "remarks" => $remarksCOVID,
                        //"symptoms" => $symptomsCOVID,
                        "travel_history" => $this->returnNull($travelHistory),
                        "date_arrival" => $this->returnNull($dateArrival),
                        "whereabouts" => $this->returnNull($whereaboutsCOVID),
                        "category" => $categoryCOVID,
                        "office_id" => $this->returnNull($specifyOffice),
                        "agency" => $this->returnNull($specifyAgency),
                    ];
                    $this->db->insert("tbl_covid_details",$data2);
                    $this->userlog("INSERTED PERSON ".$thisPerson);

                    $data3 = [
                        "person_id" => $thisPerson,
                        "status_id" => $statusCOVID,
                        "date_status" => $dateEntried,
                        "created_date" => $dateNow,
                        "created_by" => $login_id,
                    ];

                    if($statusCOVID!=61){
                        $this->db->insert("tbl_covid_status_history",$data3);
                        $this->userlog("INSERTED COVID STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                    }

                    $data4 = [
                        "primary" => $personRootId,
                        "contact" => $thisPerson,
                        "relation" => $relation,
                        "created_by" => $login_id,
                        "created_date" => $dateNow,
                    ];
                    $data5 = [
                        "primary" => $thisPerson,
                        "contact" => $personRootId,
                        "relation" => 26,
                        "created_by" => $login_id,
                        "created_date" => $dateNow,
                    ];

                    if($this->db->insert("tbl_contact_trace",$data4)){
                        $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$personRootId." TO PERSON ".$thisPerson);
                        if($this->db->insert("tbl_contact_trace",$data5)){
                            $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$thisPerson." TO PERSON ".$personRootId);

                        }
                    }
                    
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
                $ret = ["success"  => false,
                        "exist"   => true];
            }
        }
        echo json_encode($ret);
    }

    function saveDataStatusHistory(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;

        $personStatusId = $this->input->post("personStatusId");
        $statusCOVID = $this->input->post("statusCOVID");
        $dateEntried = $this->input->post("dateEntried");

        if(!$personStatusId||!$statusCOVID||!$dateEntried){
           $ret = ["success"   => false];
        }else{
            $data = [
                "person_id" => $personStatusId,
                "status_id" => $statusCOVID,
                "date_status" => $dateEntried,
                "created_date" => $dateNow,
                "created_by" => $login_id,
                "is_active" => 1,
            ];

            $data2 = [
                "is_active" => 0,
            ];

            // if($this->mainModel->update("tbl_covid_status_history",$data2,"person_id",$personStatusId)){
                //$this->db->insert("tbl_covid_status_history",$data);
            if($this->db->query("UPDATE tbl_covid_status_history SET is_active=0 WHERE person_id=$personStatusId")){
                $this->db->insert("tbl_covid_status_history",$data);
                $this->userlog("INSERTED NEW STATUS FOR PERSON ".$personStatusId);
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

    function saveDataTestHistory(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;

        $personTestId = $this->input->post("personTestId");
        $testCOVID = $this->input->post("testCOVID");
        $resultCOVID = $this->input->post("resultCOVID");
        $dateEntried = $this->input->post("dateEntried");

        if(!$personTestId||!$testCOVID||!$resultCOVID||!$dateEntried){
           $ret = ["success"   => false];
        }else{
            $data = [
                "person_id" => $personTestId,
                "test_id" => $testCOVID,
                "result_id" => $resultCOVID,
                "date_test" => $dateEntried,
                "created_date" => $dateNow,
                "created_by" => $login_id,
                "is_active" => 1,
            ];

            $data2 = [
                "is_active" => 0,
            ];

            if($this->db->query("UPDATE tbl_covid_test_history SET is_active=0 WHERE person_id=$personTestId")){
                $this->db->insert("tbl_covid_test_history",$data);
                $this->userlog("INSERTED NEW TEST FOR PERSON ".$personTestId." RESULT ".$resultCOVID);
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

    function getPersonCovid(){
        $data = ["data" => []];
        $user_id = $this->session->covid_tracker_login_id;
        $district_id = $this->session->covid_tracker_login_district;
        foreach ($this->db->query("SELECT t1.barangay_id FROM tbl_user_barangay_district t1 WHERE t1.party_id=$district_id")->result() as $key => $value1) {
            $brgyId = $value1->barangay_id;
            foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.remarks,t3.whereabouts,t3.category,t3.office_id,t3.agency,t3.date_arrival,t4.test_id,t4.result_id FROM tbl_person t1
                                       LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                       LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                       LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                       WHERE t1.barangay_id=$brgyId AND t1.party_id BETWEEN 94 AND 95
                                       ORDER BY t1.id DESC")->result() as $key => $value) {
                $id = $value->id;
                $fullName = $this->getFullName($value->id);
                // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
                //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
                //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
                //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
                $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
                // $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
                //$test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus text-white'></i>":$this->getStatusName($value->test_id)."<br/>".$result)."</center></a></center>";

                $data["data"][] = [
                    "<a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>",
                    $tree,
                    "<span class='badge bg-gradient-gray-dark text-md'>".$fullName."</span>".
                    " <span class='badge bg-".($value->gender==1?"blue":"pink")."'>".($value->gender==1?"MALE":"FEMALE")."</span>".
                    " <span class='badge bg-gray'>".$value->age." YO</span><br/>".
                    "<span class='badge badge bg-gradient-success mt-1'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id)).', '.$value->street."</span>",
                    //" <span class='badge bg-gradient-olive'>".$value->street."</span>",
                    // "<center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".$this->getStatusColor($value->status_id).";'><b>".$this->getStatusName($value->status_id)."</b></a></center>",
                    //$test,
                    "<center><span class='badge bg-gray text-sm'>".(!$value->category?"":$this->getStatusName($value->category))."</span></center>",
                    "<div style='text-align:center'>".$value->contact_num."</div>",
                    // "<center><span class='badge bg-success text-sm'>".$this->getBarangayName($value->barangay_id)."</span></center>",
                    // "<div style='text-align:center'>".$value->street."</div>",
                    "<div style='text-align:center'>".$value->travel_history."<br/>".$value->date_arrival."</div>",
                    "<div style='text-align:center;font-size:10px;'>".(!$value->office_id?"":$this->myParty($value->office_id)).(!$value->agency?"":$value->agency)."</div>",
                    // "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                    // "<div style='text-align:center'>".$value->age."</div>",
                    // "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                    "<center style='font-size:10px;'>".$value->remarks."</center>",
                    "<center style='font-size:10px;'>".$value->whereabouts."</center>",
                    // "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
                    "<center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>",
                ];
            }

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
                $this->getCovid19Details11($value->primary),
                $this->getCovid19Details1($value->contact),
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

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */