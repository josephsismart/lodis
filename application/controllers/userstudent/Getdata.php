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

    function getGradesList()
    {
        $data = ["data" => []];
        $rmsid = $this->session->schoolmis_login_rm_sec_id;
        $lrn = $this->session->schoolmis_login_lrn;
        $sy = $this->getOnLoad()["sy_id"];
        $v_grades = $this->getOnLoad()["v_grades"];
        $query = $this->db->query("SELECT t4.q1,t4.q2,t4.q3,t4.q4,t1.rm_sctn_sbjct_assgnmnt_id,t2.enrollment_id,t1.subject,t1.subject_abbr,t1.schedule,t1.advisory,t1.full_name,t1.personal_title,t1.parent_party_id FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                    LEFT JOIN building_sectioning.view_enrollment$sy t2 ON t1.room_section_id=t2.room_section_id AND t1.schl_yr_id=t2.schl_yr_id
                                    LEFT JOIN(
                                            SELECT t1.*,q1.grade q1,q2.grade q2,q3.grade q3,q4.grade q4 FROM (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id
                                            FROM building_sectioning.tbl_learner_grades$sy t1
                                            GROUP BY t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id) t1
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 
                                                LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=1 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                WHERE t1.sy_id=1 AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 
                                                LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=2 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                WHERE t1.sy_id=1 AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 
                                                LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=3 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                WHERE t1.sy_id=1 AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                                            LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, CASE WHEN t2.rssa_id IS NULL THEN 0 ELSE t1.grade END AS grade
                                                FROM building_sectioning.tbl_learner_grades$sy t1 
                                                LEFT JOIN(SELECT rssa_id FROM building_sectioning.tbl_learner_grades_stat$sy WHERE sy_id=$sy AND qrtr=4 AND is_active=true AND status_id=18) t2 ON t1.rm_sctn_sbjct_assgnmnt_id=t2.rssa_id
                                                WHERE t1.sy_id=1 AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id
                                        ) t4 ON t2.enrollment_id=t4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id=t4.rm_sctn_sbjct_assgnmnt_id
                                    LEFT JOIN building_sectioning.view_room_section t5 ON t1.rm_sctn_sbjct_assgnmnt_id=t5.rm_sctn_sbjct_assgnmnt_id
                                    WHERE t1.room_section_id=$rmsid AND t2.lrn ='$lrn' AND t1.schl_yr_id=$sy
                                    ORDER BY t1.order_by_sbjct");

        foreach ($query->result() as $key => $value) {
            $p = $value->parent_party_id;
            $t = ($p ? '&emsp;' : null);
            $q1 = $value->q1;
            $q2 = $value->q2;
            $q3 = $value->q3;
            $q4 = $value->q4;
            if ($value->full_name) {
                $data["data"][] = [
                    "<h6>$t $value->subject</h6>
                        <viewdetails class='view_details' style='display:none;'>
                            " . $t . "<small class='text-xs " . ($value->advisory == 't' ? 'text-success' : '') . "'><i class='fa fa-caret-right'></i> $value->full_name</small>
                        <viewdetails/>",
                    "<p class='text-center mb-n2'>" . ($v_grades == 't' ? $this->gradeColor($q1) : '-') . "</p>",
                    "<p class='text-center mb-n2'>" . ($v_grades == 't' ? $this->gradeColor($q2) : '-') . "</p>",
                    "<p class='text-center mb-n2'>" . ($v_grades == 't' ? $this->gradeColor($q3) : '-') . "</p>",
                    "<p class='text-center mb-n2'>" . ($v_grades == 't' ? $this->gradeColor($q4) : '-') . "</p>",
                    "<p class='text-center mb-n2'>" . (!$p ? $this->gradeColor($this->avg4($q1, $q2, $q3, $q4)) : '') . "</p>",
                    "<p class='text-center mb-n2'>-</p>",
                ];
            }
        }
        echo json_encode($data);
    }
}
