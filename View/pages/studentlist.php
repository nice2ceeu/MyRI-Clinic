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

<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82 uppercase">

  <section class="relative mt-5 text-[max(2.5vw,2rem)]">
    <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
      Student's list Form
    </h1>
    <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
  </section>

  <!-- FORM SEARCH SECTION FOR USERS  -->

  <section class="flex gap-5 mt-5 flex-wrap items-center poppins uppercase  py-3.5  w-full">
    <form
      action=""
      method="POST"
      class="ml-8.5 gap-3.5 uppercase flex justify-left">
      <section class="relative  basis-xs ">
        <label
          id="label"
          class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
          for="name">name of student</label>
        <input
          id="name"
          class="border-1 py-2.5 w-full px-4.5 rounded-lg"
          name="fullname"
          placeholder="Dela Cruz, Juan"
          type="text"
          required />
      </section>

      <button

        type="submit"
        name="search"
        class="bg-[#06118e] text-white poppins uppercase flex justify-evenly gap-2.5 px-10 cursor-pointer py-2.5 rounded-lg">
        <p>Search</p>

        <img src="../assets/icons/search-icon.svg" />
      </button>
    </form>
    <form class="" action="" method="POST">
      <button
        type="submit"
        name="search-all"
        class="border-1 leading-5 poppins uppercase flex items-center gap-2.5 px-5 cursor-pointer py-2 rounded-lg">
        <p>Show All</p>
      </button>
    </form>

    <div id="blur" class="fixed h-dvh hidden backdrop-blur-xs top-0 bg-white/30 z-20 w-full"> </div>
    <!-- btn -->





    <button id="file-upload" class="bg-[#06118e] ml-auto  text-nowrap text-white poppins uppercase flex justify-evenly gap-2.5 px-5 cursor-pointer py-2.5 rounded-lg ">upload a file <img src="../assets/icons/file-upload-icon.svg" alt=""></button>
    <!--up form  -->
    <form id="upload" class="flex invisible flex-col gap-5 z-20 bg-white justify-center items-center size-100 absolute border-1 border-dashed top-1/3 right-1/5" action="../../Controller/uploadform.php" method="POST" enctype="multipart/form-data">
      <img id="close" class="invert absolute z-10  top-1.5 right-1.5 cursor-pointer" src="../assets/icons/close-icon.svg" alt="close-icon">
      <div class="flex flex-col items-center pt-12">
        <h1 id="file-choose" class="font-semibold text-2xl">Choose a File</h1>
        <h6 class="opacity-80 text-sm">XLS, XLSX, XLSM, XLTX and XLTM</h6>
      </div>
      <br>
      <input id="file" class="absolute opacity-0 border-1 h-72 w-full text-center inline cursor-pointer" type="file" name="file" accept=".xlsx,.xls,.csv">
      <button
        id="browse"
        class=" text-nowrap border-1 rounded-lg px-5 py-2 my-5 mt-auto cursor-pointer"
        type="submit" name="upload">Browse</button>
    </form>
    <a class="bg-[#06118e] text-nowrap text-white poppins mr-5 uppercase flex justify-evenly gap-2.5 px-7  cursor-pointer py-2.5 rounded-lg"
      href="view-download.php">My downloads
      <img src="../assets/icons/my-download-icon.svg" alt="my-download-icon">
    </a>

  </section>

  <section class="relative mt-12">
    <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
  </section>

  <?php

  include("../../View/modal/alert.php");
  if (isset($_SESSION['modal_message'])) {
    $msg = $_SESSION['modal_message'];
    $title = $_SESSION['modal_title'] ?? 'Notice';

    echo "<script>
    document.getElementById('alertHeader').innerText = '$title';
    showModal('$msg');
  </script>";
    unset($_SESSION['modal_message'], $_SESSION['modal_title']);
  }


  include('../components/body.php');
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
          <th>Delete</th>
        </tr>
      </thead>



      <tbody
        class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

        <body>
          <?php
          include('../../config/database.php');
          if (isset($_POST['search'])) {
            $fullname = $_POST['fullname'];
            $name = explode(',', $fullname);

            $lastname = strtolower($name[0]);
            $firstname = strtolower(trim($name[1] ?? ''));
            //modal
            if ($firstname == '') {
              echo "<script>alert('Invalid Format. It should be (Lastname, Firstname)');
              window.location.href = window.location.pathname;</script>";
            }

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

                echo   "<td><form  action='../pages/medicalinformation.php' method='POST'>
                        
                        <input type='hidden' name='id' value='" . $_id . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-form'><span '>Form</span></button>
                        
                        </form>
                        </td>";
                echo   "<td><form action='../../Controller/studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-white' type='submit' name='view-history'><span '>History</span></button>
                        </form>
                        </td>";
                echo "<td>" .
                  "<form action='../../Controller/delete.php' method='POST'>
                                    <input type='hidden' name='id' value='$_id'>
                                    <button class='flex rounded-lg gap-5 px-3 py-2.5 text-nowrap bg-red-500 cursor-pointer text-white' type='submit' name='form-del'>REMOVE FORM</button>
                                </form></td>";

                echo "</tr>";
              } else {
                echo "<script>alert('No User Found ?');
                            window.location.href = 'studentlist.php';
                        </script>";
              }
            } catch (mysqli_sql_exception $e) {
              echo "Error: " . $e->getMessage();
            }
          } else {
            include("../../config/database.php");
            if (isset($_POST['search-all']) || !isset($_POST['search-all'])) {

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

                    echo   "<td><form  action='../pages/medicalinformation.php' method='POST'>
                        
                        <input type='hidden' name='id' value='" . $_id . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-nowrap text-white' type='submit' name='view-form'><span '>Form</span></button>
                        
                        </form>
                        </td>";
                    echo   "<td><form action='../../Controller/studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-primary cursor-pointer text-nowrap text-white' type='submit' name='view-history'><span '>History</span></button>
                        </form>
                        </td>";
                    echo "<td>" .
                      "<form action='../../Controller/delete.php' method='POST'>
                                    <input type='hidden' name='id' value='$_id'>
                                    <button class='flex rounded-lg gap-5 px-3 py-2.5 text-nowrap bg-red-500 cursor-pointer text-white' type='submit' name='form-del'>REMOVE FORM</button>
                                </form></td>";

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
          }
          ?>
          <!--  -->


      </tbody>
    </table>
  </main>

</section>
</body>

<script>
  sessionStorage.setItem("lastPage", window.location.href);
</script>
<script>
  const file_upload = document.getElementById("file-upload")
  const upload = document.getElementById("upload")
  const blur = document.getElementById("blur")
  const close = document.getElementById("close")
  const file_choose = document.getElementById("file-choose")
  const fileInput = document.getElementById("file")
  const browse = document.getElementById("browse")
  const allowedExtensions = ['xls', 'xlsx', 'xlsm', 'xltx', 'xltm'];
  let click = false
  blur.classList.add("hidden")
  file_upload.addEventListener("click", () => {
    if (!click) {
      upload.classList.remove("invisible")
      blur.classList.remove("hidden")
      click = true
    } else {
      upload.classList.add("invisible")
      blur.classList.add("hidden")
      click = false
    }
  })

  close.addEventListener("click", () => {
    if (!click) {
      upload.classList.remove("invisible")
      blur.classList.remove("hidden")
      click = true
    } else {
      upload.classList.add("invisible")
      blur.classList.add("hidden")
      click = false
    }
  })

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      file_choose.textContent = fileInput.files[0].name;
      browse.textContent = 'Upload';

    } else {
      file_choose.textContent = 'Choose a File';

    }
  });

  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (!file) return;

    const fileName = file.name.toLowerCase();
    const fileExt = fileName.split('.').pop();

    if (!allowedExtensions.includes(fileExt)) {
      alert('Invalid file type. Please select an Excel file.');
      file.value = ' '; // clear input
    }
  });
</script>

</html>