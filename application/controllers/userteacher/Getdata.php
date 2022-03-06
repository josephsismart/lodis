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
            // $q1c = $value->q1c;
            // $q1stat = $value->q1stat;
            // $q1rmrk = $value->q1rmrk;
            // $q2c = $value->q2c;
            // $q2stat = $value->q2stat;
            // $q2rmrk = $value->q2rmrk;
            // $q3c = $value->q3c;
            // $q3stat = $value->q3stat;
            // $q3rmrk = $value->q3rmrk;
            // $q4c = $value->q4c;
            // $q4stat = $value->q4stat;
            // $q4rmrk = $value->q4rmrk;
            $male = number_format($qrow->male) ?? "-";
            $female = number_format($qrow->female) ?? "-";
            $t_enrollee = number_format($qrow->total_enrollee) ?? "-";
            $data2 = [
                "personnel" => $qrow->full_name . " - " . $qrow->personal_title,
                "description" => "Class Advisory <b>" . $qrow->grade . " - " . $qrow->sctn_nm . "</b><small> <i>" . $qrow->subject . "</i> | <i>" . $qrow->sched . "</i></small>",
                "male" => $male,
                "female" => $female,
                "total_enrollee" => $t_enrollee,
                "enroll" => ($advsry == 't' && $enroll_stat == 't') ? '<button type="submit" data-toggle="modal" onclick="clear_form1()" data-target="#modalEnrollment" class="btn btn-xs btn-success float-right">Enroll</button>' : "",
                "grade" => ($grade_stat == 't') ? '<button type="submit" onclick="getGradesListFN()" data-toggle="modal" data-target="#modalGradesList" class="btn btn-xs btn-primary float-right ml-1">Grades</button>' : '',
                "grade_all" => ($advsry == 't') ? '<button onclick="customTabViewAllGrades()" data-toggle="modal" data-target="#modalAllGrades" class="btn btn-xs btn-info float-right ml-1">View All Grades</button>' : '',
                "others" => ($advsry == 't') ? '<button type="button" class="btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0 ml-1" data-toggle="dropdown" aria-expanded="true">
                                                    <span class="fa fa-ellipsis-h"></span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="logsHideShow()">Logs & Account Settings</a>
                                                    <a class="dropdown-item" href="#" onclick="allStudentLogs()">View All Student Logs</a>
                                                </div>' : '',
            ];

            // $data3 = [
            //     "q1c" => $this->submitGradesBtn($q1stat, $q1c, $q1rmrk, 3221232, 1),
            //     "q2c" => $this->submitGradesBtn($q2stat, $q2c, $q2rmrk, 2123221, 2),
            //     "q3c" => $this->submitGradesBtn($q3stat, $q3c, $q3rmrk, 3211123, 3),
            //     "q4c" => $this->submitGradesBtn($q4stat, $q4c, $q4rmrk, 4522323, 4),
            // ];
            $arr2 = json_encode($data2);
            // $arr3 = json_encode($data3);
            // getDetails(\"GradesList\",$arr3,1,\".\");
            $slct = ($advsry === 't' && $key === array_key_first($query->result()) ? 'slctdRadioAdvisory' : '');
            $data["data"][] = [
                "<div class='row' style='white-space: nowrap;'>
                    <div class='col-12 " . ($advsry === 't' ? 'text-success' : '') . "'>
                        <input type='radio' id='slctRmRadio" . $rmid . $rssaid . "' class='" . $slct . "' name='slctRm' value='" . $rmid . "' 
                                onclick='getLearnersListFN(\"LearnersList\"," . $rmid . "," . $rssaid . ",\"" . $advsry . "\");
                                        getDetails(\"PersonnelInfo\",$arr2,1,\".\");
                        '/>
                        <label class='w-100'  style='cursor:pointer' for='slctRmRadio" . $rmid . $rssaid . "'>
                            <span class='badge text-sm pb-0'>$g - $s</span><small>$qrow->code - <i>$subject</i> | <i>$sched</i></small>
                            <small class='float-right'><b class='text-primary'>" . $male . "</b> + <b class='text-pink'>" . $female . "</b> = <b>" . $t_enrollee . "</b></small><br/>
                        </label>
                    </div>
                </div>",
            ];
        }
        echo json_encode($data);
    }

    function getViewAllGrades()
    {
        $rsid = $this->input->get("a");
        $tab = null;
        $tab2 = null;
        $content = null;
        $content2 = null;
        $sy = $this->getOnLoad()["sy_id"];
        $qrtr = $this->getOnLoad()["qrtr"];
        $query = $this->db->query("SELECT t1.*,t2.parent FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                    LEFT JOIN (SELECT t1.parent_party_id AS parent FROM global.tbl_party t1
                                                            WHERE t1.parent_party_id IS NOT NULL
                                                            GROUP BY t1.parent_party_id) t2 ON t1.subject_id = t2.parent
                                    WHERE t1.room_section_id=$rsid AND t1.schl_yr_id=$sy AND t1.full_name IS NOT NULL ORDER BY t1.order_by_sbjct");
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
            $parnt_prty_id = $value->parent_party_id;
            $parnt = $value->parent;

            $a = null;
            $b = null;
            $c = null;

            $a2 = null;
            $b2 = null;
            $c2 = null;
            if ($key === array_key_first($query->result())) {
                $active = "active";
            }
            $t = '<li class="nav-item">
                    <a onclick="' . (($parnt == $sbjctid) || ($parnt_prty_id)
                ? "$('.viewAllGrades2, .sbjct_group').show();$('.sbjct_sngl').hide();$('.viewAllGrades2 .card-header .nav .nav-item .nav-link').removeClass('active');"
                : "$('.viewAllGrades2, .sbjct_group').hide();$('.sbjct_sngl').show()") . '" 
                        class="nav-link ' . $active . '" title="' . $sbjct . '" 
                        id="custom-tabs-' . $sbjctid . '-tab" 
                        data-toggle="pill" 
                        href="#custom-tabs-' . $sbjctid . '" 
                        role="tab" aria-controls="custom-tabs-' . $sbjctid . '" 
                        aria-selected="false" 
                        >' . $sbjctabbr . '</a>
                        <script>' . (($parnt == $sbjctid) || ($parnt_prty_id) ? "$('.viewAllGrades2, .sbjct_group').hide()" : "") . '
                            document.querySelector("#custom-tabs-77-tab")                            
                            document.querySelector("#custom-tabs-four-tab > li:nth-child(1)")
                        </script>
                </li>';
            if ($parnt == $sbjctid) {
                $tab2 .= $t;
            }

            if (!$parnt_prty_id) {
                $tab .= $t;
            } else {
                $tab2 .= $t;
            }


            $query2 = $this->db->query("SELECT t4.q1,t4.q2,t4.q3,t4.q4,t5.advisory,t5.full_name AS teacher_full_name,t5.personal_title,t1.id,t3.* FROM building_sectioning.tbl_room_section_subject_assignment t1
                                        LEFT JOIN building_sectioning.tbl_room_section t2 ON t1.room_section_id=t2.id
                                        LEFT JOIN building_sectioning.view_enrollment$sy t3 ON t1.room_section_id=t3.room_section_id
				                        LEFT JOIN building_sectioning.view_subject_grdlvl_personnel_assgnmnt t5 ON t1.room_section_id=t5.room_section_id AND t1.subject_id=t5.subject_id
                                        LEFT JOIN (SELECT t1.*,q1.grade q1,q2.grade q2,q3.grade q3,q4.grade q4 FROM (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id
                                                FROM building_sectioning.tbl_learner_grades$sy t1
                                                GROUP BY t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id) t1
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                                    LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=1 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                    WHERE t1.sy_id=$sy AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                                    LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=2 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                    WHERE t1.sy_id=$sy AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                                    LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=3 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                    WHERE t1.sy_id=$sy AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                                                LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                                    LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=4 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                    WHERE t1.sy_id=$sy AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id)
                                            t4 ON t3.enrollment_id=t4.learner_enrollment_id AND t1.id=t4.rm_sctn_sbjct_assgnmnt_id
                                        WHERE t5.subject_id=$sbjctid AND t3.room_section_id=$rsid
                                        ORDER BY t3.sex DESC, t3.last_fullname");


            $aa = '<div class="tab-pane fade show ' . $active . ' " id="custom-tabs-' . $sbjctid . '" role="tabpanel" aria-labelledby="custom-tabs-' . $sbjctid . '-tab">
            <div class="row ' . (($parnt == $sbjctid) || ($parnt_prty_id) ? 'sbjct_group' : 'sbjct_sngl') . '">
                <div class="col-12">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="' . base_url() . '/dist/img/avatar1.jpg" alt="user image">
                            <span class="username">
                                <a href="#" class="personnel">' . $teacher . ' - ' . $title . '</a>
                            </span>
                            <span class="description">' . $advisory . '<b>' . $grd_sctn . '</b><small> <i>' . $sbjct . '</i> | <i>' . $schedule . '</i></small></span>
                            <!-- <span class="description">Class Advisory <b>Grade XII - ABCD</b> <small><i>ARTS</i> | <i>WD</i></small></span> -->
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-hover table-striped ' . (($parnt == $sbjctid) || ($parnt_prty_id) ? 'sbjct_group' : 'sbjct_sngl') . '" id="tblAllGradesList' . $sbjctid . '" width="100%">
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

            if ($parnt == $sbjctid) {
                $a2 .= $aa;
            }

            if (!$parnt_prty_id) {
                $a .= $aa;
            } else {
                $a2 .= $aa;
            }

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



            if ($parnt == $sbjctid) {
                $content2 .= $a2 . $c . $b;
            }

            if (!$parnt_prty_id) {
                $content .= $a . $c . $b;
            } else {
                $content2 .= $a2 . $c . $b;
            }
        }

        $data = '<div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">' . $tab . '</ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        
                        <div class="card card-info p-0 mt-n2 table-responsive viewAllGrades2">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">' . $tab2 . '</ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    ' . $content2 . '
                                </div>
                            </div>
                        </div>
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
        $edit = $this->getOnLoad()["edit"];
        $unenroll = $this->getOnLoad()["unenroll"];
        $rsid = $this->input->post("rsid");

        $q = $this->db->query("SELECT 1 AS cc FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                WHERE t1.room_section_id=$rsid AND t1.advisory='t' AND t1.schl_yr_id=$sy and t1.schoolpersonnel_id=$personnel_id LIMIT 1");

        $q1 = $q->row();
        $advsry = $q1->cc ?? 0;
        $query = $this->db->query("SELECT TO_CHAR(t1.enrollment_date :: DATE, 'yyyy-mm-dd') status_date,t2.learner_account,t2.acc_stat,t2.logs,t1.* FROM building_sectioning.view_enrollment$sy t1
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

            $data1 = [
                "details" => $value->enrollment_id . '|' . $value->learner_id . '|' . $value->basic_info_id,
                "lrn" => $value->lrn,
                "firstName" => $value->first_name,
                "middleName" => $value->middle_name,
                "lastName" => $value->last_name,
                "extName" => $value->suffix,
                "sex" => $value->sex_bool,
                "birthdate" => $value->birthdate,
                "brgy" => $value->barangay_id,
                "homeAddress" => $value->address_info,
                "status" => $value->status_id,
                "enrollDate" => $value->status_date,
            ];
            $data2 = [
                "lrn" => $value->lrn,
                "last_fullname" => $value->last_fullname,
                "details" => md5($value->enrollment_id) . '|' . md5($value->learner_id) . '|' . md5($value->basic_info_id),
            ];
            $arr1 = json_encode($data1);
            $arr2 = json_encode($data2);
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
                ($sex == 'M' ? $c_male++ : $c_fmale++),
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
                

                <div class="normal_view" style="white-space: nowrap;">
                    ' . ($edit == 't'  && $advsry == 1 ? "<span class='fa fa-pencil-alt text-primary text-sm' style='cursor:pointer;' onclick='getDetails(\"UpdateLearnerInfo\",$arr1,1,\"#\");$(\"#modalUpdateLearnerInfo\").modal(\"show\");'></span> " : '') . $value->lrn . '
                </div>',
                $value->last_fullname,
                $sex,
                $birthDate,
                $value->address_details,
                '<div class="normal_view" style="white-space: nowrap;">
                    ' . $value->enrollment_status . ($unenroll == 't' && $advsry == 1 ? " <span class='fa fa-trash-alt text-danger text-sm' style='cursor:pointer' onclick='getDetails(\"UnenrollConfirm\",$arr2,1,\"#\");setTimeout(function(){ $(\".passwordUnenroll\").val(\"\").focus(); } ,200);$(\"#modalLearnersUnenroll\").modal(\"show\");'></span>" : '') . '
                </div>',
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
                                                FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=$sy AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=$sy AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=$sy AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=$sy AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id)
                                        t4 ON t3.enrollment_id=t4.learner_enrollment_id AND t1.id=t4.rm_sctn_sbjct_assgnmnt_id
                                    WHERE t1.schl_personnel_id=$personnel_id AND t1.id=$rssaid
                                    ORDER BY t3.sex DESC, t3.last_fullname");

        $query1 = $this->db->query("SELECT DISTINCT(t1.rm_sctn_sbjct_assgnmnt_id) AS rssaid,t2.q1c,t2.q1stat,t2.q1rmrk,t3.q2c,t3.q2stat,t3.q2rmrk,t4.q3c,t4.q3stat,t4.q3rmrk,t5.q4c,t5.q4stat,t5.q4rmrk
                                        FROM building_sectioning.tbl_learner_grades$sy t1 					
                                        LEFT JOIN(SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssa_id,
                                                                            (SUM(CASE WHEN t1.grade IS NOT NULL THEN 1 ELSE 0 END)*100 / count(t1.id)) AS q1c,
                                                                            t2.status q1stat, t2.remarks q1rmrk
                                                            FROM building_sectioning.tbl_learner_grades$sy t1 
                                                            LEFT JOIN (SELECT t1.*,t2.description AS status FROM building_sectioning.tbl_learner_grades_stat$sy t1
                                                                                    LEFT JOIN global.tbl_status t2 ON t1.status_id=t2.id
                                                                                    WHERE t1.is_active=true AND t1.sy_id=$sy AND t1.qrtr=1) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                            WHERE	t1.sy_id=$sy AND t1.qrtr_id=1
                                                            GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t2.status,t2.remarks) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                            
                                        LEFT JOIN(SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssa_id,
                                                                            (SUM(CASE WHEN t1.grade IS NOT NULL THEN 1 ELSE 0 END)*100 / count(t1.id)) AS q2c,
                                                                            t2.status q2stat, t2.remarks q2rmrk
                                                            FROM building_sectioning.tbl_learner_grades$sy t1 
                                                            LEFT JOIN (SELECT t1.*,t2.description AS status FROM building_sectioning.tbl_learner_grades_stat$sy t1
                                                                                    LEFT JOIN global.tbl_status t2 ON t1.status_id=t2.id
                                                                                    WHERE t1.is_active=true AND t1.sy_id=$sy AND t1.qrtr=2) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                            WHERE	t1.sy_id=$sy AND t1.qrtr_id=2
                                                            GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t2.status,t2.remarks) t3 ON t1.rm_sctn_sbjct_assgnmnt_id=t3.rssa_id
                                                            
                                        LEFT JOIN(SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssa_id,
                                                                            (SUM(CASE WHEN t1.grade IS NOT NULL THEN 1 ELSE 0 END)*100 / count(t1.id)) AS q3c,
                                                                            t2.status q3stat, t2.remarks q3rmrk
                                                            FROM building_sectioning.tbl_learner_grades$sy t1 
                                                            LEFT JOIN (SELECT t1.*,t2.description AS status FROM building_sectioning.tbl_learner_grades_stat$sy t1
                                                                                    LEFT JOIN global.tbl_status t2 ON t1.status_id=t2.id
                                                                                    WHERE t1.is_active=true AND t1.sy_id=$sy AND t1.qrtr=3) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                            WHERE	t1.sy_id=$sy AND t1.qrtr_id=3
                                                            GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t2.status,t2.remarks) t4 ON t1.rm_sctn_sbjct_assgnmnt_id=t4.rssa_id
                                                            
                                        LEFT JOIN(SELECT t1.rm_sctn_sbjct_assgnmnt_id AS rssa_id,
                                                                            (SUM(CASE WHEN t1.grade IS NOT NULL THEN 1 ELSE 0 END)*100 / count(t1.id)) AS q4c,
                                                                            t2.status q4stat, t2.remarks q4rmrk
                                                            FROM building_sectioning.tbl_learner_grades$sy t1 
                                                            LEFT JOIN (SELECT t1.*,t2.description AS status FROM building_sectioning.tbl_learner_grades_stat$sy t1
                                                                                    LEFT JOIN global.tbl_status t2 ON t1.status_id=t2.id
                                                                                    WHERE t1.is_active=true AND t1.sy_id=$sy AND t1.qrtr=4) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                            WHERE	t1.sy_id=$sy AND t1.qrtr_id=4
                                                            GROUP BY t1.rm_sctn_sbjct_assgnmnt_id,t2.status,t2.remarks) t5 ON t1.rm_sctn_sbjct_assgnmnt_id=t5.rssa_id
                                                            
                                        WHERE t1.rm_sctn_sbjct_assgnmnt_id = $rssaid");
        $q1c = null;
        $q1stat = null;
        $q1rmrk = null;
        $q2c = null;
        $q2stat = null;
        $q2rmrk = null;
        $q3c = null;
        $q3stat = null;
        $q3rmrk = null;
        $q4c = null;
        $q4stat = null;
        $q4rmrk = null;
        foreach ($query1->result() as $key => $v) {
            $q1c = $v->q1c;
            $q1stat = $v->q1stat;
            $q1rmrk = $v->q1rmrk;
            $q2c = $v->q2c;
            $q2stat = $v->q2stat;
            $q2rmrk = $v->q2rmrk;
            $q3c = $v->q3c;
            $q3stat = $v->q3stat;
            $q3rmrk = $v->q3rmrk;
            $q4c = $v->q4c;
            $q4stat = $v->q4stat;
            $q4rmrk = $v->q4rmrk;
            $data["details"] = [
                "q1c" => $this->submitGradesBtn($q1stat, $q1c, $q1rmrk, 3221232, 1),
                "q2c" => $this->submitGradesBtn($q2stat, $q2c, $q2rmrk, 2123221, 2),
                "q3c" => $this->submitGradesBtn($q3stat, $q3c, $q3rmrk, 3211123, 3),
                "q4c" => $this->submitGradesBtn($q4stat, $q4c, $q4rmrk, 4522323, 4),
            ];
        }

        foreach ($query->result() as $key => $value) {
            $birthDate = date_create($value->birthdate);
            $birthDate = strtoupper(date_format($birthDate, "m-d-Y"));
            $sex = substr($value->sex, 0, 1);
            $q1 = $value->q1;
            $q2 = $value->q2;
            $q3 = $value->q3;
            $q4 = $value->q4;
            $v = $qrtr == 1 ? $q1 : ($qrtr == 2 ? $q2 : ($qrtr == 3 ? $q3 : $q4));
            $entry = "<input onclick='maxInput(\"gradeLearner$value->lrn\")' onkeyup='maxInput(\"gradeLearner$value->lrn\")' style='text-align:center;' type='number' class='form-control' name='gradeLearner[]' value='$v' placeholder='--' nr='1' id='gradeLearner$value->lrn'/>";
            $c_fmale == 1 && $sex == 'F' ?
                $data["data"][] = [
                    " ",
                    // "",
                    // "",
                    "",
                    "",
                    "",
                    "",
                ] : "";

            $data["data"][] = [
                "<p style='text-align:left' class='mb-0 ml-n2 pr-3'>" . ($sex == 'M' ? $c_male++ : $c_fmale++) . ". " . $value->last_fullname . "</p>",
                // $sex,
                // $value->enrollment_status,
                "<input value='" . $value->enrollment_id . "' name='en_id[]' hidden/>
                <input value='" . $value->room_section_id . "' name='rm_sec_id[]' hidden/>
                <input value='" . $rssaid . "' name='rssaid[]' hidden/>" .
                    ($qrtr == 1 && ($q1stat == null || $q1stat == 20) ? $entry : $this->gradeColor($q1)),
                ($qrtr == 2 && ($q2stat == null || $q2stat == 20) ? $entry : $this->gradeColor($q2)),
                ($qrtr == 3 && ($q3stat == null || $q3stat == 20) ? $entry : $this->gradeColor($q3)),
                ($qrtr == 4 && ($q4stat == null || $q4stat == 20) ? $entry : $this->gradeColor($q4)),
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

    function getHonors()
    {
        $data = ["data" => []];
        $c = 1;
        $rsid = $this->input->post("rsid");
        $sy = $this->getOnLoad()["sy_id"];
        $q1a_wst = 0;
        $q1a_whh = 0;
        $q1a_wh = 0;

        $q2a_wst = 0;
        $q2a_whh = 0;
        $q2a_wh = 0;

        $q3a_wst = 0;
        $q3a_whh = 0;
        $q3a_wh = 0;

        $q4a_wst = 0;
        $q4a_whh = 0;
        $q4a_wh = 0;
        $query = $this->db->query("SELECT t2.room_section_id ,t1.*,t3.total_sbjct FROM(
                                    SELECT t1.learner_enrollment_id,
                                        SUM(CASE WHEN(t1.qrtr_id=1) THEN t1.grade END) AS q1,
                                        SUM(CASE WHEN(t1.qrtr_id=2) THEN t1.grade END) AS q2,
                                        SUM(CASE WHEN(t1.qrtr_id=3) THEN t1.grade END) AS q3,
                                        SUM(CASE WHEN(t1.qrtr_id=4) THEN t1.grade END) AS q4
                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                    GROUP BY t1.learner_enrollment_id) t1
                                    JOIN building_sectioning.tbl_learner_enrollment$sy t2 ON t1.learner_enrollment_id=t2.id
                                    JOIN(SELECT t1.* FROM building_sectioning.view_room_section_sbjct_cnt t1 WHERE t1.schl_yr_id = $sy) t3 ON t2.room_section_id=t3.room_section_id
                                    WHERE t2.room_section_id = $rsid");
        foreach ($query->result() as $key => $value) {
            $ts = $value->total_sbjct;
            $q1 = round($value->q1 / $ts);
            $q2 = round($value->q2 / $ts);
            $q3 = round($value->q3 / $ts);
            $q4 = round($value->q4 / $ts);
            $q1a_wst += ($q1 >= 98 &&  $q1 <= 100) ? 1 : 0;
            $q1a_whh += ($q1 >= 95 &&  $q1 <= 97) ? 1 : 0;
            $q1a_wh += ($q1 >= 90 &&  $q1 <= 94) ? 1 : 0;

            $q2a_wst += ($q2 >= 98 &&  $q2 <= 100) ? 1 : 0;
            $q2a_whh += ($q2 >= 95 &&  $q2 <= 97) ? 1 : 0;
            $q2a_wh += ($q2 >= 90 &&  $q2 <= 94) ? 1 : 0;

            $q3a_wst += ($q3 >= 98 &&  $q3 <= 100) ? 1 : 0;
            $q3a_whh += ($q3 >= 95 &&  $q3 <= 97) ? 1 : 0;
            $q3a_wh += ($q3 >= 90 &&  $q3 <= 94) ? 1 : 0;

            $q4a_wst += ($q4 >= 98 &&  $q4 <= 100) ? 1 : 0;
            $q4a_whh += ($q4 >= 95 &&  $q4 <= 97) ? 1 : 0;
            $q4a_wh += ($q4 >= 90 &&  $q4 <= 94) ? 1 : 0;
        }

        $query2 = $this->db->query("SELECT * FROM global.tbl_party WHERE party_type_id=19 AND is_active=true ORDER BY order_by");
        foreach ($query2->result() as $key => $value) {
            $pid = $value->id;
            $q1a_wst = $this->returnDashed($q1a_wst);
            $q1a_whh = $this->returnDashed($q1a_whh);
            $q1a_wh = $this->returnDashed($q1a_wh);
            
            $q2a_wst = $this->returnDashed($q2a_wst);
            $q2a_whh = $this->returnDashed($q2a_whh);
            $q2a_wh = $this->returnDashed($q2a_wh);
            
            $q3a_wst = $this->returnDashed($q3a_wst);
            $q3a_whh = $this->returnDashed($q3a_whh);
            $q3a_wh = $this->returnDashed($q3a_wh);
            
            $q4a_wst = $this->returnDashed($q4a_wst);
            $q4a_whh = $this->returnDashed($q4a_whh);
            $q4a_wh = $this->returnDashed($q4a_wh);

            $data["data"][] = [
                '<p class="mb-n2 text-nowrap">' . $value->description . ' <i>' . $value->abbr . '</i></p>',
                $pid == 109 ? $q1a_wst : ($pid == 110 ? $q1a_whh : $q1a_wh),
                $pid == 109 ? $q2a_wst : ($pid == 110 ? $q2a_whh : $q2a_wh),
                $pid == 109 ? $q3a_wst : ($pid == 110 ? $q3a_whh : $q3a_wh),
                $pid == 109 ? $q4a_wst : ($pid == 110 ? $q4a_whh : $q4a_wh),
                '4',
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
