
<?php
include("../config/database.php");

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("Delete FROM meds WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {


        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Medicine removed successfully.';
        header("Location: ../view/pages/inventory.php");
        exit;
    } else {

        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the Medicine';
        header("Location: ../view/pages/inventory.php");
        exit;
    }

    $stmt->close();
} else if (isset($_POST['delete-form'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("Delete FROM admin WHERE username = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {


        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'A record is removed successfully.';
        header("Location: ../view/pages/enrolledstudentlist.php");
        exit;
    } else {

        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the record';
        header("Location: ../view/pages/enrolledstudentlist.php");
        exit;
    }
} else if (isset($_POST['form-del'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("Delete FROM medforms WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {


        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'A form is removed successfully.';
        header("Location: ../view/pages/studentlist.php");
        exit;
    } else {

        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'Failed to Delete the form';
        header("Location: ../view/pages/studentlist.php");
        exit;
    }
}
?>