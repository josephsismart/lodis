<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataentry extends MY_Controller
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
            "page_title"        => "Dataentry",
            "current_location"  => "dataentry",
            "content"           =>  [$this->load->view('interface/' . $uri . '/Dataentry', [
                "getOnLoad" => $this->getOnLoad(),
            ], TRUE)]
        ];
        $this->public_create_page($page_data);
    }

    function savePersonnelInfo()
    {
        $this->db->trans_begin();
        $id = $this->input->post("personId");
        $firstName = strtoupper($this->input->post("firstName"));
        $middleName = strtoupper($this->input->post("middleName"));
        $lastName = strtoupper($this->input->post("lastName"));
        $extName = strtoupper($this->input->post("extName"));
        $sex = $this->input->post("sex");
        $birthdate = $this->input->post("birthdate");
        $brgy = $this->input->post("brgy");
        // $prk = $this->input->post("prk");
        $homeAddress = strtoupper($this->input->post("homeAddress"));
        // $emailAddress = $this->input->post("emailAddress");
        // $genAcc = $this->input->post("createAccount");
        // $createAccount = $genAcc!=""||$genAcc!=null?1:0;

        $emptype = $this->input->post("emptype");
        $personaltitle = $this->input->post("personaltitle");
        $empstatus = $this->input->post("empstatus");
        $login_id = $this->session->schoolmis_login_id;
        $inid = null;
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
        if ($id && $firstName && $lastName && $homeAddress && $sex && $birthdate && $brgy && $login_id) {
            if (!$this->mainModel->update("profile.tbl_basicinfo", $data, "id", $id)) {
                // $this->userlog("UPDATED MEMBER/USER PERSON ".$partyType." ".$firstName.$middleName.$lastName);
                $ret = $true;
            }
        } else if ($firstName && $lastName && $homeAddress && $sex && $birthdate && $brgy && $login_id) {
            if ($this->db->insert("profile.tbl_basicinfo", $data)) {
                $inid = $this->db->insert_id();
                $data2 = [
                    "school_id" => $this->session->schoolmis_login_school_id,
                    "employee_type_id" => $emptype,
                    "basic_info_id" => $inid,
                    "personal_title_id" => $personaltitle,
                    "status_id" => $empstatus,
                ];
                $this->userlog("INSERTED MEMBER/USER PERSON " . $inid . " " . json_encode($data));
                if ($inid) {
                    if ($this->db->insert("profile.tbl_schoolpersonnel", $data2)) {
                        $this->userlog("INSERTED SCHOOL PERSON " . $inid . " " . json_encode($data2));
                        $ret = $true;
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

    function savePersonnelAccount()
    {
        $this->db->trans_begin();
        $pid = $this->input->post("basicInfoId");
        $spid = $this->input->post("personId");
        $deptId = $this->input->post("department");
        $role = $this->input->post("role");
        $email = $this->input->post("email");
        $pwd = $this->input->post("pwd");
        $pw = md5(12345678);
        $confirmpwd = $this->input->post("confirmpwd");
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];


        // $confirmpwd $pwd
        $exist = $this->db->query("SELECT * FROM account.tbl_useraccount t1 WHERE t1.username='$email'");
        if ($exist->num_rows() == 0) {
            if ($confirmpwd && $pwd) {
                if ((strlen($pwd) > 7 || strlen($confirmpwd) > 7) && ($pwd == $confirmpwd)) {
                    $pw = md5($pwd);
                }
            }
            $data = [
                "basic_info_id" => $pid,
                "role_id" => $role,
                "username" => $email,
                "password" => $pw,
                "change_pwd" => $pw == md5(12345678) ? true : false,
                "is_active" => true,
                // $id ? "updated_by" : "added_by" => $login_id,
                // $id ? "date_updated" : "date_added" => $dateNow,
                "added_by" => $login_id,
                "date_added" => $dateNow,
            ];

            if ($pid && $role && $email) {
                if ($this->db->insert("account.tbl_useraccount", $data)) {
                    $inid = $this->db->insert_id();
                    $this->userlog("CREATED NEW ACCOUNT " . $inid . " " . json_encode($data));
                    $ret = $true;
                    if ($role == 3) {
                        $data2 = [
                            "department_head_person_id" => $spid,
                            "updated_by" => $login_id,
                            "date_updated" => $dateNow,
                        ];
                        if ($inid) {
                            $this->db->where('id', $deptId);
                            if ($this->db->update("profile.tbl_school_department", $data2)) {
                                $ret = $true;
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
            $ret += [
                "exist"   => true,
                "message"   => "Username already exist!"
            ];
        }
        echo json_encode($ret);
    }


    function saveGradeSecInfo()
    {
        $this->db->trans_begin();
        $id = null;
        // $gradelevel = $this->input->post("gradelevel");
        $sy = $this->getOnLoad()["sy_id"];
        $grade = $this->input->post("grade");
        $sectionName = strtoupper($this->input->post("sectionName"));
        $sched = $this->input->post("sched");
        $login_id = $this->session->schoolmis_login_id;
        $true = ["success"   => true];
        $false = ["success"   => false];

        $data = [
            "room_id" => 1,
            "grd_lvl_id" => $grade,
            "schl_yr_id" => $sy,
            "sctn_nm" => $sectionName,
            "schedule_id" => $sched,
        ];
        if ($id && $grade && $sy && $sectionName && $sched && $login_id) {
            if (!$this->mainModel->update("building_sectioning.tbl_room_section", $data, "id", $id)) {
                // $this->userlog("UPDATED MEMBER/USER PERSON ".$partyType." ".$firstName.$middleName.$lastName);
                $ret = $true;
            }
        } else if ($grade && $sy && $sectionName && $sched && $login_id) {
            if ($this->db->insert("building_sectioning.tbl_room_section", $data)) {
                $this->userlog("INSERTED SECTION " . json_encode($data));
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
        echo json_encode($ret);
    }

    function saveGradeSubject()
    {
        $this->db->trans_begin();
        $data = [];
        $sy = $this->getOnLoad()["sy_id"];
        $gradelevel = $this->input->post("gradelevel");
        $sbjct = $this->input->post("subjectlist");
        $login_id = $this->session->schoolmis_login_id;
        $true = ["success"   => true];
        $false = ["success"   => false];

        for ($i = 0; $i < count($sbjct); $i++) {
            $sbject = $sbjct[$i];
            $search = $this->db->query("SELECT t1.*,t2.sbjct_cc FROM building_sectioning.view_subjectlist_grdlvl t1
                                        LEFT JOIN (SELECT t1.gradelvl_id,t1.subject_id, COUNT(1) sbjct_cc FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                                    WHERE t1.schl_yr_id=$sy AND t1.schoolpersonnel_id IS NOT NULL
                                                    GROUP BY t1.subject_id,t1.gradelvl_id) t2 ON t1.subject_id=t2.subject_id AND t1.gradelvl_id=t2.gradelvl_id
                                                    WHERE t1.gradelvl_id=$gradelevel AND t1.subject_id=$sbject AND t1.schl_yr_id=$sy");
            if ($search->num_rows() == 0) {
                $data[] = [
                    "gradelvl_id"  =>  $gradelevel,
                    "subject_id"  =>  $sbject,
                    "schl_yr_id"  =>  $sy,
                ];
            }
        }

        if (count($data) == 0) {
            $ret = $true;
        } else {
            $b = json_encode($data);
            if (count($data) > 0 && $login_id) {
                if ($this->db->insert_batch("building_sectioning.tbl_gradelvl_subject", $data)) {
                    $this->userlog("INSERTED GRADE LVL SUBJECTS: " . $b);
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode($ret);
    }

    function saveSbjctAssPrsnnl()
    {
        $this->db->trans_begin();
        $data = [];
        $valid = 0;
        $rmsecid = $this->input->post("rmsecid");
        $sbjct = $this->input->post("sbjct");
        $assignPerson = $this->input->post("schlpersonnel");
        $advisory = $this->input->post("advisory");
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];

        for ($i = 0; $i < count($sbjct); $i++) {
            $sbject = $sbjct[$i];
            $assprsn = $assignPerson[$i];
            $search = $this->db->query("SELECT t1.* FROM building_sectioning.tbl_room_section_subject_assignment t1
                                        WHERE t1.room_section_id=$rmsecid AND t1.subject_id=$sbject");
            $srow = $search->row();

            if ($search->num_rows() > 0) {
                $tmpId = $srow->id;
                $tmpassprsn = $srow->schl_personnel_id;
                if ($assprsn == $tmpassprsn) {
                } else {
                    $update_data = array(
                        'schl_personnel_id' => $assprsn,
                        'advisory' => $sbject == $advisory ? true : false,
                    );
                    $this->db->where('id', $tmpId);
                    if ($this->db->update("building_sectioning.tbl_room_section_subject_assignment", $update_data)) {
                        $ret = $true;
                    } else {
                        $ret = $false;
                    }
                }
                $update_data = array(
                    'advisory' => $sbject == $advisory ? true : false,
                );
                $this->db->where('id', $tmpId);
                if ($this->db->update("building_sectioning.tbl_room_section_subject_assignment", $update_data)) {
                    $ret = $true;
                } else {
                    $ret = $false;
                }
            } else {
                $data[] = [
                    'room_section_id' => $rmsecid,
                    'subject_id' => $sbject,
                    'schl_personnel_id' => $assprsn,
                    'advisory' => $sbject == $advisory ? true : false,
                ];
            }
        }
        $b = json_encode($data);
        if (count($data) > 0 && $login_id) {
            if ($this->db->insert_batch("building_sectioning.tbl_room_section_subject_assignment", $data)) {
                $this->userlog("INSERTED SUBJECT ASSIGNMENT: " . $b);
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

        echo json_encode($ret);
    }

    function saveSubject()
    {
        $this->db->trans_begin();
        $index = $this->input->post("index");
        $sbjctnm = $this->input->post("sbjctnm");
        $abbr = $this->input->post("abbr");
        $ordr = $this->input->post("ordr");
        $login_id = $this->session->schoolmis_login_id;
        $true = ["success"   => true];
        $false = ["success"   => false];

        $exist = $this->db->query("SELECT * FROM global.tbl_party t1 WHERE t1.description='$sbjctnm'");
        if ($exist->num_rows() == 0) {
            $data = [
                "party_type_id" => 17,
                "description" => $sbjctnm,
                "is_active" => true,
                "order_by" => $ordr,
                "abbr" => $abbr,
                "group_by" => 11,
            ];
            if ($index && $sbjctnm && $abbr && $ordr && $login_id) {
                if (!$this->mainModel->update("global.tbl_party", $data, "party_index", $index)) {
                    $this->userlog("UPDATED SUBJECT " . json_encode($data));
                    $ret = $true;
                }
            } else if ($sbjctnm && $abbr && $ordr && $login_id) {
                if ($this->db->insert("global.tbl_party", $data)) {
                    $this->userlog("INSERTED SUBJECT " . json_encode($data));
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
            $ret += [
                "exist"   => true,
                "message"   => "Subject Name already exist!"
            ];
        }
        echo json_encode($ret);
    }

    function saveSbjctAssPrsnnl1()
    {
        $this->db->trans_begin();
        $data = [];
        $valid = 0;
        $rm_sec_id = $this->input->post("rm_sec_id");
        $sbjct = $this->input->post("sbjct");
        echo 1;
        echo $rm_sec_id;
        echo $sbjct[1];
        $assignPerson = $this->input->post("schlpersonnel");
        $advisory = $this->input->post("advisory");
        $login_id = $this->session->schoolmis_login_id;
        $dateNow = $this->now();
        $true = ["success"   => true];
        $false = ["success"   => false];

        for ($i = 0; $i < count($sbjct); $i++) {
            if ($sbjct[$i] == 0 || $assignPerson[$i] == 0) {
                $valid++;
                break;
            } else {
                $data[] = [
                    'room_section_id' => $rm_sec_id,
                    'subject_id' => $sbjct[$i],
                    'schl_personnel_id' => $assignPerson[$i],
                    'advisory' => $sbjct[$i] == $advisory ? true : false,
                ];
            }
        }
        $b = json_encode($data);
        if ($valid == 0 && $login_id) {
            if ($this->db->insert_batch("building_sectioning.tbl_room_section_subject_assignment", $data)) {
                $this->userlog("INSERTED SUBJECT ASSIGNMENT: " . $b);
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

    function saveSYInfo()
    {
        $this->db->select_max('to', 'max');
        $query = $this->db->get('global.tbl_sy');
        $max = $query->row()->max;
        $from = $max;
        $to = $max + 1;
        $sy = $from . '-' . $to;
        $true = ["success"   => true];
        $false = ["success"   => false];

        $data1 = [
            "is_active" => false,
        ];
        $data2 = [
            "from" => $from,
            "to" => $to,
            "description" => $sy,
            "inclusive_month" => null,
        ];
        if (!$this->mainModel->update("global.tbl_sy", $data1, "is_active", true)) {
            if ($from && $to && $sy) {
                if ($this->db->insert("global.tbl_sy", $data2)) {
                    $inid = $this->db->insert_id();
                    if ($this->db->query("CREATE TABLE building_sectioning.tbl_learner_enrollment$inid (
                                            id bigint NOT NULL,
                                            learner_id bigint NOT NULL,
                                            room_section_id bigint NOT NULL,
                                            status_id bigint NOT NULL,
                                            enrollment_date timestamp(6) without time zone,
                                            added_by bigint
                                        );
                                        ALTER TABLE building_sectioning.tbl_learner_enrollment$inid OWNER TO postgres; 
                                        CREATE SEQUENCE building_sectioning.tbl_learner_enrollment_seq$inid
                                            START WITH 1
                                            INCREMENT BY 1
                                            NO MINVALUE
                                            NO MAXVALUE
                                            CACHE 1;
                                        ALTER TABLE building_sectioning.tbl_learner_enrollment_seq$inid OWNER TO postgres;
                                        ALTER SEQUENCE building_sectioning.tbl_learner_enrollment_seq$inid OWNED BY building_sectioning.tbl_learner_enrollment$inid.id;
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid ALTER COLUMN id SET DEFAULT nextval('building_sectioning.tbl_learner_enrollment_seq$inid'::regclass);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_learner_id_key UNIQUE (learner_id);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_pkey$inid PRIMARY KEY (id);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_added_by_fkey FOREIGN KEY (added_by) REFERENCES account.tbl_useraccount(id);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_learner_id_fkey FOREIGN KEY (learner_id) REFERENCES profile.tbl_learners(id);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_room_id_fkey FOREIGN KEY (room_section_id) REFERENCES building_sectioning.tbl_room_section(id);
                                        ALTER TABLE ONLY building_sectioning.tbl_learner_enrollment$inid
                                            ADD CONSTRAINT tbl_learner_enrollment_status_id_fkey FOREIGN KEY (status_id) REFERENCES global.tbl_status(id);





                                        -- CREATE TABLE building_sectioning.tbl_learner_grades$inid (
                                        --     id bigint NOT NULL,
                                        --     learner_enrollment_id bigint NOT NULL,
                                        --     room_sec_sub_ass_id bigint NOT NULL,
                                        --     qrtr_id integer NOT NULL,
                                        --     grade numeric(255,0) DEFAULT 0 NOT NULL,
                                        --     date_added timestamp without time zone DEFAULT now() NOT NULL,
                                        --     added_by bigint NOT NULL,
                                        --     date_updated timestamp without time zone,
                                        --     updated_by bigint,
                                        --     status_id integer NOT NULL
                                        -- );


                                        -- ALTER TABLE building_sectioning.tbl_learner_grades$inid OWNER TO postgres;

                                        
                                        -- ALTER TABLE building_sectioning.tbl_learner_grades_seq$inid OWNER TO postgres;
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid ALTER COLUMN id SET DEFAULT nextval('building_sectioning.tbl_learner_grades_seq$inid'::regclass);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_pkey$inid PRIMARY KEY (id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_added_by_fkey FOREIGN KEY (added_by) REFERENCES account.tbl_useraccount(id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_learner_id_fkey FOREIGN KEY (learner_enrollment_id) REFERENCES building_sectioning.tbl_learner_enrollment$inid(id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_qrtr_id_fkey FOREIGN KEY (qrtr_id) REFERENCES global.tbl_party(id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_status_id_fkey FOREIGN KEY (status_id) REFERENCES global.tbl_status(id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_subject_id_fkey FOREIGN KEY (room_sec_sub_ass_id) REFERENCES building_sectioning.tbl_room_section_subject_assignment(id);
                                        -- ALTER TABLE ONLY building_sectioning.tbl_learner_grades$inid
                                        --     ADD CONSTRAINT tbl_learner_grades_updated_by_fkey FOREIGN KEY (updated_by) REFERENCES account.tbl_useraccount(id);

                                        CREATE TABLE building_sectioning.tbl_learner_grades$inid (
                                            id bigint NOT NULL,
                                            learner_enrollment_id bigint NOT NULL,
                                            room_section_id bigint NOT NULL,
                                            qrtr_id integer NOT NULL,
                                            grade numeric(255) NULL DEFAULT 0,
                                            date_added timestamp without time zone DEFAULT now() NOT NULL,
                                            added_by bigint NOT NULL,
                                            date_updated timestamp NULL,
                                            updated_by bigint NULL,
                                            status_id integer NOT NULL,
                                            sy_id integer NOT NULL,
                                            CONSTRAINT tbl_learner_grades_pkey$inid PRIMARY KEY (id),
                                            CONSTRAINT tbl_learner_grades_sy_id_fkey$inid FOREIGN KEY (sy_id) REFERENCES global.tbl_sy(id),
                                            CONSTRAINT tbl_learner_grades_added_by_fkey$inid FOREIGN KEY (added_by) REFERENCES account.tbl_useraccount(id),
                                            CONSTRAINT tbl_learner_grades_learner_id_fkey$inid FOREIGN KEY (learner_enrollment_id) REFERENCES building_sectioning.tbl_learner_enrollment$inid(id),
                                            CONSTRAINT tbl_learner_grades_status_id_fkey$inid FOREIGN KEY (status_id) REFERENCES global.tbl_status(id),
                                            CONSTRAINT tbl_learner_grades_subject_id_fkey$inid FOREIGN KEY (room_section_id) REFERENCES building_sectioning.tbl_room_section(id),
                                            CONSTRAINT tbl_learner_grades_updated_by_fkey$inid FOREIGN KEY (updated_by) REFERENCES account.tbl_useraccount(id)
                                        );

                                        ALTER TABLE building_sectioning.tbl_learner_grades$inid OWNER TO postgres;

                                        CREATE SEQUENCE building_sectioning.tbl_learner_grades_seq$inid
                                            START WITH 1
                                            INCREMENT BY 1
                                            NO MINVALUE
                                            NO MAXVALUE
                                            CACHE 1;

                                        ALTER SEQUENCE building_sectioning.tbl_learner_grades_seq$inid OWNED BY building_sectioning.tbl_learner_grades$inid.id;

                                        CREATE OR REPLACE VIEW building_sectioning.view_enrollment$inid AS 
                                        SELECT t1.id AS enrollment_id,
                                        t1.room_section_id,
                                        t3.rm_sctn_sbjct_assgnmnt_id,
                                        t1.enrollment_date,
                                        t1.status_id,
                                        t4.description AS enrollment_status,
                                        t3.id AS rm_sec_id,
                                        t3.room_id,
                                        t3.grd_lvl_id,
                                        t3.schl_yr_id,
                                        t3.sctn_nm,
                                        t3.schedule_id,
                                        t3.is_active,
                                        t3.grade,
                                        t3.order_by,
                                        t3.sched,
                                        t3.sy,
                                        t2.learner_id,
                                        t2.lrn,
                                        t2.basic_info_id,
                                        t2.mother_tongue,
                                        t2.ethnic_group,
                                        t2.ffirst_name,
                                        t2.fmiddle_name,
                                        t2.flast_name,
                                        t2.mfirst_name,
                                        t2.mmiddle_name,
                                        t2.mlast_name,
                                        t2.guardian,
                                        t2.relation,
                                        t2.contact_num,
                                        t2.four_ps,
                                        t2.person_id,
                                        t2.person_uuid,
                                        t2.first_name,
                                        t2.middle_name,
                                        t2.last_name,
                                        t2.suffix,
                                        t2.birthdate,
                                        t2.sex_bool,
                                        t2.sex,
                                        t2.full_name,
                                        t2.last_fullname,
                                        t2.address_details,
                                        t2.address_info,
                                        t2.citymun_id,
                                        t2.citymun_name,
                                        t2.barangay_id,
                                        t2.barangay_name,
                                        t2.purok_id,
                                        t2.purok_name
                                    FROM (((building_sectioning.tbl_learner_enrollment$inid t1
                                        JOIN profile.view_learner t2 ON ((t1.learner_id = t2.learner_id)))
                                        JOIN building_sectioning.view_room_section t3 ON ((t1.room_section_id = t3.id)))
                                        JOIN global.tbl_status t4 ON ((t1.status_id = t4.id)));

                                        ")) {
                        $this->userlog("INSERTED AND ACTIVATED NEW SCHOOL YEAR " . json_encode($data2));
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

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        echo json_encode($ret);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */