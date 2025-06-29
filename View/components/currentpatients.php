<?php
include("body.php")
?>


<main
    class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
    <table class="min-w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
                <th>ID</th>
                <th>Name of student</th>
                <th>grade and section</th>
                <th>complaint</th>
                <th>TIME IN</th>
                <th>DATE</th>
                <th>action</th>
            </tr>

        </thead>


        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include("/config/database.php");
            
            if (isset($_POST['current-filter'])) {
                $studentGrade = $_POST['studentGrade'];
                $studentSection = $_POST['studentSection'];


                try {


                    if ($studentGrade != '' && $studentSection != '') {
                        // grade and seciton
                        $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND section = ? AND checkout = ''");
                        $stmt->bind_param("ss", $studentGrade, $studentSection);
                    } else if ($studentGrade == '' && $studentSection != '') {
                        //section lang
                        $stmt = $conn->prepare("SELECT * FROM visitor WHERE section = ? AND checkout = ''");
                        $stmt->bind_param("s", $studentSection);
                    } else if ($studentGrade != '' && $studentSection == '') {
                        // grade lang
                        $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND checkout = ''");
                        $stmt->bind_param("s", $studentGrade);
                    } else {
                        // wala lahat
                        $stmt = $conn->prepare("SELECT * FROM visitor");
                    }

                    if ($stmt) {
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
                                    <button onclick='showPopup($id)' class='bg-primary text-white rounded-lg uppercase py-2.5 px-5 flex gap-5 items-center justify-evenly cursor-pointer'>
                                        <p>Patient out</p>
                                        <img class='w-4 h-4' src='/assets/icons/out-icon.svg' alt='check icon' />
                                    </button>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<td colspan='9' class='text-center bg-[#d4d4d40c]'>" . "No Patient Found." . "</td>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
                    }

                    $conn->close();
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                
                try {

                    $query = "SELECT * FROM visitor where checkout = '' order by checkin desc";
                    $result = $conn->query($query);

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
                                    <button onclick='showPopup($id)' class='bg-primary text-white rounded-lg uppercase py-2.5 px-5 flex gap-5 items-center justify-evenly cursor-pointer'>
                                        <p>Patient out</p>
                                        <img class='w-4 h-4' src='/assets/icons/out-icon.svg' alt='check icon' />
                                    </button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr '>";
                        echo "<td colspan='9' class='text-center bg-[#d4d4d40c]'>" . "No Current Patient." . "</td>";
                        echo "</tr>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>

            <?php
            include('/config/database.php');
            // Fetch medicine options once
            $medOptions = "";
            $dateNow = date('Y-m-d');
            $query = "SELECT Medicine_Name FROM meds where Med_Quantity > 0 AND Expiration_Date > '$dateNow'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $med = htmlspecialchars($row['Medicine_Name']);
                    $medOptions .= "<option value='$med'>$med</option>";
                }
            }
            ?>
            <!-- Popup Overlay -->
            <?php echo "           
            <div class='backdrop-blur-xs uppercase fixed h-dvh w-[90%] justify-center items-center p-5 top-0 right-0 hidden' id='popupOverlay'>
                <div class='bg-white shadow-xl flex relative flex-col gap-5 p-5 w-[70%] items-center  size-100 '>

                    <h1 class='poppins  font-[500] bg-white text-nowrap mt-5 text-[min(4.5vw,2rem)]'>
                        Type of treatment given
                    </h1>

                    <img class='absolute right-1.5 top-1.5 invert cursor-pointer' onclick='hidePopup()' src='/assets/icons/close-icon.svg'>

                    <form class='text-nowrap relative' action='/controller/release.php' method='POST'>
                        <div class='flex items-center gap-2'>
                            <input class='appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500' type='radio' id='with-medicine' name='treatment' value='yes' onclick='toggleMedSection()' required>
                            <label for='with-medicine'>Medicinal Treatment</label>
                            <input class='appearance-none checked:bg-[#06118e8a] w-5 h-5 border border-gray-500' type='radio' id='no-medicine' name='treatment' value='no' onclick='toggleMedSection()' required>
                            <label for='no-medicine'>No Medicine Used</label>
                        </div>

                        <div class='relative flex w-2/3 gap-5' id='with-medicine-treatment'>
                            <label class='absolute -top-1 left-1.5 inline leading-3 bg-white px-5'>Medicine Used</label>
                            <select name='medicine' id='medicine' class='border-1 p-3.5 rounded-lg w-full'>
                                <option disabled selected value='' class='opacity-50'>
                                    Select Medicine
                                </option>
                                $medOptions
                            </select>
                            <div class='mt-5  relative'>
                                <label class='absolute -top-1 left-1.5 inline leading-3 bg-white px-5'>Medicine Quantity </label>
                                <input class='border-1 px-5 py-3 rounded-lg w-full' type='number' name='medicine_qty'>
                            </div>
                        </div>
                        <div class='relative w-2/3' id='without-medicine-treatment' style='display: none;'>
                            <label class='absolute -top-1 left-1.5 inline leading-3 bg-white px-3' for='physical-treatment'>PHYSICAL TREATMENT</label>
                            <input class='border-1 px-5 py-3 rounded-lg w-full' type='text' id='physical-treatment' name='physical-treatment'>
                        </div>
                        <input type='hidden' id='id' name='user_id'>
                        <div class='flex gap-5'>
                            <button class='flex px-5 py-3 gap-5 rounded-lg cursor-pointer bg-green-500 text-white  justify-evenly' type='submit' name='release'>RELEASE <img class='invert' src='/assets/icons/release-icon.svg'></button>

                            <div class='flex px-5 py-3 gap-5 rounded-lg cursor-pointer bg-red-500 text-white  justify-evenly' onclick='hidePopup()'>Cancel <img class='' src='/assets/icons/close-icon.svg'></div>
                        </div>
                    </form>
                </div>
            </div>
            " .
                "<script>
                function toggleMedSection() {
                    const withMedSection = document.getElementById('with-medicine-treatment');
                    const withoutMedSection = document.getElementById('without-medicine-treatment');
                    const isWithMed = document.getElementById('with-medicine').checked;
                    const isWithoutMed = document.getElementById('no-medicine').checked;

                    withMedSection.style.display = isWithMed ? 'block' : 'none';
                    withoutMedSection.style.display = isWithoutMed ? 'block' : 'none';
                }

                function showPopup(id) {
                    document.getElementById('popupOverlay').style.display = 'flex';
                    document.getElementById('id').value = id;
                }

                function hidePopup() {
                    document.getElementById('popupOverlay').style.display = 'none';
                }

                window.onload = function() {
                    toggleMedSection();
                };
            </script>"

            ?>
        </tbody>
    </table>
</main>