<?php
include('../config/database.php');
if (isset($_POST['reset'])) {
    $id = $_POST['id'];
    $defaultPass = "00000000";

    $hashed = password_hash($defaultPass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("Update admin set password=? where id=?");
    $stmt->execute([$hashed, $id]);

    echo "<script>alert('Password has been reset. Password:00000000')
    window.location.href ='../view/pages/enrolledstudentlist.php'
    </script>";
}

if (isset($_POST['reset-password'])) {
    $id = $_POST['id'];
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];

    if ($newPass === $confirmPass && strlen($newPass) > 8) {


        $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($currentPass, $row['password'])) {
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $id]);

            echo
            session_start();
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'Password Successfully Changed!';
            header("Location: ../view/pages/userprofile.php");
            exit;
        } else {
            echo

            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Current Password does not match our records.';
            header("Location: ../view/pages/changepass.php");
            exit;
        }
    } else {
        echo
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Passwords must match and be longer than 8 characters.';
        header("Location: ../view/pages/changepass.php");
        exit;
    }
}
