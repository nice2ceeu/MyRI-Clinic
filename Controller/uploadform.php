

<?php
include("../View/components/body.php");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include('../config/database.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['upload'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filePath = $_FILES["file"]["tmp_name"];
        $success = 0;
        $failed = 0;

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, false, false, false);

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;


            $row = array_map(fn($v) => $v === null ? '' : $v, $row);


            $row = array_slice($row, 0, 63);

            if (count($row) !== 63) {
                echo "<p style='color:red;'>❌ Row $index has " . count($row) . " columns. Skipping.</p>";
                continue;
            }

            try {
                $stmt = $conn->prepare("INSERT INTO medforms (
                    firstname, lastname, gender, _date, _address, birthdate, birthplace,
                    religion, citizenship, guardian, relationship, contact,
                    adhd, asthma, anemia, bleeding, cancer, chestpain, diabetes, fainting,
                    fracture, hearing_speach, heart_condition, lung_prob, mental_prob, migraine,
                    seizure, tubercolosis, hernia, kidney_prob, vision, other, specify,
                    medication_treatment, medication_past, current_medication,
                    allergy, if_yes, childhood_illness, 
                    bcg, dpt, opv, hepb, measleVac, fluVaccine, varicella,
                    mmr, etc, tetanus, vaccineName, date_last_given,
                    hospitalize_before, _year, reason, family_med_history,
                    fem_height, fem_weight, first_menstrual,
                    first_dose_date, second_dose_date, vaccine_manufacturer,
                    booster, plus_covid_date
                ) VALUES (
                    " . rtrim(str_repeat('?, ', 63), ', ') . "
                )");

                $stmt->bind_param(str_repeat('s', 63), ...$row);
                $stmt->execute();
                $success++;
            } catch (Exception $ex) {
                $failed++;
                echo "<p style='color:red;'>Insert failed at row $index: " . $ex->getMessage() . "</p>";
            }
        }

        session_start();
        if ($success === 0 && $failed === 0) {
            $_SESSION['modal_title'] = 'No Records';
            $_SESSION['modal_message'] = 'No records found to process. Try again with another file.';
        } elseif ($success === 0) {
            $_SESSION['modal_title'] = 'Already Exist or Invalid Data';
            $_SESSION['modal_message'] = 'All rows failed to insert. Check for duplicates or format issues.';
        } elseif ($failed > 0) {
            $_SESSION['modal_title'] = 'Partial Success';
            $_SESSION['modal_message'] = "$success record(s) successfully uploaded, $failed failed.";
        } else {
            $_SESSION['modal_title'] = 'Success';
            $_SESSION['modal_message'] = 'All records uploaded successfully.';
        }

        header("Location: ../View/pages/studentlist.php");
        exit;
    } else {
        echo '
<a class="flex bg-[#06118e] poppins uppercase font-semibold text-white w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly text-[max(1vw,1rem)]" href="../View/pages/studentlist.php" ><span>Back</span><img src="../View/assets/icons/back-icon.svg" alt="back-icon"></a>

<div class="flex flex-col gap-5 items-center justify-center overflow-hidden h-[30rem]">
    <img class="absolute top-20 size-20 animate-spin duration-500" src="../View/assets/icons/spin-icon.svg" alt="alert-icon">
    <img class="size-20 animate-pulse duration-500" src="../View/assets/icons/alert-icon.svg" alt="alert-icon">
    <h1 class="text-6xl font-bold poppins">Upload file Failed</h1>
</div>';
    }
}
