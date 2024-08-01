<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  $uname = $_SESSION['login'];

  $conn = mysqli_query($con, "SELECT id, email from admin WHERE email = '$uname'");

  $numId = mysqli_fetch_assoc($conn);

  $cid = intval($_GET['id']); // get case id

  $sql = mysqli_query($con, "SELECT
                            pci.id,
                            pci.patient_id,
                            pci.case_id,
                            pci.hospital_id,
                            pci.doctor_id,
                            pci.treatment_name,
                            pci.attendant_name,
                            pci.relationship_with_insured,
                            pci.estimated_amount,
                            pci.expected_doa,
                            pci.created_at,
                            pci.status,
                            h.id AS hospital_id,
                            h.name AS hospital_name,
                            d.id,
                            d.first_name AS doctor_first_name,
                            d.last_name AS doctor_last_name,
                            pld.primary_card_holder_name,
                            pld.cibil_score,
                            pld.is_eligible,
                            pld.pan_number,
                            pld.is_patient_counseled,
                            pld.cibil_approval_doc,
                            pld.pan_card_copy,
                            pld.userremark,
                            pbd.bank_name,
                            pbd.account_number,
                            pbd.ifsc_code,
                            pbd.bank_details_documents,
                            pid.policy_number, 
                            pid.policy_start_date,
                            pid.policy_end_date, 
                            pid.insurrance_company_name, 
                            pid.tpa_name,
                            pid.policy_type,
                            pid.corporate_name,
                            pid.corporate_id,
                            prd.admission_date,
                            prd.intimation_number,
                            prd.intimation_document,
                            pphd.policy_holder_name,
                            pphd.policy_holder_dob,
                            pphd.policy_holder_card_number,
                            pphd.policy_holder_relation,
                            pdd.date_of_admission,
                            pdd.discharge_date,
                            pdd.mrn_number,
                            pdd.final_bill_amount,
                            pdd.final_bill,
                            pdd.query_resolution_doc,
                            pdd.discharge_summary,
                            pdd.additional_doc,
                            pdd.invoice_number,
                            pdd.user_remarks,
                            ppodd.pod_number,
                            ppodd.courier_company,
                            ppodd.date_of_file_dispatch,
                            ppodd.document_dispatch_by,
                            ppodd.pod_document,
                            pnmed.final_bill_amount AS nme_final_bill_amount,
                            pnmed.final_diagnosis,
                            pnmed.amount_payable_by_isurer,
                            pnmed.amount_payable_by_patient,
                            pnmed.explanation,
                            p.first_name,
                            p.last_name,
                            pdecodedd.sum_insured,
                            pdecodedd.balance_amount,
                            pdecodedd.top_up,
                            pdecodedd.co_pay,
                            pdecodedd.room_rent,
                            pdecodedd.allowed_icu_changes,
                            pdecodedd.treatment_name_1,
                            pdecodedd.treatment_amount_1,
                            pdecodedd.treatment_name_2,
                            pdecodedd.treatment_amount_2,
                            pdecodedd.treatment_covered,
                            ppd.payment_type,
                            ppd.loan_sanction_letter,
                            ppd.amount,
                            ppd.nbfc,
                            ppd.sanction_number,
                            ppd.loan_booked_to,
                            pci.loan_type AS case_type,
                            pci.cash_type,
                            pci.treatment_type,
                            tpa.tpa_address,
                            tpaa.tpa_address AS tpa_address_insurrance,
                            pddd.filedispatch_address,
                            pddd.all_in_one_document,
                            pddd.query_resolution_doc_dispatch,
                            pkd.doctor_prescription,
                            pkd.reports,
                            pkd.past_treatment_record,
                            pkd.patient_adhaar_card,
                            pkd.patient_insurance_card,
                            pkd.primary_insured_adhaar,
                            pkd.primary_insured_insurance,
                            pkd.primary_insured_pan,
                            psud.claim_number,
                            psud.utr_number,
                            psud.approval_amount,
                            psud.approval_date,
                            psud.settlement_date,
                            psud.settlement_letter,
                            psud.query_resolution_doc_status,
                            psud.cheque_amount,
                            psud.tds_amount,
                            psud.gst_amount,
                            psud.comission_amount,
                             pcd.pre_auth_doc,
                            pcd.pre_auth_number,
                            pcd.initial_approval_doc,
                            pcd.approval_amount AS approval_amount_cashless,
                            pcd.final_approval_letter,
                            pcd.user_remarks
                            FROM patient_cases_info pci
                            LEFT JOIN hospitals h ON pci.hospital_id = h.id  
                            LEFT JOIN doctors d ON pci.doctor_id = d.id
                            LEFT JOIN patient_loan_details pld ON pci.id = pld.case_id
                            LEFT JOIN patient_payment_details ppd ON pci.id = ppd.case_id
                            LEFT JOIN patient_bank_details pbd ON pci.id = pbd.case_id
                            LEFT JOIN patient_insurrance_details pid ON pci.id = pid.case_id
                            LEFT JOIN tpa_list tpa ON pid.tpa_name = tpa.id
                            LEFT JOIN tpa_list tpaa ON pid.insurrance_company_name = tpaa.id
                            LEFT JOIN patient_reimbursement_details prd ON pci.id = prd.case_id
                            LEFT JOIN patient_policy_holder_details pphd ON pci.id = pphd.case_id
                            LEFT JOIN patient_discharge_details pdd ON pci.id = pdd.case_id
                            LEFT JOIN patient_pod_details ppodd ON pci.id = ppodd.case_id
                            LEFT JOIN patient_nme_details pnmed ON pci.id = pnmed.case_id
                            LEFT JOIN patient_dispatch_details pddd ON pci.id = pddd.case_id
                            LEFT JOIN patient_kyc_details pkd ON pci.id = pkd.case_id
                            LEFT JOIN patient_status_update_details psud ON pci.id = psud.case_id
                            LEFT JOIN patient_cashless_details pcd ON pci.id = pcd.case_id
                            LEFT JOIN patients p ON pci.patient_id = p.id
                            LEFT JOIN patient_decoded_details pdecodedd ON pci.id = pdecodedd.case_id
                          WHERE pci.id = '$cid'");


  $num = mysqli_fetch_assoc($sql);

  $case = (object) $num;

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('Y-m-d h:i:s A', time());

  $status = mysqli_query($con, "SELECT s.id,
                                      s.patient_id,
                                      s.case_id,
                                      s.status,
                                      ss.status_name FROM status_logs s 
                                      LEFT JOIN status ss ON s.status =  ss.id
                                       WHERE s.is_active = '1' AND s.case_id = '$cid' ");

  $stat = mysqli_fetch_assoc($status);

  $case_status = (object) $stat;


  // person details 
  if (isset($_POST['submit'])) {
    $sql = mysqli_query($con, "SELECT id,patient_id,case_id,hospital_id,doctor_id,treatment_name,attendant_name,relationship_with_insured,estimated_amount,expected_doa,created_by,created_at,updated_at FROM patient_cases_info WHERE id='$cid'");

    $num = mysqli_fetch_array($sql);

    $patientId = $num['patient_id'];

    if ($num > 0) {

      $hospital = $_POST['hospital'];
      $case_id = $_POST['hospital_case_id'];
      $doctor = $_POST['doctor'];
      $treatment_name = $_POST['treatment_name'];
      $attendant_name = $_POST['attendant_name'];
      $relationship_with_insured = $_POST['relationship'];
      $estimated_amount = $_POST['estimated_amount'];
      $doa = $_POST['doa'];

      $sql_to_insert_casetype = mysqli_query($con, "UPDATE `patients` SET `hospital_id` = '$hospital' WHERE id = $patientId");

      $conn = mysqli_query(
        $con,
        "UPDATE 
      `patient_cases_info` 
      SET 
      `hospital_id`='$hospital',
      `case_id`='$case_id',
      `doctor_id`='$doctor',
      `treatment_name`='$treatment_name',
      `attendant_name`='$attendant_name',
      `relationship_with_insured`='$relationship_with_insured',
      `estimated_amount`='$estimated_amount',
      `expected_doa`='$doa' 
      WHERE `id` = '$cid'"
      );


      if ($conn && $sql_to_insert_casetype) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Case Info Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-case.php?id=$cid';
                }, 3000);
            });
           
            
           
        </script>";
      }
    } else {
    }
  }

  if (isset($_POST['submit-patient-reimbursement-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $intimation_files = $_FILES['intimation_document'];
    $allowedTypes = array("pdf", "doc", "docx", "txt");

    $upload_errors = array();
    // $intimation_fileType = strtolower(pathinfo($intimation_target_file, PATHINFO_EXTENSION));
    $intimation_fileType = array();

    foreach ($intimation_files['name'] as $key => $fileName) {
      if (!empty($fileName)) {
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
          $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for Intimation Document.";
        } else {
          $target_file = $target_dir . $cid . '_intimation_document_' . $currentTimee . '_' . $key . '.' . $fileType;
          if (move_uploaded_file($intimation_files["tmp_name"][$key], $target_file)) {
            $intimation_filePaths[] = $con->real_escape_string($target_file);
          } else {
            $upload_errors[] = "Sorry, there was an error uploading your Intimation Document.";
          }
        }
      }
    }

    if (empty($upload_errors)) {

      $intimation_documents = implode(',', $intimation_filePaths);

      $reimburse = mysqli_query(
        $con,
        "SELECT 
                prd.id,
                prd.patient_id,
                prd.case_id,
                prd.admission_date,
                prd.intimation_number,
                prd.intimation_document,
                prd.created_by,
                prd.inserted_by,
                prd.created_at,
                prd.updated_at
            FROM
                patient_reimbursement_details prd
            WHERE 
                prd.case_id = '$cid'"
      );

      $reimburse2 = mysqli_fetch_array($reimburse);
      $existing_documents = $reimburse2 ? $reimburse2['intimation_document'] : '';

      // Append new documents to existing ones if any
      if (!empty($existing_documents)) {
        $intimation_documents = $existing_documents . ',' . $intimation_documents;
      }

      if ($reimburse2) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $admission_date = $_POST['admission_date'];
        $intimation_number = $_POST['intimation_number'];
        // $intimation_document = !empty($intimation_file['name']) ? $intimation_target_file : $reimburse2['intimation_document'];
        $intimation_document = !empty($intimation_filePaths) ? $intimation_documents : $reimburse2['intimation_document'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $reimburse_conn = mysqli_query($con, "UPDATE patient_reimbursement_details 
                SET admission_date='$admission_date', 
                    intimation_number='$intimation_number', 
                    intimation_document='$intimation_document', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($reimburse_conn) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Reimbursement Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $admission_date = $_POST['admission_date'];
        $intimation_number = $_POST['intimation_number'];
        // $intimation_document = !empty($intimation_file['name']) ? $intimation_target_file : '';
        $intimation_document = !empty($intimation_filePaths) ? $intimation_documents : $_POST['intimation_document'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;

        $conn2 = mysqli_query($con, "INSERT INTO `patient_reimbursement_details` 
                (`patient_id`, `case_id`, `admission_date`, `intimation_number`, `intimation_document`, 
                 `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$admission_date', '$intimation_number', '$intimation_document', 
                 '$created_by', '$inserted_by', '$created_at')");

        if ($conn2) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Reimbursement Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-loan-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $cibil_file = $_FILES['cibil_approval_doc'];
    $pan_file = $_FILES['pan_card_copy'];
    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond
    // $cibil_target_file = $target_dir . basename($cibil_file["name"]);
    // $pan_target_file = $target_dir . basename($pan_file["name"]);

    $cibil_target_file = $target_dir . $cid . '_cibil_approval_doc_' . $currentTimee . '.' . strtolower(pathinfo($cibil_file["name"], PATHINFO_EXTENSION));
    $pan_target_file = $target_dir . $cid . '_pan_card_copy_' . $currentTimee . '.' . strtolower(pathinfo($pan_file["name"], PATHINFO_EXTENSION));


    $cibil_fileType = strtolower(pathinfo($cibil_target_file, PATHINFO_EXTENSION));
    $pan_fileType = strtolower(pathinfo($pan_target_file, PATHINFO_EXTENSION));

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    $upload_errors = array();

    if (!empty($cibil_file['name']) && !in_array($cibil_fileType, $allowedTypes)) {
      $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for CIBIL Approval Document.";
    }

    if (!empty($pan_file['name']) && !in_array($pan_fileType, $allowedTypes)) {
      $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for PAN Card Copy.";
    }

    if (empty($upload_errors)) {
      if (!empty($cibil_file['name'])) {
        if (move_uploaded_file($cibil_file["tmp_name"], $cibil_target_file)) {
          $cibil_filePath = $con->real_escape_string($cibil_target_file);
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your CIBIL Approval Document.";
        }
      }

      if (!empty($pan_file['name'])) {
        if (move_uploaded_file($pan_file["tmp_name"], $pan_target_file)) {
          $pan_filePath = $con->real_escape_string($pan_target_file);
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your PAN Card Copy.";
        }
      }
    }

    if (empty($upload_errors)) {
      $sql = mysqli_query(
        $con,
        "SELECT 
            pld.id,
            pld.patient_id,
            pld.case_id,
            pld.primary_card_holder_name,
            pld.cibil_score,
            pld.is_eligible,
            pld.pan_number,
            pld.is_patient_counseled,
            pld.cibil_approval_doc,
            pld.pan_card_copy,
            pld.userremark,
            pld.created_by,
            pld.inserted_by,
            pld.created_at,
            pld.updated_at
            FROM
            patient_loan_details pld
            WHERE 
                pld.case_id = '$cid'"
      );

      $num = mysqli_fetch_array($sql);

      if ($num > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $primary_card_holder_name = $_POST['primary_card_holder_name'];
        $cibil_score = $_POST['cibil_score'];
        $is_eligible = $_POST['iseligible'];
        $pan_number = $_POST['pan_number'];
        $is_patient_counseled = $_POST['ispatientcounseled'];
        $cibil_approval_doc = !empty($cibil_file['name']) ? $cibil_target_file : $case->cibil_approval_doc;
        $pan_card_copy = !empty($pan_file['name']) ? $pan_target_file : $case->pan_card_copy;
        $userremark = $_POST['userremark'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $conn = mysqli_query($con, "UPDATE patient_loan_details 
                SET 
                patient_id = '$patient_id',
                case_id = '$cid',
                primary_card_holder_name='$primary_card_holder_name', 
                cibil_score = '$cibil_score',
                is_eligible='$is_eligible', 
                pan_number='$pan_number', 
                is_patient_counseled='$is_patient_counseled', 
                cibil_approval_doc = '$cibil_approval_doc',
                pan_card_copy = '$pan_card_copy',
                userremark = '$userremark',
                updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($conn) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Loan Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid#loan-details`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $primary_card_holder_name = $_POST['primary_card_holder_name'];
        $cibil_score = $_POST['cibil_score'];
        $is_eligible = $_POST['iseligible'];
        $pan_number = $_POST['pan_number'];
        $is_patient_counseled = $_POST['ispatientcounseled'];
        $cibil_approval_doc = !empty($cibil_file['name']) ? $cibil_target_file : '';
        $pan_card_copy = !empty($pan_file['name']) ? $pan_target_file : '';
        $userremark = $_POST['userremark'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;

        $conn = mysqli_query($con, "INSERT INTO `patient_loan_details` 
                (`patient_id`, `case_id`, `primary_card_holder_name`, `cibil_score`, `is_eligible`, 
                 `pan_number`, `is_patient_counseled`, `cibil_approval_doc`, `pan_card_copy`,`userremark`, `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$primary_card_holder_name', '$cibil_score', '$is_eligible', 
                 '$pan_number', '$is_patient_counseled', '$cibil_approval_doc', '$pan_card_copy','$userremark', '$created_by', '$inserted_by', '$created_at')");

        if ($conn) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Loan Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  //Status details
  if (isset($_POST['submit-patient-status'])) {


    $status = mysqli_query(
      $con,
      "SELECT 
        s.id,
        s.patient_id,
        s.case_id,
        s.status,
        s.created_by,
        s.inserted_by,
        s.created_at,
        s.updated_at
    FROM
    status_logs s
    WHERE 
        s.case_id = '$cid'
        ORDER BY s.id DESC LIMIT 1"
    );

    $status2 = mysqli_fetch_array($status);

    if ($status2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $status = $_POST['status'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $status3 = mysqli_query($con, "UPDATE status_logs 
                                    SET is_active='0', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      $status_new = mysqli_query($con, "INSERT INTO `status_logs` 
        (`patient_id`, `case_id`, `status`,`is_active`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$status','1', '$created_by', '$inserted_by', '$created_at')");

      if ($status_new) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Insurrance Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $status = $_POST['status'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $status4 =
        mysqli_query($con, "INSERT INTO `status_logs` 
        (`patient_id`, `case_id`, `status`,`is_active`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$status','1', '$created_by', '$inserted_by', '$created_at')");

      if ($status4) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient StatusAdded Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
           
            
           
        </script>";
      }
    }
  }

  //insurrance details
  if (isset($_POST['submit-patient-insurrance-details'])) {


    $insurrance = mysqli_query(
      $con,
      "SELECT 
        pid.id,
        pid.patient_id,
        pid.case_id,
        pid.policy_number,
        pid.policy_start_date,
        pid.policy_end_date,
        pid.insurrance_company_name,
        pid.tpa_name,
        pid.policy_type,
        pid.corporate_name,
        pid.corporate_id,
        pid.created_by,
        pid.inserted_by,
        pid.created_at,
        pid.updated_at
    FROM
    patient_insurrance_details pid
    WHERE 
        pid.case_id = '$cid'"
    );

    $insurrance2 = mysqli_fetch_array($insurrance);

    if ($insurrance2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $policy_number = $_POST['policy_number'];
      $policy_start_date = $_POST['policy_start_date'];
      $policy_end_date = $_POST['policy_end_date'];
      $insurrance_company_name = $_POST['insurrance_company_name'];
      $tpa_name = $_POST['tpa_name'];
      $policy_type = $_POST['policy_type'];
      $corporate_name = $_POST['corporate_name'];
      $corporate_id = $_POST['corporate_id'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $insurrance3 = mysqli_query($con, "UPDATE patient_insurrance_details 
                                    SET policy_number='$policy_number', 
                                        policy_start_date='$policy_start_date', 
                                        policy_end_date='$policy_end_date', 
                                        insurrance_company_name='$insurrance_company_name', 
                                        tpa_name='$tpa_name', 
                                        policy_type='$policy_type', 
                                        corporate_name='$corporate_name', 
                                        corporate_id='$corporate_id', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      if ($insurrance3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Insurrance Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $policy_number = $_POST['policy_number'];
      $policy_start_date = $_POST['policy_start_date'];
      $policy_end_date = $_POST['policy_end_date'];
      $insurrance_company_name = $_POST['insurrance_company_name'];
      $tpa_name = $_POST['tpa_name'];
      $policy_type = $_POST['policy_type'];
      $corporate_name = $_POST['corporate_name'];
      $corporate_id = $_POST['corporate_id'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn2 = mysqli_query($con, "INSERT INTO `patient_insurrance_details` 
        (`patient_id`, `case_id`, `policy_number`, `policy_start_date`, `policy_end_date`, 
         `insurrance_company_name`, `tpa_name`,`policy_type`,`corporate_name`,`corporate_id`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$policy_number', '$policy_start_date', '$policy_end_date', 
         '$insurrance_company_name', '$tpa_name','$policy_type','$corporate_name','$corporate_id', '$created_by', '$inserted_by', '$created_at')");

      if ($conn2) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Insurrance Details Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
           
            
           
        </script>";
      }
    }
  }

  //policy holder details
  if (isset($_POST['submit-patient-policy-holder-details'])) {


    $policyHolder = mysqli_query(
      $con,
      "SELECT 
        pphd.id,
        pphd.patient_id,
        pphd.case_id,
        pphd.policy_holder_name,
        pphd.policy_holder_dob,
        pphd.policy_holder_card_number,
        pphd.policy_holder_relation,
        pphd.created_by,
        pphd.inserted_by,
        pphd.created_at,
        pphd.updated_at
    FROM
    patient_policy_holder_details pphd
    WHERE 
        pphd.case_id = '$cid'"
    );

    $policyHolder2 = mysqli_fetch_array($policyHolder);

    if ($policyHolder2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $policy_holder_name = $_POST['policy_holder_name'];
      $policy_holder_dob = $_POST['policy_holder_dob'];
      $policy_holder_card_number = $_POST['policy_holder_card_number'];
      $policy_holder_relation = $_POST['policy_holder_relation'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $policyHolder3 = mysqli_query($con, "UPDATE patient_policy_holder_details 
                                    SET policy_holder_name='$policy_holder_name', 
                                        policy_holder_dob='$policy_holder_dob', 
                                        policy_holder_card_number='$policy_holder_card_number', 
                                        policy_holder_relation='$policy_holder_relation', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      if ($policyHolder3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Policy Holder Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $policy_holder_name = $_POST['policy_holder_name'];
      $policy_holder_dob = $_POST['policy_holder_dob'];
      $policy_holder_card_number = $_POST['policy_holder_card_number'];
      $policy_holder_relation = $_POST['policy_holder_relation'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn2 = mysqli_query($con, "INSERT INTO `patient_policy_holder_details` 
        (`patient_id`, `case_id`, `policy_holder_name`, `policy_holder_dob`, `policy_holder_card_number`, 
         `policy_holder_relation`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$policy_holder_name', '$policy_holder_dob', '$policy_holder_card_number', 
         '$policy_holder_relation', '$created_by', '$inserted_by', '$created_at')");

      if ($conn2) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Policy Holder Details Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
           
            
           
        </script>";
      }
    }
  }


  if (isset($_POST['submit-patient-discharge-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $final_bill = handleFileUpload($_FILES['final_bill'], 'final_bill', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $query_resolution_doc = handleFileUpload($_FILES['query_resolution_doc'], 'query_resolution_doc', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $discharge_summary = handleFileUpload($_FILES['discharge_summary'], 'discharge_summary', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $additional_doc = handleFileUpload($_FILES['additional_doc'], 'additional_doc', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $discharge = mysqli_query(
        $con,
        "SELECT 
                pdd.id,
                pdd.patient_id,
                pdd.case_id,
                pdd.date_of_admission,
                pdd.discharge_date,
                pdd.mrn_number,
                pdd.final_bill_amount,
                pdd.final_bill,
                pdd.query_resolution_doc,
                pdd.discharge_summary,
                pdd.additional_doc,
                pdd.invoice_number,
                pdd.user_remarks,
                pdd.created_by,
                pdd.inserted_by,
                pdd.created_at,
                pdd.updated_at
            FROM
                patient_discharge_details pdd
            WHERE 
                pdd.case_id = '$cid'"
      );

      $discharge2 = mysqli_fetch_array($discharge);

      if ($discharge2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $date_of_admission = $_POST['date_of_admission'];
        $discharge_date = $_POST['discharge_date'];
        $mrn_number = $_POST['mrn_number'];
        $final_bill_amount = $_POST['final_bill_amount'];
        $final_bill = !empty($_FILES['final_bill']['name']) ? $final_bill : $discharge2['final_bill'];
        $query_resolution_doc = !empty($_FILES['query_resolution_doc']['name']) ? $query_resolution_doc : $discharge2['query_resolution_doc'];
        $discharge_summary = !empty($_FILES['discharge_summary']['name']) ? $discharge_summary : $discharge2['discharge_summary'];
        $additional_doc = !empty($_FILES['additional_doc']['name']) ? $additional_doc : $discharge2['additional_doc'];
        $invoice_number = $_POST['invoice_number'];
        $user_remarks = $_POST['user_remarks'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $discharge3 = mysqli_query($con, "UPDATE patient_discharge_details 
                SET date_of_admission='$date_of_admission', 
                    discharge_date='$discharge_date', 
                    mrn_number='$mrn_number', 
                    final_bill_amount='$final_bill_amount', 
                    final_bill='$final_bill', 
                    query_resolution_doc='$query_resolution_doc', 
                    discharge_summary='$discharge_summary', 
                    additional_doc='$additional_doc', 
                    invoice_number='$invoice_number', 
                    user_remarks='$user_remarks', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($discharge3) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Discharge Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $date_of_admission = $_POST['date_of_admission'];
        $discharge_date = $_POST['discharge_date'];
        $mrn_number = $_POST['mrn_number'];
        $final_bill_amount = $_POST['final_bill_amount'];
        $invoice_number = $_POST['invoice_number'];
        $user_remarks = $_POST['user_remarks'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;

        $conn2 = mysqli_query($con, "INSERT INTO patient_discharge_details 
                (`patient_id`, `case_id`, `date_of_admission`, `discharge_date`, `mrn_number`, 
                 `final_bill_amount`, `final_bill`, `query_resolution_doc`, `discharge_summary`, 
                 `additional_doc`, `invoice_number`, `user_remarks`, `created_by`, `inserted_by`, 
                 `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$date_of_admission', '$discharge_date', '$mrn_number', 
                 '$final_bill_amount', '$final_bill', '$query_resolution_doc', '$discharge_summary', 
                 '$additional_doc', '$invoice_number', '$user_remarks', '$created_by', '$inserted_by', '$created_at')");

        if ($conn2) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Discharge Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }


  if (isset($_POST['submit-patient-pod-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $pod_document = handleFileUpload($_FILES['pod_document'], 'pod_document', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $pod = mysqli_query(
        $con,
        "SELECT 
                ppodd.id,
                ppodd.patient_id,
                ppodd.case_id,
                ppodd.pod_number,
                ppodd.courier_company,
                ppodd.date_of_file_dispatch,
                ppodd.document_dispatch_by,
                ppodd.pod_document,
                ppodd.created_by,
                ppodd.inserted_by,
                ppodd.created_at,
                ppodd.updated_at
            FROM
                patient_pod_details ppodd
            WHERE 
                ppodd.case_id = '$cid'"
      );

      $pod2 = mysqli_fetch_array($pod);

      if ($pod2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $pod_number = $_POST['pod_number'];
        $courier_company = $_POST['courier_company'];
        $date_of_file_dispatch = $_POST['date_of_file_dispatch'];
        $document_dispatch_by = $_POST['document_dispatch_by'];
        $pod_document = !empty($_FILES['pod_document']['name']) ? $pod_document : $pod2['pod_document'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $pod3 = mysqli_query($con, "UPDATE patient_pod_details 
                SET pod_number='$pod_number', 
                    courier_company='$courier_company', 
                    date_of_file_dispatch='$date_of_file_dispatch', 
                    document_dispatch_by='$document_dispatch_by', 
                    pod_document='$pod_document', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($pod3) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient POD Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $pod_number = $_POST['pod_number'];
        $courier_company = $_POST['courier_company'];
        $date_of_file_dispatch = $_POST['date_of_file_dispatch'];
        $document_dispatch_by = $_POST['document_dispatch_by'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $conn2 = mysqli_query($con, "INSERT INTO `patient_pod_details` 
                (`patient_id`, `case_id`, `pod_number`, `courier_company`, `date_of_file_dispatch`, 
                `document_dispatch_by`, `pod_document`, `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$pod_number', '$courier_company', '$date_of_file_dispatch', 
                '$document_dispatch_by', '$pod_document', '$created_by', '$inserted_by', '$created_at')");

        if ($conn2) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient POD Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  //nme details
  if (isset($_POST['submit-patient-nme-details'])) {

    $nme = mysqli_query(
      $con,
      "SELECT 
        pnmed.id,
        pnmed.patient_id,
        pnmed.case_id,
        pnmed.final_bill_amount,
        pnmed.final_diagnosis,
        pnmed.amount_payable_by_isurer,
        pnmed.amount_payable_by_patient,
        pnmed.explanation,
        pnmed.created_by,
        pnmed.inserted_by,
        pnmed.created_at,
        pnmed.updated_at
    FROM
    patient_nme_details pnmed
    WHERE 
        pnmed.case_id = '$cid'"
    );

    $nme2 = mysqli_fetch_array($nme);

    if ($nme2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $final_bill_amount = $_POST['final_bill_amount'];
      $final_diagnosis = $_POST['final_diagnosis'];
      $amount_payable_by_isurer = $_POST['amount_payable_by_isurer'];
      $amount_payable_by_patient = $_POST['amount_payable_by_patient'];
      $explanation = $_POST['explanation'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $nme3 = mysqli_query($con, "UPDATE patient_nme_details 
                                    SET final_bill_amount='$final_bill_amount', 
                                        final_diagnosis='$final_diagnosis', 
                                        amount_payable_by_isurer='$amount_payable_by_isurer', 
                                        amount_payable_by_patient='$amount_payable_by_patient', 
                                        explanation='$explanation', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      if ($nme3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient NME Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $final_bill_amount = $_POST['final_bill_amount'];
      $final_diagnosis = $_POST['final_diagnosis'];
      $amount_payable_by_isurer = $_POST['amount_payable_by_isurer'];
      $amount_payable_by_patient = $_POST['amount_payable_by_patient'];
      $explanation = $_POST['explanation'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn2 = mysqli_query($con, "INSERT INTO `patient_nme_details` 
        (`patient_id`, `case_id`, `final_bill_amount`, `final_diagnosis`, `amount_payable_by_isurer`, 
         `amount_payable_by_patient`, `explanation`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$final_bill_amount', '$final_diagnosis', '$amount_payable_by_isurer', 
         '$amount_payable_by_patient', '$explanation', '$created_by', '$inserted_by', '$created_at')");

      if ($conn2) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient NME Details Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }

  //decoded details
  if (isset($_POST['submit-patient-decoded-details'])) {

    $decoded = mysqli_query(
      $con,
      "SELECT 
        pdecodedd.id,
        pdecodedd.patient_id,
        pdecodedd.case_id,
        pdecodedd.sum_insured,
        pdecodedd.balance_amount,
        pdecodedd.top_up,
        pdecodedd.co_pay,
        pdecodedd.room_rent,
        pdecodedd.allowed_icu_changes,
        pdecodedd.treatment_name_1,
        pdecodedd.treatment_amount_1,
        pdecodedd.treatment_name_2,
        pdecodedd.treatment_amount_2,
        pdecodedd.treatment_covered,
        pdecodedd.created_by,
        pdecodedd.inserted_by,
        pdecodedd.created_at,
        pdecodedd.updated_at
    FROM
    patient_decoded_details pdecodedd
    WHERE 
        pdecodedd.case_id = '$cid'"
    );

    $decoded2 = mysqli_fetch_array($decoded);

    if ($decoded2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $sum_insured = $_POST['sum_insured'];
      $balance_amount = $_POST['balance_amount'];
      $top_up = $_POST['top_up'];
      $co_pay = $_POST['co_pay'];
      $allowed_icu_changes = $_POST['allowed_icu_changes'];
      $room_rent = $_POST['room_rent'];
      $treatment_name_1 = $_POST['treatment_name_1'];
      $treatment_amount_1 = $_POST['treatment_amount_1'];
      $treatment_name_2 = $_POST['treatment_name_2'];
      $treatment_amount_2 = $_POST['treatment_amount_2'];
      $treatment_covered = $_POST['treatment_covered'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $decoded3 = mysqli_query($con, "UPDATE patient_decoded_details 
                                    SET sum_insured='$sum_insured', 
                                        balance_amount='$balance_amount', 
                                        top_up='$top_up', 
                                        co_pay='$co_pay', 
                                        allowed_icu_changes='$allowed_icu_changes', 
                                        room_rent='$room_rent', 
                                        treatment_name_1='$treatment_name_1', 
                                        treatment_amount_1='$treatment_amount_1', 
                                        treatment_name_2='$treatment_name_2', 
                                        treatment_amount_2='$treatment_amount_2', 
                                        treatment_covered='$treatment_covered', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      if ($decoded3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Decoded Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $sum_insured = $_POST['sum_insured'];
      $balance_amount = $_POST['balance_amount'];
      $top_up = $_POST['top_up'];
      $co_pay = $_POST['co_pay'];
      $allowed_icu_changes = $_POST['allowed_icu_changes'];
      $room_rent = $_POST['room_rent'];
      $treatment_name_1 = $_POST['treatment_name_1'];
      $treatment_amount_1 = $_POST['treatment_amount_1'];
      $treatment_name_2 = $_POST['treatment_name_2'];
      $treatment_amount_2 = $_POST['treatment_amount_2'];
      $treatment_covered = $_POST['treatment_covered'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn2 = mysqli_query($con, "INSERT INTO `patient_decoded_details` 
        (`patient_id`, `case_id`, `sum_insured`, `balance_amount`, `top_up`,`room_rent`, 
         `co_pay`, `allowed_icu_changes`,`treatment_name_1`,`treatment_amount_1`,`treatment_name_2`,`treatment_amount_2`,`treatment_covered`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$sum_insured', '$balance_amount', '$top_up','$room_rent', 
         '$co_pay', '$allowed_icu_changes','$treatment_name_1','$treatment_amount_1','$treatment_name_2','$treatment_amount_2','$treatment_covered', '$created_by', '$inserted_by', '$created_at')");

      if ($conn2) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Decoded Details Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }


  if (isset($_POST['submit-patient-payment-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $loan_sanction_letter = handleFileUpload($_FILES['loan_sanction_letter'], 'loan_sanction_letter', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $sql2 = mysqli_query(
        $con,
        "SELECT 
                ppd.id,
                ppd.patient_id,
                ppd.case_id,
                ppd.payment_type,
                ppd.loan_sanction_letter,
                ppd.amount,
                ppd.nbfc,
                ppd.sanction_number,
                ppd.loan_booked_to,
                ppd.created_by,
                ppd.inserted_by,
                ppd.created_at,
                ppd.updated_at
            FROM
                patient_payment_details ppd
            WHERE 
                ppd.case_id = '$cid'"
      );

      $num2 = mysqli_fetch_array($sql2);

      if ($num2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $payment_type = $_POST['payment_type'];
        $loan_sanction_letter = !empty($_FILES['loan_sanction_letter']['name']) ? $loan_sanction_letter : $num2['loan_sanction_letter'];
        $amount = $_POST['amount'];
        $nbfc = $_POST['nbfc'];
        $sanction_number = $_POST['sanction_number'];
        $loan_booked_to = $_POST['loan_booked_to'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $conn2 = mysqli_query($con, "UPDATE patient_payment_details 
                SET payment_type='$payment_type', 
                    amount='$amount', 
                    nbfc='$nbfc', 
                    sanction_number='$sanction_number', 
                    loan_booked_to='$loan_booked_to', 
                    loan_sanction_letter='$loan_sanction_letter',
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($conn2) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Payment Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $payment_type = $_POST['payment_type'];
        $loan_sanction_letter = $loan_sanction_letter;
        $amount = $_POST['amount'];
        $nbfc = $_POST['nbfc'];
        $sanction_number = $_POST['sanction_number'];
        $loan_booked_to = $_POST['loan_booked_to'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $conn2 = mysqli_query($con, "INSERT INTO `patient_payment_details` 
                (`patient_id`, `case_id`, `payment_type`, `loan_sanction_letter`, `amount`, `nbfc`, 
                `sanction_number`, `loan_booked_to`, `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$payment_type', '$loan_sanction_letter', '$amount', '$nbfc', 
                '$sanction_number', '$loan_booked_to', '$created_by', '$inserted_by', '$created_at')");

        if ($conn2) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Payment Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-policy-remark'])) {

    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $query_related_document = handleFileUpload($_FILES['query_related_document'], 'query_related_document', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $policy = mysqli_query(
        $con,
        "SELECT 
        ppr.id,
        ppr.patient_id,
        ppr.case_id,
        ppr.remark_type,
        ppr.remark,
        ppr.query_related_document,
        ppr.created_by,
        ppr.is_active,
        ppr.inserted_by,
        ppr.created_at,
        ppr.updated_at
                FROM
                patient_policy_remarks ppr
                WHERE 
        ppr.case_id = '$cid'"
      );

      $policy2 = mysqli_fetch_array($policy);

      if ($policy2 > 0) {

        $patient_id = $case->patient_id;
        $case_id = $cid;
        $remark_type = $_POST['remark_type'];
        $remark = $_POST['remark'];
        $query_related_document = !empty($_FILES['query_related_document']['name']) ? $query_related_document : $policy2['query_related_document'];
        // $is_active = $_POST['is_active'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $policy3 =
          mysqli_query($con, "INSERT INTO `patient_policy_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`query_related_document`,`is_active`,`created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','$query_related_document','1', '$created_by', '$inserted_by', '$created_at')");

        if ($policy3) {
          echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Policy Remarks Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
        }
      } else {


        $patient_id = $case->patient_id;
        $case_id = $cid;
        $remark_type = $_POST['remark_type'];
        $remark = $_POST['remark'];
        $query_related_document = !empty($_FILES['query_related_document']['name']) ? $query_related_document : $_POST['query_related_document'];
        $created_by = $numId['id'];
        // $is_active = $_POST['is_active'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        // $polciy4 = mysqli_query($con, "INSERT INTO `patient_policy_remarks` 
        //   (`patient_id`, `case_id`, `remark_type`, `remark`,'is_active',`created_by`, `inserted_by`, `created_at`) 
        //   VALUES 
        //   ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");
        $polciy4 = mysqli_query($con, "INSERT INTO `patient_policy_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`query_related_document`,`is_active`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','$query_related_document','1', '$created_at')");

        if ($polciy4) {
          echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Policy Remark Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
        }
      }
    }
  }

  if (isset($_POST['submit-patient-decoded-details-remark'])) {

    $policy = mysqli_query(
      $con,
      "SELECT 
        ppr.id,
        ppr.patient_id,
        ppr.case_id,
        ppr.remark_type,
        ppr.remark,
        ppr.created_by,
        ppr.is_active,
        ppr.inserted_by,
        ppr.created_at,
        ppr.updated_at
    FROM
    patient_decoded_details_remarks ppr
    WHERE 
        ppr.case_id = '$cid'"
    );

    $policy2 = mysqli_fetch_array($policy);

    if ($policy2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      // $is_active = $_POST['is_active'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $policy3 =
        mysqli_query($con, "INSERT INTO `patient_decoded_details_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");

      if ($policy3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Policy Remarks Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {


      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $is_active = $_POST['is_active'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      // $polciy4 = mysqli_query($con, "INSERT INTO `patient_decoded_details_remarks` 
      //   (`patient_id`, `case_id`, `remark_type`, `remark`,'is_active',`created_by`, `inserted_by`, `created_at`) 
      //   VALUES 
      //   ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");
      $polciy4 = mysqli_query($con, "INSERT INTO `patient_decoded_details_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`,`inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1','$created_by','$inserted_by', '$created_at')");

      if ($polciy4) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Policy Remark Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-policy-remark-delete'])) {
    $remark_id = $_POST['remark_id'];

    // Fetch the policy remark to be deleted
    $policy_delete_query = "SELECT * FROM patient_policy_remarks WHERE id = '$remark_id' AND is_active = 1";
    $policy_delete = mysqli_query($con, $policy_delete_query);

    if (mysqli_num_rows($policy_delete) > 0) {
      // Update the is_active status to '0' (soft delete)
      $update_query = "UPDATE patient_policy_remarks SET is_active = 0 WHERE id = '$remark_id'";
      $policy3delete = mysqli_query($con, $update_query);

      if ($policy3delete) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Policy Remark Deleted Successfully.'
                    });

                    setTimeout(function(){
                        window.location.href = 'edit-case.php?id=$cid';
                    }, 3000);
                });
            </script>";
      } else {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to delete policy remark. Please try again.'
                    });
                });
            </script>";
      }
    } else {
      echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Policy remark not found or already deleted.'
                });
            });
        </script>";
    }
  }

  if (isset($_POST['submit-patient-policy-remark-edit'])) {
    $remark_id = $_POST['remark_id'];
    $remark_type = $_POST['remark_type'];
    $remark = $_POST['remark'];
    $created_at = date('Y-m-d H:i:s');

    $update_query = "UPDATE patient_policy_remarks SET remark_type = '$remark_type', remark = '$remark', created_at$created_at = '$created_at' WHERE id = '$remark_id'";

    $policy_edit = mysqli_query($con, $update_query);

    if ($policy_edit) {
      echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Policy Remark Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-case.php?id=$cid';
                }, 3000);
            });
        </script>";
    } else {
      echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to update policy remark. Please try again.'
                });
            });
        </script>";
    }
  }

  //patient details
  if (isset($_POST['submit-patient-bank-details'])) {


    $sql3 = mysqli_query(
      $con,
      "SELECT 
        pbd.id,
        pbd.patient_id,
        pbd.case_id,
        pbd.bank_name,
        pbd.account_number,
        pbd.ifsc_code,
        pbd.bank_details_documents,
        pbd.created_by,
        pbd.inserted_by,
        pbd.created_at,
        pbd.updated_at
    FROM
        patient_bank_details pbd
    WHERE 
        pbd.case_id = '$cid'"
    );

    $num3 = mysqli_fetch_array($sql3);

    if ($num3 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $bank_name = $_POST['bank_name'];
      $account_number = $_POST['account_number'];
      $ifsc_code = $_POST['ifsc_code'];
      $bank_details_documents = $_POST['bank_details_documents'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn3 = mysqli_query($con, "UPDATE patient_bank_details 
                                    SET payment_type='$payment_type', 
                                        account_number='$account_number', 
                                        ifsc_code='$ifsc_code', 
                                        bank_details_documents='$bank_details_documents', 
                                        updated_at='$updated_at' 
                                    WHERE case_id='$cid'");

      if ($conn3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Bank Details Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $bank_name = $_POST['bank_name'];
      $account_number = $_POST['account_number'];
      $ifsc_code = $_POST['ifsc_code'];
      $bank_details_documents = $_POST['bank_details_documents'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $conn3 = mysqli_query($con, "INSERT INTO `patient_bank_details` 
        (`patient_id`, `case_id`, `bank_name`, `account_number`, `ifsc_code`, 
         `bank_details_documents`, `created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$bank_name', '$account_number', '$ifsc_code', 
         '$bank_details_documents',  '$created_by', '$inserted_by', '$created_at')");

      if ($conn3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Bank Details Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
           
            
           
        </script>";
      }
    }
  }


  if (isset($_POST['submit-patient-discharge-details-remark'])) {

    $DischargeRemark = mysqli_query(
      $con,
      "SELECT 
        pddr.id,
        pddr.patient_id,
        pddr.case_id,
        pddr.remark_type,
        pddr.remark,
        pddr.created_by,
        pddr.is_active,
        pddr.inserted_by,
        pddr.created_at,
        pddr.updated_at
    FROM
    patient_discharge_details_remarks pddr
    WHERE 
        pddr.case_id = '$cid'"
    );

    $DischargeRemark2 = mysqli_fetch_array($DischargeRemark);

    if ($DischargeRemark2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $DischargeRemark3 =
        mysqli_query($con, "INSERT INTO `patient_discharge_details_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");

      if ($DischargeRemark3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'DischargeRemark Remarks Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {


      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      // $polciy4 = mysqli_query($con, "INSERT INTO `patient_decoded_details_remarks` 
      //   (`patient_id`, `case_id`, `remark_type`, `remark`,'is_active',`created_by`, `inserted_by`, `created_at`) 
      //   VALUES 
      //   ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");
      $DischargeRemark4 = mysqli_query($con, "INSERT INTO `patient_discharge_details_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`,`inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1','$created_by','$inserted_by', '$created_at')");

      if ($DischargeRemark4) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Discharge Remark Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }


  if (isset($_POST['submit-patient-dispatch-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $all_in_one_document = handleFileUpload($_FILES['all_in_one_document'], 'all_in_one_document', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $query_resolution_doc_dispatch = handleFileUpload($_FILES['query_resolution_doc_dispatch'], 'query_resolution_doc_dispatch', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $dispatch = mysqli_query(
        $con,
        "SELECT 
                pddd.id,
                pddd.patient_id,
                pddd.case_id,
                pddd.filedispatch_address,
                pddd.all_in_one_document,
                pddd.query_resolution_doc_dispatch,
                pddd.created_by,
                pddd.inserted_by,
                pddd.created_at,
                pddd.updated_at
            FROM
                patient_dispatch_details pddd
            WHERE 
                pddd.case_id = '$cid'"
      );

      $dispatch2 = mysqli_fetch_array($dispatch);

      if ($dispatch2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $filedispatch_address = $_POST['filedispatch_address'];

        $all_in_one_document = !empty($_FILES['all_in_one_document']['name']) ? $all_in_one_document : $dispatch2['all_in_one_document'];

        $query_resolution_doc_dispatch = !empty($_FILES['query_resolution_doc_dispatch']['name']) ? $query_resolution_doc_dispatch : $dispatch2['query_resolution_doc_dispatch'];

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $dispatch3 = mysqli_query($con, "UPDATE patient_dispatch_details 
                SET filedispatch_address='$filedispatch_address', 
                    all_in_one_document='$all_in_one_document', 
                    query_resolution_doc_dispatch='$query_resolution_doc_dispatch', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($dispatch3) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient POD Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $filedispatch_address = $_POST['filedispatch_address'];
        $all_in_one_document = !empty($_FILES['all_in_one_document']['name']) ? $all_in_one_document : $_POST['all_in_one_document'];
        $query_resolution_doc_dispatch = !empty($_FILES['query_resolution_doc_dispatch']['name']) ? $query_resolution_doc_dispatch : $_POST['query_resolution_doc_dispatch'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $dispatch4 = mysqli_query($con, "INSERT INTO `patient_dispatch_details` 
                (`patient_id`, `case_id`, `filedispatch_address`, `all_in_one_document`, `query_resolution_doc_dispatch`, 
                 `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$filedispatch_address', '$all_in_one_document', '$query_resolution_doc_dispatch', '$created_by', '$inserted_by', '$created_at')");

        if ($dispatch4) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient POD Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-dispatch_detail-remark'])) {

    $fileDispatch = mysqli_query(
      $con,
      "SELECT 
        pfdr.id,
        pfdr.patient_id,
        pfdr.case_id,
        pfdr.remark_type,
        pfdr.remark,
        pfdr.created_by,
        pfdr.is_active,
        pfdr.inserted_by,
        pfdr.created_at,
        pfdr.updated_at
    FROM
    patient_file_dispatch_remarks pfdr
    WHERE 
        pfdr.case_id = '$cid'"
    );

    $fileDispatch2 = mysqli_fetch_array($fileDispatch);

    if ($fileDispatch2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $fileDispatch3 =
        mysqli_query($con, "INSERT INTO `patient_file_dispatch_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");

      if ($fileDispatch3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'DischargeRemark Remarks Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {


      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $fileDispatch4 = mysqli_query($con, "INSERT INTO `patient_file_dispatch_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`,`inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1','$created_by','$inserted_by', '$created_at')");

      if ($fileDispatch4) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Discharge Remark Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-kyc-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis"); // Format timestamp as YearMonthDayHourMinuteSecond

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $patient_adhaar_card = handleFileUpload($_FILES['patient_adhaar_card'], 'patient_adhaar_card', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $patient_insurance_card = handleFileUpload($_FILES['patient_insurance_card'], 'patient_insurance_card', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $primary_insured_adhaar = handleFileUpload($_FILES['primary_insured_adhaar'], 'primary_insured_adhaar', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $primary_insured_insurance = handleFileUpload($_FILES['primary_insured_insurance'], 'primary_insured_insurance', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $primary_insured_pan = handleFileUpload($_FILES['primary_insured_pan'], 'primary_insured_pan', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $doctor_prescription = handleFileUpload($_FILES['doctor_prescription'], 'doctor_prescription', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $reports = handleFileUpload($_FILES['reports'], 'reports', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $past_treatment_record = handleFileUpload($_FILES['past_treatment_record'], 'past_treatment_record', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $kyc = mysqli_query(
        $con,
        "SELECT 
                pkd.id,
                pkd.patient_id,
                pkd.case_id,
                pkd.doctor_prescription,
                pkd.reports,
                pkd.past_treatment_record,
                pkd.patient_adhaar_card,
                pkd.patient_insurance_card,
                pkd.primary_insured_adhaar,
                pkd.primary_insured_insurance,
                pkd.primary_insured_pan,
                pkd.created_by,
                pkd.inserted_by,
                pkd.created_at,
                pkd.updated_at
            FROM
                patient_kyc_details pkd
            WHERE 
                pkd.case_id = '$cid'"
      );

      $kyc2 = mysqli_fetch_array($kyc);

      if ($kyc2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;

        $doctor_prescription = !empty($_FILES['doctor_prescription']['name']) ? $doctor_prescription : $kyc2['doctor_prescription'];
        $reports = !empty($_FILES['reports']['name']) ? $reports : $kyc2['reports'];
        $past_treatment_record = !empty($_FILES['past_treatment_record']['name']) ? $past_treatment_record : $kyc2['past_treatment_record'];

        $patient_adhaar_card = !empty($_FILES['patient_adhaar_card']['name']) ? $patient_adhaar_card : $kyc2['patient_adhaar_card'];

        $patient_insurance_card = !empty($_FILES['patient_insurance_card']['name']) ? $patient_insurance_card : $kyc2['patient_insurance_card'];

        $primary_insured_adhaar = !empty($_FILES['primary_insured_adhaar']['name']) ? $primary_insured_adhaar : $kyc2['primary_insured_adhaar'];

        $primary_insured_insurance = !empty($_FILES['primary_insured_insurance']['name']) ? $primary_insured_insurance : $kyc2['primary_insured_insurance'];

        $primary_insured_pan = !empty($_FILES['primary_insured_pan']['name']) ? $primary_insured_pan : $kyc2['primary_insured_pan'];

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $kyc3 = mysqli_query($con, "UPDATE patient_kyc_details 
                SET 
                    doctor_prescription='$doctor_prescription', 
                    reports='$reports', 
                    past_treatment_record='$past_treatment_record', 
                    patient_adhaar_card='$patient_adhaar_card', 
                    patient_insurance_card='$patient_insurance_card', 
                    primary_insured_adhaar='$primary_insured_adhaar', 
                    primary_insured_insurance='$primary_insured_insurance', 
                    primary_insured_pan='$primary_insured_pan', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($kyc3) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient POD Details Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;


        $doctor_prescription = !empty($_FILES['doctor_prescription']['name']) ? $doctor_prescription : $_POST['doctor_prescription'];
        $reports = !empty($_FILES['reports']['name']) ? $reports : $_POST['reports'];
        $past_treatment_record = !empty($_FILES['past_treatment_record']['name']) ? $past_treatment_record : $_POST['past_treatment_record'];
        $patient_adhaar_card = !empty($_FILES['patient_adhaar_card']['name']) ? $patient_adhaar_card : $_POST['patient_adhaar_card'];

        $patient_insurance_card = !empty($_FILES['patient_insurance_card']['name']) ? $patient_insurance_card : $_POST['patient_insurance_card'];

        $primary_insured_adhaar = !empty($_FILES['primary_insured_adhaar']['name']) ? $primary_insured_adhaar : $_POST['primary_insured_adhaar'];

        $primary_insured_insurance = !empty($_FILES['primary_insured_insurance']['name']) ? $primary_insured_insurance : $_POST['primary_insured_insurance'];

        $primary_insured_pan = !empty($_FILES['primary_insured_pan']['name']) ? $primary_insured_pan : $_POST['primary_insured_pan'];

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $dispatch4 = mysqli_query($con, "INSERT INTO `patient_kyc_details` 
                (`patient_id`, `case_id`,`doctor_prescription`,`reports`,`past_treatment_record`, `patient_adhaar_card`, `patient_insurance_card`, `primary_insured_adhaar`,`primary_insured_insurance`,`primary_insured_pan`, 
                 `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id','$doctor_prescription','$reports','$past_treatment_record', '$patient_adhaar_card', '$patient_insurance_card', '$primary_insured_adhaar','$primary_insured_insurance','$primary_insured_pan', '$created_by', '$inserted_by', '$created_at')");

        if ($dispatch4) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Documents Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-status-update-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis");

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      if (!empty($file['name']) && in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $settlement_letter = handleFileUpload($_FILES['settlement_letter'], 'settlement_letter', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    $query_resolution_doc_status = handleFileUpload($_FILES['query_resolution_doc_status'], 'query_resolution_doc_status', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $statusUpdate = mysqli_query(
        $con,
        "SELECT 
                psud.id,
                psud.patient_id,
                psud.case_id,
                psud.claim_number,
                psud.utr_number,
                psud.approval_amount,
                psud.approval_date,
                psud.settlement_date,
                psud.settlement_letter,
                psud.query_resolution_doc_status,
                psud.cheque_amount,
                psud.tds_amount,
                psud.gst_amount,
                psud.comission_amount,
                psud.created_by,
                psud.inserted_by,
                psud.created_at,
                psud.updated_at
            FROM
                patient_status_update_details psud
            WHERE 
                psud.case_id = '$cid'"
      );

      $statusUpdate2 = mysqli_fetch_array($statusUpdate);

      if ($statusUpdate2 > 0) {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $claim_number = $_POST['claim_number'];
        $utr_number = $_POST['utr_number'];
        $approval_amount = $_POST['approval_amount'];
        $approval_date = $_POST['approval_date'];
        $settlement_date = $_POST['settlement_date'];

        $settlement_letter = !empty($_FILES['settlement_letter']['name']) ? $settlement_letter : $statusUpdate2['settlement_letter'];

        $query_resolution_doc_status = !empty($_FILES['query_resolution_doc_status']['name']) ? $query_resolution_doc_status : $statusUpdate2['query_resolution_doc_status'];

        $cheque_amount = $_POST['cheque_amount'];
        $tds_amount = $_POST['tds_amount'];
        $gst_amount = $_POST['gst_amount'];
        $comission_amount = $_POST['comission_amount'];

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $statusUpdate3 = mysqli_query($con, "UPDATE patient_status_update_details 
                SET claim_number='$claim_number', 
                    utr_number='$utr_number', 
                    approval_amount='$approval_amount', 
                    approval_date='$approval_date', 
                    settlement_date='$settlement_date', 
                    settlement_letter='$settlement_letter', 
                    query_resolution_doc_status='$query_resolution_doc_status', 
                    cheque_amount='$cheque_amount', 
                    tds_amount='$tds_amount', 
                    gst_amount='$gst_amount', 
                    comission_amount='$comission_amount', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($statusUpdate3) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Status Update Updated Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      } else {
        $patient_id = $case->patient_id;
        $case_id = $cid;
        $claim_number = $_POST['claim_number'];
        $utr_number = $_POST['utr_number'];
        $approval_amount = $_POST['approval_amount'];
        $approval_date = $_POST['approval_date'];
        $settlement_date = $_POST['settlement_date'];

        $settlement_letter = !empty($_FILES['settlement_letter']['name']) ? $settlement_letter : $_POST['settlement_letter'];

        $query_resolution_doc_status = !empty($_FILES['query_resolution_doc_status']['name']) ? $query_resolution_doc_status : $_POST['query_resolution_doc_dispatch'];

        $cheque_amount = $_POST['cheque_amount'];
        $tds_amount = $_POST['tds_amount'];
        $gst_amount = $_POST['gst_amount'];
        $comission_amount = $_POST['comission_amount'];
        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $statusUpdate4 = mysqli_query($con, "INSERT INTO `patient_status_update_details` 
                (`patient_id`, `case_id`, `claim_number`, `utr_number`, `approval_amount`, `approval_date`, `settlement_date`, `settlement_letter`, `query_resolution_doc_status`, `cheque_amount`, `tds_amount`, `gst_amount`, `comission_amount`,
                 `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$claim_number', '$utr_number', '$approval_amount', '$approval_date', '$settlement_date', '$settlement_letter', '$query_resolution_doc_status','$cheque_amount','$tds_amount','$gst_amount','$comission_amount', '$created_by', '$inserted_by', '$created_at')");

        if ($statusUpdate4) {
          echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'success',
                            title: 'Patient Status Update Details Added Successfully.'
                        });

                        setTimeout(function(){
                            window.location.href = `edit-case.php?id=$cid`;
                        }, 3000);
                    });
                </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                window.addEventListener('load', function() {
                    Toast.fire({
                        icon: 'error',
                        title: '$error'
                    });
                });
            </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-status-update-remark'])) {

    $statusUpdateRemark = mysqli_query(
      $con,
      "SELECT 
        psur.id,
        psur.patient_id,
        psur.case_id,
        psur.remark_type,
        psur.remark,
        psur.created_by,
        psur.is_active,
        psur.inserted_by,
        psur.created_at,
        psur.updated_at
    FROM
    patient_status_update_remarks psur
    WHERE 
        psur.case_id = '$cid'"
    );

    $statusUpdateRemark2 = mysqli_fetch_array($statusUpdateRemark);

    if ($statusUpdateRemark2 > 0) {

      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $statusUpdateRemark3 =
        mysqli_query($con, "INSERT INTO `patient_status_update_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`, `inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1', '$created_by', '$inserted_by', '$created_at')");

      if ($statusUpdateRemark3) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'DischargeRemark Remarks Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    } else {


      $patient_id = $case->patient_id;
      $case_id = $cid;
      $remark_type = $_POST['remark_type'];
      $remark = $_POST['remark'];
      $created_by = $numId['id'];
      $inserted_by = 'ADMIN';
      $created_at = $currentTime;
      $updated_at = $currentTime;

      $statusUpdateRemark4 = mysqli_query($con, "INSERT INTO `patient_status_update_remarks` 
        (`patient_id`, `case_id`, `remark_type`, `remark`,`is_active`,`created_by`,`inserted_by`, `created_at`) 
        VALUES 
        ('$patient_id', '$case_id', '$remark_type', '$remark','1','$created_by','$inserted_by', '$created_at')");

      if ($statusUpdateRemark4) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Discharge Remark Added Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-case.php?id=$cid`;
                }, 3000);
            });
        </script>";
      }
    }
  }

  if (isset($_POST['submit-patient-cashless-details'])) {
    // $target_dir = "uploads/";
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $currentTimee = date("YmdHis");

    $allowedTypes = array("pdf", "doc", "docx", "txt");

    function handleFileUpload($file, $fieldName, $cid, $currentTimee, $target_dir, $allowedTypes, &$upload_errors)
    {
      $fileName = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      $target_file = $target_dir . $cid . '_' . $fieldName . '_' . $currentTimee . '.' . $fileName;

      if (!empty($file['name']) && in_array($fileName, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          return $target_file;
        } else {
          $upload_errors[] = "Sorry, there was an error uploading your $fieldName.";
          return null;
        }
      } else if (!empty($file['name'])) {
        $upload_errors[] = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed for $fieldName.";
        return null;
      }
      return null;
    }

    $upload_errors = array();

    $pre_auth_doc = handleFileUpload($_FILES['pre_auth_doc'], 'pre_auth_doc', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $initial_approval_doc = handleFileUpload($_FILES['initial_approval_doc'], 'initial_approval_doc', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);
    $final_approval_letter = handleFileUpload($_FILES['final_approval_letter'], 'final_approval_letter', $cid, $currentTimee, $target_dir, $allowedTypes, $upload_errors);

    if (empty($upload_errors)) {
      $cashlessDetail = mysqli_query(
        $con,
        "SELECT 
                pcd.id,
                pcd.patient_id,
                pcd.case_id,
                pcd.pre_auth_doc,
                pcd.pre_auth_number,
                pcd.initial_approval_doc,
                pcd.approval_amount,
                pcd.final_approval_letter,
                pcd.user_remarks,
                pcd.created_by,
                pcd.inserted_by,
                pcd.created_at,
                pcd.updated_at
            FROM
                patient_cashless_details pcd
            WHERE 
                pcd.case_id = '$cid'"
      );

      $cashlessDetail2 = mysqli_fetch_array($cashlessDetail);

      if ($cashlessDetail2) {
        $pre_auth_doc = !empty($_FILES['pre_auth_doc']['name']) ? $pre_auth_doc : $cashlessDetail2['pre_auth_doc'];
        $pre_auth_number = isset($_POST['pre_auth_number']) ? $_POST['pre_auth_number'] : '';
        $initial_approval_doc = !empty($_FILES['initial_approval_doc']['name']) ? $initial_approval_doc : $cashlessDetail2['initial_approval_doc'];
        $approval_amount = isset($_POST['approval_amount']) ? $_POST['approval_amount'] : '';
        $final_approval_letter = !empty($_FILES['final_approval_letter']['name']) ? $final_approval_letter : $cashlessDetail2['final_approval_letter'];
        $user_remarks = isset($_POST['user_remarks']) ? $_POST['user_remarks'] : '';

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;
        $updated_at = $currentTime;

        $cashlessDetail3 = mysqli_query($con, "UPDATE patient_cashless_details 
                SET pre_auth_doc='$pre_auth_doc', 
                    pre_auth_number='$pre_auth_number', 
                    initial_approval_doc='$initial_approval_doc', 
                    approval_amount='$approval_amount', 
                    final_approval_letter='$final_approval_letter', 
                    user_remarks='$user_remarks', 
                    updated_at='$updated_at' 
                WHERE case_id='$cid'");

        if ($cashlessDetail3) {
          echo "<script>
                        window.addEventListener('load', function() {
                            Toast.fire({
                                icon: 'success',
                                title: 'Patient Status Update Updated Successfully.'
                            });

                            setTimeout(function(){
                                window.location.href = `edit-case.php?id=$cid`;
                            }, 3000);
                        });
                    </script>";
        }
      } else {
        $pre_auth_doc = !empty($_FILES['pre_auth_doc']['name']) ? $pre_auth_doc : '';
        $pre_auth_number = isset($_POST['pre_auth_number']) ? $_POST['pre_auth_number'] : '';
        $initial_approval_doc = !empty($_FILES['initial_approval_doc']['name']) ? $initial_approval_doc : '';
        $approval_amount = isset($_POST['approval_amount']) ? $_POST['approval_amount'] : '';
        $final_approval_letter = !empty($_FILES['final_approval_letter']['name']) ? $final_approval_letter : '';
        $user_remarks = isset($_POST['user_remarks']) ? $_POST['user_remarks'] : '';

        $created_by = $numId['id'];
        $inserted_by = 'ADMIN';
        $created_at = $currentTime;

        $cashlessDetail4 = mysqli_query($con, "INSERT INTO `patient_cashless_details` 
                (`patient_id`, `case_id`, `pre_auth_doc`, `pre_auth_number`, `initial_approval_doc`, `approval_amount`, `final_approval_letter`, `user_remarks`,
                 `created_by`, `inserted_by`, `created_at`) 
                VALUES 
                ('$patient_id', '$case_id', '$pre_auth_doc', '$pre_auth_number', '$initial_approval_doc', '$approval_amount', '$final_approval_letter', '$user_remarks',  '$created_by', '$inserted_by', '$created_at')");

        if ($cashlessDetail4) {
          echo "<script>
                        window.addEventListener('load', function() {
                            Toast.fire({
                                icon: 'success',
                                title: 'Patient Status Update Details Added Successfully.'
                            });

                            setTimeout(function(){
                                window.location.href = `edit-case.php?id=$cid`;
                            }, 3000);
                        });
                    </script>";
        }
      }
    } else {
      foreach ($upload_errors as $error) {
        echo "<script>
                    window.addEventListener('load', function() {
                        Toast.fire({
                            icon: 'error',
                            title: '$error'
                        });
                    });
                </script>";
      }
    }
  }



?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Edit Patient</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="./plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="./plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="./plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">



    <!-- Theme style -->


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Toast configuration
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });
    </script>

    <style>
      .file-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
      }

      .file-upload input[type="file"] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
      }

      .file-upload .btn {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 8px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
      }

      .file-list {
        margin-top: 10px;
      }

      .file-list .file-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
      }

      .file-list .file-item i {
        margin-right: 10px;
      }

      .file-list .file-item a {
        color: #007bff;
        text-decoration: none;
      }

      .scroll-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        padding: 10px 15px 10px 15px;
        cursor: pointer;
        font-size: 18px;
        display: none;
        /* Initially hidden */
        transition: opacity 0.3s;
        z-index: 99
      }

      .scroll-to-top:hover {
        background-color: #0056b3;
      }
    </style>

  </head>

  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <?php include('include/navbar.php'); ?>
      <?php include('include/sidebar.php'); ?>

      <button id="scrollToTopBtn" class="scroll-to-top" onclick="scrollToTop()">↑</button>

      <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><?php echo ($case->first_name) ?> <?php echo ($case->last_name) ?> | <?php echo ($case->hospital_name) ?> Hospital | <span style="color:red"> <?php echo ($case_status->status_name) ?></span> | <?php echo ($case->created_at) ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item"><a href='edit-patient.php?id=<?php echo ($case->patient_id) ?>'>Patient</a></li>
                  <li class="breadcrumb-item active"><?php echo ($case->first_name) ?> <?php echo ($case->last_name) ?></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-12">
                <a type="button" class="btn btn-danger" href="#personal-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Personal Details
                </a>
                <a type="button" class="btn btn-danger" href="#kyc" style="margin-top: 10px;margin-bottom: 10px;">
                  KYC
                </a>
                <a type="button" class="btn btn-danger" href="#policy-remarks" style="margin-top: 10px;margin-bottom: 10px;">
                  Policy Remarks
                </a>
                <?php
                if ($case->case_type == '2') {
                  echo '<a type="button" class="btn btn-danger" href="#cashless" style="margin-top: 10px; margin-bottom: 10px;">
                    Cashless
                  </a>';
                }
                ?>
                <a type="button" class="btn btn-danger" href="#reimbursement-adminttedOn" style="margin-top: 10px;margin-bottom: 10px;">
                  Reimbursement | Admintted on
                </a>
                <a type="button" class="btn btn-danger" href="#insurrance-policy-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Insurance Policy Details
                </a>
                <a type="button" class="btn btn-danger" href="#decoded-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Decoded Details
                </a>
                <a type="button" class="btn btn-danger" href="#policy-holder" style="margin-top: 10px;margin-bottom: 10px;">
                  Policy Holder
                </a>
                <a type="button" class="btn btn-danger" href="#loan-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Pre Loan Details
                </a>
                <a type="button" class="btn btn-danger" href="#bank-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Bank Details
                </a>
                <a type="button" class="btn btn-danger" href="#discharge" style="margin-top: 10px;margin-bottom: 10px;">
                  Discharge
                </a>
                <a type="button" class="btn btn-danger" href="#nme-approval" style="margin-top: 10px;margin-bottom: 10px;">
                  NME Approval
                </a>
                <a type="button" class="btn btn-danger" href="#file-dispatch" style="margin-top: 10px;margin-bottom: 10px;">
                  File Dispatch
                </a>
                <a type="button" class="btn btn-danger" href="#pod" style="margin-top: 10px;margin-bottom: 10px;">
                  POD
                </a>
                <a type="button" class="btn btn-danger" href="#payment-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Post Loan Details
                </a>
                <a type="button" class="btn btn-danger" href="#status-update-details" style="margin-top: 10px;margin-bottom: 10px;">
                  Status Update
                </a>
              </div>

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Status</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-12">
                            <label for="status">Status</label>
                            <select class="form-control select2" name="status" id="inputStatus">
                              <option value="<?php echo ($case_status->status_id) ?>"><?php echo ($case_status->status_name) ?></option>
                              <?php
                              $status = mysqli_query($con, "SELECT id, status_id,status_name FROM status");
                              while ($row = mysqli_fetch_array($status)) {
                              ?>
                                <option value="<?php echo htmlentities($row['id']); ?>">
                                  <?php echo htmlentities($row['status_name']); ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div>
                          <button type="submit" name="submit-patient-status" class="btn btn-danger">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- personal details -->
              <div class="col-md-12" id="person-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Personal Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-2">
                            <label for="case_type">Finance Type</label>
                            <select disabled class="form-control select2" name="case_type" id="case_type" style="width: 100%;">
                              <option disabled <?php if (!$case->case_type) echo 'selected="selected"'; ?>>Select is Case Type</option>
                              <option disabled value="1" <?php if ($case->case_type == '1') echo 'selected="selected"'; ?>>Reimbursement</option>
                              <option disabled value="2" <?php if ($case->case_type == '2') echo 'selected="selected"'; ?>>Cashless</option>
                              <option disabled value="3" <?php if ($case->case_type == '3') echo 'selected="selected"'; ?>>Asthetic</option>
                            </select>
                          </div>
                          <?php if ($case->case_type  == '1') : ?>
                            <div class="col-md-2">
                              <label for="case_type">Loan Type</label>
                              <select disabled class="form-control select2" name="case_type" id="case_type" style="width: 100%;">
                                <option disabled <?php if (!$case->cash_type) echo 'selected="selected"'; ?>>Select is Loan Type</option>
                                <option disabled value="PDC" <?php if ($case->cash_type == 'PDC') echo 'selected="selected"'; ?>>PDC</option>
                                <option disabled value="Loan" <?php if ($case->cash_type == 'Loan') echo 'selected="selected"'; ?>>Loan</option>
                              </select>
                            </div>
                          <?php endif; ?>

                          <div class="col-md-4">
                            <label for="hospital">Hospital</label>
                            <select class="form-control select2" name="hospital" id="inputHospital">
                              <option value="<?php echo ($case->hospital_id) ?>"><?php echo ($case->hospital_name) ?></option>
                              <?php
                              $hospitals = mysqli_query($con, "SELECT id, name FROM hospitals");
                              while ($row = mysqli_fetch_array($hospitals)) {
                              ?>
                                <option value="<?php echo htmlentities($row['id']); ?>">
                                  <?php echo htmlentities($row['name']); ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="doctor">Doctor</label>
                            <input type="text" value="<?php echo ($case->doctor_id) ?>" class="form-control" name="doctor_id" id="inputdoctor" placeholder="Hospital Case ID No.">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="inputhospitalcaseid">Hospital Case ID No.</label>
                            <input type="text" value="<?php echo ($case->case_id) ?>" class="form-control" name="hospital_case_id" id="inputhospitalcaseid" placeholder="Hospital Case ID No.">
                          </div>
                          <div class="col-md-6">
                            <label for="inputTreatmentName">Treatment Name</label>
                            <input type="text" value="<?php echo ($case->treatment_name) ?>" class="form-control" name="treatment_name" id="inputTreatmentName" placeholder="Treatment Name">
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="inputattendantname">Attendant Name</label>
                            <input type="text" value="<?php echo ($case->attendant_name) ?>" class="form-control" name="attendant_name" id="inputattendantname" placeholder="Attendant Name">
                          </div>
                          <div class="col-md-6">
                            <label for="inputRelationship">Relationship With insured</label>
                            <input type="text" value="<?php echo ($case->relationship_with_insured) ?>" class="form-control" name="relationship" id="inputRelationship" placeholder="Relationship With insured">
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="inputestimatedamoutn">Estimated Amount</label>
                            <input type="text" value="<?php echo ($case->estimated_amount) ?>" class="form-control" name="estimated_amount" id="inputestimatedamoutn" placeholder="Estimated Amount">
                          </div>
                          <div class="col-md-6">
                            <label for="inputDOA">DOA</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->expected_doa) ?>" class="form-control datetimepicker-input" data-target="#reservationdate" name="doa" />
                              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" style="margin-top: 10px;">
                              Update
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Case Detail Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to update Case Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit" class="btn btn-danger">Update</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Primary Insured KYC -->
              <div class="col-md-12" id="kyc">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">KYC</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">

                        <h4>Patient KYC</h4>
                        <hr>
                        <div class="form-group row">

                          <div class="col-md-6">
                            <label for="patient_adhaar_card">Patient Adhaar Card</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->patient_adhaar_card) ?>" id="patient_adhaar_card" name="patient_adhaar_card" placeholder="Patient Adhaar Card" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->patient_adhaar_card) ?>"><?php echo substr($case->patient_adhaar_card, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="patient_insurance_card">Patient Insurance Card</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->patient_insurance_card) ?>" id="patient_insurance_card" name="patient_insurance_card" placeholder="Primary Insured Insurance Card" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->patient_insurance_card) ?>"><?php echo substr($case->patient_insurance_card, 8); ?></a></span>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <h4>Past Treatment Record</h4>
                        <hr>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="doctor_prescription">Doctor Prescription</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->doctor_prescription) ?>" id="doctor_prescription" name="doctor_prescription" placeholder="Doctor Prescription" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->doctor_prescription) ?>"><?php echo substr($case->doctor_prescription, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="reports">Reports</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->reports) ?>" id="reports" name="reports" placeholder="Reports" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->reports) ?>"><?php echo substr($case->reports, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="past_treatment_record">Past Treatment Records</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->past_treatment_record) ?>" id="past_treatment_record" name="past_treatment_record" placeholder="Past Treatment Records" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->past_treatment_record) ?>"><?php echo substr($case->past_treatment_record, 8); ?></a></span>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <h4>Primary Insured KYC</h4>
                        <hr>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="primary_insured_adhaar">Primary Insured Adhaar Card</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->primary_insured_adhaar) ?>" id="primary_insured_adhaar" name="primary_insured_adhaar" placeholder="Primary Insured Adhaar Card" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->primary_insured_adhaar) ?>"><?php echo substr($case->primary_insured_adhaar, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="primary_insured_insurance">Primary Insured Insurance Card</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->primary_insured_insurance) ?>" id="primary_insured_insurance" name="primary_insured_insurance" placeholder="Primary Insured Insurance Card" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->primary_insured_insurance) ?>"><?php echo substr($case->primary_insured_insurance, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="primary_insured_pan">Primary Insured PAN Card</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->primary_insured_pan) ?>" id="primary_insured_pan" name="primary_insured_pan" placeholder="Primary Insured PAN Card" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->primary_insured_pan) ?>"><?php echo substr($case->primary_insured_pan, 8); ?></a></span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-primary-insured-kyc" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-primary-insured-kyc">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Primary Insured KYC Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Primary Insured KYC?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-kyc-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?php
              if ($case->case_type == '2') {
              ?>

              <!-- Cashless -->
              <div class="col-md-12" id="cashless-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Cashless Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="pre_auth_doc">Pre Auth Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->pre_auth_doc) ?>" id="pre_auth_doc" name="pre_auth_doc" placeholder="Settlement Letter" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->pre_auth_doc) ?>"><?php echo substr($case->pre_auth_doc, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="pre_auth_number">Pre Auth Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->pre_auth_number) ?>" id="bankName" name="pre_auth_number" placeholder="Pre Auth Number">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="initial_approval_doc">Initial Approval Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->initial_approval_doc) ?>" id="initial_approval_doc" name="initial_approval_doc" placeholder="Initial Approval Doc" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->initial_approval_doc) ?>"><?php echo substr($case->initial_approval_doc, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="approval_amount">Approval Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->approval_amount_cashless) ?>" id="approval_amount" name="approval_amount" placeholder="Approval Amount">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="final_approval_letter	">Final Approval Letter</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->final_approval_letter) ?>" id="final_approval_letter" name="final_approval_letter" placeholder="Initial Approval Doc" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->final_approval_letter) ?>"><?php echo substr($case->final_approval_letter, 8); ?></a></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <label for="remark">User Remark</label>
                            <div>
                              <textarea class="form-control" name="user_remark" id="remark" placeholder="User Remark"><?php echo ($case->user_remark) ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-cashless" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-cashless">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Cashless Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Cashless Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-cashless-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?php } ?>

              <!-- policy remarks -->
              <div class="col-md-12" id="policy-remarks">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Policy Remarks</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="remarkType">Remark Type</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->remark_type) ?>" id="remarkType" name="remark_type" placeholder="Remark Type">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="remark">Remark</label>
                            <div>
                              <textarea class="form-control" name="remark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="query_related_document">Query Related Document</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->query_related_document) ?>" id="query_related_document" name="query_related_document" placeholder="Query Related Document" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->query_related_document) ?>"><?php echo substr($case->query_related_document, 8); ?></a></span>
                            </div>
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-16" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-16">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Policy Remark Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Policy Remark Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-policy-remark" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>

                      <table class="table table-striped projects">
                        <thead>
                          <tr>
                            <th style="width: 10%">
                              Sr No.
                            </th>
                            <th style="width: 10%">
                              Remark Type
                            </th>
                            <th style="width: 25%">
                              Remark
                            </th>
                            <th style="width: 25%">
                              Doc
                            </th>
                            <th style="width: 20%">
                              Author
                            </th>
                            <th style="width: 20%">
                              Date Time
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php


                          $sql = mysqli_query(
                            $con,
                            "SELECT 
                    ppr.id,
                    ppr.case_id,
                    ppr.remark_type,
                    ppr.remark,
                    ppr.query_related_document,
                    ppr.is_active,
                    ppr.inserted_by,
                    ppr.created_at,
                    ppr.inserted_by
                    FROM 
                        patient_policy_remarks ppr 
                    WHERE 
                        ppr.is_active = 1 AND ppr.case_id=$cid"
                          );
                          $cnt = 1;
                          while ($row = mysqli_fetch_array($sql)) {
                          ?>
                            <tr>
                              <td>
                                <?php echo ($cnt) ?>
                              </td>
                              <td>
                                <?php echo $row['remark_type'] ?>
                              </td>
                              <td>
                                <?php echo $row['remark'] ?>
                              </td>
                              <td>
                                <a href="<?php echo $row['query_related_document'] ?>" target="_blank"> <?php echo $row['query_related_document'] ?></a>
                              </td>
                              <td>
                                <?php echo $row['inserted_by'] ?>
                              </td>

                              <td>
                                <?php echo $row['created_at'] ?>
                              </td>
                              <td class="project-actions text-right">

                                <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-edit-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                  Edit
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-delete-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                  Delete
                                </button> -->
                                <div class="modal fade" id="policy-edit-default-<?php echo $row['id']; ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title"><?php echo $row['id']; ?> Policy Remark Updation!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form class="form-horizontal" method="POST">
                                        <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                          <label for="remark_type">Remark Type</label>
                                          <input type="text" name="remark_type" class="form-control" value="<?php echo $row['remark_type']; ?>">
                                        </div>
                                        <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                          <label for="remark">Remark</label>
                                          <textarea name="remark" class="form-control"><?php echo $row['remark']; ?></textarea>
                                        </div>
                                        <div class="modal-body">
                                          <p style="text-align:center;">Are you sure you want to update Policy Remark Details?</p>
                                        </div>
                                        <div class=" modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-policy-remark-edit" class="btn btn-danger">Submit</button>
                                        </div>
                                      </form>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>

                                  <!-- /.modal-dialog -->
                                </div>

                                <div class="modal fade" id="policy-delete-default-<?php echo $row['id']; ?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title">Policy Remark Deletion!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="POST" class="form-horizontal">
                                        <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                        <div class="modal-body" style="text-align:left">
                                          <p>Are you sure you want to Delete Policy Remark Details?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-policy-remark-delete" class="btn btn-danger">Delete</button>
                                        </div>
                                      </form>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>

                                  <!-- /.modal-dialog -->
                                </div>
                              </td>
                            </tr>
                          <?php
                            $cnt = $cnt + 1;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- insurrance policy details -->
              <div class="col-md-12" id="insurrance-policy-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Insurance Policy Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="policy_number">Policy Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->policy_number) ?>" id="policy_number" name="policy_number" placeholder="Policy Number">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="policy_start_date">Policy Start Date</label>
                            <div class="input-group date" id="reservationdate4" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->policy_start_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate4" name="policy_start_date" />
                              <div class="input-group-append" data-target="#reservationdate4" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="policy_end_date">Policy End Date</label>
                            <div class="input-group date" id="reservationdate5" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->policy_end_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate5" name="policy_end_date" />
                              <div class="input-group-append" data-target="#reservationdate5" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="insurrance_company_name">Insurance Company</label>
                            <select class="form-control select2" name="insurrance_company_name" id="insurrance_company_name" style="width: 100%;">
                              <option disabled <?php if (!$case->insurrance_company_name) echo 'selected="selected"'; ?>>Select is Insurance Company</option>
                              <?php
                              $insurance_company_name = mysqli_query($con, "SELECT id, tpa_name FROM tpa_list");
                              while ($row = mysqli_fetch_array($insurance_company_name)) {
                              ?>
                                <option value="<?php echo htmlentities($row['id']); ?>">
                                  <?php echo htmlentities($row['tpa_name']); ?>
                                </option>
                              <?php } ?>
                            </select>
                            <?php echo $case->insurrance_company_name; ?>
                            <?php if ($case->insurrance_company_name) : ?>
                              <span>Address: <?php echo $case->tpa_address_insurrance; ?></span>
                            <?php endif; ?>
                          </div>
                          <div class="col-md-4">
                            <label for="tpa_name">TPA Name</label>
                            <select class="form-control select2" name="tpa_name" id="tpa_name" style="width: 100%;">
                              <option disabled <?php if (!$case->tpa_name) echo 'selected="selected"'; ?>>Select is TPA Name</option>
                              <?php
                              $tpa = mysqli_query($con, "SELECT id, tpa_name FROM tpa_list");
                              while ($row = mysqli_fetch_array($tpa)) {
                              ?>
                                <option value="<?php echo htmlentities($row['id']); ?>">
                                  <?php echo htmlentities($row['tpa_name']); ?>
                                </option>
                              <?php } ?>
                            </select>
                            <?php if ($case->tpa_name) : ?>
                              <span>Address: <?php echo $case->tpa_address; ?></span>
                            <?php endif; ?>
                          </div>
                          <div class="col-md-4">
                            <label for="policy_type">Policy Type</label>
                            <select class="form-control select2" name="policy_type" id="policy_type" style="width: 100%;" onchange="toggleCorporateFields()">
                              <option disabled <?php if (!$case->policy_type) echo 'selected="selected"'; ?>>Select is Policy Type</option>
                              <option value="Corporate" <?php if ($case->policy_type == 'Corporate') echo 'selected="selected"'; ?>>Corporate</option>
                              <option value="Individual" <?php if ($case->policy_type == 'Individual') echo 'selected="selected"'; ?>>Individual</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row" id="corporate_fields" style="display: none;">
                          <div class="col-md-6">
                            <label for="corporate_name">Corporate Name</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->corporate_name) ?>" id="corporate_name" name="corporate_name" placeholder="Corporate Name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="corporate_id">Corporate Id</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->corporate_id) ?>" id="corporate_id" name="corporate_id" placeholder="Corporate Id">
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-8" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-8">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Insurance Policy Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Insurance Policy Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-insurrance-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- reimbursement -->
              <div class="col-md-12" id="reimbursement-adminttedOn">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Reimbursement | Admintted on</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="admission_date">Admission Date</label>
                            <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->admission_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate3" name="admission_date" />
                              <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="intimation_number">Intimation Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->intimation_number) ?>" id="intimation_number" name="intimation_number" placeholder="Intimation Number">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="intimation_document">Query Resolution Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->intimation_document) ?>" id="intimation_document" name="intimation_document[]" placeholder="Intimation Document" accept=".pdf,.doc,.docx,.txt" multiple>
                              <?php if (!empty($case->intimation_document)) : ?>
                                <?php $documents = explode(',', $case->intimation_document); ?>
                                <?php foreach ($documents as $document) : ?>
                                  <div class="file-item">
                                    <i class="fas fa-file-alt"></i>
                                    <a target="_blank" href="<?php echo $document; ?>"><?php echo substr($document, strrpos($document, '/') + 1); ?></a>
                                  </div>
                                <?php endforeach; ?>
                            </div>
                          <?php endif; ?>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-7" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-7">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Reimbursement | Admitted Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Reimbursement | Admitted Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-reimbursement-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- decoded details -->
              <div class="col-md-12" id="decoded-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Decoded Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="patient_name">Patient Name</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->first_name) ?> <?php echo ($case->last_name) ?>" id="patient_name" name="patient_name" placeholder="Patient Name" disabled>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="sum_insured">Sum Insured</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->sum_insured) ?>" id="sum_insured" name="sum_insured" placeholder="Sum Insured">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="balance_amount">Balance Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->balance_amount) ?>" id="balance_amount" name="balance_amount" placeholder="Balance Amount">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="top_up">Top Up</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->top_up) ?>" id="top_up" name="top_up" placeholder="Top Up">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="co_pay">CoPay</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->co_pay) ?>" id="co_pay" name="co_pay" placeholder="CoPay">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="room_rent">Room Rent + Nursing Charges</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->room_rent) ?>" id="room_rent" name="room_rent" placeholder="Room Rent + Nursing Charges">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="allowed_icu_changes">Allowed ICU Changes</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->allowed_icu_changes) ?>" id="allowed_icu_changes" name="allowed_icu_changes" placeholder="Allowed ICU Changes">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="treatment_name_1">Treatment Name 1</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->treatment_name_1) ?>" id="treatment_name_1" name="treatment_name_1" placeholder="Treatment Name 1">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="treatment_amount_1">Treatment Amount 1</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->treatment_amount_1) ?>" id="treatment_amount_1" name="treatment_amount_1" placeholder="Treatment Amount 1">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="treatment_name_2">Treatment Name 2</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->treatment_name_2) ?>" id="treatment_name_2" name="treatment_name_2" placeholder="Treatment Name 2">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="treatment_amount_2">Treatment Amount 2</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->treatment_amount_2) ?>" id="treatment_amount_2" name="treatment_amount_2" placeholder="Treatment Amount 2">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="treatment_covered">Treatment Covered</label>
                            <select class="form-control select2" name="treatment_covered" id="treatment_covered" style="width: 100%;">
                              <option disabled <?php if (!$case->treatment_covered) echo 'selected="selected"'; ?>>Treatment Covered</option>
                              <option value="Yes" <?php if ($case->treatment_covered == 'Yes') echo 'selected="selected"'; ?>>YES</option>
                              <option value="NO" <?php if ($case->treatment_covered == 'No') echo 'selected="selected"'; ?>>NO</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-11" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-11">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Decoded Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Decoded Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-decoded-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>

                      <div class="col-md-12" id="policy-remarks">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Decoded Details Remarks</h3>
                          </div>
                          <div class="card-body">
                            <div class="tab-content">
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label for="remarkType">Decoded Remark Type</label>
                                    <div>
                                      <input type="text" class="form-control" value="<?php echo ($case->remark_type) ?>" id="remarkType" name="remark_type" placeholder="Remark Type">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="remark">Decoded Remark</label>
                                    <div>
                                      <textarea class="form-control" name="remark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                                    </div>
                                  </div>

                                </div>

                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-13" style="margin-top: 10px;">
                                      Submit
                                    </button>
                                  </div>
                                  <div class="modal fade" id="modal-default-13">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Decoded Details Remark Creation/Updation!</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>Are you sure you want to create/update Decoded Remark Details?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-decoded-details-remark" class="btn btn-danger">Submit</button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                </div>
                              </form>

                              <table class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th style="width: 10%">
                                      Sr No.
                                    </th>
                                    <th style="width: 10%">
                                      Remark Type
                                    </th>
                                    <th style="width: 25%">
                                      Remark
                                    </th>
                                    <th style="width: 20%">
                                      Author
                                    </th>
                                    <th style="width: 20%">
                                      Date Time
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php


                                  $sql = mysqli_query(
                                    $con,
                                    "SELECT 
                                      ppr.id,
                                      ppr.case_id,
                                      ppr.remark_type,
                                      ppr.remark,
                                      ppr.is_active,
                                      ppr.inserted_by,
                                      ppr.created_at,
                                      ppr.inserted_by
                                      FROM 
                                          patient_decoded_details_remarks ppr 
                                      WHERE 
                                          ppr.is_active = 1 AND ppr.case_id=$cid"
                                  );
                                  $cnt = 1;
                                  while ($row = mysqli_fetch_array($sql)) {
                                  ?>
                                    <tr>
                                      <td>
                                        <?php echo ($cnt) ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['inserted_by'] ?>
                                      </td>

                                      <td>
                                        <?php echo $row['created_at'] ?>
                                      </td>
                                      <td class="project-actions text-right">

                                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-edit-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-delete-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Delete
                                            </button> -->
                                        <div class="modal fade" id="policy-edit-default-<?php echo $row['id']; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title"><?php echo $row['id']; ?> Policy Remark Updation!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form class="form-horizontal" method="POST">
                                                <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                                <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                                  <label for="remark_type">Remark Type</label>
                                                  <input type="text" name="remark_type" class="form-control" value="<?php echo $row['remark_type']; ?>">
                                                </div>
                                                <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                                  <label for="remark">Remark</label>
                                                  <textarea name="remark" class="form-control"><?php echo $row['remark']; ?></textarea>
                                                </div>
                                                <div class="modal-body">
                                                  <p style="text-align:center;">Are you sure you want to update Policy Remark Details?</p>
                                                </div>
                                                <div class=" modal-footer justify-content-between">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="submit-patient-policy-remark-edit" class="btn btn-danger">Submit</button>
                                                </div>
                                              </form>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>

                                          <!-- /.modal-dialog -->
                                        </div>

                                        <div class="modal fade" id="policy-delete-default-<?php echo $row['id']; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Policy Remark Deletion!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form method="POST" class="form-horizontal">
                                                <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                                <div class="modal-body" style="text-align:left">
                                                  <p>Are you sure you want to Delete Policy Remark Details?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="submit-patient-policy-remark-delete" class="btn btn-danger">Delete</button>
                                                </div>
                                              </form>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>

                                          <!-- /.modal-dialog -->
                                        </div>
                                      </td>
                                    </tr>
                                  <?php
                                    $cnt = $cnt + 1;
                                  } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- policy Holder -->
              <div class="col-md-12" id="policy-holder">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Policy Holder</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="policy_holder_name">Policy Holder Name</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->policy_holder_name) ?>" id="policy_holder_name" name="policy_holder_name" placeholder="Policy Holder Name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="policy_holder_dob">Policy Holder DOB</label>
                            <div class="input-group date" id="reservationdate6" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->policy_holder_dob) ?>" class="form-control datetimepicker-input" data-target="#reservationdate6" name="policy_holder_dob" />
                              <div class="input-group-append" data-target="#reservationdate6" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>


                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="policy_holder_card_number">Policy Holder Card Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->policy_holder_card_number) ?>" id="policy_holder_card_number" name="policy_holder_card_number" placeholder="Policy Holder Card Number">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="policy_holder_relation">Policy Holder Relation</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->policy_holder_relation) ?>" id="policy_holder_relation" name="policy_holder_relation" placeholder="Policy Holder Relation">
                            </div>
                          </div>
                        </div>


                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-9" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-9">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Policy Holder Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Policy Holder Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-policy-holder-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- loan details -->
              <div class="col-md-12" id="loan-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Pre Loan Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="cardHolderName">Primary Card Holder Name</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->primary_card_holder_name) ?>" id="cardHolderName" name="primary_card_holder_name" placeholder="Primary Card Holder Name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="cibilScore">CIBIL Score</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->cibil_score) ?>" id="cibilScore" name="cibil_score" placeholder="CIBIL Score">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="iseligible">Is Elgible</label>
                            <select class="form-control select2" name="iseligible" id="iseligible" style="width: 100%;">
                              <option disabled <?php if (!$case->is_eligible) echo 'selected="selected"'; ?>>Select is Eligible</option>
                              <option value="Yes" <?php if ($case->is_eligible == 'Yes') echo 'selected="selected"'; ?>>YES</option>
                              <option value="NO" <?php if ($case->is_eligible == 'No') echo 'selected="selected"'; ?>>NO</option>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="ispatientcounseled">Is Patient Counseled</label>
                            <select class="form-control select2" name="ispatientcounseled" id="ispatientcounseled" style="width: 100%;">
                              <option disabled <?php if (!$case->is_patient_counseled) echo 'selected="selected"'; ?>>Select is Patient Counseled</option>
                              <option value="Yes" <?php if ($case->is_patient_counseled == 'Yes') echo 'selected="selected"'; ?>>YES</option>
                              <option value="NO" <?php if ($case->is_patient_counseled == 'No') echo 'selected="selected"'; ?>>NO</option>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="pannumber">PAN Number</label>
                            <input type="text" value="<?php echo ($case->pan_number) ?>" class="form-control" name="pan_number" id="pannumber" placeholder="PAN Number">
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="cibil_approval_doc">CIBIL Approval Doc</label>
                            <input type="file" class="form-control" name="cibil_approval_doc" id="cibil_approval_doc" placeholder="CIBIL Approval Doc" accept=".pdf,.doc,.docx,.txt" value="<?php echo ($case->cibil_approval_doc) ?>">
                            <span><a target="_blank" href="<?php echo ($case->cibil_approval_doc) ?>"><?php echo substr($case->cibil_approval_doc, 8); ?></a></span>
                          </div>
                          <div class="col-md-6">
                            <label for="pan_card_copy">PAN Card Copy</label>
                            <input type="file" value="<?php echo ($case->pan_card_copy) ?>" class="form-control" name="pan_card_copy" id="pan_card_copy" placeholder="PAN Card Copy" accept=".pdf,.doc,.docx,.txt">
                            <span><a target="_blank" href="<?php echo ($case->pan_card_copy) ?>"><?php echo substr($case->pan_card_copy, 8); ?></a></span>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-12">
                            <label for="remark">User Remark</label>
                            <div>
                              <textarea class="form-control" name="userremark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-2" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-2">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Loan Details Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to update your loan details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-loan-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- bank details -->
              <div class="col-md-12" id="bank-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Bank Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="bankName">Bank Name</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->bank_name) ?>" id="bankName" name="bank_name" placeholder="Bank Name">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="accountNumber">Account Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->account_number) ?>" id="accountNumber" name="account_number" placeholder="Account Number">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="ifsc_code">IFSC Code</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->ifsc_code) ?>" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="bank_details_documents">Bank Details Documents</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->bank_details_documents) ?>" id="bank_details_documents" name="bank_details_documents" placeholder="Bank Details Documents">
                            </div>
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-4" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-4">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Bank Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Payment Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-bank-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- discharge -->
              <div class="col-md-12" id="discharge">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Discharge</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="date_of_admission">Date Of Admission</label>
                            <div class="input-group date" id="reservationdate7" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->date_of_admission) ?>" class="form-control datetimepicker-input" data-target="#reservationdate7" name="date_of_admission" />
                              <div class="input-group-append" data-target="#reservationdate7" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="discharge_date">Discharge Date</label>
                            <div class="input-group date" id="reservationdate8" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->discharge_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate8" name="discharge_date" />
                              <div class="input-group-append" data-target="#reservationdate8" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="mrn_number">MRN Number/Patient ID</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->mrn_number) ?>" id="bankName" name="mrn_number" placeholder="MRN Number/Patient ID">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="final_bill_amount">Final Bill Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->final_bill_amount) ?>" id="final_bill_amount" name="final_bill_amount" placeholder="Final Bill Amount">
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="final_bill">Final Bill</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->final_bill) ?>" id="final_bill" name="final_bill" placeholder="Final Bill" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->final_bill) ?>"><?php echo substr($case->final_bill, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="query_resolution_doc">Query Resolution Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->query_resolution_doc) ?>" id="query_resolution_doc" name="query_resolution_doc" placeholder="Query Resolution Doc" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->query_resolution_doc) ?>"><?php echo substr($case->query_resolution_doc, 8); ?></a></span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="discharge_summary">Discharge Summary</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->discharge_summary) ?>" id="discharge_summary" name="discharge_summary" placeholder="Discharge Summary" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->discharge_summary) ?>"><?php echo substr($case->discharge_summary, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="additional_doc">Additional Document</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->additional_doc) ?>" id="additional_doc" name="additional_doc" placeholder="Additional Document" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->additional_doc) ?>"><?php echo substr($case->additional_doc, 8); ?></a></span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="invoice_number">Invoice Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->invoice_number) ?>" id="bankName" name="invoice_number" placeholder="Invoice Number">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="user_remarks">User Remarks</label>
                            <div>
                              <textarea class="form-control" name="user_remarks" id="user_remarks" placeholder="Final Bill Amount"><?php echo ($case->user_remarks) ?></textarea>

                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-10" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-10">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Discharge Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Discharge Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-discharge-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>

                      <div class="col-md-12" id="policy-remarks">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Decoded Details Remarks</h3>
                          </div>
                          <div class="card-body">
                            <div class="tab-content">
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label for="remarkType">Decoded Remark Type</label>
                                    <div>
                                      <input type="text" class="form-control" value="<?php echo ($case->remark_type) ?>" id="remarkType" name="remark_type" placeholder="Remark Type">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="remark">Decoded Remark</label>
                                    <div>
                                      <textarea class="form-control" name="remark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                                    </div>
                                  </div>

                                </div>

                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-14" style="margin-top: 10px;">
                                      Submit
                                    </button>
                                  </div>
                                  <div class="modal fade" id="modal-default-14">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Discharge Remark Creation/Updation!</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>Are you sure you want to Enter Discharge Remark Details?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-discharge-details-remark" class="btn btn-danger">Submit</button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                </div>
                              </form>

                              <table class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th style="width: 10%">
                                      Sr No.
                                    </th>
                                    <th style="width: 10%">
                                      Remark Type
                                    </th>
                                    <th style="width: 25%">
                                      Remark
                                    </th>
                                    <th style="width: 20%">
                                      Author
                                    </th>
                                    <th style="width: 20%">
                                      Date Time
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php


                                  $sql = mysqli_query(
                                    $con,
                                    "SELECT 
                                      pddr.id,
                                      pddr.case_id,
                                      pddr.remark_type,
                                      pddr.remark,
                                      pddr.is_active,
                                      pddr.inserted_by,
                                      pddr.created_at,
                                      pddr.inserted_by
                                      FROM 
                                          patient_discharge_details_remarks pddr 
                                      WHERE 
                                          pddr.is_active = 1 AND pddr.case_id=$cid"
                                  );
                                  $cnt = 1;
                                  while ($row = mysqli_fetch_array($sql)) {
                                  ?>
                                    <tr>
                                      <td>
                                        <?php echo ($cnt) ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['inserted_by'] ?>
                                      </td>

                                      <td>
                                        <?php echo $row['created_at'] ?>
                                      </td>
                                      <td class="project-actions text-right">

                                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-edit-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-delete-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Delete
                                            </button> -->
                                        <div class="modal fade" id="policy-edit-default-<?php echo $row['id']; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title"><?php echo $row['id']; ?> Policy Remark Updation!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form class="form-horizontal" method="POST">
                                                <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                                <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                                  <label for="remark_type">Remark Type</label>
                                                  <input type="text" name="remark_type" class="form-control" value="<?php echo $row['remark_type']; ?>">
                                                </div>
                                                <div class="form-group" style="text-align:left;padding-left:25px;padding-right:25px">
                                                  <label for="remark">Remark</label>
                                                  <textarea name="remark" class="form-control"><?php echo $row['remark']; ?></textarea>
                                                </div>
                                                <div class="modal-body">
                                                  <p style="text-align:center;">Are you sure you want to update Policy Remark Details?</p>
                                                </div>
                                                <div class=" modal-footer justify-content-between">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="submit-patient-policy-remark-edit" class="btn btn-danger">Submit</button>
                                                </div>
                                              </form>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>

                                          <!-- /.modal-dialog -->
                                        </div>

                                        <div class="modal fade" id="policy-delete-default-<?php echo $row['id']; ?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Policy Remark Deletion!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form method="POST" class="form-horizontal">
                                                <input type="hidden" name="remark_id" value="<?php echo $row['id']; ?>">
                                                <div class="modal-body" style="text-align:left">
                                                  <p>Are you sure you want to Delete Policy Remark Details?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="submit-patient-policy-remark-delete" class="btn btn-danger">Delete</button>
                                                </div>
                                              </form>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>

                                          <!-- /.modal-dialog -->
                                        </div>
                                      </td>
                                    </tr>
                                  <?php
                                    $cnt = $cnt + 1;
                                  } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- NME approval -->
              <div class="col-md-12" id="nme-approval">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">NME Approval</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="final_bill_amount">Final Bill Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->nme_final_bill_amount) ?>" id="bankName" name="final_bill_amount" placeholder="Final Bill Amount">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="final_diagnosis">Final Diagnosis</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->final_diagnosis) ?>" id="final_diagnosis" name="final_diagnosis" placeholder="Courier Company">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">

                          <div class="col-md-6">
                            <label for="amount_payable_by_isurer">Amount Payable By Isurer</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->amount_payable_by_isurer) ?>" id="amount_payable_by_isurer" name="amount_payable_by_isurer" placeholder="Amount Payable By Isurer">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="amount_payable_by_patient">Amount Payable By Patient</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->amount_payable_by_patient) ?>" id="amount_payable_by_patient" name="amount_payable_by_patient" placeholder="Amount Payable By Patient">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-12">
                            <label for="explanation">Explanation</label>
                            <div>
                              <textarea style="width: 100%;" class="form-control" name="explanation" id="explanation" rows="3" cols="12"><?php echo ($case->explanation) ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-6" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-6">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">NME Approval Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update NME Approval Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-nme-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- File Dispatch -->
              <div class="col-md-12" id="file-dispatch">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">File Dispatch</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-12">
                            <label for="filedispatch_address">Address</label>
                            <div>
                              <textarea class="form-control" name="filedispatch_address" id="filedispatch_address" placeholder="Address"><?php echo ($case->filedispatch_address) ?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="all_in_one_document">All In One Document</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->all_in_one_document) ?>" id="all_in_one_document" name="all_in_one_document" placeholder="All In One Document" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->all_in_one_document) ?>"><?php echo substr($case->all_in_one_document, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="query_resolution_doc_dispatch">Query Resolution Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->query_resolution_doc_dispatch) ?>" id="query_resolution_doc_dispatch" name="query_resolution_doc_dispatch" placeholder="Query Resolution Document" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->query_resolution_doc_dispatch) ?>"><?php echo substr($case->query_resolution_doc_dispatch, 8); ?></a></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-15" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-15">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Dispatch Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Dispatch Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-dispatch-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>

                      <div class="col-md-12" id="policy-remarks">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">File Dispatch Details Remarks</h3>
                          </div>
                          <div class="card-body">
                            <div class="tab-content">
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label for="remarkType">File Dispatch Remark Type</label>
                                    <div>
                                      <input type="text" class="form-control" value="<?php echo ($case->remark_type) ?>" id="remarkType" name="remark_type" placeholder="Remark Type">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="remark">File Dispatch Remark</label>
                                    <div>
                                      <textarea class="form-control" name="remark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                                    </div>
                                  </div>

                                </div>

                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-file-dispatch" style="margin-top: 10px;">
                                      Submit
                                    </button>
                                  </div>
                                  <div class="modal fade" id="modal-default-file-dispatch">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">File Dispatch Remark Creation/Updation!</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>Are you sure you want to Enter File Dispatch Remark Details?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-dispatch_detail-remark" class="btn btn-danger">Submit</button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                </div>
                              </form>

                              <table class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th style="width: 10%">
                                      Sr No.
                                    </th>
                                    <th style="width: 10%">
                                      Remark Type
                                    </th>
                                    <th style="width: 25%">
                                      Remark
                                    </th>
                                    <th style="width: 20%">
                                      Author
                                    </th>
                                    <th style="width: 20%">
                                      Date Time
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php


                                  $sql = mysqli_query(
                                    $con,
                                    "SELECT 
                                      pfdr.id,
                                      pfdr.case_id,
                                      pfdr.remark_type,
                                      pfdr.remark,
                                      pfdr.is_active,
                                      pfdr.inserted_by,
                                      pfdr.created_at,
                                      pfdr.inserted_by
                                      FROM 
                                          patient_file_dispatch_remarks pfdr 
                                      WHERE 
                                          pfdr.is_active = 1 AND pfdr.case_id=$cid"
                                  );
                                  $cnt = 1;
                                  while ($row = mysqli_fetch_array($sql)) {
                                  ?>
                                    <tr>
                                      <td>
                                        <?php echo ($cnt) ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['inserted_by'] ?>
                                      </td>

                                      <td>
                                        <?php echo $row['created_at'] ?>
                                      </td>
                                      <td class="project-actions text-right">

                                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-edit-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#policy-delete-default-<?php echo $row['id']; ?>" style="margin-top: 10px;">
                                              Delete
                                            </button> -->
                                      </td>
                                    </tr>
                                  <?php
                                    $cnt = $cnt + 1;
                                  } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- pod -->
              <div class="col-md-12" id="pod">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">POD</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="pod_number">POD Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->pod_number) ?>" id="bankName" name="pod_number" placeholder="POD Number">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="courier_company">Courier Company</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->courier_company) ?>" id="courier_company" name="courier_company" placeholder="Courier Company">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="date_of_file_dispatch">Date Of File Dispatch</label>
                            <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->date_of_file_dispatch) ?>" class="form-control datetimepicker-input" data-target="#reservationdate2" name="date_of_file_dispatch" />
                              <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="document_dispatch_by">Document Dispatched By</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->document_dispatch_by) ?>" id="document_dispatch_by" name="document_dispatch_by" placeholder="Document Dispatched By">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="pod_document">POD Document</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->pod_document) ?>" id="pod_document" name="pod_document" placeholder="POD Document" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->pod_document) ?>"><?php echo substr($case->pod_document, 8); ?></a></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-5" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-5">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">POD Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update POD Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-pod-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- payment details -->
              <div class="col-md-12" id="payment-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Post Loan Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="paymentType">Payment Type</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->payment_type) ?>" id="paymentType" name="payment_type" placeholder="Payment Type">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="loanSacntionLetter">Loan Sanction Letter</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->loan_sanction_letter) ?>" id="loanSacntionLetter" name="loan_sanction_letter" placeholder="Loan Sanction Letter" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->loan_sanction_letter) ?>"><?php echo substr($case->loan_sanction_letter, 8); ?></a></span>
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="amount">Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->amount) ?>" id="amount" name="amount" placeholder="Amount">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="nbfc">NBFC</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->nbfc) ?>" id="nbfc" name="nbfc" placeholder="NBFC">
                            </div>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="sanction_number">Sanction Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->sanction_number) ?>" id="sanction_number" name="sanction_number" placeholder="Sanction Number">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="loan_booked_to">Loan Booked To</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->loan_booked_to) ?>" id="loan_booked_to" name="loan_booked_to" placeholder="Loan Booked To">
                            </div>
                          </div>

                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-3" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-3">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Payment Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Payment Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-payment-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- status update -->
              <div class="col-md-12" id="status-update-details">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Status Update Details</h3>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <div class="col-md-4">
                            <label for="claim_number">Claim Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->claim_number) ?>" id="bankName" name="claim_number" placeholder="Claim Number">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="utr_number">UTR Number</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->utr_number) ?>" id="bankName" name="utr_number" placeholder="UTR Number">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="approval_amount">Approval Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->approval_amount) ?>" id="bankName" name="approval_amount" placeholder="Approval Amount">
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="approval_date">Approval Date</label>
                            <div class="input-group date" id="reservationdate9" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->approval_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate9" name="approval_date" />
                              <div class="input-group-append" data-target="#reservationdate9" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="settlement_date">Settlement Date</label>
                            <div class="input-group date" id="reservationdate10" data-target-input="nearest">
                              <input type="text" value="<?php echo ($case->settlement_date) ?>" class="form-control datetimepicker-input" data-target="#reservationdate10" name="settlement_date" />
                              <div class="input-group-append" data-target="#reservationdate10" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label for="settlement_letter">Settlement Letter</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->settlement_letter) ?>" id="settlement_letter" name="settlement_letter" placeholder="Settlement Letter" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->settlement_letter) ?>"><?php echo substr($case->settlement_letter, 8); ?></a></span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="query_resolution_doc_status">Query Resolution Doc</label>
                            <div>
                              <input type="file" class="form-control" value="<?php echo ($case->query_resolution_doc_status) ?>" id="query_resolution_doc_status" name="query_resolution_doc_status" placeholder="Query Resolution Doc" accept=".pdf,.doc,.docx,.txt">
                              <span><a target="_blank" href="<?php echo ($case->query_resolution_doc_status) ?>"><?php echo substr($case->query_resolution_doc_status, 8); ?></a></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-3">
                            <label for="cheque_amount">Cheque Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->cheque_amount) ?>" id="bankName" name="cheque_amount" placeholder="Cheque Amount">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="tds_amount">TDS Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->tds_amount) ?>" id="bankName" name="tds_amount" placeholder="TDS Amount">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="gst_amount">GST Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->gst_amount) ?>" id="bankName" name="gst_amount" placeholder="GST Amount">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="comission_amount">Comission Amount</label>
                            <div>
                              <input type="text" class="form-control" value="<?php echo ($case->comission_amount) ?>" id="bankName" name="comission_amount" placeholder="Comission Amount">
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-status-update" style="margin-top: 10px;">
                              Submit
                            </button>
                          </div>
                          <div class="modal fade" id="modal-default-status-update">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Status Update Details Creation/Updation!</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to create/update Status Update Details?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="submit" name="submit-patient-status-update-details" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>

                      <div class="col-md-12" id="policy-remarks">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Status Update Details Remarks</h3>
                          </div>
                          <div class="card-body">
                            <div class="tab-content">
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label for="remarkType">Status Update Remark Type</label>
                                    <div>
                                      <input type="text" class="form-control" value="<?php echo ($case->remark_type) ?>" id="remarkType" name="remark_type" placeholder="Remark Type">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="remark">Status Update Remark</label>
                                    <div>
                                      <textarea class="form-control" name="remark" id="remark" placeholder="Remark"><?php echo ($case->remark) ?></textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-status-update-remark" style="margin-top: 10px;">
                                      Submit
                                    </button>
                                  </div>
                                  <div class="modal fade" id="modal-default-status-update-remark">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Status Update Creation/Updation!</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>Are you sure you want to Enter Status Update Details?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                          <button type="submit" name="submit-patient-status-update-remark" class="btn btn-danger">Submit</button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                </div>
                              </form>

                              <table class="table table-striped projects">
                                <thead>
                                  <tr>
                                    <th style="width: 10%">
                                      Sr No.
                                    </th>
                                    <th style="width: 10%">
                                      Remark Type
                                    </th>
                                    <th style="width: 25%">
                                      Remark
                                    </th>
                                    <th style="width: 20%">
                                      Author
                                    </th>
                                    <th style="width: 20%">
                                      Date Time
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php


                                  $sql = mysqli_query(
                                    $con,
                                    "SELECT 
                                      psur.id,
                                      psur.case_id,
                                      psur.remark_type,
                                      psur.remark,
                                      psur.is_active,
                                      psur.inserted_by,
                                      psur.created_at,
                                      psur.inserted_by
                                      FROM 
                                          patient_status_update_remarks psur 
                                      WHERE 
                                          psur.is_active = 1 AND psur.case_id=$cid"
                                  );
                                  $cnt = 1;
                                  while ($row = mysqli_fetch_array($sql)) {
                                  ?>
                                    <tr>
                                      <td>
                                        <?php echo ($cnt) ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['remark'] ?>
                                      </td>
                                      <td>
                                        <?php echo $row['inserted_by'] ?>
                                      </td>

                                      <td>
                                        <?php echo $row['created_at'] ?>
                                      </td>
                                    </tr>
                                  <?php
                                    $cnt = $cnt + 1;
                                  } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
      <?php include('include/footer.php') ?>
    </div>


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    <!-- SweetAlert2 -->
    <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="./plugins/toastr/toastr.min.js"></script>


    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="./plugins/select2/js/select2.full.min.js"></script>
    <script src="./plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="./plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="./plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="./plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="./plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="./plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="./plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./dist/js/demo.js"></script>

    <script>
      function toggleCorporateFields() {
        var policyType = document.getElementById('policy_type').value;
        var corporateFields = document.getElementById('corporate_fields');
        if (policyType === 'Corporate') {
          corporateFields.style.display = 'flex';
        } else {
          corporateFields.style.display = 'none';
        }
      }

      // Initial check in case the page is loaded with a selected policy type
      document.addEventListener('DOMContentLoaded', function() {
        toggleCorporateFields();
      });
    </script>
    <script>
      $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
          'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
          'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
          format: 'YYYY-MM-DD'
        });
        $('#reservationdate2').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate3').datetimepicker({
          format: 'YYYY-MM-DD',
          minDate: moment().startOf('day')
        });

        $('#reservationdate4').datetimepicker({
          format: 'YYYY-MM-DD'
        });
        $('#reservationdate5').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate6').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate7').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate8').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate9').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        $('#reservationdate10').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
          icons: {
            time: 'far fa-clock'
          }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
          function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

      })
      // BS-Stepper Init
      document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })

      // DropzoneJS Demo Code Start
      Dropzone.autoDiscover = false

      // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
      var previewNode = document.querySelector("#template")
      previewNode.id = ""
      var previewTemplate = previewNode.parentNode.innerHTML
      previewNode.parentNode.removeChild(previewNode)

      var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
      })

      myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
          myDropzone.enqueueFile(file)
        }
      })

      // Update the total progress bar
      myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
      })

      myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
      })

      // Hide the total progress bar when nothing's uploading anymore
      myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
      })

      // Setup the buttons for all transfers
      // The "add files" button doesn't need to be setup because the config
      // `clickable` has already been specified.
      document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
      }
      document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
      }
      // DropzoneJS Demo Code End
    </script>

    <script>
      // Function to scroll to the top of the page
      function scrollToTop() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }

      // Show or hide the button based on scroll position
      window.onscroll = function() {
        let button = document.getElementById('scrollToTopBtn');
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
          button.style.display = 'block';
        } else {
          button.style.display = 'none';
        }
      };
    </script>
  </body>

  </html>
<?php } ?>