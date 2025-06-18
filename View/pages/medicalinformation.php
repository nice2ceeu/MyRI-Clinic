<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>
<?php
include('../components/body.php');
include('../components/navbar.php');
?>



<section class="relative z-20 overflow-x-hidden md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">

  <div id="bgFade" class="fixed top-0 w-full h-full -z-10  bg-[#5858582f] overflow-auto"></div>

  <div class="flex relative">
    <a class="flex bg-[#06118e]  text-white poppins uppercase font-semibold  w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly text-[max(1vw,1rem)]" href="studentlist.php"><span>Back</span><img class="size-6.5" src="../assets/icons/back-icon.svg" alt="back-icon"></a>

    <!-- edit button -->
    <div class="">
      <button
        id="editBtn"
        class="border-1 poppins my-5 place-self-center mt-5 justify-center cursor-pointer  px-5 py-3 flex gap-x-3 rounded-lg">
        <p>Edit</p>
        <img class="invert size-5" src="../assets/icons/edit-icon.svg" alt="check-icon" />
      </button>
    </div>
    <!-- save and cancel -->
    <div id="actionBtn" class="flex gap-3.5 hidden">
      <button
        id="saveBtn"
        onclick="sendToPHP()"
        name="saveBtn"
        type="submit"
        class="bg-green-500 text-white poppins my-5 place-self-center mt-5 justify-center cursor-pointer  px-5 py-3 flex gap-x-3 rounded-lg">
        <p>Save</p>
      </button>
      <button
        id="cancelBtn"
        class="bg-red-500 text-white poppins my-5 place-self-center mt-5 justify-center cursor-pointer  px-5 py-3 flex gap-x-3 rounded-lg">
        <p>Cancel</p>
      </button>
    </div>

  </div>

  <section class="relative -z-20  mt-5 text-[max(3vw,2rem)] ">
    <h1 class="poppins uppercase font-[500] bg-white ml-12  px-5 inline ">
      student information
    </h1>
    <hr class="absolute -z-10 text-[#acacac] top-1/2 w-full" />
  </section>

  <?php
  include('../../config/database.php');


  if (isset($_POST['view-form'])) {
    $id = $_POST['id'];


    try {
      $stmt = $conn->prepare("SELECT * FROM medforms WHERE id = ? ");
      $stmt->bind_param("i", $id);
      $stmt->execute();

      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_id = htmlspecialchars($row['id']);
        $_firstname = htmlspecialchars($row['firstname']);
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
      }
    } catch (mysqli_sql_exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  ?>
  <fieldset id="myFieldset" disabled>
    <form action="../../Controller/medform.php" method="POST">
      <!-- form for student information........ -->
      <section
        class="poppins my-7.5 flex flex-col md:flex-row md:flex-wrap gap-4 px-3 uppercase">
        <!-- namee of student -->
        <input type="hidden" value="<?php echo $_id ?>" name="id" id="id">
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="fullname">full name: </label>
          <input
            id="fullname"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 "
            name="fullname"
            value="<?php echo $_lastname . ", " . $_firstname; ?>"
            required
            type="text" />
        </section>
        <!-- gender of student -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="gender">gender: </label>
          <input
            id="gender"
            class="border-b-1 focus:border-b-1  px-2 focus:outline-0"
            name="gender"
            value="<?php echo $gender ?>"
            required
            type="text" />
        </section>


        <!-- date -->

        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="date">date: </label>
          <input
            id="_date"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
            name="_date"
            value="<?php echo $_date ?>"
            required
            type="date" />
        </section>


        <!-- address -->

        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="address">home address: </label>
          <input
            id="_address"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-[32rem]"
            name="_address"
            value="<?php echo $_address ?>"
            required
            type="text" />
        </section>

        <!-- date of birth -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="birthday">date of birth: </label>
          <input
            id="birthdate"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
            name="birthdate"
            value="<?php echo $birthdate ?>"
            required
            type="date" />
        </section>

        <!--birthplace -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="birthplace">birthplace: </label>
          <input
            id="birthplace"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
            name="birthplace"
            value="<?php echo $birthplace ?>"
            required
            type="text" />
        </section>

        <!--religion -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="religion">religion: </label>
          <input
            id="religion"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
            name="religion"
            value="<?php echo $religion ?>"
            required
            type="text" />
        </section>

        <!--citizenship -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="citizenship">citizenship: </label>
          <input
            id="citizenship"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
            name="citizenship"
            value="<?php echo $citizenship ?>"
            required
            type="text" />
        </section>

        <!--person to contact -->
        <section class="flex flex-col md:flex-row">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="emergencyContact">person to contact in case of emergency: </label>
          <input
            id="emergencyContact"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 "
            name="emergencyContact"
            value="<?php echo $guardian ?>"
            required
            type="name" />
        </section>

        <!--relationship to contact number -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="relationship">relationship: </label>
          <input
            id="relationship"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-32"
            name="relationship"
            value="<?php echo $relationship ?>"
            required
            type="text" />
        </section>


        <!--contactnumber -->
        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="contactNumber">contactnumber: </label>
          <input
            id="contact"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-32"
            name="contact"
            value="<?php echo $contact ?>"
            required
            type="text" />
        </section>

      </section>

      <!--form for STUDENT MEDICAL HISTORY ........ -->
      <section class="relative  -z-20  my-5 text-[min(4vw,1.5rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
          MEDICAL HISTORY
        </h1>
        <hr class="absolute z-[-1] w-full top-1/2" />
      </section>

      <section class="poppins flex flex-col w-[75%] md:w-full md:flex-row capitalize gap-3 justify-evenly">
        <!-- First column -->
        <section class="poppins w-full flex gap-2 justify-evenly">
          <div class="flex gap-2 w-full p-3 flex-col [&>div]:grid [&>div]:items-center [&>div]:p-2 [&>div]:grid-cols-[1fr_30px_30px] [&>div]:grid-row-auto [&>div]:gap-5 [&>div]:border-1">
            <div class="">
              <div></div>
              <h1>yes</h1>
              <h1>no</h1>
            </div>
            <div class="">
              <div>ADHD (Attention deficit hyperactivity disorder)</div>
              <input id="adhd-yes" name="adhd" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 "
                <?php if (isset($adhd) && $adhd === 'yes') echo 'checked'; ?>>
              <input id="adhd-no" name="adhd" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 "
                <?php if (isset($adhd) && $adhd === 'no') echo 'checked'; ?>>
            </div>
            <div class="">
              <div>asthma</div>
              <input id="asthma-yes" name="asthma" value="yes" type="radio" <?php if (isset($asthma) && $asthma === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="asthma-no" name="asthma" value="no" type="radio" <?php if (isset($asthma) && $asthma === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Anemia</div>
              <input id="anemia-yes" name="anemia" value="yes" type="radio" <?php if (isset($anemia) && $anemia === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="anemia-no" name="anemia" value="no" type="radio" <?php if (isset($anemia) && $anemia === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>bleeding problem</div>
              <input id="bleeding-yes" name="bleeding" value="yes" type="radio" <?php if (isset($bleeding) && $bleeding === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="bleeding-no" name="bleeding" value="no" type="radio" <?php if (isset($bleeding) && $bleeding === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Cancer</div>
              <input id="cancer-yes" name="cancer" value="yes" type="radio" <?php if (isset($cancer) && $cancer === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="cancer-no" name="cancer" value="no" type="radio" <?php if (isset($cancer) && $cancer === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Chest pain</div>
              <input id="chestpain-yes" name="chestpain" value="yes" type="radio" <?php if (isset($chestpain) && $chestpain === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="chestpain-no" name="chestpain" value="no" type="radio" <?php if (isset($chestpain) && $chestpain === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Diabetes</div>
              <input id="diabetes-yes" name="diabetes" value="yes" type="radio" <?php if (isset($diabetes) && $diabetes === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="diabetes-no" name="diabetes" value="no" type="radio" <?php if (isset($diabetes) && $diabetes === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>fainting</div>
              <input id="fainting-yes" name="fainting" value="yes" type="radio" <?php if (isset($fainting) && $fainting === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="fainting-no" name="fainting" value="no" type="radio" <?php if (isset($fainting) && $fainting === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>fracture</div>
              <input id="fracture-yes" name="fracture" value="yes" type="radio" <?php if (isset($fracture) && $fracture === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="fracture-no" name="fracture" value="no" type="radio" <?php if (isset($fracture) && $fracture === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>hearing/speech problem</div>
              <input id="hearing-yes" name="hearing_speach" value="yes" type="radio" <?php if (isset($hearing_speech) && $hearing_speech === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="hearing-no" name="hearing_speach" value="no" type="radio" <?php if (isset($hearing_speech) && $hearing_speech === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
          </div>
        </section>
        <!-- Second column -->
        <section class="poppins w-full flex gap-2 justify-evenly">
          <div class="flex gap-2  w-full  p-3 flex-col [&>div]:grid [&>div]:items-center [&>div]:p-2 [&>div]:grid-cols-[1fr_30px_30px] [&>div]:grid-row-auto [&>div]:gap-5 [&>div]:border-1">
            <div class="">
              <div></div>
              <h1>yes</h1>
              <h1>no</h1>
            </div>
            <div class="">
              <div>hearth condition</div>
              <input id="heart-yes" name="heart_condition" value="yes" type="radio" <?php if (isset($heart_condition) && $heart_condition === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="heart-no" name="heart_condition" value="no" type="radio" <?php if (isset($heart_condition) && $heart_condition === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>lung problems</div>
              <input id="lung-yes" name="lung_prob" value="yes" type="radio" <?php if (isset($lung_prob) && $lung_prob === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="lung-no" name="lung_prob" value="no" type="radio" <?php if (isset($lung_prob) && $lung_prob === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Mental or psychological problems</div>
              <input id="mental-yes" name="mental_prob" value="yes" type="radio" <?php if (isset($mental_prob) && $mental_prob === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="mental-no" name="mental_prob" value="no" type="radio" <?php if (isset($mental_prob) && $mental_prob === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Migraine/Headache</div>
              <input id="migraine-yes" name="migraine" value="yes" type="radio" <?php if (isset($migraine) && $migraine === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="migraine-no" name="migraine" value="no" type="radio" <?php if (isset($migraine) && $migraine === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Seizure/Convulsion</div>
              <input id="seizure-yes" name="seizure" value="yes" type="radio" <?php if (isset($seizure) && $seizure === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="seizure-no" name="seizure" value="no" type="radio" <?php if (isset($seizure) && $seizure === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Tuberculosis</div>
              <input id="tb-yes" name="tubercolosis" value="yes" type="radio" <?php if (isset($tubercolosis) && $tubercolosis === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="tb-no" name="tubercolosis" value="no" type="radio" <?php if (isset($tubercolosis) && $tubercolosis === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Hernia</div>
              <input id="hernia-yes" name="hernia" value="yes" type="radio" <?php if (isset($hernia) && $hernia === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="hernia-no" name="hernia" value="no" type="radio" <?php if (isset($hernia) && $hernia === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Urinary/kidney problem</div>
              <input id="kidney-yes" name="kidney_prob" value="yes" type="radio" <?php if (isset($kidney_prob) && $kidney_prob === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="kidney-no" name="kidney_prob" value="no" type="radio" <?php if (isset($kidney_prob) && $kidney_prob === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Vision: Glasses/Contact Lens</div>
              <input id="vision-yes" name="vision" value="yes" type="radio" <?php if (isset($vision) && $vision === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="vision-no" name="vision" value="no" type="radio" <?php if (isset($vision) && $vision === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>other issue</div>
              <input id="other-yes" name="other" value="yes" type="radio" <?php if (isset($other) && $other === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="other-no" name="other" value="no" type="radio" <?php if (isset($other) && $other === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
          </div>
        </section>
      </section>
      <!--form for STUDENT MEDICAL HISTORY ........ -->
      <!-- other information for medical History  -->
      <section class="flex gap-y-5 flex-col poppins px-3 [&>section>label]:font-semibold">
        <section id="specifyOpacity" class="flex flex-col md:flex-row">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="specify">IF YES please specify: </label>
          <input
            id="specify"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 grow-1"
            name="specify"
            value="<?php echo $specify ?>"
            required
            type="text" />
        </section>
        <!--  -->
        <!--  -->

        <section class="flex flex-col lg:flex-row  mt-10">
          <label
            id="label"
            class="mr-1 font-semibold text-wrap lg:text-nowrap"
            for="underMedication">Are you under under medication treatment now?
            if so, what is the condition being treated:</label>
          <input
            id="medication_treatment"
            class=" border-b-1 focus:border-b-1 px-2 focus:outline-0 grow-1"
            name="underMedication"
            value="<?php echo $medication_treatment ?>"
            required

            type="text" />
        </section>

        <section class="flex flex-col lg:flex-row ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="pastMedication">MEDICATION that are already take form the past:</label>
          <input
            id="medication_past"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 grow-1"
            name="pastMedication"
            required
            value="<?php echo $medication_past ?>"
            type="text" />
        </section>
        <section class="flex flex-col lg:flex-row ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="currentMedication">Current medication:</label>
          <input
            id="current_medication"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 grow-1"
            name="currentMedication"
            required
            value="<?php echo $current_medication ?>"
            type="text" />
        </section>


        <section class="flex flex-col  lg:flex-row  mt-10">
          <label
            id="label"
            class="text-wrap lg:text-nowrap mr-1 font-semibold uppercase"
            for="allergy">do you have allergy( insect, foods , medications):</label>
          <section class="flex items-center gap-1.5">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="allergy-yes">yes</label>
            <input id="allergy-yes" <?php if (isset($allergy) && $allergy === 'yes') echo 'checked'; ?> name="allergy" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="allergy-no">no</label>
            <input id="allergy-no" <?php if (isset($allergy) && $allergy === 'no') echo 'checked'; ?> name="allergy" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <input
            id="allergy"
            class=" border-b-1 focus:border-b-1 px-2 focus:outline-0 mt-5 md:mt-0 grow-1"
            name="allergy"
            placeholder="input what allergy is it"
            required
            value="<?php echo $if_yes ?>"
            type="text" />
        </section>
        <div
          id="child"
          class="relative -z-20 w-full mt-5">
          <label
            id="label"
            class=" inline top-[-10px] left-2  absolute px-5 bg-white text-nowrap mr-1 font-semibold uppercase"
            for="chillhoodIllness">chillhood Illnesses</label>
          <select name="chillhoodIllness" id="childhood_illness" class="border-1 p-3.5  w-full">
            <option value="" <?= empty($childhood_illness) ? 'selected' : '' ?> class="opacity-40">Select Illnesses</option>
            <option value="mumps" <?= $childhood_illness === 'mumps' ? 'selected' : '' ?>>Mumps</option>
            <option value="chicken Pox" <?= $childhood_illness === 'chicken Pox' ? 'selected' : '' ?>>Chicken Pox</option>
            <option value="measles" <?= $childhood_illness === 'measles' ? 'selected' : '' ?>>Measles</option>
            <option value="german Measles" <?= $childhood_illness === 'german Measles' ? 'selected' : '' ?>>German Measles</option>
          </select>

        </div>



        <!-- immunization -->
        <section class="flex flex-col md:flex-wrap md:flex-row [&>section]:flex  [&>section]:items-center [&>section]:gap-3">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="immunization">immunization</label>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="bcg">BCG</label>
            <input id="bcg" name="bcg" type="checkbox" value="no" <?php if (isset($_bcg) && $_bcg === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="dpt">DPT</label>
            <input id="dpt" name="dpt" type="checkbox" value="no" <?php if (isset($_dpt) && $_dpt === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>

          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="opv">OPV</label>
            <input id="opv" name="opv" type="checkbox" value="no" <?php if (isset($_opv) && $_opv === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="hep-b">HEP.B</label>
            <input id="hep-b" name="hep-b" type="checkbox" value="no" <?php if (isset($_hepb) && $_hepb === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="measleVaccine">MEASLE VACCINE</label>
            <input id="measleVaccine" name="measleVaccine" type="checkbox" value="no" <?php if (isset($_measleVac) && $_measleVac === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">


          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="fluVaccine">FLU VACCINE</label>
            <input id="fluVaccine" name="fluVaccine" type="checkbox" value="no" <?php if (isset($_flu_vaccine) && $_flu_vaccine === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="varicella">VARICELLA</label>
            <input id="varicella" name="varicella" type="checkbox" value="no" <?php if (isset($_varicella) && $_varicella === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="mmr">MMR</label>
            <input id="mmr" name="mmr" type="checkbox" value="no" <?php if (isset($_mmr) && $_mmr === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="etc">etc,</label>
            <input id="etc" name="etc" type="checkbox" value="no" <?php if (isset($_etc) && $_etc === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
        </section>

        <!--  -->
        <section class="mt-5">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="complete-yes">complete</label>
          <input id="-yes" name="tetanus" value="complete" <?php if (isset($tetanus) && $tetanus === 'complete') echo 'checked'; ?> type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="incomplete-no">incomplete</label>
          <input id="-no" name="tetanus" value="incomplete" <?php if (isset($tetanus) && $tetanus === 'incomplete') echo 'checked'; ?> type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="vaccineName">tetanus toxoviod: </label>
          <input id="vaccineName" name="vaccineName" value="no" <?php if (isset($_vaccineName) && $_vaccineName === 'yes') echo 'checked'; ?> type="checkbox" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

        </section>

        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="dateLastGiven">date last given:</label>
          <input
            id="date_last_given"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-[32]"
            name="dateLastGiven"
            required
            value="<?php echo $date_last_given ?>"
            type="date" />
        </section>
      </section>

      <!-- hospitalized  -->
      <section class="mt-20">
        <section class="flex  flex-col poppins poppins px-3">
          <label

            class=" md:text-nowrap mr-1 font-semibold"
            for="hospitalized">Have you been hospitalized? </label>

          <h6>
            ( accident, illness, surgery, fracture, etc )
          </h6>

          <!-- if yes input combo box -->
          <div class="flex items-center gap-1 uppercase ">
            <label id="label"

              class="text-nowrap mr-1 font-semibold"
              for="hospitalized-yes">yes</label>
            <input id="hospitalized-yes" name="hospitalize_before" value="yes" type="radio" <?php if (isset($hospitalize_before) && $hospitalize_before === 'yes') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold"
              for="hospitalized-no">no</label>
            <input id="hospitalized-no" name="hospitalize_before" value="no" type="radio" <?php if (isset($hospitalize_before) && $hospitalize_before === 'no') echo 'checked'; ?> class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          </div>
        </section>

        <!-- hospitalized  ibnput field for user   -->

        <section id="hospitalize" class="uppercase px-3">
          <div class="flex flex-col gap-2 md:mt-5">
            <label for="year" class="font-semibold">year</label>
            <input
              id="_year"
              class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-42 "
              name="_year"
              required
              value="<?php echo $_year ?>"
              type="date" />
          </div>
          <div class="flex flex-col gap-2 md:mt-5">
            <label for="reason" class="font-semibold">reason </label>
            <input
              id="reason"
              class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 grow-1"
              name="reason"
              required
              value="<?php echo $reason ?>"
              type="text" />
          </div>
        </section>

        <!-- Family medical History -->

        <section class="space-y-2 w-full mt-5 px-3">
          <label for="Family-medical-history" class="font-semibold text-xl">Family medical History</label>
          <h6 class="block">Type all the condition or illness that your family has (example asthma, diabetes, tb, migraine, hypertension)</h6>
          <input
            id="family_med_history"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-full"
            name="Family-medical-history"
            required
            value="<?php echo $family_med_history ?>"
            type="text" />
        </section>



      </section>
      <!-- for female  -->
      <section id="femaleDiv"
        class="flex flex-col md:flex-row gap-2 poppins w-full mt-5 px-3">
        <h1 class=" text-nowrap font-semibold uppercase">for female: menarche</h1>
        <section>
          <label for="height">height(cm.)</label>
          <input
            id="height"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-32"
            name="height"
            required
            value="<?php echo $fem_height  ?>"
            type="text" />
        </section>

        <section>
          <label for="weight">weight(kg.)</label>
          <input
            id="weight"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-32"
            name="weight"
            required
            value="<?php echo $fem_weight  ?>"
            type="text" />
        </section>

        <section class="">
          <label for="firstMens">first menstrual period</label>
          <input
            id="firstMens"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-38"
            name="firstMens"
            required
            value="<?php echo $first_menstrual  ?>"
            type="date" />
        </section>
      </section>

      <!-- covid 19 vaccine -->
      <section class="flex md:flex-col px-3 gap-2 mt-5 ">
        <div class="flex flex-col md:flex-row gap-1 [&>p]:p-3 [&>p]:w-full [&>p]:border-1">
          <p><label for="firstDose">Date of 1<sup>st</sup> dose</label></p>
          <p> <label for="secondDose">Date of 2<sup>nd</sup> dose</label></p>
          <p> <label for="vaccineBrand" class="text-nowrap">vaccine manufacturer</label></p>
          <p><label for="booster">booster</label></p>
          <p><label for="plusCovid">(+) Covid (when)</label></p>
        </div>

        <div class="flex flex-col md:flex-row [&>input]:p-3 [&>input]:w-full  gap-1.5">
          <input type="date" id="first_dose_date" name="firstDose" value="<?php echo $first_dose_date  ?>" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="date" id="second_dose_date" name="secondDose" value="<?php echo $second_dose_date  ?>" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="text" id="vaccine_manufacturer" name="vaccineBrand" value="<?php echo $vaccine_manufacturer  ?>" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="text" id="booster" name="booster" value="<?php echo $booster  ?>" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="date" id="plus_covid_date" name="plusCovid" value="<?php echo $plus_covid_date  ?>" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
        </div>
      </section>
      <!-- SUBMIT BUTTON FOR MEDICAL FORM  -->
    </form>
  </fieldset>
  <form class="" action="../../Controller/download.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <button

      type="submit"
      name='download'
      class="bg-primary poppins my-5 place-self-center mt-5 w-1/3 md:w-1/5 justify-center cursor-pointer text-white px-5 py-3 flex gap-x-3 rounded-lg">
      <p>Download</p>
      <img src="../assets/icons/check-icon.svg" alt="check-icon" />

    </button>

  </form>
</section>


</body>
<script src="../script/medform.js"></script>
<script>
  const edit = document.getElementById("editBtn")
  const container = document.getElementById("actionBtn")
  const cancel = document.getElementById("cancelBtn")
  const fade = document.getElementById("bgFade")
  const zindex = document.getElementById("child")
  const myFieldset = document.getElementById("myFieldset");

  edit.addEventListener("click", (e) => {
    e.preventDefault()
    zindex.classList.remove("-z-20");
    edit.classList.add("hidden");
    container.classList.remove("hidden");
    fade.classList.remove("bg-[#5858582f]");
    myFieldset.disabled = false;

  })

  cancel.addEventListener("click", (e) => {
    e.preventDefault()
    edit.classList.remove("hidden");
    container.classList.add("hidden");
    fade.classList.add("bg-[#5858582f]");
    myFieldset.disabled = true;
  })
</script>

<script>
  function sendToPHP() {
    // Basic personal info
    const getVal = id => document.getElementById(id)?.value || '';
    const getRadioVal = name => document.querySelector(`input[name="${name}"]:checked`)?.value || '';
    const getCheckVal = id => document.getElementById(id)?.checked ? 'yes' : 'no';



    const data = {
      id: getVal("id"),
      fullname: getVal("fullname"),
      gender: getVal("gender"),
      _date: getVal("_date"),
      _address: getVal("_address"),
      birthdate: getVal("birthdate"),
      birthplace: getVal("birthplace"),
      religion: getVal("religion"),
      citizenship: getVal("citizenship"),
      guardian: getVal("emergencyContact"),
      relationship: getVal("relationship"),
      contact: getVal("contact"),

      // Medical history (radio)
      adhd: getRadioVal("adhd"),
      asthma: getRadioVal("asthma"),
      anemia: getRadioVal("anemia"),
      bleeding: getRadioVal("bleeding"),
      cancer: getRadioVal("cancer"),
      chestpain: getRadioVal("chestpain"),
      diabetes: getRadioVal("diabetes"),
      fainting: getRadioVal("fainting"),
      fracture: getRadioVal("fracture"),
      hearing_speach: getRadioVal("hearing_speach"),
      heart_condition: getRadioVal("heart_condition"),
      lung_prob: getRadioVal("lung_prob"),
      mental_prob: getRadioVal("mental_prob"),
      migraine: getRadioVal("migraine"),
      seizure: getRadioVal("seizure"),
      tubercolosis: getRadioVal("tubercolosis"),
      hernia: getRadioVal("hernia"),
      kidney_prob: getRadioVal("kidney_prob"),
      vision: getRadioVal("vision"),
      other: getRadioVal("other"),

      // Medication & Allergies
      specify: getVal("specify"),
      medication_treatment: getVal("medication_treatment"),
      medication_past: getVal("medication_past"),
      current_medication: getVal("current_medication"),
      allergy: getRadioVal("allergy"), // You may want to double-check this name
      if_yes: getVal("allergy"),
      childhood_illness: getVal("childhood_illness"),

      // Vaccinations (checkboxes)
      bcg: getCheckVal("bcg"),
      dpt: getCheckVal("dpt"),
      opv: getCheckVal("opv"),
      hepb: getCheckVal("hep-b"),
      measleVac: getCheckVal("measleVaccine"),
      fluVaccine: getCheckVal("fluVaccine"),
      varicella: getCheckVal("varicella"),
      mmr: getCheckVal("mmr"),
      etc: getCheckVal("etc"),

      // Other health info
      tetanus: getRadioVal("tetanus"),
      vaccineName: getCheckVal("vaccineName"),
      date_last_given: getVal("date_last_given"),
      hospitalize_before: getRadioVal("hospitalize_before"),
      _year: getVal("_year"),
      reason: getVal("reason"),
      family_med_history: getVal("family_med_history"),
      fem_height: getVal("height"),
      fem_weight: getVal("weight"),
      first_menstrual: getVal("firstMens"),
      first_dose_date: getVal("first_dose_date"),
      second_dose_date: getVal("second_dose_date"),
      vaccine_manufacturer: getVal("vaccine_manufacturer"),
      booster: getVal("booster"),
      plus_covid_date: getVal("plus_covid_date")
    };

    const body = Object.entries(data)
      .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
      .join("&");

    fetch("../../Controller/update.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: body
      })
      .then(response => response.text())
      .then(data => {
        const fullnames = document.getElementById('fullname').value; // 
        if (fullnames && fullnames.includes(',')) {
          alert("The form is updated successfully");
          window.location.reload();
        } else {
          alert("Invalid Name Format.\nMust be in the form: 'Lastname, Firstname'");
          window.location.reload();
        }
      });

  }
</script>



</html>