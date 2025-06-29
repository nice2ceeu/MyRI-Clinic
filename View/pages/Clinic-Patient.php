<?php

session_start();

include("../../view/modal/alert.php");
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
include('../components/body.php');
include('../components/navbar.php');
?>
<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">

  <section class="relative mt-5 text-[max(3vw,2rem)] ">
    <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
      Today's Patient
    </h1>
    <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
  </section>
  <!-- visitor form  -->
  <form
    action="../../controller/addvisitor.php"
    method="POST"
    class="px-8.5 mt-5 gap-3.5 uppercase flex justify-center flex-wrap lg:flex-nowrap min-[200px]:w-[90%]">

    <!-- name of student  -->

    <section class="relative  w-2/5 grow-1">
      <label

        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="first">First Name</label>

      <input
        required
        id="first"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="firstname"
        type="text" />

    </section>
    <section class="relative w-2/5 grow-1">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="last">Last Name</label>

      <input
        required
        id="last"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="lastname"
        type="text" />

    </section>

    <!-- Grade and section  -->

    <section class="relative w-2/5 grow-1">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="grade">grade</label>


      <input
        required
        id="grade"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="grade"
        type="number"
        min="1" max="12" />

    </section>

    <section class="relative w-2/5 grow-1">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="section">section</label>

      <input
        required
        id="section"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="section"
        type="text" />

    </section>


    <!-- complaint of student  -->
    <section class="relative w-2/5 grow-1">
      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="complaint">complaint</label>

      <input
        required
        id="complaint"
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="complaint"
        type="text" />


    </section>

    <!-- submit button  -->
    <section
      class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
      <button
        name="submit"
        class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>submit</p>
        <img clas src="../assets/icons/check-icon.svg" alt="" />
      </button>
    </section>
  </form>

  <!--  -->
  <!--  -->
  <section class="relative my-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>
  <!--  -->
  <!-- sort section -->
  <section class="flex gap-5 flex-wrap poppins  uppercase place-self-left py-3.5 mx-8.5">
    <form class=" flex items-center flex-wrap gap-5" action="" method="POST">
      <div class="relative">
        <label
          id="label"
          class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
          for="studentGrade">
          grade
        </label>
        <input class="border-1 rounded px-3.5 py-1.5 w-42" type="number" name="studentGrade" id="studentGrade" min="1" max="12" placeholder="1-12">
      </div>
      <div class="relative">
        <label
          id="label"
          class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
          for="studentSection">
          Section
        </label>
        <input class="border-1 rounded px-3.5 py-1.5 " type="text" name="studentSection" id="studentSection" placeholder="Rosas">

        </select>
      </div>
      <button
        disabled
        type="submit"
        name="filter"
        id="filter"
        class="uppercase bg-primary text-white rounded-lg py-2 px-5 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>Filter</p>
        <img class="size-5.5" src="../assets/icons/filter-icon.svg" alt="" />
      </button>

    </form>
    <form action="" method="POST">
      <button
        type="submit"
        name="show-all"
        id="filter"
        class="uppercase border-1 rounded-lg  leading-5 py-2 px-5 flex cursor-pointer">
        <p>Show All</p>
      </button>
    </form>
    <script>
      const gradeInput = document.getElementById('studentGrade');
      const sectionInput = document.getElementById('studentSection');
      const filterButton = document.getElementById('filter');

      function checkInputs() {
        const grade = gradeInput.value.trim();
        const section = sectionInput.value.trim();


        if (grade !== '' || section !== '') {
          filterButton.disabled = false;
        } else {
          filterButton.disabled = true;
        }
      }


      gradeInput.addEventListener('input', checkInputs);
      sectionInput.addEventListener('input', checkInputs);
    </script>
  </section>
  <!--  -->
  <!-- visitor list components >>>>>>>>> -->
  <main
    class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
    <table class="min-w-full poppins">
      <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
        <tr>
          <th>ID</th>
          <th>Name of student</th>
          <th>grade and section</th>
          <th>complaint</th>
          <th>status</th>
          <th>TIME IN</th>
          <th>DATE</th>
        </tr>
      </thead>
      <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
        <?php


        include("../../config/database.php");
        include('../components/body.php');



        if (isset($_POST['filter'])) {
          $studentGrade = $_POST['studentGrade'];
          $studentSection = $_POST['studentSection'];

          if ($studentGrade != '' && $studentSection != '') {
            // grade and section
            $sql = "SELECT * FROM visitor WHERE grade = ? AND section = ? AND _date = CAST(GETDATE() AS DATE) ORDER BY id DESC";
            $params = [$studentGrade, $studentSection];
          } else if ($studentGrade == '' && $studentSection != '') {
            // section only
            $sql = "SELECT * FROM visitor WHERE section = ? AND _date = CAST(GETDATE() AS DATE) ORDER BY id DESC";
            $params = [$studentSection];
          } else if ($studentGrade != '' && $studentSection == '') {
            // grade only
            $sql = "SELECT * FROM visitor WHERE grade = ? AND _date = CAST(GETDATE() AS DATE) ORDER BY id DESC";
            $params = [$studentGrade];
          } else {
            // none
            $sql = "SELECT * FROM visitor";
            $params = [];
          }

          $stmt = sqlsrv_prepare($conn, $sql, $params);
          if ($stmt && sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $status = empty($row['checkout']) ? "On Treatment" : "Treated";
              $color = empty($row['checkout']) ? " text-yellow-600" : " text-green-500";

              echo "<tr class=''>";
              echo "<td>" . htmlspecialchars($row['id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
              echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
              echo "<td class='{$color}'>" . $status . "</td>";
              echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
              echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<td colspan='9' class='text-center bg-[#d4d4d433]'>No Patient Found.</td>";
          }
        } else {
          if (isset($_POST['show-all']) || !isset($_POST['show-all'])) {
            $sql = "SELECT * FROM visitor WHERE _date = CAST(GETDATE() AS DATE) ORDER BY id DESC";
            $stmt = sqlsrv_query($conn, $sql);

            if ($stmt && sqlsrv_has_rows($stmt)) {
              while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $status = empty($row['checkout']) ? "On Treatment" : "Treated";
                $color = empty($row['checkout']) ? " text-yellow-600" : " text-green-500";

                echo "<tr class=''>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                echo "<td class='{$color}'>" . $status . "</td>";
                echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='9' class='text-center bg-[#d4d4d44d]'>No Current Patient.</td></tr>";
            }
          }
        }


        ?>

      </tbody>
    </table>
  </main>
</section>
</body>

</html>