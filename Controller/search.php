<?php
include('/view/components/body.php');



?>

<tbody
    class='text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5'>

    <?php
    //for current patients
    include('/config/database.php');
    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $name = explode(',', $fullname);

        $lastname = strtolower($name[0]);
        $firstname = strtolower(trim($name[1]));
        echo "<main class='uppercase mt-22 px-8.5'>
    <table class='w-full poppins'>
        <thead class='[&>tr>th]:px-4 text-left [&>tr>th]:pb-22'>
            <tr class=''>
                <th>ID</th>
                <th>Name of student</th>
                <th>grade and section</th>
                <th>complaint</th>
                <th>TIME IN</th>
                <th>DATE</th>
                <th>Action</th>

            </tr>
        </thead>";

        try {
            $stmt = $conn->prepare("SELECT * FROM visitor WHERE firstname = ? AND lastname = ? AND checkout=''");
            $stmt->bind_param("ss", $firstname, $lastname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = htmlspecialchars($row['id']);
                    echo "<tr class=''>";
                    echo "<td >" . $id . "</td>";
                    echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['_date']) . "</td>";

                    echo  "<td>  
                                <button onclick='showPopup()' class='bg-primary text-white rounded-lg uppercase  py-2.5 px-5 flex gap-5 items-center justify-evenly cursor-pointer'>
                                    <p>Patient out</p>
                                    <img class='w-4 h-4' src='/view/assets/icons/out-icon.svg' alt='check icon' />
                                </button>
                            </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr '>";
                echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "Patient Not Found." . "</td>";
                echo "</tr>";
            }
        } catch (mysqli_sql_exception $e) {
            //Invalid input format
            echo "Error: " . $e->getMessage();
        }
    } else {
        include('/view/components/body.php');

    ?>
<tbody
    class='text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5'>

<?php

        include('/config/database.php');
        $fullname = $_POST['fullname'];
        $name = explode(',', $fullname);

        $lastname = strtolower($name[0]);
        $firstname = strtolower(trim($name[1]));
        echo "<main class='uppercase mt-22 px-8.5'>
    <table class='w-full poppins'>
        <thead class='[&>tr>th]:px-4 text-left [&>tr>th]:pb-22'>
            <tr class=''>
                <th>ID</th>
                <th>Name of student</th>
                <th>Gender</th>
                <th>citizenship</th>
                <th>guardian</th>
                <th>Contact</th>
                <th>Medical Form</th>
                <th>History</th>

            </tr>
        </thead>";

        try {
            $stmt = $conn->prepare("SELECT * FROM medforms WHERE firstname = ? AND lastname = ?");
            $stmt->bind_param("ss", $firstname, $lastname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = htmlspecialchars($row['id']);
                    $_firstname = htmlspecialchars($row['firstname']);
                    $_lastname = htmlspecialchars($row['lastname']);
                    echo "<tr class=''>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" .  $_firstname . " " . $_lastname . "</td>";
                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['citizenship']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['guardian']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";

                    echo   "<td><form action='/view/pages/medicalinformation.php' method='POST'>
                        <input type='hidden' name='id' value='" . $id  . "'>
                        <button type='submit' name='view-form'><span style='color: green;'>view Form</span></button>
                        </form>
                        </td>";
                    echo   "<td><form action='studenthistory.php' method='POST'>
                        <input type='hidden' name='fname' value='" . $_firstname . "'>
                        <input type='hidden' name='lname' value='" . $_lastname . "'>
                        
                        <button type='submit' name='view-history'><span style='color: blue;'>view History</span></button>
                        </form>
                        </td>";
                }
            } else {
                echo "<tr '>";
                echo "<td colspan='9' class='text-center bg-[#ffc5c541]'>" . "Patient Not Found." . "</td>";
                echo "</tr>";
            }
        } catch (mysqli_sql_exception $e) {
            //Invalid input format
            echo "Error: " . $e->getMessage();
        }
    }



?>
</tbody>
<table>
    </main>