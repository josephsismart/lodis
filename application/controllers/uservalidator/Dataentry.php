<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataentry extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->redirect();
    }

    public function index()
    {       
        $page_data = $this->system();
        $page_data += [
            "page_title"        => "Dataentry",
            "current_location"  => "dataentry",
            "content"           =>  [$this->load->view('interface/uservalidator/Dataentry', [
                                        "getBarangay" => $this->getBarangay(),
                                        //"accomplished"      => $this->get_accomplished(),
                                        //"useraccount"      => $this->get_useraccount(),
                                        //"pending"      => $this->get_pending(),
                                        //"documents"      => $this->get_documents(),
                                    ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function savelocal(){
        $this->db->trans_begin();
        $dateNow = $this->now();
        $login_id = $this->session->covid_tracker_login_id;
        $partyId = $this->input->post("dataBarangay");
        $localDate = $this->input->post("localDate");
        $dataGender = $this->input->post("dataGender");
        $dataAge = $this->input->post("dataAge");
        $dataCount = $this->input->post("dataCount");
        $dataStatus = $this->input->post("dataStatus");
        if(!$localDate||!$partyId[0]||!$dataGender[0]||!$dataCount[0]||!$dataStatus[0]){
            $ret = ["success"   => false];
        }else{
            foreach ($this->input->post("dataBarangay") as $key => $value2){
            $data[] = [
                "report_num" => $dataCount[$key],
                "party_id" => $value2,
                "reported_date" => $localDate,
                "status_id" => $dataStatus[$key],
                "age" => $dataAge[$key],
                "gender" => $dataGender[$key],
                "created_at" => $dateNow,
                "created_by" => $login_id,
            ];
            }
            if($this->db->insert_batch("tbl_report",$data)){
                $this->userlog("INSERTED REPORT #".$this->db->insert_id());
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

    function getlocal(){
        $data = ["data" => []];
        foreach ($this->db->get("tbl_report")->result() as $key => $value) {
            $data["data"][] = [
                $value->reported_date,
                $this->getBarangayName($value->party_id),
                $this->getStatusName($value->status_id),
                "<div style='text-align:center'>".($value->gender==1?"MALE":"FEMALE")."</div>",
                "<div style='text-align:center'>".$value->age."</div>",
                "<div style='text-align:right'>".number_format($value->report_num)."</div>",
                "<div style='text-align:center'>".($value->is_post==1?"POSTED":"PENDING")."</div>",
            ];
        }
        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */