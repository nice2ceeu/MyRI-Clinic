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


<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">
  <section class="relative mt-5 text-[max(3vw,2rem)] ">
    <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
      Visitor History
    </h1>
    <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
  </section>


  <form
    action=""
    method="POST"
    class="mx-8.5 mt-5 gap-3.5 uppercase flex justify-left flex-wrap lg:flex-nowrap min-[200px]:w-[90%]">


    <!-- name of student  -->

    <section class="relative  basis-xs ">

      <label
        id="label"
        class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
        for="name">name of student</label>

      <input
        id="fullname"
        required
        class="border-1 py-2.5 w-full px-4.5 rounded-lg"
        name="fullname"
        placeholder="Dela Cruz, Juan"
        type="text" />
    </section>


    <!-- submit button  -->
    <section
      class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
      <button
        type="submit"
        name="submit"
        class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>Search</p>
        <img clas src="../assets/icons/search-icon.svg" alt="" />
      </button>
    </section>
  </form>

  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>



  <!--  -->
  <!-- sort section -->
  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>
  <!--  -->


  <section class="flex items-center  gap-5 flex-wrap poppins uppercase place-self-left py-3.5 mx-8.5">
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
        name="view-history"
        id="view-history"
        class="uppercase bg-primary text-white rounded-lg py-2 px-5 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>Filter</p>
        <img class="size-5.5" src="../assets/icons/filter-icon.svg" alt="" />
      </button>
      <script>
        const gradeInput = document.getElementById('studentGrade');
        const sectionInput = document.getElementById('studentSection');
        const filterButton = document.getElementById('view-history');

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
    </form>

    <form action="" method="POST">
      <button
        type="submit"
        name="show-all"
        id="show-all"
        class="uppercase border-1 rounded-lg leading-5 py-2 px-5 flex gap-5 items-center justify-evenly cursor-pointer">
        <p>Show All</p>
      </button>
    </form>


  </section>




  <main
    class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
    <table class="min-w-full poppins">
      <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
        <tr>

          <th>Visit ID</th>
          <th>Name of student</th>
          <th>grade and section</th>
          <th>complaint</th>
          <th>TIME IN</th>
          <th>RELEASE</th>
          <th>DATE</th>
          <th>Treatment</th>
          <th>Qty.</th>
          <th>Preview</th>
        </tr>

      </thead>


      <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

        <?php
        include("../../config/database.php");
        if (isset($_POST['view-history'])) {

          $studentGrade = $_POST['studentGrade'];
          $studentSection = $_POST['studentSection'];

          if ($studentGrade != '' && $studentSection != '') {
            // grade and seciton
            $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND section = ? AND checkout !='' order by id desc");
            $stmt->bind_param("ss", $studentGrade, $studentSection);
          } else if ($studentGrade == '' && $studentSection != '') {
            //section lang
            $stmt = $conn->prepare("SELECT * FROM visitor WHERE section = ? AND checkout !='' order by id desc");
            $stmt->bind_param("s", $studentSection);
          } else if ($studentGrade != '' && $studentSection == '') {
            // grade lang
            $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND checkout !='' order by id desc");
            $stmt->bind_param("s", $studentGrade);
          } else {
            // wala lahat
            $stmt = $conn->prepare("SELECT * FROM visitor order by id desc");
          }

          if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                $_firstname = htmlspecialchars($row['firstname']);
                $_lastname = htmlspecialchars($row['lastname']);
                if (htmlspecialchars($row['checkout']) == "") {
                  $status = "On Treatment";
                } else {
                  $status = "Treated";
                }
                echo "<tr class=''>";
                echo "<td >" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                echo "<td>" . $treatment . "</td>";
                echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                echo "<td>" . "<form action='../../Controller/studenthistory.php' method='POST'>
                          <input type='hidden' name='fname' value='" . $_firstname . "'>
                          <input type='hidden' name='lname' value='" . $_lastname . "'>
                          <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><p class='hidden lg:block'>View History </p> <img class='lg:hidden size-5 block' src='../assets/icons/view-icon.svg'></button>
                        </form>" . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<td colspan='10' class='text-center bg-[#d4d4d40c]'>" . "No Patient Found." . "</td>";
            }

            $stmt->close();
          } else {
            echo "<p>Error preparing the statement: " . $conn->error . "</p>";
          }

          $conn->close();
        } else if (isset($_POST['submit'])) {
          $fullname = $_POST['fullname'];
          $name = explode(',', $fullname);

          $lastname = strtolower($name[0]);
          $firstname = strtolower(trim($name[1] ?? ''));
          if ($firstname == '') {
            //modal
            echo "<script>alert('Invalid Format. It should be (Lastname, Firstname)');
              window.location.href = window.location.pathname;</script>";
          }

          try {
            $stmt = $conn->prepare("SELECT * FROM visitor WHERE firstname = ? AND lastname = ? AND checkout!='' order by id desc");
            $stmt->bind_param("ss", $firstname, $lastname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $id = htmlspecialchars($row['id']);
                $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                $_firstname = htmlspecialchars($row['firstname']);
                $_lastname = htmlspecialchars($row['lastname']);
                if (htmlspecialchars($row['checkout']) == "") {
                  $status = "On Treatment";
                } else {
                  $status = "Treated";
                }
                echo "<tr class=''>";
                echo "<td >" . $id . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                echo "<td>" . $treatment . "</td>";
                echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";

                echo "<td>" . "<form action='../../Controller/studenthistory.php' method='POST'>
                          <input type='hidden' name='fname' value='" . $_firstname . "'>
                          <input type='hidden' name='lname' value='" . $_lastname . "'>
                          <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><p class='hidden lg:block'>View History </p> <img class='lg:hidden size-5 block' src='../assets/icons/view-icon.svg'></button>
                        </form>" . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr '>";
              echo "<td colspan='10' class='text-center bg-[#d4d4d40c]'>" . "Patient Not Found." . "</td>";
              echo "</tr>";
            }
          } catch (mysqli_sql_exception $e) {
            //Invalid input format
            echo "Error: " . $e->getMessage();
          }
        } else {
          include("../../config/database.php");
          if (isset($_POST['show-all']) || !isset($_POST['show-all'])) {



            try {
              $query = "SELECT * FROM visitor where checkout != '' order by id desc";
              $result = $conn->query($query);

              if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                  $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                  $_firstname = htmlspecialchars($row['firstname']);
                  $_lastname = htmlspecialchars($row['lastname']);

                  echo "<tr class=''>";
                  echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                  echo "<td>" . $treatment . "</td>";
                  echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                  echo "<td>
                        <form action='../../Controller/studenthistory.php' method='POST'>
                          <input type='hidden' name='fname' value='" . $_firstname . "'>
                          <input type='hidden' name='lname' value='" . $_lastname . "'>
                          <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><p class='hidden lg:block'>View History </p> <img class='lg:hidden size-5 block' src='../assets/icons/view-icon.svg'></button>
                        </form>
                  </td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr>";
                echo "<td colspan='10' class='text-center bg-[#d4d4d40c]'>" . "No Current Patient." . "</td>";
                echo "</tr>";
              }
            } catch (mysqli_sql_exception $e) {
              echo "Error: " . $e->getMessage();
            }
          }
        }
        ?>

      </tbody>
    </table>
  </main>
</section>
</body>

<script>
  sessionStorage.setItem("lastPage", window.location.href);
</script>

</html>