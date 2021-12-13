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

    // function getPersonnelInfo()
    // {
    //     $data = ["data" => []];
    //     $thisQuery = $this->db->query("SELECT * FROM profile.view_schoolpersonnel");
    //     $cc = 1;
    //     foreach ($thisQuery->result() as $key => $value) {
    //         $id = $value->schoolpersonnel_id;
    //         $birthDate = date_create($value->birthDate);
    //         $birthDate = strtoupper(date_format($birthDate, "M d, Y"));
    //         $data2 = [
    //             "personId" => $id,
    //             "partyType" => $value->personalTitleId,
    //             "firstName" => $value->first_name,
    //             "middleName" => $value->middle_name,
    //             "lastName" => $value->last_name,
    //             "extName" => $value->suffix,
    //             "sex" => $value->sex_bool,
    //             "homeAddress" => $value->address_details,
    //         ];
    //         $arr = json_encode($data2);
    //         $data["data"][] = [
    //             $cc++,
    //             "<span class='badge'>" . $value->employee_type . "</span><br/>
    //             <span class='badge'>" . $value->status . "</span>",
    //             "<div class='row'><div class='col-6'>
    //                 <span class='badge text-md'>$value->full_name</span><span class='badge'>" . $value->personal_title . "</span><br/>
    //                 <span class='badge'>" . $value->address_details . "</span>,
    //                 <span class='badge font-weight-light'>" . $value->sex . "</span>, 
    //                 <span class='badge font-weight-light'>" . $birthDate . "</span>
    //             </div>
    //             <div class='col-6'>
    //                 <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
    //                     <span class='fa fa-ellipsis-h'></span>
    //                 </button>
    //                 <div class='dropdown-menu'>
    //                     <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",$arr,1)'>Edit Information</a>
    //                     " . ($value->level ? "" :
    //                 "<a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",$arr,1)'>Create Account</a>") .
    //                 "</div>
    //             </div></div>",
    //             $value->level ?
    //                 "<div class='row'><div class='col-6'><span class='badge text-sm'>$value->username</span><br/>
    //                 <span class='badge'>" . $value->user_description . "</span><br/>
    //             </div>
    //             <div class='col-6'>
    //                 <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
    //                     <span class='fa fa-ellipsis-h'></span>
    //                 </button>
    //                 <div class='dropdown-menu'>
    //                     <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",$arr,1)'>Edit Account</a>
    //                 </div>
    //             </div></div>" : "-",
    //         ];
    //     }
    //     echo json_encode($data);
    // }

    // function getSbjctAssPrsnnl()
    // {
    //     $sy = $this->getOnLoad()["sy_id"];
    //     $lst = $this->SchoolPersonnelList(null);
    //     $grdlvl = (int)$this->input->post("grdlvl");
    //     $rmid = (int)$this->input->post("rmid");
    //     $data = ["data" => []];

    //     $thisQuery = $this->db->query("SELECT t1.* FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
    //                                     WHERE t1.gradelvl_id=$grdlvl AND t1.room_section_id=$rmid AND t1.schl_yr_id=$sy");
    //     foreach ($thisQuery->result() as $key => $value) {
    //         $sbjctid = $value->subject_id;
    //         $p_id = $value->schoolpersonnel_id;
    //         $sbjct = $value->subject;
    //         $fn = $value->full_name;
    //         $a = $value->advisory;
    //         $s = $a == 't' ? 'checked' : '';
    //         $opt = "<option value=''>SELECT</option>";
    //         for ($i = 0; $i < count($lst["data"]); $i++) {
    //             $id = $lst["data"][$i]["id"];
    //             $item = $lst["data"][$i]["item"];
    //             $slctd = $id === $p_id ? "selected" : "";
    //             $opt .= "<option value=" . $id . " " . $slctd . ">" . $item . "</option>";
    //         }
    //         $data["data"][] = [
    //             "<b>" . $sbjct . "</b><input value='" . $sbjctid . "' name='sbjct[]' hidden/>",
    //             "<div class='row'><div class='col-12'>" .
    //                 "<select class='form-control selectSbjctAssPrsnnl' name='schlpersonnel[]' type='select' style='width:100%;'>" .
    //                 $opt . "</select></div>" .
    //                 '<div class="col-1"><div class="custom-control custom-radio float-right mr-n3">
    //                 <input class="custom-control-input custom-radio" type="radio" value="' . $sbjctid . '" id="customRadio2' . $sbjctid . '" name="advisory" ' . $s . '>
    //                 <label for="customRadio2' . $sbjctid . '" class="custom-control-label" style="cursor:pointer;"></label>
    //             </div></div></div>',
    //         ];
    //     }
    //     echo json_encode($data);
    // }

    function getAssignedSectionList()
    {
        $data = ["data" => []];
        $data2 = [];
        $c = 1;
        $personnel_id = $this->session->schoolmis_login_prsnnl_Id;
        $sy = $this->getOnLoad()["sy_id"];
        $enroll_stat = $this->getOnLoad()["enroll_stat"];
        $grade_stat = $this->getOnLoad()["grade_stat"];
        $query = $this->db->query("SELECT t1.* FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                   WHERE t1.schoolpersonnel_id=$personnel_id AND t1.schl_yr_id=$sy ORDER BY t1.advisory DESC");

        foreach ($query->result() as $key => $value) {
            $rmid = $value->room_section_id;
            $query1 = $this->db->query("SELECT t1.*,t2.male,t2.female,t2.total_enrollee FROM building_sectioning.view_room_section t1
                                        LEFT JOIN (SELECT t1.room_section_id,t1.schl_yr_id, SUM(CASE WHEN t1.sex_bool='t' THEN 1 ELSE 0 END) AS male,
                                        SUM(CASE WHEN t1.sex_bool='f' THEN 1 ELSE 0 END) AS female, SUM(1) AS total_enrollee
                                        FROM building_sectioning.view_enrollment$sy t1
										GROUP by t1.room_section_id,t1.schl_yr_id) t2 ON t1.id=t2.room_section_id
                                        AND t1.schl_yr_id=t2.schl_yr_id
                                        WHERE t1.id = $rmid");
            $qrow = $query1->row();
            $rssaid = $value->rm_sctn_sbjct_assgnmnt_id;
            $g = $value->grade;
            $sched = $value->schedule;
            $subject = $value->subject_abbr;
            $s = $value->sctn_nm;
            $advsry = $value->advisory;
            $male = number_format($qrow->male) ?? "-";
            $female = number_format($qrow->female) ?? "-";
            $t_enrollee = number_format($qrow->total_enrollee) ?? "-";
            $data2 = [
                "personnel" => $qrow->full_name . " - " . $qrow->personal_title,
                "description" => "Class Advisory <b>" . $qrow->grade . " - " . $qrow->sctn_nm . "</b><small> <i>" . $qrow->subject . "</i> | <i>" . $qrow->sched . "</i></small>",
                "male" => $male,
                "female" => $female,
                "total_enrollee" => $t_enrollee,
                "enroll" => ($advsry == 't' && $enroll_stat == 1) ? '<button type="submit" data-toggle="modal" data-target="#modalEnrollment" class="btn btn-xs btn-success float-right">Enroll</button>' : '',
                "grade" => ($grade_stat == 1) ? '<button type="submit" onclick="getGradesListFN()" data-toggle="modal" data-target="#modalGrades" class="btn btn-xs btn-primary float-right ml-1">Grades</button>' : '',
                "grade_all" => ($advsry == 't') ? '<button onclick="customTabViewAllGrades()" data-toggle="modal" data-target="#modalAllGrades" class="btn btn-xs btn-info float-right ml-1">View All Grades</button>' : '',
                "others" => ($advsry == 't') ? '<button type="button" class="btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0 ml-1" data-toggle="dropdown" aria-expanded="true">
                                                    <span class="fa fa-ellipsis-h"></span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="logsHideShow()">Logs & Account Settings</a>
                                                    <a class="dropdown-item" href="#" onclick="allStudentLogs()">View All Student Logs</a>
                                                </div>' : '',
            ];
            $arr = json_encode($data2);
            $slct = ($advsry === 't' && $key === array_key_first($query->result()) ? 'slctdRadioAdvisory' : '');
            $data["data"][] = [
                "<div class='row' style='white-space: nowrap;'><div class='col-12 " . ($advsry === 't' ? 'text-success' : '') . "'>
                <input type='radio' id='slctRmRadio" . $rmid . $rssaid . "' class='" . $slct . "' name='slctRm' value='" . $rmid . "' onclick='getLearnersListFN(\"LearnersList\"," . $rmid . "," . $rssaid . ",\"" . $advsry . "\");getDetails(\"PersonnelInfo\",$arr,1,\".\");'/>
                <label  style='cursor:pointer' for='slctRmRadio" . $rmid . $rssaid . "'>
                    <span class='badge text-sm pb-0'>$g - $s</span><small>$qrow->code - <i>$subject</i> | <i>$sched</i></small>
                </label>
                <label class='float-right' style='cursor:pointer;'>
                    <small><b class='text-primary'>" . $male . "</b> + <b class='text-pink'>" . $female . "</b> = <b>" . $t_enrollee . "</b></small>
                </label></div>",
            ];
        }
        echo json_encode($data);
    }

    function getViewAllGrades()
    {
        $rsid = $this->input->get("a");
        $tab = null;
        $content = null;
        $sy = $this->getOnLoad()["sy_id"];
        $qrtr = $this->getOnLoad()["qrtr"];
        $query = $this->db->query("SELECT * FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt
                                   WHERE room_section_id=$rsid ORDER BY advisory desc");
        foreach ($query->result() as $key => $value) {
            $sbjctabbr = $value->subject_abbr;
            $sbjct = $value->subject;
            $sbjctid = $value->subject_id;
            $teacher = $value->full_name;
            $title = $value->personal_title;
            $advisory = $value->advisory == 't' ? 'Class Advisory ' : '';
            $schedule = $value->schedule;
            $grd_sctn = $value->grade . ' - ' . $value->sctn_nm;
            $active = "";

            $a = null;
            $b = null;
            $c = null;
            if ($key === array_key_first($query->result())) {
                $active = "active";
            }
            $tab .= '<li class="nav-item">
                        <a class="nav-link ' . $active . '" title="' . $sbjct . '" id="custom-tabs-' . $sbjctid . '-tab" data-toggle="pill" href="#custom-tabs-' . $sbjctid . '" role="tab" aria-controls="custom-tabs-' . $sbjctid . '" aria-selected="false">' . $sbjctabbr . '</a>
                    </li>';

            $query2 = $this->db->query("SELECT t4.q1,t4.q2,t4.q3,t4.q4,t5.advisory,t5.full_name AS teacher_full_name,t5.personal_title,t1.id,t3.* FROM building_sectioning.tbl_room_section_subject_assignment t1
                                        LEFT JOIN building_sectioning.tbl_room_section t2 ON t1.room_section_id=t2.id
                                        LEFT JOIN building_sectioning.view_enrollment$sy t3 ON t1.room_section_id=t3.room_section_id
				                        LEFT JOIN building_sectioning.view_subject_grdlvl_personnel_assgnmnt t5 ON t1.room_section_id=t5.room_section_id AND t1.subject_id=t5.subject_id
                                        LEFT JOIN (SELECT t1.*,q1.grade q1,q2.grade q2,q3.grade q3,q4.grade q4 FROM (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id
                                                FROM building_sectioning.tbl_learner_grades$sy t1
                                                GROUP BY t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id) t1
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id)
                                            t4 ON t3.enrollment_id=t4.learner_enrollment_id AND t1.id=t4.rm_sctn_sbjct_assgnmnt_id
                                        WHERE t5.subject_id=$sbjctid AND t3.room_section_id=$rsid
                                        ORDER BY t3.sex DESC, t3.last_fullname");


            $a = '<div class="tab-pane fade show ' . $active . '" id="custom-tabs-' . $sbjctid . '" role="tabpanel" aria-labelledby="custom-tabs-' . $sbjctid . '-tab">
            <div class="row">
                <div class="col-12">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="http://localhost/SchoolMIS//dist/img/avatar1.jpg" alt="user image">
                            <span class="username">
                                <a href="#" class="personnel">' . $teacher . ' - ' . $title . '</a>
                            </span>
                            <span class="description">' . $advisory . '<b>' . $grd_sctn . '</b><small> <i>' . $sbjct . '</i> | <i>' . $schedule . '</i></small></span>
                            <!-- <span class="description">Class Advisory <b>Grade XII - ABCD</b> <small><i>ARTS</i> | <i>WD</i></small></span> -->
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-hover table-striped" id="tblAllGradesList' . $sbjctid . '" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>LRN</th>
                                <th>Personal Details</th>
                                <th>Sex</th>
                                <th>Status</th>
                                <th>Q1</th>
                                <th>Q2</th>
                                <th>Q3</th>
                                <th>Q4</th>
                            </tr>
                        </thead>
                        <tbody>';

            $c_male = 1;
            $c_fmale = 1;
            foreach ($query2->result() as $key2 => $value2) {
                $birthDate = date_create($value2->birthdate);
                $birthDate = strtoupper(date_format($birthDate, "m-d-Y"));
                $sex = substr($value2->sex, 0, 1);
                $q1 = $value2->q1;
                $q2 = $value2->q2;
                $q3 = $value2->q3;
                $q4 = $value2->q4;
                $v = $qrtr == 1 ? $q1 : ($qrtr == 2 ? $q2 : ($qrtr == 3 ? $q3 : $q4));
                $c_fmale == 1 && $sex == 'F' ?
                    $c .= '<tr>
                                <td> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>' : "";
                $c .= '<tr>
                                <td>' . ($sex == 'M' ? $c_male++ : $c_fmale++) . '</td>
                                <td>' . $value2->lrn . '</td>
                                <td>' . $value2->last_fullname . '</td>
                                <td>' . $sex . '</td>
                                <td>' . $value2->enrollment_status . '</td>
                                <td>' . $this->gradeColor($q1) . '</td>
                                <td>' . $this->gradeColor($q2) . '</td>
                                <td>' . $this->gradeColor($q3) . '</td>
                                <td>' . $this->gradeColor($q4) . '</td>
                            </tr>';
            }


            $b =      '</tbody>
                    </table>
                  </div>';
            $content .= $a . $c . $b;
        }

        $data = '<div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">' . $tab . '</ul>
                </div>
                <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                  ' . $content . '
                </div>
                </div>';
        echo json_encode($data);
    }

    function getLearnersList()
    {
        $data = ["data" => []];
        $data2 = [];
        $c_male = 1;
        $c_fmale = 1;
        $personnel_id = $this->session->schoolmis_login_prsnnl_Id;
        $sy = $this->getOnLoad()["sy_id"];
        $rsid = $this->input->post("rsid");
        $query = $this->db->query("SELECT t2.learner_account,t2.acc_stat,t2.logs,t1.* FROM building_sectioning.view_enrollment$sy t1
                                    LEFT JOIN (SELECT t1.basic_info_id AS learner_account,t2.logs,t1.is_active AS acc_stat FROM account.tbl_useraccount t1
																	 LEFT JOIN (SELECT t2.basic_info_id,count(1) AS logs FROM global.tbl_userlogs_learner$sy t1
																	 LEFT JOIN account.tbl_useraccount t2 ON t1.user_id=t2.id
																	 GROUP BY t2.basic_info_id) t2 ON t1.basic_info_id=t2.basic_info_id) t2 ON t1.basic_info_id=t2.learner_account
                                   WHERE t1.room_section_id=$rsid AND t1.schl_yr_id=$sy 
                                   ORDER BY t1.sex DESC, t1.last_fullname");

        foreach ($query->result() as $key => $value) {
            $logs =  number_format($value->logs);
            $a_c = $value->acc_stat;
            $searchLog = $value->lrn . ' - ' . $value->last_fullname;
            $birthDate = date_create($value->birthdate);
            $personUuid = $value->person_uuid;
            $birthDate = strtoupper(date_format($birthDate, "m-d-Y"));
            $bold = "font-weight-bold";
            $sex = substr($value->sex, 0, 1);
            $txtColor = $value->learner_account && $a_c == 't' ? 'text-success ' . $bold : ($a_c == 'f' ? 'text-danger ' . $bold : 'text-black font-weight-light');
            //LEARNER ID _&&_ LRN _&&_ BASIC INFO ID _&&_ ACCOUNT
            $val =  $value->learner_id . '_&&_' . $value->lrn  . '_&&_' . $value->basic_info_id . '_&&_' . ($value->learner_account ? 1 : 0);
            $c_fmale == 1 && $sex == 'F' ?
                $data["data"][] = [
                    " ",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                ] : "";
            $data["data"][] = [
                $sex == 'M' ? $c_male++ : $c_fmale++,
                '<div class="row logs_account" style="white-space: nowrap;display:none;">
                    <div class="col-8 pr-5">
                        <div class="custom-control custom-checkbox">
                            <input style="cursor:pointer" class="custom-control-input learnerCheckBox" type="checkbox" id="customCheckbox' . $value->lrn . '" name="learnerCheckBox[]" value="' . $val . '">
                            <label style="cursor:pointer" for="customCheckbox' . $value->lrn . '" class="custom-control-label ' . $txtColor . '">' . $value->lrn . '</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-xs text-gray ml-1" data-toggle="dropdown" aria-expanded="true">' .
                    ($value->logs ? '<span title="' . $value->logs . ' Log(s) Count" class="badge badge-danger button-badge">' . $logs . '</span>' : '<span class="fa fa-ellipsis-h"></span>') . '
                        </button>
                        <div class="dropdown-menu" style="cursor:pointer;">
                        ' . ($value->logs ? "<a class='dropdown-item' href='#' onclick='allStudentLogs(\" $searchLog \")'><i class='fa fa-list'></i> View Logs</a>" : null) . '
                        ' . ($value->learner_account ? "<a class='dropdown-item' onclick='learnerAccnt(\"$personUuid\",\"1\")' href='#'><i class='fa fa-key'></i> Reset Password</a>" : "<a class='dropdown-item' onclick='learnerAccnt(\"$personUuid\",\"0\")'><i class='fa fa-plus'></i> Create Account</a>") . '
                        </div>
                    </div>
                </div>
                <div class="normal_view">
                    ' . $value->lrn . '
                </div>',
                $value->last_fullname,
                $sex,
                $birthDate,
                $value->address_details,
                $value->enrollment_status,
            ];
        }
        echo json_encode($data);
    }

    function getSearchEnrollLearnersList()
    {
        $data = ["data" => []];
        $by = $this->input->post("by");
        $key = $this->input->post("key");
        $w = $by == 1 ? "t1.lrn='$key'" : "t1.last_name='$key'";
        $c = 1;
        $personnel_id = $this->session->schoolmis_login_prsnnl_Id;
        $sy = $this->getOnLoad()["sy_id"];
        $rsid = $this->input->post("rsid");
        $query = $this->db->query("SELECT t1.lrn,t1.learner_id,t1.last_fullname,t1.sex,t1.birthdate,
                                    t2.grade,t2.sctn_nm,t2.enrollment_date, t2.sy FROM profile.view_learner t1
                                    LEFT JOIN building_sectioning.view_enrollment$sy t2 ON t1.learner_id=t2.learner_id
                                    -- WHERE $w
                                    ORDER BY t2.enrollment_date DESC
                                    LIMIT 10");

        foreach ($query->result() as $key => $value) {
            $birthDate = date_create($value->birthdate);
            $birthDate = strtoupper(date_format($birthDate, "m-d-Y"));
            $sex = substr($value->sex, 0, 1);
            $data["data"][] = [
                $c++,
                $value->grade === null ? "<div class='custom-control custom-checkbox'>
                    <input class='custom-control-input' type='checkbox' id='customCheckbox" . $value->lrn . "' name='searchEnrollCheckBox[]' value='" . $value->learner_id . "'>
                    <label for='customCheckbox" . $value->lrn . "' class='custom-control-label'>" . $value->lrn . "</label>
                </div>" : "<div class='custom-control custom-checkbox'><span class='custom-control-input'>ENRL</span> <label>" . $value->lrn . "</label></div>",
                $value->last_fullname,
                $sex,
                $birthDate,
                $value->grade . '-' . $value->sctn_nm . '<br/>' . $value->enrollment_date,
            ];
        }
        echo json_encode($data);
    }

    function getGradesList()
    {
        $data = ["data" => []];
        $c_male = 1;
        $c_fmale = 1;
        $personnel_id = $this->session->schoolmis_login_prsnnl_Id;
        $sy = $this->getOnLoad()["sy_id"];
        $qrtr = $this->getOnLoad()["qrtr"];
        $rssaid = $this->input->post("rssaid");

        $query = $this->db->query("SELECT t4.q1,t4.q2,t4.q3,t4.q4, t1.id,t3.* FROM building_sectioning.tbl_room_section_subject_assignment t1
        LEFT JOIN building_sectioning.tbl_room_section t2 ON t1.room_section_id=t2.id
        LEFT JOIN building_sectioning.view_enrollment$sy t3 ON t1.room_section_id=t3.room_section_id
        LEFT JOIN (SELECT t1.*,q1.grade q1,q2.grade q2,q3.grade q3,q4.grade q4 FROM (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id
                FROM building_sectioning.tbl_learner_grades$sy t1
                GROUP BY t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id) t1
                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id)
            t4 ON t3.enrollment_id=t4.learner_enrollment_id AND t1.id=t4.rm_sctn_sbjct_assgnmnt_id
        WHERE t1.schl_personnel_id=$personnel_id AND t1.id=$rssaid
        ORDER BY t3.sex DESC, t3.last_fullname");


        foreach ($query->result() as $key => $value) {
            $birthDate = date_create($value->birthdate);
            $birthDate = strtoupper(date_format($birthDate, "m-d-Y"));
            $sex = substr($value->sex, 0, 1);
            $q1 = $value->q1;
            $q2 = $value->q2;
            $q3 = $value->q3;
            $q4 = $value->q4;
            $v = $qrtr == 1 ? $q1 : ($qrtr == 2 ? $q2 : ($qrtr == 3 ? $q3 : $q4));
            $entry = "<input type='number' class='form-control' name='gradeLearner[]' value='$v' placeholder='--' nr='1' id='gradeLearner$value->lrn'/>";
            $c_fmale == 1 && $sex == 'F' ?
                $data["data"][] = [
                    " ",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                ] : "";

            $data["data"][] = [
                ($sex == 'M' ? $c_male++ : $c_fmale++) . ". " . $value->last_fullname,
                $sex,
                $value->enrollment_status,
                "<input value='" . $value->enrollment_id . "' name='en_id[]' hidden/>
                <input value='" . $value->room_section_id . "' name='rm_sec_id[]' hidden/>
                <input value='" . $rssaid . "' name='rssaid[]' hidden/>" .
                    ($qrtr == 1 ? $entry : $this->gradeColor($q1)),
                ($qrtr == 2 ? $entry : $this->gradeColor($q2)),
                ($qrtr == 3 ? $entry : $this->gradeColor($q3)),
                ($qrtr == 4 ? $entry : $this->gradeColor($q4)),
            ];
        }
        echo json_encode($data);
    }

    function getAllStudentLogs()
    {
        $data = ["data" => []];
        $c = 1;
        $rsid = $this->input->post("rsid");
        $sy = $this->getOnLoad()["sy_id"];
        $query = $this->db->query("SELECT t1.*,t2.lrn,t2.last_fullname FROM global.tbl_userlogs_learner$sy t1 
                                    JOIN building_sectioning.view_enrollment$sy t2 ON t1.user_name=t2.lrn 
                                    WHERE t2.rm_sec_id=$rsid
                                    ORDER BY t1.date_time DESC");
        foreach ($query->result() as $key => $value) {
            $data["data"][] = [
                '<b>' . $c++ . '.</b>',
                '<div style="white-space: nowrap;">' . $value->lrn . ' - ' . $value->last_fullname . '</div>',
                '<div style="white-space: nowrap;">' . $value->date_time . '</div>',
                '<div style="white-space: nowrap;">' . $value->action . '</div>',
                '<div style="white-space: nowrap;">' . $value->ip . '</div>',
            ];
        }
        echo json_encode($data);
    }
    // function getSYInfo()
    // {
    //     $data = ["data" => []];
    //     $c = 1;
    //     $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_sy t1 ORDER BY t1.from DESC");
    //     foreach ($thisQuery->result() as $key => $value) {
    //         $stat = $value->is_active;
    //         $data["data"][] = [
    //             $c++,
    //             "<div class='row'><div class='col-6'>
    //                 <span class='badge text-md " . ($stat == "t" ? "bg-success" : "bg-gray") . "'>$value->description</span>
    //             </div>
    //             <div class='col-6'>
    //                 <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
    //                     <span class='fa fa-ellipsis-h'></span>
    //                 </button>
    //                 <div class='dropdown-menu'>
    //                     <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",1)'>Edit Information</a>
    //                 </div>
    //             </div></div>",
    //         ];
    //     }
    //     echo json_encode($data);
    // }
}
