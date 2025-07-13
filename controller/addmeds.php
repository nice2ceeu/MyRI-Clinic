<?php
include('../config/database.php'); // assumes $conn is sqlsrv_connect()

if (isset($_POST['add'])) {
    $medName = $_POST['medicine_name'];
    $medqty = $_POST['medicine_qty'];
    $medExpiration = $_POST['expiration'];

    try {
        date_default_timezone_set('Asia/Manila');
        $issued = date("Y-m-d");

        // 🔍 1. Check if medicine already exists with same expiration
        $checkSql = "SELECT Med_Quantity FROM meds WHERE LOWER(Medicine_Name) = LOWER(?) AND Expiration_Date = ?";
        $checkParams = array($medName, $medExpiration);
        $checkStmt = sqlsrv_prepare($conn, $checkSql, $checkParams);

        if (!$checkStmt || !sqlsrv_execute($checkStmt)) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        if ($row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
            // ✅ 2. Medicine exists — update quantity
            $existingQty = (int)$row['Med_Quantity'];
            $incomingQty = (int)$medqty;
            $newQty = $existingQty + $incomingQty;

            $updateSql = "UPDATE meds SET Med_Quantity = ?, issued = ? WHERE LOWER(Medicine_Name) = LOWER(?) AND Expiration_Date = ?";
            $updateParams = array($newQty, $issued, $medName, $medExpiration);
            $updateStmt = sqlsrv_prepare($conn, $updateSql, $updateParams);

            if (!$updateStmt || !sqlsrv_execute($updateStmt)) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            session_start();
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'Medicine quantity updated successfully.';
            header("Location: ../view/pages/inventory.php");
            exit;
        } else {
            // 🆕 3. Insert new medicine record
            $insertSql = "INSERT INTO meds (Medicine_Name, Med_Quantity, Expiration_Date, issued) VALUES (?, ?, ?, ?)";
            $insertParams = array($medName, $medqty, $medExpiration, $issued);
            $insertStmt = sqlsrv_prepare($conn, $insertSql, $insertParams);

            if (!$insertStmt || !sqlsrv_execute($insertStmt)) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            session_start();
            $_SESSION['modal_title'] = 'New Medicine';
            $_SESSION['modal_message'] = 'New medicine added to inventory.';
            header("Location: ../view/pages/inventory.php");
            exit;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
