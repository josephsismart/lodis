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


    function getGradeSecInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $dept_id = $this->session->schoolmis_login_dept_id;
        $data = ["data" => []];
        $data2 = [];
        $c = 1;
        $thisQuery = $this->db->query('SELECT t2.sec_handle, t1.schoolpersonnel_id,t1.person_id,t1.last_fullname, t1.personal_title, t1.school_department_id  FROM profile.view_schoolpersonnel t1
                                        LEFT JOIN (SELECT count(1) AS sec_handle,t1.schoolpersonnel_id
                                                    FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                                    WHERE t1.schl_yr_id=' . $sy . '
                                                    GROUP BY t1.schoolpersonnel_id) t2 ON t1.schoolpersonnel_id=t2.schoolpersonnel_id 
                                        WHERE t1.school_department_id=' . $dept_id . ' AND t1.school_id=1 AND t1."employeeTypeId"=4
                                        ORDER BY t1.last_fullname');
        foreach ($thisQuery->result() as $key => $value) {
            $sec_handle = $value->sec_handle;
            $spid = $value->schoolpersonnel_id;
            $pid = $value->person_id;
            $name = $value->last_fullname;
            $title = $value->personal_title;
            $data2 = [
                "spid" => $spid,
            ];
            $arr = json_encode($data2);

            $data["data"][] = [
                $c++,
                "<div class='row'><div class='col-11'>
                        <span class='badge text-sm pb-0'>$name </span>
                        <small>$title<i></i></small><br/>
                        <small class='ml-2'>LOAD: " . ($sec_handle ?? "<i class='text-red'>NONE</i>") . "<i></i></small>
                    </div>
                    <div class='col-1'>
                        <button type='button' onclick='customTabViewAllGrades(\"$spid\");' class='btn btn-xs text-xs float-right btn-outline-secondary rounded-circle border-0'>
                            <span class='fa fa-eye'></span>
                        </button>
                        <!-- <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                            <span class='fa fa-ellipsis-h'></span>
                        </button>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",1)'>Edit Information</a>
                        </div> --!>
                    </div></div>",
            ];
        }
        echo json_encode($data);
    }


    function getViewAllGrades()
    {
        $sid = $this->input->get("a");
        $tab = null;
        $content = null;
        $sy = $this->getOnLoad()["sy_id"];
        $qrtr = $this->getOnLoad()["qrtr"];
        $query = $this->db->query("SELECT t1.*,t2.full_name AS fn_advsry,t2.personal_title AS fn_advsry_ttl FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                   LEFT JOIN (SELECT * FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt
												WHERE advisory=true) t2 ON t1.room_section_id=t2.room_section_id
                                   WHERE t1.schoolpersonnel_id=$sid
                                   ORDER BY t1.sctn_nm desc");
        foreach ($query->result() as $key => $value) {
            $spid = $value->schoolpersonnel_id;
            $rsid = $value->room_section_id;
            $fn_advsry = $value->fn_advsry;
            $fn_advsry_ttl = $value->fn_advsry_ttl;
            // $sbjctabbr = $value->subject_abbr;
            $sbjct = $value->subject;
            // $sbjctid = $value->subject_id;
            // $teacher = $value->full_name;
            // $title = $value->personal_title;
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
                        <a class="nav-link ' . $active . '" title="' . $sbjct . '" id="custom-tabs-' . $rsid . '-tab" data-toggle="pill" href="#custom-tabs-' . $rsid . '" role="tab" aria-controls="custom-tabs-' . $rsid . '" aria-selected="false">' . $grd_sctn . '</a>
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
                                        WHERE t5.schoolpersonnel_id=$spid AND t3.room_section_id=$rsid
                                        ORDER BY t3.sex DESC, t3.last_fullname");


            $a = '<div class="tab-pane fade show ' . $active . '" id="custom-tabs-' . $rsid . '" role="tabpanel" aria-labelledby="custom-tabs-' . $rsid . '-tab">
            <div class="row">
                <div class="col-12">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="http://localhost/SchoolMIS//dist/img/avatar1.jpg" alt="user image">
                            <span class="username">
                                <a href="#" class="personnel">' . $fn_advsry . ' - ' . $fn_advsry_ttl . '</a>
                            </span>
                            <span class="description">' . $advisory . '<b>' . $grd_sctn . '</b><small> <i>' . $sbjct . '</i> | <i>' . $schedule . '</i></small></span>
                            <!-- <span class="description">Class Advisory <b>Grade XII - ABCD</b> <small><i>ARTS</i> | <i>WD</i></small></span> -->
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-hover table-striped" id="tblAllGradesList' . $rsid . '" width="100%">
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
}
