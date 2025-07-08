<?php
include("/config/database.php");

if (isset($_POST['release'])) {
    $id = $_POST['user_id']; // Patient ID
    $withMedicine = $_POST['treatment'];

    date_default_timezone_set('Asia/Manila');
    $checkout = date("h:i:s A");
    $dateConsumed = date("Y-m-d");

    if ($withMedicine == "yes") {
        $medicine = trim($_POST['medicine'] ?? '');
        $quantity = trim($_POST['medicine_qty'] ?? '');

        if ($medicine === "" || $quantity === "") {
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Please fill all fields for medicinal treatment.';
            header("Location: /View/pages/current-patients.php");
            exit;
        }

        $medicineLower = strtolower($medicine);

        // Select the medicine with the lowest quantity
        $query = "SELECT TOP 1 * FROM meds WHERE Medicine_Name = ? ORDER BY Med_Quantity ASC, Expiration_Date ASC";
        $params = array($medicineLower);
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $currQty = (int)$row['Med_Quantity'];
            $medicine_id = $row['id'];

            if ($currQty < (int)$quantity) {
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'Not enough stock in medical inventory';
                header("Location: /View/pages/current-patients.php");
                exit;
            }

            $newQty = $currQty - (int)$quantity;

            $updateVisitor = "UPDATE visitor SET withMedicine = ?, medicine = ?, Quantity = ?, checkout = ? WHERE id = ?";
            $paramsVisitor = array($withMedicine, $medicineLower, (int)$quantity, $checkout, (int)$id);
            sqlsrv_query($conn, $updateVisitor, $paramsVisitor);

            $updateMeds = "UPDATE meds SET Med_Quantity = ? WHERE id = ?";
            $paramsMeds = array($newQty, $medicine_id);
            sqlsrv_query($conn, $updateMeds, $paramsMeds);

            $checkUsed = "SELECT Med_Quantity FROM used_meds WHERE Medicine_name = ?";
            $paramsCheck = array($medicineLower);
            $stmtCheck = sqlsrv_query($conn, $checkUsed, $paramsCheck);

            if ($stmtCheck && $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC)) {
                $updatedQuantity = (int)$quantity + (int)$rowCheck['Med_Quantity'];
                $updateUsed = "UPDATE used_meds SET id = ?, Med_Quantity = ?, Date_Consumed = ? WHERE Medicine_name = ?";
                $paramsUsed = array($medicine_id, $updatedQuantity, $dateConsumed, $medicineLower);
            } else {
                $updateUsed = "INSERT INTO used_meds (id, Medicine_name, Med_Quantity, Date_Consumed) VALUES (?, ?, ?, ?)";
                $paramsUsed = array($medicine_id, $medicineLower, (int)$quantity, $dateConsumed);
            }

            sqlsrv_query($conn, $updateUsed, $paramsUsed);

            session_start();
            $_SESSION['modal_title'] = 'successfull';
            $_SESSION['modal_message'] = 'Patient record updated. You can check it in the visitor history';
            header("Location: /View/pages/current-patients.php");
            exit;
        } else {
            session_start();
            $_SESSION['modal_title'] = 'ALERT';
            $_SESSION['modal_message'] = 'Medicine not found in inventory';
            header("Location: /View/pages/current-patients.php");
            exit;
        }
    } else if ($withMedicine == "no") {
        $physicalTreatment = trim($_POST['physical-treatment'] ?? '');

        if ($physicalTreatment === "") {
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Please fill all fields for physical treatment.';
            header("Location: /View/pages/current-patients.php");
            exit;
        }

        $updateVisitor = "UPDATE visitor SET physical_treatment = ?, checkout = ? WHERE id = ?";
        $paramsVisitor = array($physicalTreatment, $checkout, (int)$id);
        sqlsrv_query($conn, $updateVisitor, $paramsVisitor);

        session_start();
        $_SESSION['modal_title'] = 'successfull';
        $_SESSION['modal_message'] = 'Patient record updated. You can check it in the visitor history';
        header("Location: /View/pages/current-patients.php");
        exit;
    }
}
