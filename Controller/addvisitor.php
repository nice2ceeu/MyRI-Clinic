<?php


use BcMath\Number;

include("../config/database.php");
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

        $patientAlready = $conn->prepare("SELECT * from visitor where firstname =? AND lastname =? AND checkout =''");
        $patientAlready->execute([$lowfirst, $lowlast]);
        $existing = $patientAlready->get_result();

        if ($existing->num_rows > 0) {
            session_start();
            $_SESSION['modal_title'] = 'Duplicate Entry';
            $_SESSION['modal_message'] = 'Patient is already checked in.';
            header("Location: ../view/pages/Clinic-Patient.php");
            exit();
        }



        $stmt = $conn->prepare("INSERT INTO visitor (firstname, lastname, complaint,grade,section, checkin, _date) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("sssisss", $lowfirst, $lowlast, $complaint, $grade, $lowsec, $checkin, $date);
        $stmt->execute();


        session_start();
        $_SESSION['modal_title'] = 'Success';
        $_SESSION['modal_message'] = 'Patient added';
        header("Location: ../view/pages/Clinic-Patient.php");
        exit();
    }
}
