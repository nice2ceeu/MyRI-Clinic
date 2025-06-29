<?php
include('/config/database.php');

if (isset($_POST['register'])) {

    $firstname = strtolower(trim($_POST['firstname']));
    $lastname = strtolower(trim($_POST['lastname']));
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (strlen($password) < 8) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Password too short. Must be at least 8 characters long.';
        header("Location: /view/pages/signup.php");
        exit;
    }

    if ($password !== $confirm_password) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Passwords do not match. Please try again.';
        header("Location: /view/pages/signup.php");
        exit;
    }

    // Check for existing user
    $sql = "SELECT * FROM admin WHERE firstname = ? AND lastname = ? AND username = ?";
    $params = array($firstname, $lastname, $username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $userFound = false;
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $userFound = true;

        if (!empty($row['password'])) {
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Already Registered. Please sign in.';
            header("Location: /view/pages/index.php");
            exit;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateSql = "UPDATE admin SET password = ? WHERE username = ?";
            $updateParams = array($hashedPassword, $username);
            $updateStmt = sqlsrv_query($conn, $updateSql, $updateParams);

            if ($updateStmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            session_start();
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'Registration successful. You may now sign in.';
            header("Location: /view/pages/index.php");
            exit;
        }
    }

    if (!$userFound) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'The student is not currently enrolled. Please contact the administrator.';
        header("Location: /view/pages/signup.php");
        exit;
    }
}
