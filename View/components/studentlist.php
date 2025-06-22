<?php

include("View/modal/alert.php");
if (isset($_SESSION['modal_message'])) {
  $msg = $_SESSION['modal_message'];
  $title = $_SESSION['modal_title'] ?? 'Notice';

  echo "<script>
    document.getElementById('alertHeader').innerText = '$title';
    showModal('$msg');
  </script>";
  unset($_SESSION['modal_message'], $_SESSION['modal_title']);
}


include('/components/body.php');
?>
<main
  class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
  <table class="min-w-full poppins">
    <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
      <tr class="">

        <th>ID</th>
        <th>FULL NAME</th>
        <th>Gender</th>
        <th>Citezenship</th>
        <th>Guardian</th>
        <th>Guardian's Contact No.</th>
        <th>Medical Form</th>
        <th>History</th>
      </tr>
    </thead>



    <tbody
      class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

      <body>
        <?php
        include('config/database.php');
        if (isset($_POST['submit'])) {
          $fullname = $_POST['fullname'];
          $name = explode(',', $fullname);

          $lastname = strtolower($name[0]);
          $firstname = strtolower(trim($name[1]));

          try {
            $stmt = $conn->prepare("SELECT * FROM medforms WHERE firstname = ? AND lastname = ?");
            $stmt->bind_param("ss", $firstname, $lastname);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();


              $_id = htmlspecialchars($row['id']);
              $_firstname = htmlspecialchars($row['firstname']);
              $_lastname = htmlspecialchars($row['lastname']);
              echo "<tr class=''>";
              echo "<td>" . $_id . "</td>";
              echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
              echo "<td>" . htmlspecialchars($row['citizenship']) . "</td>";
              echo "<td>" . htmlspecialchars($row['guardian']) . "</td>";
              echo "<td>" . htmlspecialchars($row['contact']) . "</td>";

              echo   "<td><form  action='/pages/medicalinformation.php' method='POST'>
                        
                        <input type='hidden' name='id' value='" . $_id . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-form'><span '>View Form</span></button>
                        
                        </form>
                        </td>";
              echo   "<td><form action='/controller/studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><span '>View History</span></button>
                        </form>
                        </td>";
            } else {
              echo "<script>alert('No User Found');
                            window.location.href = '/view/pages/studentlist.php';
                        </script>";
            }
          } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
          }
        } else {
          include("config/database.php");

          try {
            $query = "SELECT * FROM medforms order by firstname asc";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {

              while ($row = $result->fetch_assoc()) {
                $_id = htmlspecialchars($row['id']);
                $_firstname = htmlspecialchars($row['firstname']);
                $_lastname = htmlspecialchars($row['lastname']);
                echo "<tr>";
                echo "<td>" . $_id . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['citizenship']) . "</td>";
                echo "<td>" . htmlspecialchars($row['guardian']) . "</td>";
                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";

                echo   "<td><form  action='/pages/medicalinformation.php' method='POST'>
                        
                        <input type='hidden' name='id' value='" . $_id . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-form'><span '>View Form</span></button>
                        
                        </form>
                        </td>";
                echo   "<td><form action='/controller/studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><span '>View History</span></button>
                        </form>
                        </td>";

                echo "</tr>";
              }
            } else {
              echo "<tr>";
              echo "<td colspan='8' class='text-center bg-[#d4d4d40c]'>" . "No data available." . "</td>";
              echo "</tr>";
            }
          } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
          }
        }

        ?>
        <!-- <?php

              ?> -->


    </tbody>
  </table>
</main>
<script>
  sessionStorage.setItem("lastPage", window.location.href);
</script>