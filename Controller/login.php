<?php
include("../config/database.php");

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['user_role'] = $user['user_role'];


                if ($_SESSION['user_role'] == "admin") {
                    header("Location: ../view/pages/Clinic-Patient.php");
                    exit();
                } elseif ($_SESSION['user_role'] == "student") {
                    header("Location: ../view/pages/userprofile.php");
                    exit();
                }
            } else {
                echo
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'Invalid Password';
                header("Location: ../view/pages/index.php");
                exit;
            }
        } else {
            echo

            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'User not found';
            header("Location: ../view/pages/index.php");
            exit;
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
