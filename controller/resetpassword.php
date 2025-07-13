<?php
include('../config/database.php');

if (isset($_POST['reset'])) {
    $id = $_POST['id'];
    $defaultPass = "00000000";
    $hashed = password_hash($defaultPass, PASSWORD_DEFAULT);

    $sql = "UPDATE admin SET password = ? WHERE id = ?";
    $params = array($hashed, $id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        echo "<script>
            alert('Password has been reset. Password: 00000000');
            window.location.href ='../view/pages/enrolledstudentlist.php';
        </script>";
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

if (isset($_POST['reset-password'])) {
    $id = $_POST['id'];
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];

    if ($newPass === $confirmPass && strlen($newPass) > 8) {
        $sql = "SELECT password FROM admin WHERE id = ?";
        $params = array($id);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (password_verify($currentPass, $row['password'])) {
                $hashed = password_hash($newPass, PASSWORD_DEFAULT);

                $updateSql = "UPDATE admin SET password = ? WHERE id = ?";
                $updateParams = array($hashed, $id);
                $updateStmt = sqlsrv_query($conn, $updateSql, $updateParams);

                if ($updateStmt) {
                    session_start();
                    $_SESSION['modal_title'] = 'Success';
                    $_SESSION['modal_message'] = 'Password Successfully Changed!';
                    header("Location: ../view/pages/userprofile.php");
                    exit;
                } else {
                    die(print_r(sqlsrv_errors(), true));
                }
            } else {
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'Current Password does not match our records.';
                header("Location: ../view/pages/changepass.php");
                exit;
            }
        } else {
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'User not found.';
            header("Location: ../view/pages/changepass.php");
            exit;
        }
    } else {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Passwords must match and be longer than 8 characters.';
        header("Location: ../view/pages/changepass.php");
        exit;
    }
}
