<?php
include('../config/database.php');
if (isset($_POST['add'])) {
    $medName = $_POST['medicine_name'];
    $medqty = $_POST['medicine_qty'];
    $medExpiration = $_POST['expiration'];


    try {
        date_default_timezone_set('Asia/Manila');
        $issued = date("Y-m-d");


        $checkStmt = $conn->prepare("SELECT Med_Quantity FROM meds WHERE LOWER(Medicine_Name) = LOWER(?)");
        $checkStmt->bind_param("s", $medName);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $existingQty = (int)$row['Med_Quantity'];
            $incomingQty = (int)$medqty;
            $newQty = $existingQty + $incomingQty;

            $updateStmt = $conn->prepare("UPDATE meds SET Med_Quantity = ?, Expiration_Date = ?, issued = ? WHERE LOWER(Medicine_Name) = LOWER(?)");
            $updateStmt->bind_param("isss", $newQty, $medExpiration, $issued, $medName);
            $updateStmt->execute();

            echo

            session_start();
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'Medicine quantity updated successfully';
            header("Location: ../view/pages/inventory.php");
            exit;
        } else {

            $insertStmt = $conn->prepare("INSERT INTO meds (Medicine_Name, Med_Quantity, Expiration_Date, issued) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("ssss", $medName, $medqty, $medExpiration, $issued);
            $insertStmt->execute();

            echo
            session_start();
            $_SESSION['modal_title'] = 'New Medicine';
            $_SESSION['modal_message'] = 'New medicine added to inventory.';
            header("Location: ../view/pages/inventory.php");
            exit;
            "<script>
            alert('New medicine added to inventory.');
            window.location.href = '../view/pages/inventory.php';
            </script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
