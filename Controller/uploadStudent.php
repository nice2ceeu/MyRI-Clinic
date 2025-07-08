<?php
require '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include('/config/database.php');

if (isset($_POST['upload'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filePath = $_FILES["file"]["tmp_name"];
        $success = 0;
        $failed = 0;
        $user_role = "student";

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        foreach ($rows as $index => $row) {
            // Skip header
            if ($index === 1) continue;

            $firstname = isset($row['A']) ? strtolower(trim($row['A'])) : '';
            $lastname  = isset($row['B']) ? strtolower(trim($row['B'])) : '';
            $username  = isset($row['C']) ? trim($row['C']) : '';

            // Check for exactly 3 non-empty values
            if (empty($firstname) || empty($lastname) || empty($username)) {
                session_start();
                $_SESSION['modal_title'] = 'Invalid File Format';
                $_SESSION['modal_message'] = "Row $index is missing required data (Firstname, Lastname, Username).";
                header("Location: /View/pages/enrolledstudentlist.php");
                exit;
            }

            // Check for existing username
            $checkSql = "SELECT 1 FROM admin WHERE username = ?";
            $checkStmt = sqlsrv_query($conn, $checkSql, [$username]);

            if ($checkStmt && sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
                $failed++;
                continue;
            }

            // Insert new user
            $insertSql = "INSERT INTO admin (firstname, lastname, username, user_role) VALUES (?, ?, ?, ?)";
            $params = [$firstname, $lastname, $username, $user_role];
            $insertStmt = sqlsrv_prepare($conn, $insertSql, $params);

            if ($insertStmt && sqlsrv_execute($insertStmt)) {
                $success++;
            } else {
                $failed++;
            }
        }

        session_start();
        if ($success === 0 && $failed === 0) {
            $_SESSION['modal_title'] = 'No Records';
            $_SESSION['modal_message'] = 'No valid rows found in the file.';
        } elseif ($success === 0) {
            $_SESSION['modal_title'] = 'Already Exists';
            $_SESSION['modal_message'] = 'All usernames already exist or failed to insert.';
        } elseif ($failed > 0) {
            $_SESSION['modal_title'] = 'Partial Success';
            $_SESSION['modal_message'] = "$success row(s) inserted. $failed duplicate(s) or failed.";
        } else {
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'All student records uploaded successfully.';
        }

        header("Location: /View/pages/enrolledstudentlist.php");
        exit;
    } else {
        echo "File upload failed.";
    }
}
