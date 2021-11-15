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
        $query = $this->db->query("SELECT t4.q1,t4.q2,t4.q3,t4.q4,t1.rm_sctn_sbjct_assgnmnt_id,t2.enrollment_id,t1.subject,t1.subject_abbr,t1.schedule,t1.advisory,t1.full_name,t1.personal_title FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                    LEFT JOIN building_sectioning.view_enrollment$sy t2 ON t1.room_section_id=t2.room_section_id AND t1.schl_yr_id=t2.schl_yr_id
                                    LEFT JOIN(
                                    SELECT t1.*,q1.grade q1,q2.grade q2,q3.grade q3,q4.grade q4 FROM (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id
                                    FROM building_sectioning.tbl_learner_grades$sy t1
                                    GROUP BY t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id) t1
                                    LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=1)q1 ON t1.learner_enrollment_id =q1.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q1.rm_sctn_sbjct_assgnmnt_id
                                    LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=2)q2 ON t1.learner_enrollment_id =q2.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q2.rm_sctn_sbjct_assgnmnt_id
                                    LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=3)q3 ON t1.learner_enrollment_id =q3.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q3.rm_sctn_sbjct_assgnmnt_id
                                    LEFT JOIN (SELECT t1.learner_enrollment_id, t1.rm_sctn_sbjct_assgnmnt_id, t1.grade
                                    FROM building_sectioning.tbl_learner_grades$sy t1 where t1.sy_id=1 AND t1.qrtr_id=4)q4 ON t1.learner_enrollment_id =q4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id =q4.rm_sctn_sbjct_assgnmnt_id) t4 ON t2.enrollment_id=t4.learner_enrollment_id AND t1.rm_sctn_sbjct_assgnmnt_id=t4.rm_sctn_sbjct_assgnmnt_id
                                    WHERE t1.room_section_id=$rmsid AND t2.lrn ='$lrn' AND t1.schl_yr_id=$sy");

        foreach ($query->result() as $key => $value) {
            $data["data"][] = [
                $value->subject,
                $value->q1,
                $value->q2,
                $value->q3,
                $value->q4,
            ];
        }
        echo json_encode($data);
    }
}
