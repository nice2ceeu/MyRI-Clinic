<?php

include('../config/database.php');

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    try {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $params = array($username);
        $stmt = sqlsrv_prepare($conn, $sql, $params);

        if (!$stmt) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_execute($stmt)) {
            $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['firstname'] = $user['firstname'];
                    $_SESSION['lastname'] = $user['lastname'];
                    $_SESSION['user_role'] = $user['user_role'];

                    // Safely check before closing session
                    $role = $_SESSION['user_role'];
                    session_write_close();

                    if ($role === "admin") {
                        echo "<script>location.href='/view/pages/clinic-patient.php';</script>";
                        exit();
                    } elseif ($role === "student") {
                        echo "<script>location.href='/view/pages/userprofile.php';</script>";
                        exit();
                    }
                } else {
                    session_start();
                    $_SESSION['modal_title'] = 'Alert';
                    $_SESSION['modal_message'] = 'Invalid Password';
                    session_write_close();
                    echo "<script>location.href='/view/pages/index.php';</script>";
                    exit();
                }
            } else {
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'User not found';
                session_write_close();
                echo "<script>location.href='../view/pages/index.php';</script>";
                exit();
            }
        } else {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
