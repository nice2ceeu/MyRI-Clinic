<?php
session_start();



include("/View/modal/alert.php");
if (isset($_SESSION['modal_message'])) {
  $msg = $_SESSION['modal_message'];
  $title = $_SESSION['modal_title'] ?? 'Notice';

  echo "<script>
    document.getElementById('alertHeader').innerText = '$title';
    showModal('$msg');
  </script>";
  unset($_SESSION['modal_message'], $_SESSION['modal_title']);
}


if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>
<?php
include('/components/body.php');
include('/components/navbar.php');
?>

<section class="overflow-x-hidden md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">
  <section class="relative my-5 text-[max(3vw,2rem)] ">
    <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
      student information
    </h1>
    <hr class="absolute z-[-1] w-full top-1/2" />
  </section>

  <form action="/Controller/medform.php" method="POST">
    <!-- form for student information........ -->
    <section
      class="poppins flex flex-col md:flex-row md:flex-wrap gap-4 px-3 uppercase">
      <!-- namee of student -->

      <section class="flex">
        <label
          id="label"
          class="text-nowrap mr-1 font-semibold"
          for="fullname">full name: </label>
        <input
          id="fullname"
          class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 "
          name="fullname"
          placeholder="Dela Cruz, Juan"
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
          id="date"
          class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
          name="date"
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
          id="address"
          class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-[32rem]"
          name="address"
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
          id="birthday"
          class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-38"
          name="birthday"
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
          id="relationship"
          class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-32"
          name="contactNumber"
          required
          type="text" />
      </section>

    </section>

    <!--form for STUDENT MEDICAL HISTORY ........ -->
    <section class="relative py-7.5 pt-12">

      <section class="relative  my-5 text-[min(4vw,1.5rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
          MEDICAL HISTORY
        </h1>
        <hr class="absolute z-[-1] w-full top-1/2" />
      </section>

      <section class="poppins flex flex-col md:flex-row capitalize gap-3 justify-evenly">
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
              <input id="adhd-yes" name="adhd" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="adhd-no" name="adhd" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>asthma</div>
              <input id="asthma-yes" name="asthma" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="asthma-no" name="asthma" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Anemia</div>
              <input id="anemia-yes" name="anemia" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="anemia-no" name="anemia" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>bleeding problem</div>
              <input id="bleeding-yes" name="bleeding" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="bleeding-no" name="bleeding" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Cancer</div>
              <input id="cancer-yes" name="cancer" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="cancer-no" name="cancer" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Chest pain</div>
              <input id="chestpain-yes" name="chestpain" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="chestpain-no" name="chestpain" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Diabetes</div>
              <input id="diabetes-yes" name="diabetes" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="diabetes-no" name="diabetes" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>fainting</div>
              <input id="fainting-yes" name="fainting" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="fainting-no" name="fainting" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>fracture</div>
              <input id="fracture-yes" name="fracture" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="fracture-no" name="fracture" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>hearing/speech problem</div>
              <input id="hearing-yes" name="hearing" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="hearing-no" name="hearing" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
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
              <input id="heart-yes" name="heart" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="heart-no" name="heart" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>lung problems</div>
              <input id="lung-yes" name="lung" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="lung-no" name="lung" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Mental or psychological problems</div>
              <input id="mental-yes" name="mental" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="mental-no" name="mental" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Migraine/Headache</div>
              <input id="migraine-yes" name="migraine" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="migraine-no" name="migraine" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Seizure/Convulsion</div>
              <input id="seizure-yes" name="seizure" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="seizure-no" name="seizure" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Tuberculosis</div>
              <input id="tb-yes" name="tb" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="tb-no" name="tb" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Hernia</div>
              <input id="hernia-yes" name="hernia" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="hernia-no" name="hernia" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Urinary/kidney problem</div>
              <input id="kidney-yes" name="kidney" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="kidney-no" name="kidney" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>Vision: Glasses/Contact Lens</div>
              <input id="vision-yes" name="vision" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="vision-no" name="vision" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            </div>
            <div class="">
              <div>other issue</div>
              <input id="other-yes" name="other" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
              <input id="other-no" name="other" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
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
            id="underMedication"
            class=" border-b-1 focus:border-b-1 px-2 focus:outline-0 grow-1"
            name="underMedication"
            required
            type="text" />
        </section>

        <section class="flex flex-col lg:flex-row ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold"
            for="pastMedication">MEDICATION that are already take from the past:</label>
          <input
            id="pastMedication"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 grow-1"
            name="pastMedication"
            required
            type="text" />
        </section>
        <section class="flex flex-col lg:flex-row ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold "
            for="currentMedication">Current medication:</label>
          <input
            id="currentMedication"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 grow-1"
            name="currentMedication"
            required
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
              for="allergy-no">yes</label>
            <input id="allergy-yes" name="allergy" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="allergy-no">no</label>
            <input id="allergy-no" name="allergy" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <input
            id="allergy"
            class=" border-b-1 focus:border-b-1 px-2 focus:outline-0 mt-5 md:mt-0 grow-1"
            name="yes_allergy"
            placeholder="input what allergy is it"
            required
            type="text" />
        </section>
        <div class="relative w-full mt-5">
          <label
            id="label"
            class=" inline top-[-10px] left-2 absolute px-5 bg-white text-nowrap mr-1 font-semibold uppercase"
            for="chillhoodIllness">chillhood Illnesses</label>
          <select name="chillhoodIllness" id="chillhoodIllness" class="border-1 p-3.5 w-full">
            <option disabled selected value="none" class="opacity-40 ">select Illnesses</option>
            <option value="mumps">Mumps</option>
            <option value="chicken Pox">Chicken Pox</option>
            <option value="measles">Measles</option>
            <option value="german measles">German Measles</option>
          </select>
        </div>



        <!-- immunization -->
        <label
          id="label"
          class="text-nowrap mr-1 font-semibold uppercase"
          for="immunization">immunization</label>
        <section class="flex flex-col md:flex-wrap md:flex-row gap-4 [&>section]:flex  [&>section]:items-center [&>section]:gap-3">

          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="bcg">BCG</label>
            <input id="bcg" name="bcg" type="radio" onclick="toggleRadio(this)" value="yes" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="dpt">DPT</label>
            <input id="dpt" name="dpt" type="radio" onclick="toggleRadio(this)" value="yes" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>

          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="opv">OPV</label>
            <input id="opv" name="opv" type="radio" onclick="toggleRadio(this)" value="yes" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="hep-b">HEP.B</label>
            <input id="hep-b" name="hep-b" type="radio" onclick="toggleRadio(this)" value="yes" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="measleVaccine">MEASLE VACCINE</label>
            <input id="measleVaccine" name="measleVaccine" value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">


          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="fluVaccine">FLU VACCINE</label>
            <input id="fluVaccine" name="fluVaccine" value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          </section>
          <section>

            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="varicella">VARICELLA</label>
            <input id="varicella" name="varicella" value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="mmr">MMR</label>
            <input id="mmr" name="mmr" value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
          <section>
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold uppercase"
              for="etc">etc,</label>
            <input id="etc" name="etc" value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </section>
        </section>

        <!--  -->
        <section class="mt-5">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="complete-yes">complete</label>
          <input id="-yes" name="tetanus" value="complete" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="incomplete-no">incomplete</label>
          <input id="-no" name="tetanus" value="incomplete" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="mmr">tetanus toxoviod: </label>
          <input id="mmr" name='vaccineName' value="yes" type="radio" onclick="toggleRadio(this)" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">

        </section>

        <section class="flex">
          <label
            id="label"
            class="text-nowrap mr-1 font-semibold uppercase"
            for="date_last_given">date last given:</label>
          <input
            id="date_last_given"
            class=" border-b-1 focus:border-b-1  px-2 focus:outline-0 w-[32]"
            name="date_last_given"
            required
            type="date" />
        </section>
      </section>

      <!-- hospitalized  -->
      <section class="mt-20">
        <section class="flex  flex-col poppins poppins px-3">
          <label
            id="label"
            class=" md:text-nowrap mr-1 font-semibold"
            for="Hospitalized">Have you been hospitalized? </label>

          <h6>
            ( accident, illness, surgery, fracture, etc )
          </h6>

          <!-- if yes input combo box -->
          <div class="flex items-center gap-1 uppercase ">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold"
              for="hospitalized-yes">yes</label>
            <input id="hospitalized-yes" name="hospitalized" value="yes" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
            <label
              id="label"
              class="text-nowrap mr-1 font-semibold"
              for="hospitalized-no">no</label>
            <input id="hospitalized-no" name="hospitalized" value="no" type="radio" class="appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500 ">
          </div>
        </section>

        <!-- hospitalized  ibnput field for user   -->

        <section id="hospitalize" class="uppercase px-3">
          <div class="flex flex-col gap-2 md:mt-5">
            <p class="font-semibold">year</p>
            <input
              id="_year"
              class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-42 "
              name="_year"
              required
              type="date" />
          </div>
          <div class="flex flex-col gap-2 md:mt-5">
            <p class="font-semibold">reason </p>
            <input
              id="reason"
              class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 grow-1"
              name="reason"
              required
              type="text" />
          </div>
        </section>

        <!-- Family medical History -->

        <section class="space-y-2 w-full mt-5 px-3">
          <h1 class="font-semibold text-xl">Family medical History</h1>
          <h6 class="block">Type all the condition or illness that your family has (example asthma, diabetes, tb, migraine, hypertension)</h6>
          <input
            id="Family-medical-history"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-full"
            name="Family-medical-history"
            required
            type="text" />
        </section>



      </section>
      <!-- for female  -->
      <section id="femaleDiv"
        class="flex flex-col md:flex-row gap-2 poppins w-full mt-5 px-3">
        <h1 class=" text-nowrap font-semibold uppercase">for female: menarche</h1>
        <section>
          <label for="">height(cm.)</label>
          <input
            id="height"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-32"
            name="height"
            required
            type="text" />
        </section>

        <section>
          <label for="">weight(kg.)</label>
          <input
            id="weight"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-32"
            name="weight"
            required
            type="text" />
        </section>

        <section class="">
          <label for="">first menstrual period</label>
          <input
            id="firstMens"
            class=" border-b-1  focus:border-b-1 px-2 focus:outline-0 w-38"
            name="firstMens"
            required
            type="date" />
        </section>
      </section>

      <!-- covid 19 vaccine -->
      <section class="flex md:flex-col px-3 gap-2 mt-5 ">
        <div class="flex flex-col md:flex-row gap-1 [&>p]:p-3 [&>p]:w-full [&>p]:border-1">
          <p>Date of 1<sup>st</sup> dose</p>
          <p>Date of 2<sup>nd</sup> dose</p>
          <p class="text-nowrap">vaccine manufacturer</p>
          <p>booster</p>
          <p>(+) Covid (when)</p>
        </div>

        <div class="flex flex-col md:flex-row [&>input]:p-3 [&>input]:w-full  gap-1.5">
          <input type="date" name="firstDose" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="date" name="secondDose" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="text" name="vaccineBrand" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="text" name="booster" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
          <input type="date" name="plusCovid" class="appearance-none border-b-1 focus:border-b-1 focus:outline-0"></input>
        </div>
      </section>
      <!-- SUBMIT BUTTON FOR MEDICAL FORM  -->
      <button
        name="submit"
        class="bg-primary poppins place-self-center mt-5 w-1/3 justify-center cursor-pointer text-white px-5 py-3 flex gap-x-3 rounded-lg">
        <p>SUBMIT</p>
        <img src="/assets/icons/check-icon.svg" alt="check-icon" />
      </button>

  </form>
</section>

</body>
<script src="/script/medformFillup.js"></script>
<script>
  let selectedRadio = null;

  function toggleRadio(radio) {
    if (selectedRadio === radio) {
      radio.checked = false;
      selectedRadio = null;
    } else {
      selectedRadio = radio;
    }
  }
</script>


</html>