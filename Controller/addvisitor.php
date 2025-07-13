<?php

include("../config/database.php"); // should contain sqlsrv_connect()
include("../View/modal/alert.php");

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $grade = $_POST["grade"];
    $section = $_POST["section"];
    $complaint = $_POST["complaint"];

    if ($firstname == "" || $lastname == "" || $complaint == "" || $grade == "" || $section == "") {
        echo "<script>alert('Please fill all Fields');
        window.location.href = '../view/pages/Clinic-Patient.php';
        </script>";
    } else {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d");
        $lowfirst = strtolower($firstname);
        $lowlast = strtolower($lastname);
        $lowsec = trim(strtolower($section));
        $checkin = date("h:i:s A");

        // 🔍 Check if patient is already checked in
        $checkSql = "SELECT * FROM visitor WHERE firstname = ? AND lastname = ? AND checkout = ''";
        $checkParams = array($lowfirst, $lowlast);
        $checkStmt = sqlsrv_prepare($conn, $checkSql, $checkParams);

        if (!$checkStmt || !sqlsrv_execute($checkStmt)) {
            die("Check error: " . print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
            session_start();
            $_SESSION['modal_title'] = 'Duplicate Entry';
            $_SESSION['modal_message'] = 'Patient is already checked in.';
            header("Location: ../view/pages/Clinic-Patient.php");
            exit();
        }

        // 📝 Insert patient record
        
        $insertSql = "INSERT INTO visitor (firstname, lastname, complaint, grade, section, checkin, _date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertParams = array($lowfirst, $lowlast, $complaint, $grade, $lowsec, $checkin, $date);
        $insertStmt = sqlsrv_prepare($conn, $insertSql, $insertParams);

        if (!$insertStmt || !sqlsrv_execute($insertStmt)) {
            die("Insert error: " . print_r(sqlsrv_errors(), true));
        }

        session_start();
        $_SESSION['modal_title'] = 'Success';
        $_SESSION['modal_message'] = 'Patient added';
        header("Location: ../view/pages/Clinic-Patient.php");
        exit();
    }
}
