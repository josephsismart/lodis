<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{

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
        $uri = $this->session->schoolmis_login_uri;
        $page_data += [
            "page_title"        => "Report",
            "current_location"  => "report",
            "content"           =>  [$this->load->view('interface/' . $uri . '/Report', [], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function getReportConsoGrades()
    {
        $data = ["thead" => [], "tbody" => []];
        $rsid = $this->input->post("rsid");
        $thead = [];
        $tbody = [];
        $cc = 1;
        $ccc = 1;
        // $rsid = 217;
        $rssaid = 0;
        // $rssaid = $this->input->post("rssaid");
        $sy = $this->getOnLoad()["sy_id"];
        $queryHead = $this->db->query("SELECT t1.rm_sctn_sbjct_assgnmnt_id,t1.subject_abbr,t1.subject,t1.subject_id,t1.full_name,
        t1.personal_title,t1.advisory,t1.schedule,t1.grade,t1.sctn_nm,t1.parent_party_id,
        t2.parent FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                    LEFT JOIN (SELECT t1.parent_party_id AS parent FROM global.tbl_party t1
                                                WHERE t1.parent_party_id IS NOT NULL
                                                GROUP BY t1.parent_party_id) t2 ON t1.subject_id = t2.parent
                                    WHERE t1.room_section_id=$rsid AND t1.schl_yr_id=$sy AND t1.full_name IS NOT NULL 
                                    ORDER BY t1.order_by_sbjct LIMIT 1");
        $thead[] = ["<td>Learner</td>"];
        foreach ($queryHead->result() as $key => $value) {
            $thead[] = [
                "<td colspan='4'>" . $value->subject_abbr . "</td>"
            ];
            $rssaid = $value->rm_sctn_sbjct_assgnmnt_id;

            $queryBody = $this->db->query("SELECT t1.learner_enrollment_id,t1.last_fullname,t1.rm_sctn_sbjct_assgnmnt_id, 
            SUM(t1.q1) AS q1,SUM(t1.q2) AS q2,SUM(t1.q3) AS q3,SUM(t1.q4) AS q4 from(
            SELECT t1.id,t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id,t2.last_fullname,
            CASE WHEN(t1.qrtr_id=1)THEN t1.grade ELSE NULL END AS q1,
            CASE WHEN(t1.qrtr_id=2)THEN t1.grade ELSE NULL END AS q2,
            CASE WHEN(t1.qrtr_id=3)THEN t1.grade ELSE NULL END AS q3,
            CASE WHEN(t1.qrtr_id=4)THEN t1.grade ELSE NULL END AS q4
            FROM building_sectioning.tbl_learner_grades1 t1
            LEFT JOIN building_sectioning.view_enrollment1 t2 ON t1.learner_enrollment_id=t2.enrollment_id
            )AS t1 
            WHERE t1.rm_sctn_sbjct_assgnmnt_id=220
            GROUP BY t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id,t1.last_fullname");
            foreach ($queryBody->result() as $key => $value2) {
                $tbody[] = [
                    "<tr><td>" . $value2->last_fullname . "</td>".
                    "<td>" . $value2->q1 . "</td><td>" . $value2->q2 . "</td><td>" . $value2->q3 . "</td><td>" . $value2->q4 . "</td>".
                    "</tr>"
                ];
            }
        }
        $data["thead"] = $thead;
        $data["tbody"] = $tbody;

        //     SELECT t1.*,t2.parent FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
        //                                 LEFT JOIN (SELECT t1.parent_party_id AS parent FROM global.tbl_party t1
        //                                                         WHERE t1.parent_party_id IS NOT NULL
        //                                                         GROUP BY t1.parent_party_id) t2 ON t1.subject_id = t2.parent
        //                                                         WHERE t1.room_section_id=24 AND t1.schl_yr_id=1 AND t1.full_name IS NOT NULL ORDER BY t1.order_by_sbjct



        //                                                         SELECT t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id, 
        // SUM(t1.q1) AS q1,SUM(t1.q2) AS q2,SUM(t1.q3) AS q3,SUM(t1.q4) AS q4 from(
        // SELECT t1.id,t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id,
        // CASE WHEN(t1.qrtr_id=1)THEN t1.grade ELSE NULL END AS q1,
        // CASE WHEN(t1.qrtr_id=2)THEN t1.grade ELSE NULL END AS q2,
        // CASE WHEN(t1.qrtr_id=3)THEN t1.grade ELSE NULL END AS q3,
        // CASE WHEN(t1.qrtr_id=4)THEN t1.grade ELSE NULL END AS q4
        // FROM building_sectioning.tbl_learner_grades1 t1
        // )AS t1 
        // GROUP BY t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id

        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */