<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataentry extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->library('excel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    public function index()
    {
        $page_data = $this->system();
        $uri = $this->session->schoolmis_login_uri;
        $page_data += [
            "page_title"        => "Dataentry",
            "current_location"  => "dataentry",
            "content"           =>  [$this->load->view('interface/' . $uri . '/Dataentry', [
                "getOnLoad" => $this->getOnLoad(),
            ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function saveSearchBatchEnroll()
    {
        $this->db->trans_begin();
        $data = [];
        parse_str($this->input->post("c"), $filter);
        $sy = $this->getOnLoad()["sy_id"];
        $rsid = $this->input->post("d");
        $learner_id = $filter['searchEnrollCheckBox'];
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];

        for ($i = 0; $i < count($learner_id); $i++) {
            $data[] = [
                'learner_id' => (int)$learner_id[$i],
                'room_section_id' => $rsid,
                'status_id' => 5,
                'enrollment_date' => $dateNow,
                'added_by' => $login_id,
            ];
        }
        $b = json_encode($data);
        if (count($data) > 0 && $login_id) {
            if ($this->db->insert_batch("building_sectioning.tbl_learner_enrollment$sy", $data)) {
                $this->userlog("INSERTED NEW ENROLLMENT: " . $b);
                $ret = $true;
            }
        } else {
            $ret = $false;
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        echo json_encode($ret);
    }

    function saveEnrollmentInfo()
    {
        $this->db->trans_begin();
        $data = [];
        $sy = $this->getOnLoad()["sy_id"];

        $id = null;
        $lrn = $this->input->post("lrn");
        $rsId = $this->input->post("rsId");
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $extName = strtoupper($this->input->post("extName"));
        $sex = $this->input->post("sex");
        $birthdate = $this->input->post("birthdate");
        $brgy = $this->input->post("brgy");
        $homeAddress = strtoupper($this->input->post("homeAddress"));
        $enrollDate = $this->input->post("enrollDate");

        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];

        $data = [
            "first_name" => $firstName,
            "middle_name" => $middleName,
            "last_name" => $lastName,
            "suffix" => $extName,
            "sex" => $sex,
            "birthdate" => $birthdate,
            "address_info" => $homeAddress,
            "barangay_id" => $brgy,
            // "purok_id" => $prk != "" ? $prk : null,
            // "address_info" => $homeAddress,
            // "email_address" => $emailAddress,
            $id ? "updated_by" : "added_by" => $login_id,
            $id ? "date_updated" : "date_added" => $dateNow,
        ];
        // if ($id && $lrn && $firstName && $lastName && $sex && $birthdate && $brgy && $login_id) {
        //     if (!$this->mainModel->update("profile.tbl_basicinfo", $data, "id", $id)) {
        //         // $this->userlog("UPDATED MEMBER/USER PERSON ".$partyType." ".$firstName.$middleName.$lastName);
        //         $ret = $true;
        //     }else{
        //         $ret = $false;
        //     }
        // } else 

        if ($lrn && $firstName && $lastName && $sex && $birthdate && $brgy && $login_id) {
            if ($this->db->insert("profile.tbl_basicinfo", $data)) {
                $inid = $this->db->insert_id();
                $data2 = [
                    "lrn" => $lrn,
                    "basic_info_id" => $inid,
                ];
                $this->userlog("INSERTED STUDENT DETAILS " . $inid . " " . json_encode($data));
                if ($inid) {
                    if ($this->db->insert("profile.tbl_learners", $data2)) {
                        $lrnId = $this->db->insert_id();
                        $this->userlog("CREATED LRN FOR STUDENT " . $lrnId . " " . json_encode($data2));
                        $data3 = [
                            "learner_id" => $lrnId,
                            "room_section_id" => $rsId,
                            "status_id" => 5,
                            "enrollment_date" => $enrollDate,
                            "added_by" => $login_id,
                        ];
                        if ($lrnId) {
                            if ($this->db->insert("building_sectioning.tbl_learner_enrollment$sy", $data3)) {
                                $this->userlog("ENROLLED STUDENT " . $lrnId . " " . json_encode($data3));
                                $ret = $true;
                            } else {
                                $ret = $false;
                            }
                        } else {
                            $ret = $false;
                        }
                    } else {
                        $ret = $false;
                    }
                } else {
                    $ret = $false;
                }
            }
        } else {
            $ret = $false;
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode($ret);
    }

    function saveImportEnrollmentInfo()
    {
        $this->db->trans_begin();
        $rsid = $this->input->post("rsid");
        $basicInfoData = [];
        $learnerData = [];
        $enrollmentData = [];
        $true = ["success"   => true];
        $false = ["success"   => false];
        $sy = $this->getOnLoad()["sy_id"];
        $login_id = $this->session->schoolmis_login_id;
        $basicInfoId = null;
        $learnerId = null;

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 7; $row <= $highestRow; $row++) {
                    //BASIC INFORMATION
                    $LRN = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    if (is_numeric($LRN) && strlen($LRN) > 5) {
                        //LEARNER
                        $full_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $name = $full_name ? explode(",", $full_name) : null;
                        $lname = $name && !empty($name[0]) ? strtoupper(trim($name[0])) : null;
                        $fname = $name && !empty($name[1]) ? strtoupper(trim($name[1])) : null;
                        $mname = $name && !empty($name[2]) ? strtoupper(trim($name[2])) : null;

                        $sex = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $bdate = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $homeAddress = $worksheet->getCellByColumnAndRow(15, $row)->getValue();

                        //OTHER DETAILS
                        $mt = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $ip = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $rlgn = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        //Father
                        $father_name = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                        $f_name = $father_name ? explode(",", $father_name) : null;
                        $flname = $f_name && !empty($f_name[0]) ? strtoupper(trim($f_name[0])) : null;
                        $ffname = $f_name && !empty($f_name[1]) ? strtoupper(trim($f_name[1])) : null;
                        $fmname = $f_name && !empty($f_name[2]) ? strtoupper(trim($f_name[2])) : null;
                        //MOTHER
                        $mother_name = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                        $m_name = $mother_name ? explode(",", $mother_name) : null;
                        $mlname = $m_name && !empty($m_name[0]) ? strtoupper(trim($m_name[0])) : null;
                        $mfname = $m_name && !empty($m_name[1]) ? strtoupper(trim($m_name[1])) : null;
                        $mmname = $m_name && !empty($m_name[2]) ? strtoupper(trim($m_name[2])) : null;

                        $g_name = $worksheet->getCellByColumnAndRow(36, $row)->getValue();
                        $rltn = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
                        $cntct = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                        $module = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                        $rmrks = $worksheet->getCellByColumnAndRow(44, $row)->getValue();

                        // echo " BDATE: " . $bdate;

                        $birthdate = $bdate ? DateTime::createFromFormat('m-d-Y', $bdate)->format('Y-m-d') : null;
                        // echo " STRTOTIME: " . $stringtoTime;
                        // $birthdate = $bdate ? date('Y-m-d', $stringtoTime) : null;
                        // echo " BIRTHDATE: " . $birthdate;
                        // $ymd = DateTime::createFromFormat('m-d-Y', $bdate)->format('Y-m-d');
                        // echo " BIRTHDATE: " . $birthdate;
                        $boolSex = $sex == 'M' ? true : ($sex == 'F' ? false : null);


                        if ($LRN && $fname && $lname && $bdate && $sex) {
                            $checkLearner = $this->learnerChecker($LRN, null);

                            // echo $a;
                            if ($checkLearner) { //IF LEARNER EXIST IN TBL_LEARNER
                                $checkEnrollemnt = $this->enrollmentChecker($checkLearner);
                                if ($checkEnrollemnt) { //IF LEARNER EXIST IN TBL_ENROLLMENT THEN DO NOTHING
                                    $ret = $false;
                                } else {
                                    $enrollmentData[] = [
                                        "learner_id" => $checkLearner,
                                        "room_section_id" => $rsid,
                                        "status_id" => 5,
                                        "added_by" => $login_id,
                                    ];
                                }
                            } else {
                                // echo "b";

                                $checkBasicInfo = $this->basicInfoChecker($fname, $mname, $lname, $birthdate, $boolSex);
                                if (!$checkBasicInfo) { //IF BASIC INFORMATION NOT EXIST
                                    // echo "c";
                                    $basicInfoData = [
                                        "first_name" => $fname,
                                        "middle_name" => $mname,
                                        "last_name" => $lname,
                                        "birthdate" => $birthdate,
                                        "sex" => $boolSex,
                                        "barangay_id" => 160202054, //$barangay,
                                        "address_info" => $homeAddress,
                                    ];
                                    $basicInfoDataLOG = json_encode($basicInfoData);
                                    if ($this->db->insert("profile.tbl_basicinfo", $basicInfoData)) { //INSERT TO TBL_BASICNFO FOR NEW RECORD
                                        $basicInfoId = $this->db->insert_id();
                                        $this->userlog("INERTED NEW BASIC INFO FROM EXCEL FILE" . $basicInfoDataLOG);
                                        $ret = $true;
                                        // echo "d";
                                        // echo $basicInfoId;
                                        if ($basicInfoId) { //IF THE VALUE OF BASICINO ID HAS DATA THEN PREPARATION FOR A NEW LEARNER
                                            $learnerData = [
                                                "lrn" => $LRN,
                                                "basic_info_id" => $basicInfoId,
                                                "ffirst_name" => $ffname,
                                                "fmiddle_name" => $fmname,
                                                "flast_name" => $flname,
                                                "mfirst_name" => $mfname,
                                                "mmiddle_name" => $mmname,
                                                "mlast_name" => $mlname,
                                                "guardian" => $g_name,
                                                "relation" => $rltn,
                                                "contact_num" => $cntct,
                                                "mother_tongue_txt" => $mt,
                                                "ip_ethnic_group_txt" => $ip,
                                                "religion_txt" => $rlgn,
                                                "learning_modality_txt" => $module,
                                                "remarks" => $rmrks,
                                            ];
                                            $learnerDataLOG = json_encode($learnerData);
                                            if ($this->db->insert("profile.tbl_learners", $learnerData)) {
                                                $learnerId = $this->db->insert_id();
                                                $this->userlog("INSERTED NEW LEARNER FROM EXCEL FILE" . $learnerDataLOG);
                                                $ret = $true;
                                                if ($learnerId) {
                                                    $enrollmentData[] = [
                                                        "learner_id" => $learnerId,
                                                        "room_section_id" => $rsid,
                                                        "status_id" => 5,
                                                        "added_by" => $login_id,
                                                    ];
                                                }
                                            }
                                        }
                                    } else {
                                        $ret = $false;
                                    }
                                } else {
                                    $checkLearnerId = $this->learnerChecker(null, $checkBasicInfo);
                                    if ($checkLearnerId) {
                                        $checkEnrollemnt = $this->enrollmentChecker($checkLearnerId);
                                        if ($checkEnrollemnt) { //IF LEARNER EXIST IN TBL_ENROLLMENT THEN DO NOTHING
                                            $ret = $false;
                                        } else {
                                            $enrollmentData[] = [
                                                "learner_id" => $checkLearner,
                                                "room_section_id" => $rsid,
                                                "status_id" => 5,
                                                "added_by" => $login_id,
                                            ];
                                        }
                                    }
                                }
                            }
                        } else {
                            $ret = $false;
                        }
                    }
                }
            }

            if (count($enrollmentData) > 0 && $login_id) {
                $enrollmentDataLOG = json_encode($enrollmentData);
                if ($this->db->insert_batch("building_sectioning.tbl_learner_enrollment$sy", $enrollmentData)) {
                    $this->userlog("INSERTED NEW ENROLLEE FROM EXCEL FILE" . $enrollmentDataLOG);
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            $ret = $false;
        }
        echo json_encode($ret);
    }

    function saveGradesList()
    {
        $this->db->trans_begin();
        $true = ["success"   => true];
        $false = ["success"   => false];
        if ($this->getOnLoad()["grade_stat"] == 1) {
            $data = [];
            $sy = $this->getOnLoad()["sy_id"];
            $sy_insert = (int)$sy;

            $en_id = $this->input->post("en_id");
            $rm_sec_id = $this->input->post("rm_sec_id");
            $rssaid = $this->input->post("rssaid");
            $qrtr = $this->getOnLoad()["qrtr"];
            $gradeLearner = $this->input->post("gradeLearner");
            $tmpGrade = 0;

            $login_id = $this->session->schoolmis_login_id;
            $dateNow = $this->now();
            $ret = $true;
            for ($i = 0; $i < count($en_id); $i++) {
                $en = $en_id[$i];
                $rm = $rm_sec_id[$i];
                $rssaid1 = $rssaid[$i];
                $grades = $this->returnNull($gradeLearner[$i]);
                $search = $this->db->query("SELECT t1.* FROM building_sectioning.tbl_learner_grades$sy t1
                                        WHERE t1.learner_enrollment_id=$en AND t1.rm_sctn_sbjct_assgnmnt_id=$rssaid1 
                                        AND t1.qrtr_id=$qrtr AND t1.sy_id=$sy");
                $srow = $search->row();

                if ($search->num_rows() > 0) {
                    $tmpId = $srow->id;
                    $tmpGrade = $srow->grade;
                    if ($grades == $tmpGrade) {
                    } else {
                        $update_data = array(
                            'grade' => $grades,
                            'date_updated' => $dateNow,
                            'updated_by' => $login_id
                        );

                        // $this->db->where('learner_enrollment_id', $en);
                        // $this->db->where('room_section_id', $rm);
                        // $this->db->where('qrtr_id', $qrtr);
                        // $this->db->where('sy_id', $sy);
                        $this->db->where('id', $tmpId);
                        if ($this->db->update("building_sectioning.tbl_learner_grades$sy", $update_data)) {
                            $ret = $true;
                        } else {
                            $ret = $false;
                        }
                    }
                } else {
                    $data[] = [
                        'learner_enrollment_id' => $en,
                        'rm_sctn_sbjct_assgnmnt_id' => $rssaid1,
                        'qrtr_id' => $qrtr,
                        'grade' => $grades,
                        'date_added' => $dateNow,
                        'added_by' => $login_id,
                        'status_id' => 1,
                        'sy_id' => $sy_insert,
                    ];
                }
            }
            $b = json_encode($data);
            if (count($data) > 0 && $login_id) {
                if ($this->db->insert_batch("building_sectioning.tbl_learner_grades$sy", $data)) {
                    $this->userlog("INSERTED GRADES: " . $b);
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            $ret = $false;
        }

        echo json_encode($ret);
    }

    function learnerAccount()
    {

        $this->db->trans_begin();
        $uuid = $this->input->post("a");
        $b = $this->input->post("b");
        $sy = $this->getOnLoad()["sy_id"];
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];
        $query = $this->db->query("SELECT t1.basic_info_id, t1.lrn FROM building_sectioning.view_enrollment$sy t1
                                    WHERE t1.person_uuid='$uuid'");
        $row = $query->row();
        if ($query->num_rows() > 0) {
            $data = [
                "basic_info_id" => $row->basic_info_id,
                "role_id" => 8,
                "username" => $row->lrn,
                "password" => md5(1),
                "change_pwd" => false,
                "is_active" => true,
                "added_by" => $login_id,
                "date_added" => $dateNow,
            ];

            if (count($data) > 0 && $b == 0 && $login_id) {
                if ($this->db->insert("account.tbl_useraccount", $data)) {
                    $inid = $this->db->insert_id();
                    $this->userlog("CREATED NEW STUDENT ACCOUNT " . $inid . " " . json_encode($data));
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            } else if (count($data) > 0 && $b == 1 && $login_id) {
                $update_data = array(
                    'password' => md5(2),
                    'date_updated' => $dateNow,
                    'updated_by' => $login_id
                );
                $this->db->where('username', $row->lrn);
                if ($this->db->update("account.tbl_useraccount", $update_data)) {
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            } else {
                $ret = $false;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } else {
            $ret = $false;
        }

        echo json_encode($ret);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */