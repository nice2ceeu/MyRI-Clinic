<?php
include('../View/components/body.php');

?>


<nav class="poppins uppercase font-semibold text-white text-center py-5 bg-[#06118e] text-[max(2vw,3rem)] w-full">Visit History</nav>
<a class="flex bg-[#06118e] poppins uppercase font-semibold text-white w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly items-center text-[max(0.5vw,1rem)]" href="#" onclick="goBack()"><span>Back</span><img src="../View/assets/icons/back-icon.svg" alt="back-icon"></a>
<main class="uppercase mt-22 px-8.5">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr class="">
                <th>Visit ID</th>
                <th>FULL NAME</th>
                <th>Grade and Section</th>
                <th>complaint</th>
                <th>Time in</th>
                <th>Time Out</th>
                <th>Date</th>
                <th>treatment</th>
                <th>Qty.</th>

            </tr>
        </thead>

        <tbody
            class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include('../config/database.php');
            include('../View/components/body.php');
            if (isset($_POST['view-history'])) {
                $firstname = $_POST['fname'];
                $lastname = $_POST['lname'];

                try {
                    $stmt = $conn->prepare("SELECT * FROM visitor WHERE firstname = ? and lastname =? order by _date desc");
                    $stmt->bind_param("ss", $firstname, $lastname);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $treatment = htmlspecialchars($row['medicine']) ?: htmlspecialchars($row['physical_treatment']);
                            $id = htmlspecialchars($row['id']);
                            echo "<tr class=''>";
                            echo "<td>" . $id . "</td>";
                            echo "<td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['grade']) . " - " . htmlspecialchars($row['section']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['complaint']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkout']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
                            echo "<td>" . $treatment . "</td>";
                            echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo


                        session_start();
                        $_SESSION['modal_title'] = 'Alert';
                        $_SESSION['modal_message'] = 'No History found';
                        header("Location: ../view/pages/studentlist.php");
                        exit;
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            ?>
    </table>

    <script>
        function goBack() {
            const backURL = sessionStorage.getItem("lastPage");

            if (backURL) {
                window.location.href = backURL;
            } else {
                window.location.href = "visit_history.php?page=visit"; // fallback
            }
        }
    </script>