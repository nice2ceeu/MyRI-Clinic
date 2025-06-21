<?php
include('../config/database.php');

if (isset($_POST['add'])) {
    $medName = $_POST['medicine_name'];
    $medqty = $_POST['medicine_qty'];
    $medExpiration = $_POST['expiration'];

    try {
        date_default_timezone_set('Asia/Manila');
        $issued = date("Y-m-d");

        // Check if the medicine exists with the same expiration date
        $checkStmt = $conn->prepare("SELECT Med_Quantity FROM meds WHERE LOWER(Medicine_Name) = LOWER(?) AND Expiration_Date = ?");
        $checkStmt->bind_param("ss", $medName, $medExpiration);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Medicine with same name and expiration exists — update quantity
            $row = $result->fetch_assoc();
            $existingQty = (int)$row['Med_Quantity'];
            $incomingQty = (int)$medqty;
            $newQty = $existingQty + $incomingQty;

            $updateStmt = $conn->prepare("UPDATE meds SET Med_Quantity = ?, issued = ? WHERE LOWER(Medicine_Name) = LOWER(?) AND Expiration_Date = ?");
            $updateStmt->bind_param("isss", $newQty, $issued, $medName, $medExpiration);
            $updateStmt->execute();

            session_start();
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'Medicine quantity updated successfully.';
            header("Location: ../view/pages/inventory.php");
            exit;
        } else {
            // New medicine or different expiration date — insert as new
            $insertStmt = $conn->prepare("INSERT INTO meds (Medicine_Name, Med_Quantity, Expiration_Date, issued) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("ssss", $medName, $medqty, $medExpiration, $issued);
            $insertStmt->execute();

            session_start();
            $_SESSION['modal_title'] = 'New Medicine';
            $_SESSION['modal_message'] = 'New medicine added to inventory.';
            header("Location: ../view/pages/inventory.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
