<?php
include('/config/database.php');

$id = $_POST['id'];
$fullname = $_POST['fullname'];

$nameParts = explode(',', $fullname);
$lastname = trim(strtolower($nameParts[0]));
$firstname = trim(strtolower($nameParts[1] ?? ''));

if ($firstname == '') {
  session_start();
  $_SESSION['modal_title'] = 'Invalid Format';
  $_SESSION['modal_message'] = 'The Fullname Field Must be (Lastname, Firstname)';
  header("Location: /View/pages/medicalinformation.php");
  exit;
}

$gender = $_POST['gender'];
$_date = $_POST['_date'];
$_address = $_POST['_address'];
$birthdate = $_POST['birthdate'];
$birthplace = $_POST['birthplace'];
$religion = $_POST['religion'];
$citizenship = $_POST['citizenship'];
$guardian = $_POST['guardian'];
$relationship = $_POST['relationship'];
$contact = $_POST['contact'];

$adhd = $_POST['adhd'];
$asthma = $_POST['asthma'];
$anemia = $_POST['anemia'];
$bleeding = $_POST['bleeding'];
$cancer = $_POST['cancer'];
$chestpain = $_POST['chestpain'];
$diabetes = $_POST['diabetes'];
$fainting = $_POST['fainting'];
$fracture = $_POST['fracture'];
$hearing_speach = $_POST['hearing_speach'];
$heart_condition = $_POST['heart_condition'];
$lung_prob = $_POST['lung_prob'];
$mental_prob = $_POST['mental_prob'];
$migraine = $_POST['migraine'];
$seizure = $_POST['seizure'];
$tubercolosis = $_POST['tubercolosis'];
$hernia = $_POST['hernia'];
$kidney_prob = $_POST['kidney_prob'];
$vision = $_POST['vision'];
$other = $_POST['other'];

$specify = $_POST['specify'];
$medication_treatment = $_POST['medication_treatment'];
$medication_past = $_POST['medication_past'];
$current_medication = $_POST['current_medication'];
$allergy = $_POST['allergy'];
$if_yes = $_POST['if_yes'];
$childhood_illness = $_POST['childhood_illness'];

$bcg = $_POST['bcg'];
$dpt = $_POST['dpt'];
$opv = $_POST['opv'];
$hepb = $_POST['hepb'];
$measleVac = $_POST['measleVac'];
$fluVaccine = $_POST['fluVaccine'];
$varicella = $_POST['varicella'];
$mmr = $_POST['mmr'];
$etc = $_POST['etc'];

$tetanus = $_POST['tetanus'];
$vaccineName = $_POST['vaccineName'];
$date_last_given = $_POST['date_last_given'];
$hospitalize_before = $_POST['hospitalize_before'];
$_year = $_POST['_year'];
$reason = $_POST['reason'];
$family_med_history = $_POST['family_med_history'];
$fem_height = $_POST['fem_height'];
$fem_weight = $_POST['fem_weight'];
$first_menstrual = $_POST['first_menstrual'];
$first_dose_date = $_POST['first_dose_date'];
$second_dose_date = $_POST['second_dose_date'];
$vaccine_manufacturer = $_POST['vaccine_manufacturer'];
$booster = $_POST['booster'];
$plus_covid_date = $_POST['plus_covid_date'];

$sql = "UPDATE medforms SET
  firstname=?, lastname=?, gender=?, _date=?, _address=?, birthdate=?, birthplace=?, religion=?, citizenship=?, guardian=?, relationship=?, contact=?,
  adhd=?, asthma=?, anemia=?, bleeding=?, cancer=?, chestpain=?, diabetes=?, fainting=?, fracture=?, hearing_speach=?, heart_condition=?,
  lung_prob=?, mental_prob=?, migraine=?, seizure=?, tubercolosis=?, hernia=?, kidney_prob=?, vision=?, other=?,
  specify=?, medication_treatment=?, medication_past=?, current_medication=?, allergy=?, if_yes=?, childhood_illness=?,
  bcg=?, dpt=?, opv=?, hepb=?, measleVac=?, fluVaccine=?, varicella=?, mmr=?, etc=?,
  tetanus=?, vaccineName=?, date_last_given=?, hospitalize_before=?, _year=?, reason=?, family_med_history=?, fem_height=?,
  fem_weight=?, first_menstrual=?, first_dose_date=?, second_dose_date=?, vaccine_manufacturer=?, booster=?, plus_covid_date=?
WHERE id = ?";

$params = [
  $firstname,
  $lastname,
  $gender,
  $_date,
  $_address,
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
  $bcg,
  $dpt,
  $opv,
  $hepb,
  $measleVac,
  $fluVaccine,
  $varicella,
  $mmr,
  $etc,
  $tetanus,
  $vaccineName,
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
  $plus_covid_date,
  $id // final WHERE clause
];

$stmt = sqlsrv_prepare($conn, $sql, $params);

if ($stmt === false) {
  die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt)) {
  echo "success";
} else {
  echo "error: ";
  print_r(sqlsrv_errors(), true);
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
