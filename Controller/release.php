<?php
include("../config/database.php");

if (isset($_POST['release'])) {
    $id = $_POST['user_id']; // Patient ID
    $withMedicine = $_POST['treatment'];

    date_default_timezone_set('Asia/Manila');
    $checkout = date("h:i:s A");
    $dateConsumed = date("Y-m-d");

    if ($withMedicine == "yes") {
        $medicine = trim($_POST['medicine'] ?? '');
        $quantity = trim($_POST['medicine_qty'] ?? '');

        // || $quantity === ""

        if ($medicine === "" || $quantity === "") {
            echo
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Please fill all fields for medicinal treatment.';
            header("Location: ../view/pages/Current-Patients.php");

            exit;
        }

        $medicineLower = strtolower($medicine);

        // Get current quantity from meds table
        $getCurrentQty = $conn->prepare("SELECT * FROM meds WHERE Medicine_Name = ?");
        $getCurrentQty->bind_param("s", $medicineLower);
        $getCurrentQty->execute();
        $result = $getCurrentQty->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currQty = (int)$row['Med_Quantity'];
            $medicine_id = $row['id']; // avoid overwriting $id

            if ($currQty < (int)$quantity) {
                echo
                session_start();
                $_SESSION['modal_title'] = 'Alert';
                $_SESSION['modal_message'] = 'Not enough stock in medical inventory';
                header("Location: ../view/pages/Current-Patients.php");
                exit;
            }

            $newQty = $currQty - (int)$quantity;


            $stmt = $conn->prepare("UPDATE visitor SET withMedicine = ?, medicine = ?, Quantity = ?, checkout = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $withMedicine, $medicineLower, $quantity, $checkout, $id);
            $stmt->execute();


            $stmt1 = $conn->prepare("UPDATE meds SET Med_Quantity = ? WHERE Medicine_Name = ?");
            $stmt1->bind_param("is", $newQty, $medicineLower);
            $stmt1->execute();

            $stmtCheck = $conn->prepare("SELECT Med_Quantity FROM used_meds WHERE Medicine_name = ?");
            $stmtCheck->bind_param("s", $medicineLower);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $row = $resultCheck->fetch_assoc();
                $updatedQuantity = (int)$quantity + (int)$row['Med_Quantity'];


                $stmt3 = $conn->prepare("UPDATE used_meds SET id =?, Med_Quantity = ?, Date_Consumed = ? WHERE Medicine_name = ?");
                $stmt3->bind_param("siss", $medicine_id,$updatedQuantity, $dateConsumed, $medicineLower);
            } else {

                $stmt3 = $conn->prepare("INSERT INTO used_meds (id, Medicine_name, Med_Quantity, Date_Consumed) VALUES (?, ?, ?, ?)");
                $stmt3->bind_param("isis", $medicine_id, $medicineLower, $quantity, $dateConsumed);
            }

            $stmt3->execute();

            echo
            session_start();
            $_SESSION['modal_title'] = 'successfull';
            $_SESSION['modal_message'] = 'Patient record updated. You can check it in the visitor history';
            header("Location: ../view/pages/Current-Patients.php");
            exit;
        } else {
            echo
            session_start();
            $_SESSION['modal_title'] = 'ALERT';
            $_SESSION['modal_message'] = 'Medicine not found in inventor';
            header("Location: ../view/pages/Current-Patients.php");
            exit;
        }
    } else if ($withMedicine == "no") {
        $physicalTreatment = trim($_POST['physical-treatment'] ?? '');

        if ($physicalTreatment === "") {
            echo
            session_start();
            $_SESSION['modal_title'] = 'Alert';
            $_SESSION['modal_message'] = 'Please fill all fields for physical treatment.';
            header("Location: ../view/pages/Current-Patients.php");

            exit;
        }

        $stmt = $conn->prepare("UPDATE visitor SET physical_treatment = ?, checkout = ? WHERE id = ?");
        $stmt->bind_param("ssi", $physicalTreatment, $checkout, $id);
        $stmt->execute();

        echo
        session_start();
        $_SESSION['modal_title'] = 'successfull';
        $_SESSION['modal_message'] = 'Patient record updated. You can check it in the visitor history';
        header("Location: ../view/pages/Current-Patients.php");
        exit;
    }
}
