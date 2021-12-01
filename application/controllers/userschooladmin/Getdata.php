<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') or exit('No direct script access allowed');

class Getdata extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    function getRegionList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->RegionList($filter, 1);
        echo json_encode($data);
    }

    function getProvinceList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->ProvinceList($filter, 1);
        echo json_encode($data);
    }

    function getCityMunList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->CityMunList($filter, 1);
        echo json_encode($data);
    }

    function getBarangayList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->BarangayList($filter);
        echo json_encode($data);
    }

    function getPurokList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PurokList($filter);
        echo json_encode($data);
    }

    function getGradeSubjectList()
    {
        $v = $this->input->post("v");
        $data = ["data" => []];
        $filter  = $v == '' || $v == null ? 0 : $v;
        $sy = $this->getOnLoad()["sy_id"];
        $thisQuery = $this->db->query("SELECT t1.*,t2.sbjct_cc FROM building_sectioning.view_subjectlist_grdlvl t1
                                        LEFT JOIN (
                                        SELECT t1.gradelvl_id,t1.subject_id, COUNT(1) sbjct_cc FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                        WHERE t1.schl_yr_id=$sy AND t1.schoolpersonnel_id IS NOT NULL
                                        GROUP BY t1.subject_id,t1.gradelvl_id) t2 ON t1.subject_id=t2.subject_id AND t1.gradelvl_id=t2.gradelvl_id
                                        WHERE t1.gradelvl_id=$filter AND t1.schl_yr_id=$sy");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "subject_id" => (int) $value->subject_id,
                "item" => $value->subject,
                "cc" => $value->sbjct_cc,
            ];
        }
        echo json_encode($data);
    }

    function getDepartmentList()
    {
        $school_id = $this->session->schoolmis_login_school_id;
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM profile.tbl_school_department t1
                                        WHERE t1.school_id=$school_id
                                        ORDER BY t1.department_name");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->department_name,
            ];
        }
        echo json_encode($data);
    }

    function getRoleList()
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM account.tbl_role t1
                                        WHERE t1.visible=1
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        echo json_encode($data);
    }

    function getPartyList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PartyList($filter);
        echo json_encode($data);
    }

    function getPartyTypeList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PartyTypeList($filter);
        echo json_encode($data);
    }

    function getStatusList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->StatusList($filter);
        echo json_encode($data);
    }

    function getPersonnelInfo()
    {
        $data = ["data" => []];
        // $thisQuery = $this->db->query("SELECT * FROM profile.view_schoolpersonnel ORDER BY schoolpersonnel_id DESC");
        $thisQuery = $this->db->query("SELECT t2.school_department_id,t1.* FROM profile.view_schoolpersonnel t1
                                       LEFT JOIN profile.tbl_schoolpersonnel t2 ON t1.schoolpersonnel_id=t2.id 
                                       ORDER BY t1.schoolpersonnel_id DESC");
        $cc = 1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->schoolpersonnel_id;
            if ($value->birthdate) {
                $birthDate = date_create($value->birthdate);
                $birthDate = strtoupper(date_format($birthDate, "M d, Y"));
            } else {
                $birthDate = "-";
            }
            $data1 = [
                "personId" => $value->person_id,
                "personnelId" => $id,
                "partyType" => $value->personalTitleId,
                "firstName" => $value->first_name,
                "middleName" => $value->middle_name,
                "lastName" => $value->last_name,
                "extName" => $value->suffix,
                // "sex" => $value->sex_bool == 't' ? 1 : 0,
                "sex" => $value->sex_bool,
                "birthdate" => $value->birthdate,
                "homeAddress" => $value->address_info,
                "cty" => $value->citymun_id,
                "brgy" => $value->barangay_id,
                "personName" => $value->full_name,
                "basicInfoId" => $value->person_id,
            ];
            $data2 = [
                "userId" => $value->user_id,
                "basicInfoId" => $value->person_id,
                "personnelId" => $id,
                "email" => $value->username,
                "role" => $value->role_id,
                "department" => $value->school_department_id,
            ];
            $arr1 = json_encode($data1);
            $arr2 = json_encode($data2);
            $data["data"][] = [
                $cc++,
                "<span class='badge'>" . $value->employee_type . "</span><br/>
                <span class='badge'>" . $value->status . "</span>",
                "<div class='row'><div class='col-6'>
                    <span class='badge text-md'>$value->full_name</span><span class='badge'>" . $value->personal_title . "</span><br/>
                    <span class='badge'>" . $value->address_details . "</span>,
                    <span class='badge font-weight-light'>" . $value->sex . "</span>, 
                    <span class='badge font-weight-light'>" . $birthDate . "</span>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <button class='dropdown-item' onclick='getDetails(\"PersonnelInfo\",$arr1,1);brgyLoad($value->barangay_id)'>Edit Information</button>
                        " . ($value->level ? "" :
                    "<button class='dropdown-item' onclick='clear_form(\"form_save_dataPersonnelAccount\");getDetails(\"PersonnelAccount\",$arr1,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Create User Account</button>") .
                    "</div>
                </div></div>",
                $value->level ?
                    "<div class='row'><div class='col-6'><span class='badge text-sm'>$value->username</span><br/>
                    <span class='badge'>" . $value->user_description . "</span><br/>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <button class='dropdown-item' onclick='clear_form(\"form_save_dataPersonnelAccount\");getDetails(\"PersonnelAccount\",$arr2,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Edit Account</button>
                    </div>
                </div></div>" : "-",
            ];
        }
        echo json_encode($data);
    }

    function getSubjectList()
    {
        $data = ["data" => []];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_party t1
                                        WHERE t1.group_by=11 ORDER BY t1.order_by ASC");

        foreach ($thisQuery->result() as $key => $value) {
            $dscrpt = $value->description;
            $active = $value->is_active == 't' ? true : false;
            $order = $value->order_by;
            $prtyindex = $value->party_index;
            $abbr = $value->abbr;
            $ppid = $value->parent_party_id;
            $data["data"][] = [
                $order . ".",
                "<b>" . $dscrpt . "</b>",
                $abbr
            ];
        }
        echo json_encode($data);
    }

    function getSbjctAssPrsnnl()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $lst = $this->SchoolPersonnelList(null);
        $grdlvl = (int)$this->input->post("grdlvl");
        $rmid = (int)$this->input->post("rmid");
        $data = ["data" => []];

        $thisQuery = $this->db->query("SELECT t1.* FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                        WHERE t1.gradelvl_id=$grdlvl AND t1.room_section_id=$rmid AND t1.schl_yr_id=$sy");

        foreach ($thisQuery->result() as $key => $value) {
            $sbjctid = $value->subject_id;
            $p_id = $value->schoolpersonnel_id;
            $sbjct_abbr = $value->subject_abbr;
            $sbjct = $value->subject;
            $fn = $value->full_name;
            $a = $value->advisory;
            $s = $a == 't' ? 'checked' : '';
            $opt = "<option value=''>SELECT</option>";
            for ($i = 0; $i < count($lst["data"]); $i++) {
                $id = $lst["data"][$i]["id"];
                $item = $lst["data"][$i]["item"];
                $slctd = $id === $p_id ? "selected" : "";
                $opt .= "<option value=" . $id . " " . $slctd . ">" . $item . "</option>";
            }
            $data["data"][] = [
                "<b>" . $sbjct_abbr . "</b> - <small><i>$sbjct</i></small><input type='text' value='" . $sbjctid . "' name='sbjct[]' hidden/>",
                "<div class='row'><div class='col-11'>" .
                    "<select class='form-control selectSbjctAssPrsnnl' name='schlpersonnel[]' type='select' style='width:100%;'>" .
                    $opt . "</select></div>" .
                    '<div class="col-1"><div class="custom-control custom-radio float-right mr-n3">
                    <input class="custom-control-input custom-radio" type="radio" value="' . $sbjctid . '" id="customRadio2' . $sbjctid . '" name="advisory" ' . $s . '>
                    <label for="customRadio2' . $sbjctid . '" class="custom-control-label" style="cursor:pointer;"></label>
                </div></div></div>',
            ];
        }
        echo json_encode($data);
    }

    function getGradeSecInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $data = ["data" => []];
        $data2 = [];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.* FROM building_sectioning.view_room_section t1
                                        WHERE t1.schl_yr_id=$sy");
        foreach ($thisQuery->result() as $key => $value) {
            // $stat = $value->isactive;
            $g = $value->grade;
            $gid = $value->grd_lvl_id;
            $rmsecid = $value->id;
            $s = $value->sctn_nm;
            $schd = $value->sched;
            $code = $value->code;

            $data2 = [
                "rmsecid" => $value->id,
            ];
            $arr = json_encode($data2);

            $data["data"][] = [
                $c++,
                "<div class='row'><div class='col-11'>
                    <span class='badge text-sm pb-0'>$g - $s</span>
                    <small>$code<i> - $schd</i></small>
                </div>
                <div class='col-1'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='#' onclick='getSbjctAssPrsnnlFN(\"SbjctAssPrsnnl\"," . $gid . "," . $rmsecid . ");getDetails(\"SbjctAssPrsnnl\",$arr);'>Subject Assignment</a>
                        <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",1)'>Edit Information</a>
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
    }

    function getSYInfo()
    {
        $data = ["data" => []];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_sy t1 ORDER BY t1.from DESC");
        foreach ($thisQuery->result() as $key => $value) {
            $stat = $value->is_active;
            $ebg = $value->enrollment_stat == 1 ? "bg-success" : "bg-gray";
            $gbg = $value->grading_stat == 1 ? "bg-success" : "bg-gray";

            $data1 = [
                "qrtrid" => $value->id,
                "quarter" => $value->qrtr,
                "enrollment" => $value->enrollment_stat,
                "enrolldl" => $value->enrollment_deadline,
                "grading" => $value->grading_stat,
                "gradingdl" => $value->grading_deadline,
            ];
            $arr1 = json_encode($data1);

            $data["data"][] = [
                $c++,
                "<span class='badge text-lg " . ($stat == "t" ? "bg-success" : "bg-gray") . "'>$value->description</span>",
                "<div class='row'><div class='col-9' style='white-space: nowrap;'>
                    <span class='badge text-lg bg-primary'>" . $this->getOnLoad()["qrtrR"] . "</span>
                    <span class='badge text-xs " . $ebg . " '>ENRLMNT" . $this->getOnLoad()["edl"] . "</span>
                    <span class='badge text-xs " . $gbg . "'>GRADING" . $this->getOnLoad()["gdl"] . "</span>
                </div>
                <div class='col-3'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <button class='dropdown-item' onclick='getDetails(\"QuarterInfo\",$arr1,1);$(\"#modalQuarterInfo\").modal(\"show\");'>Edit Quarter</button>
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
    }
}
