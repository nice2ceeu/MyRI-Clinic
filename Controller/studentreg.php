<?php
include('../config/database.php');

if (isset($_POST['register'])) {

    $firstname = strtolower(trim($_POST['firstname']));
    $lastname = strtolower(trim($_POST['lastname']));
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);


    if (strlen($password) < 8) {
        echo
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Password too short must be at least 8 characters long.';
        header("Location: ../view/pages/signIn.php");
        exit;
    }
    if ($password !== $confirm_password) {
        echo
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Passwords do not match please try again.';
        header("Location: ../view/pages/signIn.php");
        exit;
    } else {
        try {

            $stmt = $conn->prepare("SELECT * FROM admin WHERE firstname = ? AND lastname = ? AND username = ?");
            $stmt->execute([$firstname, $lastname, $username]);
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (!empty($row['password'])) {

                    echo

                    session_start();
                    $_SESSION['modal_title'] = 'Alert';
                    $_SESSION['modal_message'] = 'Already Registered. Please sign in.';
                    header("Location: ../view/pages/index.php");
                    exit;
                } else {

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $updateStmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
                    $updateStmt->execute([$hashedPassword, $username]);

                    echo
                    session_start();
                    $_SESSION['modal_title'] = 'Success';
                    $_SESSION['modal_message'] = 'Registration successful. You may now sign in.';
                    header("Location: ../view/pages/index.php");
                    exit;
                }
            } else {
                echo
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'The Student is not Currently Enroled. Please contact the administrator.';
                header("Location: ../view/pages/signIn.php");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            echo "<script>
                alert('Database error: " . addslashes($e->getMessage()) . "');
                window.location.href = '../view/pages/index.php';
              </script>";
            exit();
        }
    }
}
