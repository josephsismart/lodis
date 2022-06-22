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
        $data = ["thead" => [], "thead2" => [], "tbody" => []];
        $rsid = $this->input->post("rsid");
        $thead = [];
        $thead2 = [];
        $tbody = [];

        $qar = ["q1" => []];
        $qar1 = 0;
        $cc = 1;
        $ccc = 1;
        $rssaid = 0;
        $sy = $this->getOnLoad()["sy_id"];
        $queryHead = $this->db->query("SELECT t1.rm_sctn_sbjct_assgnmnt_id,t1.subject_abbr,t1.subject,t1.subject_id,t1.full_name,
        t1.personal_title,t1.advisory,t1.schedule,t1.grade,t1.sctn_nm,t1.parent_party_id,
        t2.parent,t1.color FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                    LEFT JOIN (SELECT t1.parent_party_id AS parent FROM global.tbl_party t1
                                                WHERE t1.parent_party_id IS NOT NULL
                                                GROUP BY t1.parent_party_id) t2 ON t1.subject_id = t2.parent
                                    WHERE t1.room_section_id=$rsid AND t1.schl_yr_id=$sy AND t1.full_name IS NOT NULL 
                                    ORDER BY t1.order_by_sbjct");
        $thead[] = ["<td width='1' rowspan='2'>Learner</td>"];
        foreach ($queryHead->result() as $key => $value) {
            $qar1 = 0;
            $color = $value->color;
            $stc = 'background-color:' . $color;
            $thead[] = [
                "<td colspan='5' style='" . $stc . ";'>" . $value->subject_abbr . "</td>"
            ];
            $thead2[] = [
                "<td>Q1</td><td>Q2</td><td>Q3</td><td>Q4</td><td style='" . $stc . ";'>FG</td>"
            ];
            $rssaid = $value->rm_sctn_sbjct_assgnmnt_id;

            $queryBody = $this->db->query("SELECT t2.last_fullname,t2.enrollment_id
                                            FROM building_sectioning.view_enrollment1 t2
                                            WHERE t2.room_section_id=$rsid
                                            ");
            if (empty($tbody)) {
                foreach ($queryBody->result() as $key => $value2) {
                    $tbody[] = [
                        "<tr id='" . $value2->enrollment_id . "'><td align='left'>" . $cc++ . " " . $value2->last_fullname . "</td></tr>"
                    ];
                }
            }

            $queryBody2 = $this->db->query("SELECT t1.enrollment_id,t1.full_name,t2.q1,t2.q2,t2.q3,t2.q4 FROM building_sectioning.view_enrollment1 t1
                                            LEFT JOIN(SELECT t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id, 
                                                        SUM(t1.q1) AS q1,SUM(t1.q2) AS q2,SUM(t1.q3) AS q3,SUM(t1.q4) AS q4 from(
                                                        SELECT t1.id,t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id,
                                                        CASE WHEN(t1.qrtr_id=1)THEN t1.grade ELSE NULL END AS q1,
                                                        CASE WHEN(t1.qrtr_id=2)THEN t1.grade ELSE NULL END AS q2,
                                                        CASE WHEN(t1.qrtr_id=3)THEN t1.grade ELSE NULL END AS q3,
                                                        CASE WHEN(t1.qrtr_id=4)THEN t1.grade ELSE NULL END AS q4
                                                        FROM building_sectioning.tbl_learner_grades1 t1
                                                        )AS t1 
                                                        WHERE t1.rm_sctn_sbjct_assgnmnt_id=$rssaid
                                                        GROUP BY t1.learner_enrollment_id,t1.rm_sctn_sbjct_assgnmnt_id) t2 ON t1.enrollment_id=t2.learner_enrollment_id
                                                        WHERE t1.room_section_id = $rsid
                                                        ");
            foreach ($queryBody2->result() as $key => $value3) {
                $eid = $value3->enrollment_id;
                $q1 = $this->returnZero($value3->q1);
                $q2 = $this->returnZero($value3->q2);
                $q3 = $this->returnZero($value3->q3);
                $q4 = $this->returnZero($value3->q4);
                $avg = round(($q1 + $q2 + $q3 + $q4) / 4, 0);

                // $zz 
                $qar1 += $q1;

                // $qar[] = ["q1" . $eid => $qar1];

                $tbody[] = [
                    "<script>
                        $('#tblReportConsoGrades #" . $eid . "').append('<td width=" . 1 . " align=" . 'center' . ">" . $this->returnDDashed($q1) . "</td>'+
                                                                        '<td width=" . 1 . " align=" . 'center' . ">" . $this->returnDDashed($q2) . "</td>'+
                                                                        '<td width=" . 1 . " align=" . 'center' . ">" . $this->returnDDashed($q3) . "</td>'+
                                                                        '<td width=" . 1 . " align=" . 'center' . ">" . $this->returnDDashed($q4) . "</td>'+
                                                                        '<td width=" . 1 . " align=" . 'center' . " style=" . $stc . ">" . $this->returnDDashed($avg) . "</td>')
                    </script>"
                ];
            }
        }

        // $thead[] = [
        //     "<td colspan='8' width='1'>QUARTER AVE. & RANK</td>" .
        //         "<td rowspan='2' width='1'>GEN. AV.</td>" .
        //         "<td rowspan='2' width='1'>FINAL RANK</td>"
        // ];
        // $thead2[] = [
        //     "<td>Q1</td><td>R1</td>" .
        //         "<td>Q2</td><td>R2</td>" .
        //         "<td>Q3</td><td>R3</td>" .
        //         "<td>Q4</td><td>R4</td>"
        // ];
        // for ($i = 0; count($qar); $i++) {
        //     $tbody[] = [
        //         "<script>
        //         $('#tblReportConsoGrades #" . $eid . "').append('<td width=" . 1 . " align=" . 'center' . ">" . $this->returnDDashed($q1) . "</td>)
        //     </script>"
        //     ];
        // }

        $data["thead"] = $thead;
        $data["thead2"] = $thead2;
        $data["tbody"] = $tbody;

        echo json_encode($data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */