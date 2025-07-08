<?php
include("/config/database.php"); // assumes $conn is your sqlsrv_connect() connection

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

                    if ($_SESSION['user_role'] === "admin") {
                        header("Location: /View/pages/clinic-patient.php");
                        exit();
                    } elseif ($_SESSION['user_role'] === "student") {
                        header("Location: /View/pages/userprofile.php");
                        exit();
                    }
                } else {
                    session_start();
                    $_SESSION['modal_title'] = 'Alert';
                    $_SESSION['modal_message'] = 'Invalid Password';
                    header("Location: /View/pages/index.php");
                    exit();
                }
            } else {
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'User not found';
                header("Location: /View/pages/index.php");
                exit();
            }
        } else {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
