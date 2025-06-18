<?php
include('../config/database.php');
require '../vendor/autoload.php';


use PhpOffice\PhpWord\TemplateProcessor;

if (isset($_POST['download'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * from medforms where id=?");
    $stmt->execute([$id]);
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && ($row = $result->fetch_assoc())) {
        // Sanitize values
        echo $_firstname = htmlspecialchars($row['firstname']);
        $_lastname = htmlspecialchars($row['lastname']);
        $gender = htmlspecialchars($row['gender']);
        $_date = htmlspecialchars($row['_date']);
        $_address = htmlspecialchars($row['_address']);
        $birthdate = htmlspecialchars($row['birthdate']);
        $birthplace = htmlspecialchars($row['birthplace']);
        $religion = htmlspecialchars($row['religion']);
        $citizenship = htmlspecialchars($row['citizenship']);
        $guardian = htmlspecialchars($row['guardian']);
        $relationship = htmlspecialchars($row['relationship']);
        $contact = htmlspecialchars($row['contact']);
        $adhd = htmlspecialchars($row['adhd']);
        $asthma = htmlspecialchars($row['asthma']);
        $anemia = htmlspecialchars($row['anemia']);
        $bleeding = htmlspecialchars($row['bleeding']);
        $cancer = htmlspecialchars($row['cancer']);
        $chestpain = htmlspecialchars($row['chestpain']);
        $diabetes = htmlspecialchars($row['diabetes']);
        $fainting = htmlspecialchars($row['fainting']);
        $fracture = htmlspecialchars($row['fracture']);
        $hearing_speech = htmlspecialchars($row['hearing_speach']);
        $heart_condition = htmlspecialchars($row['heart_condition']);
        $lung_prob = htmlspecialchars($row['lung_prob']);
        $mental_prob = htmlspecialchars($row['mental_prob']);
        $migraine = htmlspecialchars($row['migraine']);
        $seizure = htmlspecialchars($row['seizure']);
        $tubercolosis = htmlspecialchars($row['tubercolosis']);
        $hernia = htmlspecialchars($row['hernia']);
        $kidney_prob = htmlspecialchars($row['kidney_prob']);
        $vision = htmlspecialchars($row['vision']);
        $other = htmlspecialchars($row['other']);
        $specify = htmlspecialchars($row['specify']);
        $medication_treatment = htmlspecialchars($row['medication_treatment']);
        $medication_past = htmlspecialchars($row['medication_past']);
        $current_medication = htmlspecialchars($row['current_medication']);
        $allergy = htmlspecialchars($row['allergy']);
        $if_yes = htmlspecialchars($row['if_yes']);
        $childhood_illness = htmlspecialchars($row['childhood_illness']);
        $_bcg = htmlspecialchars($row['bcg']);
        $_dpt = htmlspecialchars($row['dpt']);
        $_opv = htmlspecialchars($row['opv']);
        $_hepb = htmlspecialchars($row['hepb']);
        $_measleVac = htmlspecialchars($row['measleVac']);
        $_flu_vaccine = htmlspecialchars($row['fluVaccine']);
        $_varicella = htmlspecialchars($row['varicella']);
        $_mmr = htmlspecialchars($row['mmr']);
        $_etc = htmlspecialchars($row['etc']);
        $tetanus = htmlspecialchars($row['tetanus']);
        $_vaccineName = htmlspecialchars($row['vaccineName']);
        $date_last_given = htmlspecialchars($row['date_last_given']);
        $hospitalize_before = htmlspecialchars($row['hospitalize_before']);
        $_year = htmlspecialchars($row['_year']);
        $reason = htmlspecialchars($row['reason']);
        $family_med_history = htmlspecialchars($row['family_med_history']);
        $fem_height = htmlspecialchars($row['fem_height']);
        $fem_weight = htmlspecialchars($row['fem_weight']);
        $first_menstrual = htmlspecialchars($row['first_menstrual']);
        $first_dose_date = htmlspecialchars($row['first_dose_date']);
        $second_dose_date = htmlspecialchars($row['second_dose_date']);
        $vaccine_manufacturer = htmlspecialchars($row['vaccine_manufacturer']);
        $booster = htmlspecialchars($row['booster']);
        $plus_covid_date = htmlspecialchars($row['plus_covid_date']);

        // Create Word document
        $template = new TemplateProcessor('../View/pages/template/medform.docx');

        $template->setValue('firstname', $_firstname);
        $template->setValue('lastname', $_lastname);
        $template->setValue('gender', $gender);
        $template->setValue('_date', $_date);
        $template->setValue('_address', $_address);
        $template->setValue('birthdate', $birthdate);
        $template->setValue('birthplace', $birthplace);
        $template->setValue('religion', $religion);
        $template->setValue('citizenship', $citizenship);
        $template->setValue('guardian', $guardian);
        $template->setValue('relationship', $relationship);
        $template->setValue('contact', $contact);

        // Health conditions
        $template->setValue('adhd', $adhd === 'yes' ? '✔' : '✘');
        $template->setValue('asthma', $asthma === 'yes' ? '✔' : '✘');
        $template->setValue('anemia', $anemia === 'yes' ? '✔' : '✘');
        $template->setValue('bleeding', $bleeding === 'yes' ? '✔' : '✘');
        $template->setValue('cancer', $cancer === 'yes' ? '✔' : '✘');
        $template->setValue('chestpain', $chestpain === 'yes' ? '✔' : '✘');
        $template->setValue('diabetes', $diabetes === 'yes' ? '✔' : '✘');
        $template->setValue('fainting', $fainting === 'yes' ? '✔' : '✘');
        $template->setValue('fracture', $fracture === 'yes' ? '✔' : '✘');
        $template->setValue('hearing_speech', $hearing_speech === 'yes' ? '✔' : '✘');
        $template->setValue('heart_condition', $heart_condition === 'yes' ? '✔' : '✘');
        $template->setValue('lung_prob', $lung_prob === 'yes' ? '✔' : '✘');
        $template->setValue('mental_prob', $mental_prob === 'yes' ? '✔' : '✘');
        $template->setValue('migraine', $migraine === 'yes' ? '✔' : '✘');
        $template->setValue('seizure', $seizure === 'yes' ? '✔' : '✘');
        $template->setValue('tubercolosis', $tubercolosis === 'yes' ? '✔' : '✘');
        $template->setValue('hernia', $hernia === 'yes' ? '✔' : '✘');
        $template->setValue('kidney_prob', $kidney_prob === 'yes' ? '✔' : '✘');
        $template->setValue('vision', $vision === 'yes' ? '✔' : '✘');
        $template->setValue('other', $other === 'yes' ? '✔' : '✘');
        $template->setValue('specify', $specify);

        // Medication
        $template->setValue('medication_treatment', $medication_treatment);
        $template->setValue('medication_past', $medication_past);
        $template->setValue('current_medication', $current_medication);

        // Allergies and childhood illness
        $template->setValue('allergy', $allergy);
        $template->setValue('if_yes', $if_yes);
        $template->setValue('childhood_illness', $childhood_illness);

        // Immunizations
        $template->setValue('_bcg', $_bcg === 'yes' ? '✔' : '✘');
        $template->setValue('_dpt', $_dpt === 'yes' ? '✔' : '✘');
        $template->setValue('_opv', $_opv === 'yes' ? '✔' : '✘');
        $template->setValue('_hepb', $_hepb === 'yes' ? '✔' : '✘');
        $template->setValue('_measleVac', $_measleVac === 'yes' ? '✔' : '✘');
        $template->setValue('_fluVaccine', $_flu_vaccine === 'yes' ? '✔' : '✘');
        $template->setValue('_varicella', $_varicella === 'yes' ? '✔' : '✘');
        $template->setValue('_mmr', $_mmr === 'yes' ? '✔' : '✘');
        $template->setValue('_etc', $_etc === 'yes' ? '✔' : '✘');
        $template->setValue('tetanus', $tetanus);
        $template->setValue('_vaccineName', $_vaccineName);
        $template->setValue('date_last_given', $date_last_given);

        // Hospitalization
        $template->setValue('hospitalize_before', $hospitalize_before === 'yes' ? '✔' : '✘');
        $template->setValue('_year', $_year);
        $template->setValue('reason', $reason);
        $template->setValue('family_med_history', $family_med_history);

        // Female only
        $template->setValue('fem_height', $fem_height);
        $template->setValue('fem_weight', $fem_weight);
        $template->setValue('first_menstrual', $first_menstrual);

        // COVID-19
        $template->setValue('first_dose_date', $first_dose_date);
        $template->setValue('second_dose_date', $second_dose_date);
        $template->setValue('vaccine_manufacturer', $vaccine_manufacturer);
        $template->setValue('booster', $booster);
        $template->setValue('plus_covid_date', $plus_covid_date);

        $filename = $_lastname . $_firstname . ".docx";
        $filepath = '../View/pages/downloads/' . $filename;
        $template->saveAs($filepath);

        // Force file download
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . filesize($filepath));
        flush();
        readfile($filepath);
        exit; // Ensure nothing else runs after file is sent
    }
}


if (isset($_POST['download-stud'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $stmt = $conn->prepare("SELECT * from medforms where firstname  =? AND lastname=?");
    $stmt->execute([$firstname, $lastname]);
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && ($row = $result->fetch_assoc())) {
        // Sanitize values
        echo $_firstname = htmlspecialchars($row['firstname']);
        $_lastname = htmlspecialchars($row['lastname']);
        $gender = htmlspecialchars($row['gender']);
        $_date = htmlspecialchars($row['_date']);
        $_address = htmlspecialchars($row['_address']);
        $birthdate = htmlspecialchars($row['birthdate']);
        $birthplace = htmlspecialchars($row['birthplace']);
        $religion = htmlspecialchars($row['religion']);
        $citizenship = htmlspecialchars($row['citizenship']);
        $guardian = htmlspecialchars($row['guardian']);
        $relationship = htmlspecialchars($row['relationship']);
        $contact = htmlspecialchars($row['contact']);
        $adhd = htmlspecialchars($row['adhd']);
        $asthma = htmlspecialchars($row['asthma']);
        $anemia = htmlspecialchars($row['anemia']);
        $bleeding = htmlspecialchars($row['bleeding']);
        $cancer = htmlspecialchars($row['cancer']);
        $chestpain = htmlspecialchars($row['chestpain']);
        $diabetes = htmlspecialchars($row['diabetes']);
        $fainting = htmlspecialchars($row['fainting']);
        $fracture = htmlspecialchars($row['fracture']);
        $hearing_speech = htmlspecialchars($row['hearing_speach']);
        $heart_condition = htmlspecialchars($row['heart_condition']);
        $lung_prob = htmlspecialchars($row['lung_prob']);
        $mental_prob = htmlspecialchars($row['mental_prob']);
        $migraine = htmlspecialchars($row['migraine']);
        $seizure = htmlspecialchars($row['seizure']);
        $tubercolosis = htmlspecialchars($row['tubercolosis']);
        $hernia = htmlspecialchars($row['hernia']);
        $kidney_prob = htmlspecialchars($row['kidney_prob']);
        $vision = htmlspecialchars($row['vision']);
        $other = htmlspecialchars($row['other']);
        $specify = htmlspecialchars($row['specify']);
        $medication_treatment = htmlspecialchars($row['medication_treatment']);
        $medication_past = htmlspecialchars($row['medication_past']);
        $current_medication = htmlspecialchars($row['current_medication']);
        $allergy = htmlspecialchars($row['allergy']);
        $if_yes = htmlspecialchars($row['if_yes']);
        $childhood_illness = htmlspecialchars($row['childhood_illness']);
        $_bcg = htmlspecialchars($row['bcg']);
        $_dpt = htmlspecialchars($row['dpt']);
        $_opv = htmlspecialchars($row['opv']);
        $_hepb = htmlspecialchars($row['hepb']);
        $_measleVac = htmlspecialchars($row['measleVac']);
        $_flu_vaccine = htmlspecialchars($row['fluVaccine']);
        $_varicella = htmlspecialchars($row['varicella']);
        $_mmr = htmlspecialchars($row['mmr']);
        $_etc = htmlspecialchars($row['etc']);
        $tetanus = htmlspecialchars($row['tetanus']);
        $_vaccineName = htmlspecialchars($row['vaccineName']);
        $date_last_given = htmlspecialchars($row['date_last_given']);
        $hospitalize_before = htmlspecialchars($row['hospitalize_before']);
        $_year = htmlspecialchars($row['_year']);
        $reason = htmlspecialchars($row['reason']);
        $family_med_history = htmlspecialchars($row['family_med_history']);
        $fem_height = htmlspecialchars($row['fem_height']);
        $fem_weight = htmlspecialchars($row['fem_weight']);
        $first_menstrual = htmlspecialchars($row['first_menstrual']);
        $first_dose_date = htmlspecialchars($row['first_dose_date']);
        $second_dose_date = htmlspecialchars($row['second_dose_date']);
        $vaccine_manufacturer = htmlspecialchars($row['vaccine_manufacturer']);
        $booster = htmlspecialchars($row['booster']);
        $plus_covid_date = htmlspecialchars($row['plus_covid_date']);

        // Create Word document
        $template = new TemplateProcessor('../View/pages/template/medform.docx');

        $template->setValue('firstname', $_firstname);
        $template->setValue('lastname', $_lastname);
        $template->setValue('gender', $gender);
        $template->setValue('_date', $_date);
        $template->setValue('_address', $_address);
        $template->setValue('birthdate', $birthdate);
        $template->setValue('birthplace', $birthplace);
        $template->setValue('religion', $religion);
        $template->setValue('citizenship', $citizenship);
        $template->setValue('guardian', $guardian);
        $template->setValue('relationship', $relationship);
        $template->setValue('contact', $contact);

        // Health conditions
        $template->setValue('adhd', $adhd === 'yes' ? '✔' : '✘');
        $template->setValue('asthma', $asthma === 'yes' ? '✔' : '✘');
        $template->setValue('anemia', $anemia === 'yes' ? '✔' : '✘');
        $template->setValue('bleeding', $bleeding === 'yes' ? '✔' : '✘');
        $template->setValue('cancer', $cancer === 'yes' ? '✔' : '✘');
        $template->setValue('chestpain', $chestpain === 'yes' ? '✔' : '✘');
        $template->setValue('diabetes', $diabetes === 'yes' ? '✔' : '✘');
        $template->setValue('fainting', $fainting === 'yes' ? '✔' : '✘');
        $template->setValue('fracture', $fracture === 'yes' ? '✔' : '✘');
        $template->setValue('hearing_speech', $hearing_speech === 'yes' ? '✔' : '✘');
        $template->setValue('heart_condition', $heart_condition === 'yes' ? '✔' : '✘');
        $template->setValue('lung_prob', $lung_prob === 'yes' ? '✔' : '✘');
        $template->setValue('mental_prob', $mental_prob === 'yes' ? '✔' : '✘');
        $template->setValue('migraine', $migraine === 'yes' ? '✔' : '✘');
        $template->setValue('seizure', $seizure === 'yes' ? '✔' : '✘');
        $template->setValue('tubercolosis', $tubercolosis === 'yes' ? '✔' : '✘');
        $template->setValue('hernia', $hernia === 'yes' ? '✔' : '✘');
        $template->setValue('kidney_prob', $kidney_prob === 'yes' ? '✔' : '✘');
        $template->setValue('vision', $vision === 'yes' ? '✔' : '✘');
        $template->setValue('other', $other === 'yes' ? '✔' : '✘');
        $template->setValue('specify', $specify);

        // Medication
        $template->setValue('medication_treatment', $medication_treatment);
        $template->setValue('medication_past', $medication_past);
        $template->setValue('current_medication', $current_medication);

        // Allergies and childhood illness
        $template->setValue('allergy', $allergy);
        $template->setValue('if_yes', $if_yes);
        $template->setValue('childhood_illness', $childhood_illness);

        // Immunizations
        $template->setValue('_bcg', $_bcg === 'yes' ? '✔' : '✘');
        $template->setValue('_dpt', $_dpt === 'yes' ? '✔' : '✘');
        $template->setValue('_opv', $_opv === 'yes' ? '✔' : '✘');
        $template->setValue('_hepb', $_hepb === 'yes' ? '✔' : '✘');
        $template->setValue('_measleVac', $_measleVac === 'yes' ? '✔' : '✘');
        $template->setValue('_fluVaccine', $_flu_vaccine === 'yes' ? '✔' : '✘');
        $template->setValue('_varicella', $_varicella === 'yes' ? '✔' : '✘');
        $template->setValue('_mmr', $_mmr === 'yes' ? '✔' : '✘');
        $template->setValue('_etc', $_etc === 'yes' ? '✔' : '✘');
        $template->setValue('tetanus', $tetanus);
        $template->setValue('_vaccineName', $_vaccineName);
        $template->setValue('date_last_given', $date_last_given);

        // Hospitalization
        $template->setValue('hospitalize_before', $hospitalize_before === 'yes' ? '✔' : '✘');
        $template->setValue('_year', $_year);
        $template->setValue('reason', $reason);
        $template->setValue('family_med_history', $family_med_history);

        // Female only
        $template->setValue('fem_height', $fem_height);
        $template->setValue('fem_weight', $fem_weight);
        $template->setValue('first_menstrual', $first_menstrual);

        // COVID-19
        $template->setValue('first_dose_date', $first_dose_date);
        $template->setValue('second_dose_date', $second_dose_date);
        $template->setValue('vaccine_manufacturer', $vaccine_manufacturer);
        $template->setValue('booster', $booster);
        $template->setValue('plus_covid_date', $plus_covid_date);

        $filename = $_lastname . $_firstname . ".docx";
        $filepath = '../View/pages/downloads/' . $filename;
        $template->saveAs($filepath);

        // Force file download
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . filesize($filepath));
        flush();
        readfile($filepath);
        exit; // Ensure nothing else runs after file is sent
    }
}
