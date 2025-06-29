<?php
include("/config/database.php"); // Assumes $conn from sqlsrv_connect()

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM meds WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Medicine removed successfully.';
        header("Location: /view/pages/inventory.php");
        exit;
    } else {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the Medicine';
        header("Location: /view/pages/inventory.php");
        exit;
    }
} else if (isset($_POST['delete-form'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM admin WHERE username = ?";
    $params = array($id); // ⚠️ username should likely be a string
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'A record is removed successfully.';
        header("Location: /view/pages/enrolledstudentlist.php");
        exit;
    } else {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the record';
        header("Location: /view/pages/enrolledstudentlist.php");
        exit;
    }
} else if (isset($_POST['form-del'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM medforms WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'A form is removed successfully.';
        header("Location: /view/pages/studentlist.php");
        exit;
    } else {
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the form';
        header("Location: /view/pages/studentlist.php");
        exit;
    }
}
