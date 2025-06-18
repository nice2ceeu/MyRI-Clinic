<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include('../config/database.php');

if (isset($_POST['upload'])) {
  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $filePath = $_FILES["file"]["tmp_name"];
    $success = 0;
    $failed = 0;

    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();
    $student = "student";

    foreach ($rows as $index => $row) {
      if ($index === 0) continue;
      if (count(array_filter($row, fn($col) => $col !== null && $col !== '')) !== 3) {
        session_start();
        $_SESSION['modal_title'] = 'Invalid File Format';
        $_SESSION['modal_message'] = 'Each row must contain exactly 3 columns (Firstname, Lastname, Username). Check row ' . ($index + 1);
        header("Location: ../../View/pages/enrolledstudentlist.php");
        exit;
      }

      try {
        $stmt = $conn->prepare("INSERT INTO admin (firstname, lastname, username, user_role) VALUES (?, ?, ?, ?)");
        $stmt->execute([strtolower($row[0]), strtolower($row[1]), $row[2], $student]);
        $success++;
      } catch (Exception $ex) {
        $failed++;
      }
    }

    session_start();
    if ($success == 0 && $failed == 0) {
      $_SESSION['modal_title'] = 'No Records';
      $_SESSION['modal_message'] = 'No records found to process. Try again with a different file.';
    } else if ($success == 0) {
      $_SESSION['modal_title'] = 'Already Exists';
      $_SESSION['modal_message'] = 'Student records might already exist in the Excel file.';
    } else if ($failed > 0) {
      $_SESSION['modal_title'] = 'Partial Success';
      $_SESSION['modal_message'] = $success . ' Successfully Recorded and ' . $failed . ' already existed.';
    } else {
      $_SESSION['modal_title'] = 'Success';
      $_SESSION['modal_message'] = 'All records have been uploaded successfully.';
    }

    header("Location: ../../View/pages/enrolledstudentlist.php");
    exit;
  } else {
    echo "File upload failed.";
  }
}
