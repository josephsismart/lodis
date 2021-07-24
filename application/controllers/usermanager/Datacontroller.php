<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

class Datacontroller extends MY_Controller
{
    public function __construct(){
      parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    // function index(){
    //     $this->load->view('interface/usertestvalidator/Datacontroller');
    // }

    public function index()
        {       
            $page_data = $this->system();
            $uri = $this->session->schoolmis_login_uri;
            $page_data += [
                "page_title"        => "Datacontroller",
                "current_location"  => "datacontroller",
                "content"           =>  [$this->load->view('interface/'.$uri.'/Datacontroller', [
                                            // "getBarangay" => $this->getBarangayAssigned(),
                                            // "getStatus" => $this->getStatus(),
                                            //"accomplished"      => $this->get_accomplished(),
                                            //"useraccount"      => $this->get_useraccount(),
                                            //"pending"      => $this->get_pending(),
                                            //"documents"      => $this->get_documents(),
                                        ], TRUE)]
            ];
            $this->public_create_page($page_data);
    }
    
    function saveVariantCategory(){
        $this->db->trans_begin();
        $id = $this->input->post("typeId");
        $itemType = $this->input->post("itemType");
        $description = strtoupper($this->input->post("description"));
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();

        $data = [
            "itemGroupId" => $itemType,
            "itemTypeName" => $description,
            $id?"updated_by":"added_by" => $login_id,
            $id?"date_updated":"date_added" => $dateNow,
        ];

        if($id && $itemType && $description && $login_id){
            if(!$this->mainModel->update("tbl_itemtype",$data,"id",$id)){
                $this->userlog("UPDATED VARIANT/CATEGORY ".$itemType." DESCRIPTION ".$description);
                $ret = ["success"   => true,
                        "exist"   => false,
                        "existCode"   => false];
            }    
        }else if($itemType && $description && $login_id){
            if($this->db->insert("tbl_itemtype",$data)){
                $this->userlog("INSERTED VARIANT/CATEGORY ".$itemType." DESCRIPTION ".$description);
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

        echo json_encode($ret);
    }

    function saveMemberUser(){
        $this->db->trans_begin();
        $id = $this->input->post("personId");
        $partyType = $this->input->post("partyType");
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $extName = strtoupper($this->input->post("extName"));
        $sex = $this->input->post("sex");
        $homeAddress = strtoupper($this->input->post("homeAddress"));
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();

        $data = [
            "partyId" => $partyType,
            "firstName" => $firstName,
            "middleName" => $middleName,
            "lastName" => $lastName,
            "nameExt" => $extName,
            "sex" => $sex,
            "address" => $homeAddress,
            $id?"updated_by":"added_by" => $login_id,
            $id?"date_updated":"date_added" => $dateNow,
        ];
        if($id && $partyType && $firstName && $lastName && $homeAddress && $login_id){
            if(!$this->mainModel->update("tbl_person",$data,"id",$id)){
                $this->userlog("UPDATED MEMBER/USER PERSON ".$partyType." ".$firstName.$middleName.$lastName);
                $ret = ["success"   => true,
                        "exist"   => false,
                        "existCode"   => false];
            }    
        }else if($partyType && $firstName && $lastName && $homeAddress && $login_id){
            if($this->db->insert("tbl_person",$data)){
                $this->userlog("INSERTED MEMBER/USER PERSON ".$partyType." ".$firstName.$middleName.$lastName);
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

        echo json_encode($ret);
    }

    function getVariantCategory(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;

        $thisQuery=$this->db->query("SELECT * FROM view_itemtype");
        
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
         
            $data2 = [
                "typeId" => $value->id,
                "itemType" => $value->itemGroupId,
                "description" => $value->itemTypeName,
            ];
            $arr = json_encode($data2);
            $data["data"][] = [
                $cc++,
                "<span style='cursor:pointer' class='badge badge bg-gradient-success text-md' onclick='getDetails(\"VariantCategory\",$arr)'>$value->itemTypeName</span><br/>".
                "<span style='cursor:pointer' class='badge mt-1'>$value->description</span>",
            ];
        }
        echo json_encode($data);
    }

    function getMemberUser(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;

        $thisQuery=$this->db->query("SELECT * FROM view_person");
        
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
            $data2 = [
                "personId" => $id,
                "partyType" => $value->partyId,
                "firstName" => $value->firstName,
                "middleName" => $value->middleName,
                "lastName" => $value->lastName,
                "extName" => $value->nameExt,
                "sex" => $value->sex,
                "homeAddress" => $value->address,
            ];
            $arr = json_encode($data2);
            $data["data"][] = [
                $cc++,
                $value->description,
                "<span class='badge badge bg-gradient-navy text-md' onclick='getDetails(\"MemberUser\",$arr)' title='SELECT FOR UPDATE' style='cursor:pointer'>".$value->fullName."</span>".
                " <span class='badge bg-".($value->sex==1?"blue":"pink")."'>".($value->sex==1?"MALE":"FEMALE")."</span><br/>".
                "<span class='badge badge bg-gradient-success mt-1'>".$value->address."</span>",
            ];
        }
        echo json_encode($data);
    }
 
    function fetch(){
        $dateN = Date('d/m/Y');
        echo $dateN;
        $data = $this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.testing_code,t3.remarks,t3.symptoms,t4.test_id,t4.result_id FROM tbl_person t1
                                           LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                           LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                           LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                           WHERE t1.party_id BETWEEN 94 AND 95 AND TO_CHAR(t1.created_at :: DATE, 'dd/mm/yyyy')='$dateN'");

        $output = '
        <h3 align="center">Total Data - '.$data->num_rows().'</h3>
        <table id="tbl_person_covid19" style="width:100%;" class="table table-bordered table-hover table-data-checkbox">
        <thead>
            <tr>
                <th width="1"><div class="custom-control custom-checkbox ml-1">
                                    <input class="custom-control-input checkbox-toggle" type="checkbox" id="CheckAll">
                                    <label for="CheckAll" class="custom-control-label" style="cursor:pointer;"></label>
                                </div>
                </th>
                <th width="1"></th>
                <th width="1"><i class="fa fa-sitemap"></i></th>
                <th><i class="fa fa-qrcode"></i> Code</th>
                <th><i class="fa fa-user"></i> Name</th>
                <th width="1"><i class="fa fa-virus"></i> Status</th>
                <th width="1"><i class="fa fa-vial"></i> Test</th>
                <th width="1"><i class="fa fa-phone"></i></th>
                <th>Barangay/Address</th>
                <th>Street</th>
                <th><i class="fa fa-plane"></i> Travel History</th>
                <th width="1"><i class="fa fa-venus-mars"></i></th>
                <th width="1">Age</th>
                <th width="1"><i class="fas fa-head-side-cough"></i></th>
                <th width="1"><i class="fas fa-sticky-note"></i></th>
                <th width="1">Level</th>
                <th width="1">Encoded By</th>
            </tr>
        </thead>';
        foreach($data->result() as $key => $value){
            $id = $value->id;
            $fullName = $this->getFullName($value->id);
            // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
            //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
            //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
            //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
            $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
            $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
            //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            $thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus'></i>":$this->getStatusCode($value->test_id)."<br/>".$result)."</center></a></center>";

            $output .= "
                <tr>
                    <div class='text-center'><div class='custom-control custom-checkbox ml-1'><input class='custom-control-input' type='checkbox' id='checkMe".$id."' name='personNames[]' value='".$id."'><label for='checkMe".$id."' class='custom-control-label' style='cursor:pointer;'><a hidden>".$thisTestCode." | ".$fullName."</a></label></div></div>
                    <a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>
                    $tree
                    $thisTestCode
                    <span class='badge bg-gradient-gray-dark text-sm'>".$fullName."</span>
                    <center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".(!$value->status_id?"gray":$this->getStatusColor($value->status_id)).";'><b>".(!$value->status_id?"-":$this->getStatusName($value->status_id))."</b></a></center>
                    $test
                    <div style='text-align:center'>".$value->contact_num."</div>
                    <center><span class='badge bg-success text-sm'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id))."</span></center>
                    <div style='text-align:center'>".$value->street."</div>
                    <div style='text-align:center'>".$value->travel_history."</div>
                    <div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>
                    <div style='text-align:center'>".$value->age."</div>
                    <center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>
                    <center style='font-size:10px;'>".$value->remarks."</center>
                    <center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>
                    <center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>
                </tr>
                ";
        }
        $output .= '</table>';
        echo $output;
    }

    function getPersonCovid(){
        $dateN = Date('d/m/Y');
        $data = ["data" => []];
        $user_id = $this->session->schoolmis_login_id;
        $district_id = $this->session->schoolmis_login_district;
        foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.testing_code,t3.remarks,t3.symptoms,t4.test_id,t4.result_id FROM tbl_person t1
                                   LEFT JOIN covid_status_history t2 ON t1.id=t2.person_id
                                   LEFT JOIN tbl_covid_details t3 ON t1.id=t3.person_id
                                   LEFT JOIN covid_test_history t4 ON t1.id=t4.person_id
                                   WHERE t1.party_id BETWEEN 94 AND 95 AND TO_CHAR(t1.created_at :: DATE, 'dd/mm/yyyy')='$dateN'")->result() as $key => $value) {
            $id = $value->id;
            $fullName = $this->getFullName($value->id);
            // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
            //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
            //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
            //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
            $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
            $result = (!$value->test_id?"":"<span class='badge bg-".($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success")."'>".$this->getStatusName($value->result_id)."</span>");
            //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$this->getStatusCode($value->testing_code).'-'.$this->getTestCodeNum($value->testing_number)."</span>");
            $thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus'></i>":$this->getStatusCode($value->test_id)."<br/>".$result)."</center></a></center>";

            $data["data"][] = [
                "<div class='text-center'><div class='custom-control custom-checkbox ml-1'><input class='custom-control-input' type='checkbox' id='checkMe".$id."' name='personNames[]' value='".$id."'><label for='checkMe".$id."' class='custom-control-label' style='cursor:pointer;'><a hidden>".$thisTestCode." | ".$fullName."</a></label></div></div>",
                // "<a class='btn btn-success btn-xs text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus text-xs'></i></a>",
                $tree,
                $thisTestCode,
                "<span class='badge bg-gradient-gray-dark text-sm'>".$fullName."</span><br/>".
                "<span class='badge badge bg-gradient-success text-sm'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id))."</span>",
                "<center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".(!$value->status_id?"gray":$this->getStatusColor($value->status_id)).";'><b>".(!$value->status_id?"-":$this->getStatusName($value->status_id))."</b></a></center>",

                $test,
                "<div style='text-align:center'>".$value->contact_num."</div>",
                // "<center><span class='badge bg-success text-sm'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id))."</span></center>",
                "<div style='text-align:center'>".$value->street."</div>",
                "<div style='text-align:center'>".$value->travel_history."</div>",
                "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                "<div style='text-align:center'>".$value->age."</div>",
                "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                "<center style='font-size:10px;'>".$value->remarks."</center>",
                "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
                "<center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>",
            ];
        }
        echo json_encode($data);
    }

    function getPersonCovidExist(){
        $dateN = Date('d/m/Y');
        $data = ["data" => []];
        $user_id = $this->session->schoolmis_login_id;
        $district_id = $this->session->schoolmis_login_district;
        foreach ($this->db->query("SELECT t1.*,t2.status_id,t3.travel_history,t3.main_person_id,t3.testing_code,t3.remarks,t3.symptoms,t4.test_id,t4.result_id FROM existing.tbl_person t1
                                   LEFT JOIN covid_status_history_exist t2 ON t1.id=t2.person_id
                                   LEFT JOIN existing.tbl_covid_details t3 ON t1.id=t3.person_id
                                   LEFT JOIN covid_test_history_exist t4 ON t1.id=t4.person_id
                                   WHERE t1.party_id BETWEEN 94 AND 95 AND t3.is_display=1")->result() as $key => $value) {
            $id = $value->id;
            $mId = $value->main_person_id;
            $fullName = $this->getFullName2($value->id);
            // $tree = $this->hasContact($id)>0?"<div style='white-space: nowrap;'>".
            //                                  "<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>".
            //                                  "<span class='badge bg-danger' onclick='myContact($id)' style='cursor:pointer;position:absolute;margin-left:-5px;'>".$this->hasContact($id)."</span></div>"
            //                                 :"<a class='btn btn-success btn-xs ml-2 text-white' onclick='addContact($id,\"$fullName\")' style='cursor:pointer;'><i class='fa fa-plus'></i></a>";
            $tree = $this->hasContact($id)>0?"<center><span class='badge bg-danger text-md' onclick='myContact($id)' style='cursor:pointer'>".$this->hasContact($id)."</span></center>":"";
            $result = (!$value->test_id?"":"<span class='badge bg-".(!$value->result_id?"dark":($this->getStatusName($value->result_id)=='POSITIVE'?"danger":"success"))."'>".(!$value->result_id?"NO RESULT":$this->getStatusName($value->result_id))."</span>");
            $thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            //$thisTestCode = (!$value->testing_code?"":"<span class='badge bg-gray text-sm'>".$value->testing_code."</span>");
            $test = "<center><a class='btn btn-xs bg-yellow' onclick='updateTest($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;'><center style='font-size:12px;'>".(!$value->test_id?"<i class='fa fa-plus'></i>":$this->getStatusCode($value->test_id)."<br/>".$result)."</center></a></center>";
                
            $data["data"][] = [
                "<div class='text-center'><div class='custom-control custom-checkbox ml-1'><input class='custom-control-input' type='checkbox' id='checkMe".$id."' name='personNames[]' value='".$mId."'><label for='checkMe".$id."' class='custom-control-label' style='cursor:pointer;'><a hidden>".$thisTestCode." | ".$fullName."</a></label></div></div>",
                $thisTestCode,
                "<span class='badge bg-gradient-gray-dark text-sm'>".$fullName."</span></br>".
                "<span class='badge bg-gradient-success text-sm'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id))."</span>",

                "<center><a class='btn btn-xs text-white' onclick='updateStatus($id,\"$fullName\")' style='cursor:pointer;white-space:nowrap;font-size:12px;background-color:".(!$value->status_id?"black":$this->getStatusColor($value->status_id)).";'><b>".(!$value->status_id?"NO DATA":$this->getStatusName($value->status_id))."</b></a></center>",
                $test,
                "<div style='text-align:center'>".$value->contact_num."</div>",
                // "<center><span class='badge bg-success text-sm'>".(!$value->barangay_id?"":$this->getBarangayName($value->barangay_id))."</span></center>",
                "<div style='text-align:center'>".$value->street."</div>",
                "<div style='text-align:center'>".$value->travel_history."</div>",
                "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                "<div style='text-align:center'>".$value->age."</div>",
                "<center style='font-size:10px;'>".(!$value->symptoms?"":$this->getStatusName($value->symptoms))."</center>",
                "<center style='font-size:10px;'>".$value->remarks."</center>",
                "<center style='font-size:12px;'>".$this->myParty($value->party_id)."</center>",
                "<center style='font-size:12px;'>".$this->getUserName($value->created_by)."</center>",
            ];
        }
        echo json_encode($data);
    }

    function import(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->schoolmis_login_id;
        $tmpId = "";
        $nLast="";
        if(isset($_FILES["file"]["name"])){
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $nRow = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $nLast = $nRow;
                    $code = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $fname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $mname = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $lname = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $gender = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $age = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $contactN = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $address = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $street = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    
                    $datestat = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $status = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $contactT = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $relation = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $tHistory = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $tArrival = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $symptoms = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $remarks = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                    $wAbouts = $worksheet->getCellByColumnAndRow(18, $row)->getValue();

                    $resultRDT = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    $tDateRDT = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                    $symptomsRDT = $worksheet->getCellByColumnAndRow(21, $row)->getValue();

                    $resultPCR = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    $tDatePCR = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    $symptomsPCR = $worksheet->getCellByColumnAndRow(24, $row)->getValue();

                    $category = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    $agency = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                    $lguOffice = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                    $qstatus = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                    $qdate = $worksheet->getCellByColumnAndRow(29, $row)->getValue();

                    $created_date_time = $worksheet->getCellByColumnAndRow(30, $row)->getValue();

                    $dateArrival = (!$tArrival?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tArrival)));
                    $dateStatus = (!$datestat?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($datestat)));
                    $dateTestRDT = (!$tDateRDT?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tDateRDT)));
                    $dateTestPCR = (!$tDatePCR?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tDatePCR)));
                    $dateQuarantine = (!$qdate?NULL:date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($qdate)));
                    $dateTimeCreate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($created_date_time));

                    if(!$mname){
                        $exist = $this->db->query("SELECT id FROM tbl_person WHERE fname='$fname' AND lname='$lname' AND party_id BETWEEN 94 AND 95");
                    }else{
                        $exist = $this->db->query("SELECT id FROM tbl_person WHERE fname='$fname' AND mname='$mname' AND lname='$lname' AND party_id BETWEEN 94 AND 95");
                    }
                    $thisExisted = $exist->row("id");
                    if(!$thisExisted){
                        $existCode = $this->db->query("SELECT t1.id FROM tbl_person t1
                                                       LEFT JOIN tbl_covid_details t2 ON t1.id=t2.person_id
                                                       WHERE t2.testing_code='$contactT' LIMIT 1");
                        $personCode = $existCode->row("id");
                        $data = [
                            "party_id" => (!$personCode?94:95),
                            "fname" => $fname,
                            "mname" => $mname,
                            "lname" => $lname,
                            "gender" => ($gender=='M'?1:0),
                            "age" => $age,
                            "contact_num" => $contactN,
                            "created_at" => $dateNow,
                            "created_by" => $login_id,
                            "barangay_id" => ($this->getBarangayParty($address)!=""?$this->getBarangayParty($address):106),
                            "street" => $this->returnNull(($this->getBarangayParty($address)!=""?$street:$address)),
                        ];
                        // if($contactT=='CONTACT'){
                        //     $primaryId = $tmpId;
                        // }
                        if($this->db->insert("tbl_person",$data)){
                            $thisPerson = $this->db->insert_id();
                            $data2 = [
                                "person_id" => $thisPerson,
                                "created_date" => $dateNow,
                                "created_by" => $login_id,
                                //"symptoms" => $this->getStatusId($symptoms),
                                "remarks" => $remarks,
                                "travel_history" => $tHistory,
                                //"testing_code" => $this->getStatusIdCode($code),
                                "testing_code" => $code,//$this->getTestCodeMaxNumSaveImport($code),
                                "date_arrival" => $this->returnNull($dateArrival),
                                "whereabouts" => $this->returnNull($wAbouts),
                                "category" => $this->getStatusId($category),
                                "office_id" => $this->returnNull($this->getBarangayParty($lguOffice)),
                                "agency" => $this->returnNull($agency),

                            ];
                            
                            if($this->db->insert("tbl_covid_details",$data2)){
                                $this->userlog("INSERTED PERSON ".$thisPerson);
                                
                                if($status!="" || $dateStatus!=""){
                                    $data3 = [
                                        "person_id" => $thisPerson,
                                        "status_id" => $this->getStatusId($status),
                                        "date_status" => $dateStatus,
                                        "created_date" => $dateNow,
                                        "created_by" => $login_id,
                                    ];

                                    $this->db->insert("tbl_covid_status_history",$data3);
                                    $this->userlog("INSERTED COVID STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                                }

                                if($qstatus!=""){
                                    $data33 = [
                                        "person_id" => $thisPerson,
                                        "qstatus_id" => $this->getStatusId($qstatus),
                                        "date_status" => $dateQuarantine,
                                        "created_date" => $dateNow,
                                        "created_by" => $login_id,
                                    ];
                                    $this->db->insert("tbl_covid_qstatus_history",$data33);
                                    $this->userlog("INSERTED COVID QUARANTINE STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                                }

                                if($resultRDT!=""){
                                    $data4 = [
                                        "person_id"  =>  $thisPerson,
                                        "test_id"  =>  27,
                                        "date_test"  =>  $dateTestRDT,
                                        "created_date" =>  $dateNow,
                                        "created_by" =>  $login_id,
                                        "is_active"  =>  1,
                                        "result_id"  =>  $this->getStatusId($resultRDT),
                                        "symptoms"  =>  $this->getStatusId($symptomsRDT),
                                    ];
                                    $this->db->insert("tbl_covid_test_history",$data4);
                                    $this->userlog("ADDED TEST RDT AND RESULT ".$this->getStatusId($resultRDT)." OF PERSON ".$thisPerson." BY USER ".$login_id);
                                }

                                if($resultPCR!=""){
                                    $data2 = [
                                        "is_active" => 0,
                                    ];
                                    $this->mainModel->update("tbl_covid_test_history",$data2,"person_id",$thisPerson);
                                    $data4 = [
                                        "person_id"  =>  $thisPerson,
                                        "test_id"  =>  28,
                                        "date_test"  =>  $dateTestPCR,
                                        "created_date" =>  $dateNow,
                                        "created_by" =>  $login_id,
                                        "is_active"  =>  1,
                                        "result_id"  =>  $this->getStatusId($resultPCR),
                                        "symptoms"  =>  $this->getStatusId($symptomsPCR),
                                    ];
                                    $this->db->insert("tbl_covid_test_history",$data4);
                                    $this->userlog("ADDED TEST PCR AND RESULT ".$this->getStatusId($resultPCR)." OF PERSON ".$thisPerson." BY USER ".$login_id);
                                }
                                
                                if($personCode!=""){
                                    $data6 = [
                                        "primary" => $personCode,
                                        "contact" => $thisPerson,
                                        "relation" => $this->getStatusId($relation),
                                    ];
                                    $this->db->insert("tbl_contact_trace",$data6);
                                    $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$personCode." TO PERSON ".$thisPerson);
                                }
                                    
                                $ret = ["success"   => true];
                            }
                        }else{
                            $ret = ["success"   => false];
                        }
                    }else{
                        $existCode = $this->db->query("SELECT t1.id FROM existing.tbl_person t1
                                                       LEFT JOIN existing.tbl_covid_details t2 ON t1.id=t2.person_id
                                                       WHERE t2.testing_code='$contactT' LIMIT 1");
                        $personCode = $existCode->row("id");
                        $data = [
                            "party_id" => (!$personCode?94:95),
                            "fname" => $fname,
                            "mname" => $mname,
                            "lname" => $lname,
                            "gender" => ($gender=='M'?1:0),
                            "age" => $age,
                            "contact_num" => $contactN,
                            "created_at" => $dateNow,
                            "created_by" => $login_id,
                            "barangay_id" => ($this->getBarangayParty($address)!=""?$this->getBarangayParty($address):106),
                            "street" => $this->returnNull(($this->getBarangayParty($address)!=""?$street:$address)),
                        ];
                        // if($contactT=='CONTACT'){
                        //     $primaryId = $tmpId;
                        // }
                        if($this->db->insert("existing.tbl_person",$data)){
                            $thisPerson = $this->db->insert_id();
                            $data2 = [
                                "person_id" => $thisPerson,
                                "created_date" => $dateNow,
                                "created_by" => $login_id,
                                //"symptoms" => $this->getStatusId($symptoms),
                                "remarks" => $remarks,
                                "travel_history" => $tHistory,
                                //"testing_code" => $this->getStatusIdCode($code),
                                "testing_code" => $code,//$this->getTestCodeMaxNumSaveImport($code),
                                "date_arrival" => $this->returnNull($dateArrival),
                                "whereabouts" => $this->returnNull($wAbouts),
                                "category" => $this->getStatusId($category),
                                "office_id" => $this->returnNull($this->getBarangayParty($lguOffice)),
                                "agency" => $this->returnNull($agency),
                                "is_display" => 1,
                                "main_person_id" => $thisExisted,

                            ];
                            
                            if($this->db->insert("existing.tbl_covid_details",$data2)){
                                $this->userlog("INSERTED PERSON ".$thisPerson);
                                
                                if($status!="" || $dateStatus!=""){
                                    $data3 = [
                                        "person_id" => $thisPerson,
                                        "status_id" => $this->getStatusId($status),
                                        "date_status" => $dateStatus,
                                        "created_date" => $dateNow,
                                        "created_by" => $login_id,
                                    ];

                                    $this->db->insert("existing.tbl_covid_status_history",$data3);
                                    $this->userlog("INSERTED COVID STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                                }

                                if($qstatus!=""){
                                    $data33 = [
                                        "person_id" => $thisPerson,
                                        "qstatus_id" => $this->getStatusId($qstatus),
                                        "date_status" => $dateQuarantine,
                                        "created_date" => $dateNow,
                                        "created_by" => $login_id,
                                    ];
                                    $this->db->insert("existing.tbl_covid_qstatus_history",$data33);
                                    $this->userlog("INSERTED COVID QUARANTINE STATUS ".$this->db->insert_id()." TO PERSON ".$thisPerson);
                                }

                                if($resultRDT!=""){
                                    $data4 = [
                                        "person_id"  =>  $thisPerson,
                                        "test_id"  =>  27,
                                        "date_test"  =>  $dateTestRDT,
                                        "created_date" =>  $dateNow,
                                        "created_by" =>  $login_id,
                                        "is_active"  =>  1,
                                        "result_id"  =>  $this->getStatusId($resultRDT),
                                        "symptoms"  =>  $this->getStatusId($symptomsRDT),
                                    ];
                                    $this->db->insert("existing.tbl_covid_test_history",$data4);
                                    $this->userlog("ADDED TEST RDT AND RESULT ".$this->getStatusId($resultRDT)." OF PERSON ".$thisPerson." BY USER ".$login_id);
                                }

                                if($resultPCR!=""){
                                    $data2 = [
                                        "is_active" => 0,
                                    ];
                                    $this->mainModel->update("tbl_covid_test_history",$data2,"person_id",$thisPerson);
                                    $data4 = [
                                        "person_id"  =>  $thisPerson,
                                        "test_id"  =>  28,
                                        "date_test"  =>  $dateTestPCR,
                                        "created_date" =>  $dateNow,
                                        "created_by" =>  $login_id,
                                        "is_active"  =>  1,
                                        "result_id"  =>  $this->getStatusId($resultPCR),
                                        "symptoms"  =>  $this->getStatusId($symptomsPCR),
                                    ];
                                    $this->db->insert("existing.tbl_covid_test_history",$data4);
                                    $this->userlog("ADDED TEST PCR AND RESULT ".$this->getStatusId($resultPCR)." OF PERSON ".$thisPerson." BY USER ".$login_id);
                                }
                                
                                if($personCode!=""){
                                    $data6 = [
                                        "primary" => $personCode,
                                        "contact" => $thisPerson,
                                        "relation" => $this->getStatusId($relation),
                                    ];
                                    $this->db->insert("existing.tbl_contact_trace",$data6);
                                    $this->userlog("INSERTED COVID TRACE CONTACT FROM ".$personCode." TO PERSON ".$thisPerson);
                                }
                                $ret = ["success"   => true];
                            }
                        }else{
                            $ret = ["success"   => false];
                        }
                    }
                    if($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                    }
                    else {
                        $this->db->trans_commit();
                    }
                }
            }
            // $this->excel_import_model->insert($data);
            // $this->db->insert_batch('tbl_customer', $data);
            //echo 'Data Imported successfully';
            //echo json_encode($existData);
        }

        //echo json_encode($ret);
    }


    function batch_append(){
        $dateNow = $this->now();
        $personNames = $this->input->post("personNames");
        $user_id = $this->session->schoolmis_login_id;
        $this->db->trans_begin();
        foreach ($personNames as $key => $value){
            $qpid = $this->db->query("SELECT person_id FROM existing.tbl_covid_details WHERE main_person_id=$value AND is_display=1 LIMIT 1");
            $personId = $qpid->row("person_id");

            $qtst = $this->db->query("SELECT person_id FROM tbl_covid_test_history WHERE person_id=$value");
            $qstt = $this->db->query("SELECT person_id FROM tbl_covid_status_history WHERE person_id=$value");
            
            foreach ($this->db->query("SELECT * FROM existing.tbl_covid_test_history WHERE person_id=$personId ORDER BY id")->result() as $key => $tst){
                $dataTest = [
                    "person_id" => $value,
                    "test_id"  =>  $tst->test_id,
                    "date_test"  =>  $tst->date_test,
                    "created_date"  =>  $dateNow,
                    "created_by"  =>  $user_id,
                    "is_active"  =>  (!$qtst->row("person_id")?1:0),
                    "result_id" => $tst->result_id,
                    "symptoms"  =>  $tst->symptoms,
                ];

                if($qtst->row("person_id")!=""){
                    if($this->db->query("UPDATE tbl_covid_test_history SET is_active=0 WHERE person_id=$value")){
                        if($this->db->insert("tbl_covid_test_history",$dataTest)){
                            if($this->db->query("UPDATE tbl_covid_test_history SET is_active=1
                                                        FROM(SELECT id FROM tbl_covid_test_history WHERE person_id=$value ORDER BY date_test DESC,id DESC LIMIT 1) AS squery
                                                 WHERE tbl_covid_test_history.id=squery.id")){
                                $this->userlog("INSERTED NEW TEST FOR PERSON ".$value." RESULT ".$tst->result_id);
                            }
                        }
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }else{
                    if($this->db->insert("tbl_covid_test_history",$dataTest)){
                        $this->userlog("INSERTED NEW TEST FOR PERSON ".$value." RESULT ".$tst->result_id);
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }
            }



            $stt = $this->db->query("SELECT * FROM existing.tbl_covid_status_history WHERE person_id=$personId ORDER BY id");

            if($stt->row("status_id")!=""){
                $dataStat = [
                    "person_id" => $value,
                    "status_id" => $stt->row("status_id"),
                    "date_status" => $stt->row("date_status"),
                    "created_date" => $dateNow,
                    "created_by" => $user_id,
                    "is_active" => (!$qstt->row("person_id")?1:0),
                ];
                
                if($qtst->row("person_id")!=""){
                    if($this->db->query("UPDATE tbl_covid_status_history SET is_active=0 WHERE person_id=$value")){
                        if($this->db->insert("tbl_covid_status_history",$dataStat)){
                            if($this->db->query("UPDATE tbl_covid_status_history SET is_active=1
                                                        FROM(SELECT id FROM tbl_covid_status_history WHERE person_id=$value ORDER BY date_status DESC,id DESC LIMIT 1) AS squery
                                                 WHERE tbl_covid_status_history.id=squery.id")){
                                $this->userlog("INSERTED NEW STATUS FOR PERSON ".$value." RESULT ".$stt->row("status_id"));
                            }
                        }
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }else{
                    if($this->db->insert("tbl_covid_status_history",$dataStat)){
                        $this->userlog("INSERTED NEW STATUS FOR PERSON ".$value." RESULT ".$stt->row("status_id"));
                        $ret = ["success"   => true];
                    }else{
                        $ret = ["success"   => false];
                    }
                }
            }
            
            $data4 = [
                "is_display" => 2,
            ];

            $this->mainModel->update("existing.tbl_covid_details",$data4,"person_id",$personId);
        }

        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        }
        else {
            $this->db->trans_commit();
        }
        echo json_encode($ret);
    }

    function batch_remove(){
        $dateNow = $this->now();
        $personNames = $this->input->post("personNames");
        $user_id = $this->session->schoolmis_login_id;
        $this->db->trans_begin();
        foreach ($personNames as $key => $value){
            $qpid = $this->db->query("SELECT person_id FROM existing.tbl_covid_details WHERE main_person_id=$value AND is_display=1 LIMIT 1");
            $personId = $qpid->row("person_id");

            $data = [
                "is_display" => 3,                
            ];

            if(!$this->mainModel->update("existing.tbl_covid_details",$data,"person_id",$personId)){
                $this->userlog("REMOVED EXISTED DATA OF PERSON ".$personId." BY USER ".$user_id);
                $ret = ["success"   => true];
            }else{
                $ret = ["success"   => false];
            }
        }

        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        }
        else {
            $this->db->trans_commit();
        }
        echo json_encode($ret);
    }
}

?>