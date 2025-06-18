
<?php
include("../config/database.php");

if (isset($_POST["submit"])) {
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $_date = $_POST['date'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthday'];
    $birthplace = $_POST['birthplace'];
    $religion = $_POST['religion'];
    $citizenship = $_POST['citizenship'];
    $guardian = $_POST['emergencyContact'];
    $relationship = $_POST['relationship'];
    $contact = $_POST['contactNumber'];
    $adhd = $_POST['adhd'];
    $asthma = $_POST['asthma'];
    $anemia = $_POST['anemia'];
    $bleeding = $_POST['bleeding'];
    $cancer = $_POST['cancer'];
    $chestpain = $_POST['chestpain'];
    $diabetes = $_POST['diabetes'];
    $fainting = $_POST['fainting'];
    $fracture = $_POST['fracture'];
    $hearing_speach = $_POST['hearing'];
    $heart_condition = $_POST['heart'];
    $lung_prob = $_POST['lung'];
    $mental_prob = $_POST['mental'];
    $migraine = $_POST['migraine'];
    $seizure = $_POST['seizure'];
    $tubercolosis = $_POST['tb'];
    $hernia = $_POST['hernia'];
    $kidney_prob = $_POST['kidney'];
    $vision = $_POST['vision'];
    $other = $_POST['other'];
    $specify = $_POST['specify'] ?? 'no';
    $medication_treatment = $_POST['underMedication'];
    $medication_past = $_POST['pastMedication'];
    $current_medication = $_POST['currentMedication'];
    $allergy = $_POST['allergy'];
    $if_yes = $_POST['yes_allergy'] ?? '';
    $childhood_illness = $_POST['chillhoodIllness'] ?? '';
    $bcg = $_POST['bcg'] ?? 'no';
    $dpt = $_POST['dpt'] ?? 'no';
    $opv = $_POST['opv'] ?? 'no';
    $hepb = $_POST['hep-b'] ?? 'no';
    $fluVaccine = $_POST['fluVaccine'] ?? 'no';
    $measleVac = $_POST['measleVac'] ?? 'no';
    $varicella = $_POST['varicella'] ?? 'no';
    $mmr = $_POST['mmr'] ?? 'no';
    $etc = $_POST['etc'] ?? 'no';
    $tetanus = $_POST['tetanus'];
    $vaccineName = $_POST['vaccineName'] ?? 'no';
    $date_last_given = $_POST['date_last_given'];
    $hospitalize_before = $_POST['hospitalized'] ?? '';
    $_year = $_POST['_year'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $family_med_history = $_POST['Family-medical-history'] ?? '';
    $fem_height = $_POST['height'] ?? '';
    $fem_weight = $_POST['weight'] ?? '';
    $first_menstrual = $_POST['firstMens'] ?? '';
    $first_dose_date = $_POST['firstDose'] ?? '';
    $second_dose_date = $_POST['secondDose'] ?? '';
    $vaccine_manufacturer = $_POST['vaccineBrand'] ?? '';
    $booster = $_POST['booster'] ?? '';
    $plus_covid_date = $_POST['plusCovid'] ?? '';

    $name = explode(',', $fullname);
    $lastname = strtolower($name[0] ?? '');
    $firstname = strtolower(trim($name[1] ?? ''));

    // Sanitize special variables for DB binding
    $_bcg = $bcg;
    $_dpt = $dpt;
    $_opv = $opv;
    $_hepb = $hepb;
    $_measleVac = $measleVac;
    $_flu_vaccine = $fluVaccine;
    $_varicella = $varicella;
    $_mmr = $mmr;
    $_etc = $etc;
    $_vaccineName = $vaccineName;

    $checkStmt = $conn->prepare("SELECT id FROM medforms WHERE firstname = ? AND lastname = ?");
    $checkStmt->bind_param("ss", $firstname, $lastname);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo
        // ??? not working alert mo 
        session_start();
        $_SESSION['modal_title'] = 'Alert';
        $_SESSION['modal_message'] = 'This patient already exists in the record';
        header("Location: ../view/pages/medicalform.php");
        exit;
    }

    $checkStmt->close();

    $stmt = $conn->prepare("INSERT INTO medforms (
        firstname, lastname, gender, _date, _address, birthdate, birthplace,
        religion, citizenship, guardian, relationship, contact,
        adhd, asthma, anemia, bleeding, cancer, chestpain, diabetes, fainting,
        fracture, hearing_speach, heart_condition, lung_prob, mental_prob, migraine,
        seizure, tubercolosis, hernia, kidney_prob, vision, other, specify,
        medication_treatment, medication_past, current_medication,
        allergy, if_yes, childhood_illness, 
        bcg, dpt, opv, hepb,measleVac, fluVaccine, varicella,
        mmr, etc, tetanus, vaccineName,date_last_given,
        hospitalize_before, _year, reason, family_med_history,
        fem_height, fem_weight, first_menstrual,
        first_dose_date, second_dose_date, vaccine_manufacturer,
        booster, plus_covid_date) 
        VALUES (?, ?, ?, ?, ?
        , ?, ?, ?, ?, ?,
         ?,?, ?, ?, ?,
          ?, ?, ?, ?, ?,
           ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
             ?, ?, ?, ?, ?,
              ?, ?, ?, ?, ?,
               ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                 ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?,?,
                   ?, ?)");

    $stmt->bind_param(
        "sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
        $firstname,
        $lastname,
        $gender,
        $_date,
        $address,
        $birthdate,
        $birthplace,
        $religion,
        $citizenship,
        $guardian,
        $relationship,
        $contact,
        $adhd,
        $asthma,
        $anemia,
        $bleeding,
        $cancer,
        $chestpain,
        $diabetes,
        $fainting,
        $fracture,
        $hearing_speach,
        $heart_condition,
        $lung_prob,
        $mental_prob,
        $migraine,
        $seizure,
        $tubercolosis,
        $hernia,
        $kidney_prob,
        $vision,
        $other,
        $specify,
        $medication_treatment,
        $medication_past,
        $current_medication,
        $allergy,
        $if_yes,
        $childhood_illness,
        $_bcg,
        $_dpt,
        $_opv,
        $_hepb,
        $_measleVac,
        $_flu_vaccine,
        $_varicella,
        $_mmr,
        $_etc,
        $tetanus,
        $_vaccineName,
        $date_last_given,
        $hospitalize_before,
        $_year,
        $reason,
        $family_med_history,
        $fem_height,
        $fem_weight,
        $first_menstrual,
        $first_dose_date,
        $second_dose_date,
        $vaccine_manufacturer,
        $booster,
        $plus_covid_date
    );

    $stmt->execute();
    echo
    // ??? not working alert mo 
    session_start();
    $_SESSION['modal_title'] = 'successfull';
    $_SESSION['modal_message'] = 'Patient record updated. You can check it in the visitor history';
    header("Location: ../view/pages/medicalform.php");
    exit;
}
?>
