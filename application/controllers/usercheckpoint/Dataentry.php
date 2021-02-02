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
            "content"           =>  [$this->load->view('interface/usercheckpoint/Dataentry', [
                                        "getBarangay" => $this->getBarangayAssigned(),
                                        "getStatus" => $this->getStatus(),
                                        "reset" => $this->resetExist(),
                                        //"getStatusCode" => $this->getStatusCode($this->session->covid_tracker_testing_code),
                                        //"getTestCodeMaxNum" => $this->getTestCodeMaxNum(),
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

        // foreach ($this->db->query("SELECT CONCAT(t1.testing_code,CASE WHEN t1.testing_code IS NULL THEN '' ELSE ' - ' END) code,t2.id personid FROM tbl_covid_details t1
        //                             LEFT JOIN tbl_person t2 ON t1.person_id=t2.id ORDER BY t2.fname ASC")->result() as $key => $value){
        //     $data["data7"][] = [
        //         "id" => $value->personid,
        //         "text" => $value->code.$this->getFullName($value->personid),
        //     ];
        // }

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

    function getPrimaryContact(){
        $data = ["data1"=>[]];
        $personNameFilter = strtoupper($this->input->post("v"));
        $where = "WHERE CONCAT(t2.fname,COALESCE(CONCAT(' ',t2.mname),''),' ',t2.lname,COALESCE(t2.extname,'')) LIKE '%$personNameFilter%'";
        foreach ($this->db->query("SELECT CONCAT(t1.testing_code,CASE WHEN t1.testing_code IS NULL THEN '' ELSE ' - ' END) code,t2.id personid FROM tbl_covid_details t1
                                    LEFT JOIN tbl_person t2 ON t1.person_id=t2.id
                                    $where
                                    ORDER BY t2.fname ASC")->result() as $key => $value){
            $data["data1"][] = [
                "id" => $value->personid,
                "text" => $value->code.$this->getFullName($value->personid),
            ];
        }
        echo json_encode($data);
    }

    // function getMaxCode(){
    //     $this->session->covid_tracker_person_exist = 0;
    //     $max = $this->getTestCodeMaxNum();
    //     echo $max;
    // }

    function resetExist(){
        $this->session->covid_tracker_person_exist = 0;
    }

    function saveDataPrimary(){
        $this->session->covid_tracker_person_exist = 0;
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        
        $Pid = $this->input->post("Pid");
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
        //$symptomsCOVID = $this->input->post("symptomsCOVID");
        $remarksCOVID = strtoupper($this->input->post("remarksCOVID"));
        $travelHistory = strtoupper($this->input->post("travelHistory"));
        $dateArrival = $this->input->post("dateArrival");
        $whereaboutsCOVID = strtoupper($this->input->post("whereaboutsCOVID"));

        $resultRDT = $this->input->post("resultRDT");
        $dateRDT = $this->input->post("dateRDT");
        $symptomsCOVIDRDT = $this->input->post("symptomsCOVIDRDT");

        $resultPCR = $this->input->post("resultPCR");
        $datePCR = $this->input->post("datePCR");
        $symptomsCOVIDPCR = $this->input->post("symptomsCOVIDPCR");

        
        $testingCode = strtoupper($this->input->post("personCode"));
        //$testingNum = $this->getTestCodeMaxNumSave($testingCode);

        $categoryCOVID = $this->input->post("categoryCOVID");
        $qstatusCOVID = $this->input->post("qstatusCOVID");
        $qstatusDate = $this->input->post("qstatusDate");

        $contactCode = $this->input->post("contactCode");
        $relation = $this->input->post("relation");

        $specifyOffice = $this->input->post("specifyOffice");
        $specifyAgency = strtoupper($this->input->post("specifyAgency"));
        $PidUpdate = $this->input->post("PidUpdate");
        $PCodeTemp = $this->input->post("PCodeTemp");

        $exist = $this->db->query("SELECT id FROM tbl_person WHERE fname='$firstName' AND mname='$middleName' AND lname='$lastName' AND party_id BETWEEN 94 AND 95");
        $existCode = $this->mainModel->sel_table("tbl_covid_details","testing_code",$testingCode);
        $thisExisted = $exist->row("id");
        //$this->session->covid_tracker_person_exist = $thisExisted;
        $thisExistedCode = $existCode->row("id");
        $existCodePerson = $existCode->row("person_id");

        if(!$statusCOVID||!$dateEntried||!$barangayName||!$streetName||!$firstName||!$lastName||$gender==""||!$personAge||!$personNumber||!$categoryCOVID||!$qstatusCOVID||!$qstatusDate){
           $ret = ["success"   => false];
        }
        else if($travelHistory!="" && !$dateArrival){
           $ret = ["success"   => false];
        }
        else if($contactCode!="" && !$relation){
           $ret = ["success"   => false];
        }
        else if($resultRDT!="" && !$dateRDT){
           $ret = ["success"   => false];
        }
        else if($resultPCR!="" && !$datePCR){
           $ret = ["success"   => false];
        }
        else if($categoryCOVID==44 && !$specifyOffice){
           $ret = ["success"   => false];
        }
        else if($categoryCOVID==45 && !$specifyAgency){
           $ret = ["success"   => false];
        }else if($Pid!="" && $testingCode!=$PCodeTemp && $thisExistedCode!=""){
            $ret = ["success"  => false,
                    "exist"   => false,
                    "existCode"   => true,
                    "existPerson"   => $this->getFullName($existCodePerson)];
        }else if(!$Pid && $thisExistedCode!=""){
            $ret = ["success"  => false,
                    "exist"   => false,
                    "existCode"   => true,
                    "existPerson"   => $this->getFullName($existCodePerson)];
        }else if(!$Pid && $thisExisted!=""){
            $ret = ["success"  => false,
                    "exist"   => true,
                    "existCode"   => false];
        }else{
            if(!$Pid && !$PidUpdate){
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
                        "remarks" => $this->returnNull($remarksCOVID),
                        //"symptoms" => $symptomsCOVID,
                        "travel_history" => $this->returnNull($travelHistory),
                        "date_arrival" => $this->returnNull($dateArrival),
                        "testing_code" => $this->returnNull($testingCode),
                        //"testing_number" => $this->returnNull($testingNum),
                        "whereabouts" => $this->returnNull($whereaboutsCOVID),
                        "category" => $categoryCOVID,
                        "office_id" => $this->returnNull($specifyOffice),
                        "agency" => $this->returnNull($specifyAgency),
                    ];
                    if($this->db->insert("tbl_covid_details",$data2)){
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
                           $this->userlog("INSERTED COVID STATUS ".$statusCOVID." TO PERSON ".$thisPerson);
                        }

                        $data8 = [
                            "person_id" => $thisPerson,
                            "qstatus_id" => $qstatusCOVID,
                            "date_status" => $qstatusDate,
                            "created_date" => $dateNow,
                            "created_by" => $login_id,
                        ];

                        if($qstatusCOVID!=62){
                           $this->db->insert("tbl_covid_qstatus_history",$data8);
                           $this->userlog("INSERTED COVID QUARANTINE STATUS ".$qstatusCOVID." TO PERSON ".$thisPerson);
                        }

                        $data4 = [
                            "is_active" => 0,
                        ];

                        if($resultRDT!="" && $dateRDT!=""){
                            $data5 = [
                                "person_id" => $thisPerson,
                                "test_id" => 27,
                                "result_id" => $resultRDT,
                                "date_test" => $dateRDT,
                                "created_date" => $dateNow,
                                "created_by" => $login_id,
                                "is_active" => 1,
                                "symptoms" => $symptomsCOVIDRDT,
                            ];
                            if(!$this->mainModel->update("tbl_covid_test_history",$data4,"person_id",$thisPerson)){
                                $this->db->insert("tbl_covid_test_history",$data5);
                                $this->userlog("INSERTED NEW TEST ".$this->getStatusCode(27)."-".$resultRDT." FOR PERSON ".$thisPerson);
                            }
                        }

                        if($resultPCR!="" && $datePCR!=""){
                            $data6 = [
                                "person_id" => $thisPerson,
                                "test_id" => 28,
                                "result_id" => $resultPCR,
                                "date_test" => $datePCR,
                                "created_date" => $dateNow,
                                "created_by" => $login_id,
                                "is_active" => 1,
                                "symptoms" => $symptomsCOVIDPCR,
                            ];
                            if(!$this->mainModel->update("tbl_covid_test_history",$data4,"person_id",$thisPerson)){
                                $this->db->insert("tbl_covid_test_history",$data6);
                                $this->userlog("INSERTED NEW TEST ".$this->getStatusCode(28)."-".$resultPCR." FOR PERSON ".$thisPerson);
                            }
                        }

                        if($contactCode!="" && $relation!=""){
                            $data7 = [
                                "primary" => $contactCode,
                                "contact" => $thisPerson,
                                "relation" => $relation,
                                "created_by" => $login_id,
                                "created_date" => $dateNow,
                            ];
                            $data8 = [
                                "primary" => $thisPerson,
                                "contact" => $contactCode,
                                "relation" => 26,
                                "created_by" => $login_id,
                                "created_date" => $dateNow,
                            ];
                            if($this->db->insert("tbl_contact_trace",$data7)){
                                $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$contactCode." TO PERSON ".$thisPerson);
                                if($this->db->insert("tbl_contact_trace",$data8)){
                                    $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$thisPerson." TO PERSON ".$contactCode);

                                }
                            }
                        }

                        $ret = ["success"   => true,
                                "exist"   => false,
                                "existCode"   => false];

                    }
                }else{
                    $ret = ["success"   => false,
                            "exist"   => false,
                            "existCode"   => false];
                }

                if($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }else if($Pid!="" && $PidUpdate=="UP"){
                $data = [
                    "fname" => $firstName,
                    "mname" => $middleName,
                    "lname" => $lastName,
                    "gender" => $gender,    
                    "age" => $personAge,
                    "contact_num" => $personNumber,
                    "updated_at" => $dateNow,
                    "updated_by" => $login_id,
                    "barangay_id" => $barangayName,
                    "street" => $streetName,
                ];
                if(!$this->mainModel->update("tbl_person",$data,"id",$Pid)){
                    $this->userlog("UPDATED PERSON ".$Pid);
                    $data2 = [
                        "updated_date" => $dateNow,
                        "updated_by" => $login_id,
                        "remarks" => $this->returnNull($remarksCOVID),
                        "travel_history" => $this->returnNull($travelHistory),
                        "date_arrival" => $this->returnNull($dateArrival),
                        "testing_code" => $this->returnNull($testingCode),
                        "whereabouts" => $this->returnNull($whereaboutsCOVID),
                        "category" => $categoryCOVID,
                        "office_id" => $this->returnNull($specifyOffice),
                        "agency" => $this->returnNull($specifyAgency),
                    ];
                    if(!$this->mainModel->update("tbl_covid_details",$data2,"person_id",$Pid)){
                        $this->userlog("UPDATED COVID DETAILS ".$Pid);
                        $ret = ["success"   => true,
                                "exist"   => false,
                                "existCode"   => false];
                    }
                }else{
                    $ret = ["success"   => false,
                            "exist"   => false,
                            "existCode"   => false];
                }

                if($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }else{
                $ret = ["success"  => false,
                        "exist"   => true,
                        "existCode"   => false];
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
        $proceed = $this->input->post("proceed");
        $testCOVID = $this->input->post("testCOVID");
        $resultCOVID = $this->input->post("resultCOVID");
        $dateEntried = $this->input->post("dateEntried");
        $symptomsCOVID = $this->input->post("symptomsCOVID");

        if(!$personTestId||!$testCOVID||!$resultCOVID||!$dateEntried||!$symptomsCOVID){
           $ret = ["success"   => false];
        }else{

            $exist_date = $this->db->query("SELECT id FROM tbl_covid_test_history WHERE person_id=$personTestId AND date_test='$dateEntried'::date");

            if(!$exist_date->row("id") || $proceed==1){
                $date_old = $this->db->query("SELECT id FROM tbl_covid_test_history WHERE person_id=$personTestId AND date_test>'$dateEntried'::date");
                $exist = $this->db->query("SELECT id FROM tbl_covid_test_history WHERE person_id=$personTestId");

                $data = [
                    "person_id" => $personTestId,
                    "test_id" => $testCOVID,
                    "result_id" => $resultCOVID,
                    "date_test" => $dateEntried,
                    "symptoms" => $symptomsCOVID,
                    "created_date" => $dateNow,
                    "created_by" => $login_id,
                    "is_active" => (!$exist->row("id")?1:0),
                ];
                
                
                if($exist->row("id")!=""){
                    if($this->db->query("UPDATE tbl_covid_test_history SET is_active=0 WHERE person_id=$personTestId")){
                        if($this->db->insert("tbl_covid_test_history",$data)){
                            if($this->db->query("UPDATE tbl_covid_test_history SET is_active=1
                                                        FROM(SELECT id FROM tbl_covid_test_history WHERE person_id=$personTestId ORDER BY date_test DESC,id DESC LIMIT 1) AS squery
                                                 WHERE tbl_covid_test_history.id=squery.id")){
                                $this->userlog("INSERTED NEW TEST FOR PERSON ".$personTestId." RESULT ".$resultCOVID);
                            }
                        }
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }else{
                    if($this->db->insert("tbl_covid_test_history",$data)){
                        $this->userlog("INSERTED NEW TEST FOR PERSON ".$personTestId." RESULT ".$resultCOVID);
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }
                
                    

                if($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }else{
                $ret = ["success"   => false,
                        "exist" => true];
            }
        }
        echo json_encode($ret);
    }

    function saveDataQStatusHistory(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;

        $personQStatusId = $this->input->post("personQStatusId");
        $qstatusCOVID = $this->input->post("qstatusCOVID");
        $dateEntried = $this->input->post("dateEntried");

        if(!$personQStatusId||!$qstatusCOVID||!$dateEntried){
           $ret = ["success"   => false];
        }else{
            $data = [
                "person_id" => $personQStatusId,
                "qstatus_id" => $qstatusCOVID,
                "date_status" => $dateEntried,
                "created_date" => $dateNow,
                "created_by" => $login_id,
                "is_active" => 1,
            ];

            $data2 = [
                "is_active" => 0,
            ];

            // if($this->mainModel->update("tbl_covid_qstatus_history",$data2,"person_id",$personQStatusId)){
                //$this->db->insert("tbl_covid_qstatus_history",$data);
            if($this->db->query("UPDATE tbl_covid_qstatus_history SET is_active=0 WHERE person_id=$personQStatusId")){
                $this->db->insert("tbl_covid_qstatus_history",$data);
                $this->userlog("INSERTED NEW QUARANTINE STATUS FOR PERSON ".$personQStatusId);
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

    function saveDataCodeHistory(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;

        $personCode = strtoupper($this->input->post("modalPersonCode"));
        $personId = $this->input->post("personCodeId");

            if(!$personCode){
               $ret = ["success"   => false];
            }else{
                $existCode = $this->db->query("SELECT id,person_id FROM tbl_covid_details WHERE testing_code='$personCode'");
                $thisExistedCode = $existCode->row("id");
                $existCodePerson = $existCode->row("person_id");
                if(!$thisExistedCode){
                    $data = [
                        "testing_code" => $personCode,
                        "updated_date" => $dateNow,
                        "updated_by" => $login_id,
                    ];
                    if(!$this->mainModel->update("tbl_covid_details",$data,"person_id",$personId)){
                        $this->userlog("UPDATED PERSON CODE TO ".$personCode);
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }

                    if($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                }else{
                    $ret = ["success"   => false,
                            "exist"   => true,
                            "existPerson"   => $this->getFullName($existCodePerson)];
                }
            }
        echo json_encode($ret);
    }

    function getPersonCovid(){
        $dateN = Date('d/m/Y');
        $data = ["data" => []];
        $data2 = [];
        $user_id = $this->session->covid_tracker_login_id;
        $district_id = $this->session->covid_tracker_login_district;
        
        parse_str($this->input->post("a"),$filter);
        $fromDate = $filter['fromDate'];
        $toDate = $filter['toDate'];
        $filterSelect = $filter['filterSelect'];
        $barangayNameFilter = $filter['barangayNameFilter'];
        $testCOVIDFilter = $filter['testCOVIDFilter'];
        $personCodeFilter = strtoupper($filter['personCodeFilter']);
        $personNameFilter = strtoupper($filter['personNameFilter']);

        $and = "";

        $brgy = (!$barangayNameFilter?"":" AND t1.barangay_id=$barangayNameFilter");
        if($filterSelect==1){
            $and = "AND TO_CHAR(t1.created_at :: DATE, 'yyyy-mm-dd') BETWEEN '$fromDate' AND '$toDate'";
        }if($filterSelect==2){
            if($testCOVIDFilter==""){
                $and = "AND t4.test_id IS NULL $brgy";
            }else{
                $and = "AND t4.test_id=$testCOVIDFilter $brgy";
            }
        }if($filterSelect==6){
            if($personCodeFilter==""){
                $and = "AND t3.testing_code IS NULL $brgy";
            }else{
                $and = "AND t3.testing_code LIKE '%$personCodeFilter%' $brgy";
            }
        }if($filterSelect==7){
            $and = "AND CONCAT(t1.fname,COALESCE(CONCAT(' ',t1.mname),''),' ',t1.lname,COALESCE(t1.extname,'')) LIKE '%$personNameFilter%' $brgy";
        }

        $cc=1;
        //$testingCode = $this->session->covid_tracker_testing_code;
        //foreach ($this->db->query("SELECT t1.barangay_id FROM tbl_user_barangay_district t1 WHERE t1.party_id=$district_id")->result() as $key => $value1) {
            //$brgyId = $value1->barangay_id;
            foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.date_arrival,t3.testing_code,t3.remarks,t3.office_id,t3.agency,t3.whereabouts,t3.category,t3.symptoms,t4.test_id,t4.result_id,t5.qstatus_id FROM tbl_person t1
                                       LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                       LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                       LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                       LEFT JOIN covid_qstatus_history t5 ON t1.id=t5.person_id
                                       WHERE t1.party_id BETWEEN 94 AND 95 $and
                                       ORDER BY t1.id DESC
                                       -- AND TO_CHAR(t1.created_at :: DATE, 'dd/mm/yyyy')='$dateN' AND t1.created_by=$user_id")->result() as $key => $value) {
                $id = $value->id;
                $fullName = $this->getFullName($value->id);
                // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
                //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
                //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
                //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
                $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
                // $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
                //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$this->getStatusCode($testingCode).'-'.$this->getTestCodeNum($value->testing_number)."</span>");
                $thisTestCode = (!$value->testing_code?"<center><a class='btn btn-xs bg-yellow' onclick='updateCode($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a></center>":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
                // $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus'></i>":$this->getStatusCode($value->test_id)."<br/>".$result)."</center></a></center>";
                $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center>".(!$value->test_id?"<i class='fa fa-plus'></i>":"<b style='font-size:17px;'>".$this->getStatusCode($value->test_id)."</b>")."</center></a></center>";
                $quarantine = "<center><a class='btn btn-xs bg-info bg-xs' onclick='updateQStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center>".(!$value->qstatus_id?"<i class='fa fa-plus'></i>":"<span class='badge bg-info'>".$this->getStatusName($value->qstatus_id)."</span>")."</center></a></center>";

                $data2 = [
                    "Pid" => $value->id,
                    "PidUpdate" => "UP",
                    "PCodeTemp" => $value->testing_code,
                    "personCode" => $value->testing_code,
                    "firstName" => $value->fname,
                    "middleName" => $value->mname,
                    "lastName" => $value->lname,
                    "gender" => $value->gender,
                    "personAge" => $value->age,
                    "personNumber" => $value->contact_num,
                    "barangayName" => $value->barangay_id,
                    "streetName" => $value->street,
                    "categoryCOVID" => $value->category,
                    "specifyAgency" => $value->agency,
                    "specifyOffice" => $value->office_id,
                    "travelHistory" => $value->travel_history,
                    "dateArrival" => $value->date_arrival,
                    "remarksCOVID" => $value->remarks,
                    "whereaboutsCOVID" => $value->whereabouts,
                ];
                $arr = json_encode($data2);

                $data["data"][] = [
                    // "<div class='text-center'><div class='custom-control custom-checkbox ml-1'><input class='custom-control-input' type='checkbox' id='checkMe".$id."' name='personNames[]' value='".$id."'><label for='checkMe".$id."' class='custom-control-label' style='cursor:pointer;'><a hidden>".$thisTestCode." | ".$fullName."</a></label></div></div>",
                    // "<a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>",
                    // $tree,
                    $cc++,
                    $thisTestCode,
                    "<span class='badge bg-gradient-gray-dark text-md' onclick='getDetails(\"form_save_dataPrimary\",$arr)' title='SELECT FOR UPDATE' style='cursor:pointer'>".$fullName."</span>".
                    " <span class='badge bg-".($value->gender==1?"blue":"pink")."'>".($value->gender==1?"MALE":"FEMALE")."</span>".
                    " <span class='badge bg-gray'>".$value->age." YO</span><br/>".
                    "<span class='badge badge bg-gradient-success mt-1'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id)).', '.$value->street."</span>",
                    //" <span class='badge bg-gradient-olive'>".$value->street."</span>",
                    // "<center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".$this->getStatusColor($value->status_id).";'><b>".$this->getStatusName($value->status_id)."</b></a></center>",
                    $test,
                    "<center><span class='badge bg-gray text-sm'>".(!$value->category?"":$this->getStatusName($value->category))."</span></center>",
                    // $quarantine,
                    "<center>".$value->contact_num."</center>",
                    // "<center><span class='badge bg-success text-sm'>".$this->getBarangayName($value->barangay_id)."</span></center>",
                    // "<center>".$value->street."</center>",
                    "<center>".$value->travel_history."<br/>".$value->date_arrival."</center>",
                    "<div style='text-align:center;font-size:10px;'>".(!$value->office_id?"":$this->myParty($value->office_id)).(!$value->agency?"":$value->agency)."</div>",
                    // "<center>".($value->gender==1?"MALE":"FEMALE")."</center>",
                    // "<center>".$value->age."</center>",
                    // "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                    "<center style='font-size:10px;'>".$value->remarks."</center>",
                    "<center style='font-size:10px;'>".$value->whereabouts."</center>",
                    // "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
                    "<center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>",
                    "<center style='font-size:12px;'>".(!$value->updated_by?"-":$this->getUserName($value->updated_by))."</center>",
                ];
            }

        //}
        echo json_encode($data);
    }

    function getPersonCovidExist(){
        $p_exist = $this->session->covid_tracker_person_exist;
        $dateN = Date('d/m/Y');
        $data = ["data" => []];
        $user_id = $this->session->covid_tracker_login_id;
        $district_id = $this->session->covid_tracker_login_district;
        //$testingCode = $this->session->covid_tracker_testing_code;
        foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.date_arrival,t3.testing_code,t3.remarks,t3.whereabouts,t3.symptoms,t4.test_id,t4.result_id,t5.qstatus_id FROM tbl_person t1
                                   LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                   LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                   LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                   LEFT JOIN covid_qstatus_history t5 ON t1.id=t5.person_id
                                   WHERE t1.id=$p_exist")->result() as $key => $value) {
            $id = $value->id;
            $fullName = $this->getFullName($value->id);
            // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
            //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
            //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
            //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
            $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
            $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
            //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$this->getStatusCode($value->testing_code).'-'.$this->getTestCodeNum($value->testing_number)."</span>");
            $thisTestCode = $value->testing_code;
            $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus'></i>":$this->getStatusCode($value->test_id)."<br/>".$result)."</center></a></center>";
            $quarantine = "<center><a class='btn btn-xs bg-info bg-xs' onclick='updateQStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center>".(!$value->qstatus_id?"<i class='fa fa-plus'></i>":"<span class='badge bg-info'>".$this->getStatusName($value->qstatus_id)."</span>")."</center></a></center>";

            $data["data"][] = [
                // "<div class='text-center'><div class='custom-control custom-checkbox ml-1'><input class='custom-control-input' type='checkbox' id='checkMe".$id."' name='personNames[]' value='".$id."'><label for='checkMe".$id."' class='custom-control-label' style='cursor:pointer;'><a hidden>".$thisTestCode." | ".$fullName."</a></label></div></div>",
                // "<a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>",
                // $tree,
                $thisTestCode,
                "<span class='badge bg-gradient-gray-dark text-md'>".$fullName."</span>".
                " <span class='badge bg-".($value->gender==1?"blue":"pink")."'>".($value->gender==1?"MALE":"FEMALE")."</span>".
                " <span class='badge bg-gray'>".$value->age." YO</span><br/>".
                "<span class='badge badge bg-gradient-success mt-1'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id)).', '.$value->street."</span>",
                //" <span class='badge bg-gradient-olive'>".$value->street."</span>",
                "<center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".$this->getStatusColor($value->status_id).";'><b>".$this->getStatusName($value->status_id)."</b></a></center>",
                $test,
                $quarantine,
                "<center>".$value->contact_num."</center>",
                "<center>".$value->contact_num."</center>",
                // "<center><span class='badge bg-success text-sm'>".$this->getBarangayName($value->barangay_id)."</span></center>",
                // "<center>".$value->street."</center>",
                "<center>".$value->travel_history."<br/>".$value->date_arrival."</center>",
                // "<center>".($value->gender==1?"MALE":"FEMALE")."</center>",
                // "<center>".$value->age."</center>",
                "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                "<center style='font-size:10px;'>".$value->remarks."</center>",
                "<center style='font-size:10px;'>".$value->whereabouts."</center>",
                "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
                "<center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>",
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidStatus(){
        $data = ["data" => []];
        $personId=$this->input->post("personId");
        $cc=1;
        $query = (!$personId?"":" WHERE t1.person_id=$personId ORDER BY t1.id DESC");
        foreach ($this->db->query("SELECT t1.*, to_char(t1.date_status, 'MON dd, YYYY') as date_status2 FROM tbl_covid_status_history t1 $query")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                $this->getStatusName($value->status_id),
                $value->date_status2,
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidTest(){
        $data = ["data" => []];
        $personId=$this->input->post("personId");
        $cc=1;
        $query = (!$personId?"":" WHERE t1.person_id=$personId ORDER BY t1.date_test DESC,t1.id DESC");
        foreach ($this->db->query("SELECT t1.*, to_char(t1.date_test, 'MON dd, YYYY') as date_test2 FROM tbl_covid_test_history t1 $query")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                (!$value->test_id?'-':$this->getStatusName($value->test_id)),
                // $this->getStatusName($value->result_id),
                // $value->date_test2,
                "<center style='white-space: nowrap;'>".(!$value->date_test2?'-':$value->date_test2)."</center>",
                $value->created_date,
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidQStatus(){
        $data = ["data" => []];
        $personId=$this->input->post("personId");
        $cc=1;
        $query = (!$personId?"":" WHERE t1.person_id=$personId ORDER BY t1.id DESC");
        foreach ($this->db->query("SELECT t1.*, to_char(t1.date_status, 'MON dd, YYYY') as date_status2 FROM tbl_covid_qstatus_history t1 $query")->result() as $key => $value) {
            $data["data"][] = [
                $cc++,
                $this->getStatusName($value->qstatus_id),
                $value->date_status2,
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
                $this->getCovid19Details1($value->primary),
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