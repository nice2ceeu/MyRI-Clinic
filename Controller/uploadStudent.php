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
    foreach ($rows as $row) {
      try {
        $stmt = $conn->prepare("INSERT INTO admin (firstname, lastname, username, user_role) VALUES (?, ?, ?,?)");
        $stmt->execute([strtolower($row[0]), strtolower($row[1]), $row[2], $student]);
        $success++;
      } catch (Exception $ex) {
        $failed++;
      }
    }
    if ($success == 0 && $failed == 0) {
      echo
      session_start();
      $_SESSION['modal_title'] = 'No Records';
      $_SESSION['modal_message'] = 'No records found to process try again with other files';
      header("Location: ../../View/pages/enrolledstudentlist.php");
      exit;
    } else if ($success == 0) {
      echo
      session_start();
      $_SESSION['modal_title'] = 'already exist';
      $_SESSION['modal_message'] = 'Student records might already exist on the excel file';
      header("Location: ../../View/pages/enrolledstudentlist.php");
      exit;
    } else if ($failed > 0) {
      echo
      session_start();
      $_SESSION['modal_title'] = 'already exist';
      $_SESSION['modal_message'] = '{$success} Successfully Recorded and {$failed} already existed';
      header("Location: ../../View/pages/enrolledstudentlist.php");
      exit;
    } else {
      echo

      session_start();
      $_SESSION['modal_title'] = 'Success';
      $_SESSION['modal_message'] = 'All records are uploaded successfully';
      header("Location: ../../View/pages/enrolledstudentlist.php");
      exit;
    }
  } else {
    echo "File upload failed.";
  }
}
