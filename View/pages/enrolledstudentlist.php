<?php
session_start();



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





if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
include('../components/body.php');
include('../components/navbar.php');
?>


<main class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">
    <section class="relative mt-5 text-[max(3vw,2rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
            Enrolled Student's
        </h1>
        <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
    </section>

    <section class="flex gap-5 mt-5 items-center  flex-wrap poppins uppercase  py-3.5  ">

        <form
            class="mx-8.5 gap-3.5 uppercase flex flex-wrap w-full md:basis-[68%] "
            action=""
            method="POST">

            <!-- name of student  -->

            <section class="relative basis-xs ">

                <label
                    id="label"
                    class="absolute uppercase text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
                    for="name">name of student</label>

                <input
                    id="fullname"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="fullname"
                    placeholder="Dela Cruz, Juan"
                    type="text" />

            </section>


            <!-- search button  -->
            <section
                class="poppins text-white bg-primary  rounded-lg relative cursor-pointer">
                <button

                    name="submit"
                    class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Search</p>
                    <img clas src="../assets/icons/search-icon.svg" alt="" />
                </button>


            </section>
        </form>

        <button
            id="file-upload"
            class="bg-[#06118e] text-nowrap text-white  poppins uppercase flex justify-between gap-2.5 px-10 mx-8.5 cursor-pointer py-2.5 rounded-lg">
            Upload a file
            <img src="../assets/icons/file-upload-icon.svg" alt="">
        </button>


    </section>




    <div id="blur" class="fixed h-dvh backdrop-blur-xs top-0 bg-white/30 z-20 w-full"></div>

    <form id="upload" class="border-dotted absolute left-12.5 md:left-[30%] top-1/3 size-100 md:w-1/2 z-30 invisible shadow-xl bg-white border-3 border-[#8080808e] rounded-lg  flex flex-col items-center justify-between p-10 " action="../../controller//uploadStudent.php" method="POST" enctype="multipart/form-data">

        <img id="close" class="invert absolute z-10  top-1.5 right-1.5 cursor-pointer" src="../assets/icons/close-icon.svg" alt="close-icon">
        <table class="opacity-70 w-full  uppercase poppins mb-10">
            <tr class="border-1">
                <th class="text-sm" colspan="4"> excel must contains</th>
            </tr>
            <tr class="[&>th]:border-1">
                <th>firstname</th>
                <th>lastname</th>
                <th>LRN</th>
            </tr>
            <tr class="text-center [&>td]:border-1">
                <td>Juan</td>
                <td>Dela Cruz</td>
                <td>11 Digit No.</td>
            </tr>
        </table>
        <img class="size-7 opacity-70" src="../assets/icons/upload-icon.svg" alt="upload-icon" />
        <div class="h-full w-full  absolute">
            <label for="file">
                <div class="flex flex-col items-center pt-40">
                    <h1 id="file-choose" class="font-semibold text-2xl">Choose a File</h1>
                    <h6 class="opacity-80 text-sm">XLS, XLSX, XLSM, XLTX and XLTM</h6>
                </div>
                <input class="absolute opacity-0 top-[-20px] focus:opacity-0 h-full w-full" id="file" type="file" name="file" accept=".xlsx,.xls,.csv" required>
            </label>
        </div>
        <br>
        <br>
        <br>
        <br>
        <button
            id="browse"
            class="poppins z-10 mt-5 w-1/3 justify-center cursor-pointer border-1 px-5 py-3 flex gap-x-3 rounded-lg"
            type='submit' name="upload">Browse</button>
    </form>



    <section class="relative mt-12">
        <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
    </section>





    <!--  -->
    <section class="relative mt-12">
        <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
    </section>
    <!--  -->

    <!-- sort section -->

    <section class="flex gap-5 items-center poppins uppercase place-self-left py-3.5 mx-8.5">
        <form class=" flex items-center flex-wrap gap-5" action="" method="POST">


            <div class="relative">
                <label
                    id="label"
                    class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
                    for="accountStatus">
                    Account Status
                </label>
                <select name="accountStatus" id="accountStatus" class="border rounded px-7.5 py-1.5">
                    <option disabled selected>Select to filter</option>
                    <option value="registered">Registered</option>
                    <option value="notRegistered">Not registered</option>
                </select>
            </div>

            <button
                disabled
                id="show-filter"
                name="show-filter"
                class="uppercase bg-primary text-white rounded-lg py-2 px-5 flex gap-5 items-center justify-evenly cursor-pointer">
                <p>Filter</p>
                <img class="size-5.5" src="../assets/icons/filter-icon.svg" alt="" />
            </button>


            <section class="poppins  relative cursor-pointer">
                <button
                    name="show-all"
                    class="uppercase border-1 rounded-lg w-full py-2 px-5 leading-5 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Show All</p>
                </button>
            </section>

        </form>
        <script>
            const accountStatus = document.getElementById('accountStatus');
            const filterButton = document.getElementById('show-filter');







            function checkInputs() {


                // Enable button only if one or both inputs have value
                if (accountStatus !== '') {
                    filterButton.disabled = false;
                } else {
                    filterButton.disabled = true;

                }
            }


            accountStatus.addEventListener('input', checkInputs);
        </script>



    </section>





    <!-- end of upload <form action=""></form> -->
    <!-- end of upload <form action=""></form> -->
    <!-- end of upload <form action=""></form> -->


    <div
        class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
        <table class="min-w-full poppins">
            <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22 ">
                <tr class="">

                    <th>ID</th>
                    <th>FULL NAME</th>
                    <th>Username (LRN)</th>
                    <th>Account Status</th>
                    <th>Reset Password</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody
                class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">


                <?php
                include("../../config/database.php");

                if (isset($_POST['submit'])) {
                    $fullname = $_POST['fullname'];
                    $name = explode(',', $fullname);

                    $lastname = strtolower($name[0]);
                    $firstname = strtolower(trim($name[1] ?? ''));
                    if ($firstname == '') {
                        echo "<script>alert('Invalid Format. It should be (Lastname, Firstname)');
        window.location.href = window.location.pathname;</script>";
                    }

                    $query = "SELECT * FROM admin WHERE firstname = ? AND lastname = ? AND user_role='student' ORDER BY id DESC";
                    $params = array($firstname, $lastname);
                    $stmt = sqlsrv_prepare($conn, $query, $params);

                    if ($stmt && sqlsrv_execute($stmt)) {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $user = htmlspecialchars($row['username']);
                            $password = $row['password'] ?? '';
                            $registered = $password == '' ? "<span style='color:red'>Not Registered</span>" : "<span style='color:green'>Registered</span>";
                            $id = htmlspecialchars($row['id']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . " " . htmlspecialchars($row['firstname']) . "</td>";
                            echo "<td>$user</td>";
                            echo "<td>$registered</td>";

                            if ($password === '' || $password === null) {
                                echo "<td>Unavailable</td>";
                            } else {
                                echo "<td><form action='../../controller/resetpassword.php' method='POST'>
                <input type='hidden' name='id' value='$id'>
                <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-orange-500 cursor-pointer text-white' type='submit' name='reset'>RESET PASSWORD</button>
                </form></td>";
                            }

                            echo "<td><form action='../../controller/delete.php' method='POST'>
            <input type='hidden' name='id' value='$user'>
            <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete-form'>REMOVE RECORD</button>
            </form></td>";
                            echo "</tr>";
                        }
                    }
                } elseif (isset($_POST['show-filter'])) {
                    $accountStatus = $_POST['accountStatus'];
                    $query = $accountStatus === 'registered'
                        ? "SELECT * FROM admin WHERE user_role = 'student' AND password != '' ORDER BY lastname ASC"
                        : "SELECT * FROM admin WHERE user_role = 'student' AND (password IS NULL OR password = '') ORDER BY lastname ASC";


                    $stmt = sqlsrv_prepare($conn, $query);

                    if ($stmt && sqlsrv_execute($stmt)) {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $user = htmlspecialchars($row['username']);
                            $password = $row['password'] ?? '';
                            $registered = $password == '' ? "<span style='color:red'>Not Registered</span>" : "<span style='color:green'>Registered</span>";
                            $id = htmlspecialchars($row['id']);

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . " " . htmlspecialchars($row['firstname']) . "</td>";
                            echo "<td>$user</td>";
                            echo "<td>$registered</td>";

                            if ($password === '' || $password === null) {
                                echo "<td>Unavailable</td>";
                            } else {
                                echo "<td><form action='../../controller/resetpassword.php' method='POST'>
                <input type='hidden' name='id' value='$id'>
                <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-orange-500 cursor-pointer text-white' type='submit' name='reset'>RESET PASSWORD</button>
                </form></td>";
                            }

                            echo "<td><form action='../../controller/delete.php' method='POST'>
            <input type='hidden' name='id' value='$user'>
            <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete-form'>REMOVE RECORD</button>
            </form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center uppercase bg-[#d4d4d40c]'>No data available.</td></tr>";
                    }
                } elseif (isset($_POST['show-all']) || !isset($_POST['show-all'])) {
                    try {
                        $query = "SELECT * FROM admin WHERE user_role = 'student' ORDER BY lastname ASC";
                        $stmt = sqlsrv_prepare($conn, $query);

                        if ($stmt && sqlsrv_execute($stmt)) {
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $user = htmlspecialchars($row['username']);
                                $password = $row['password'] ?? '';
                                $registered = $password == '' ? "<span style='color:red'>Not Registered</span>" : "<span style='color:green'>Registered</span>";
                                $id = htmlspecialchars($row['id']);

                                echo "<tr>";
                                echo "<td>$id</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . " " . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>$user</td>";
                                echo "<td>$registered</td>";

                                if ($password === '' || $password === null) {
                                    echo "<td>Unavailable</td>";
                                } else {
                                    echo "<td><form action='../../controller/resetpassword.php' method='POST'>
                    <input type='hidden' name='id' value='$id'>
                    <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-orange-500 cursor-pointer text-white' type='submit' name='reset'>RESET PASSWORD</button>
                    </form></td>";
                                }

                                echo "<td><form action='../../controller/delete.php' method='POST'>
                <input type='hidden' name='id' value='$user'>
                <button class='flex rounded-lg gap-5 px-3 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete-form'>REMOVE RECORD</button>
                </form></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center uppercase bg-[#d4d4d40c]'>No data available.</td></tr>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>


        </table>
    </div>
</main>
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
</body>