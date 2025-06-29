<?php
include('/view/components/body.php');
?>

<nav class="poppins uppercase font-semibold text-white text-center py-5 bg-[#06118e] text-[max(2vw,3rem)] w-full">Visit History</nav>
<a class="flex bg-[#06118e] poppins uppercase font-semibold text-white w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly text-[max(1vw,1rem)]" href="#" onclick="goBack()">
    <span>Back</span>
    <img src="/view/assets/icons/back-icon.svg" alt="back-icon">
</a>

<main class="uppercase mt-22 px-8.5">
    <table class="w-full poppins">
        <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
            <tr>
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
        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
            <?php
            include('/config/database.php');

            if (isset($_POST['view-history'])) {
                $firstname = $_POST['fname'];
                $lastname = $_POST['lname'];

                $sql = "SELECT * FROM visitor WHERE firstname = ? AND lastname = ? ORDER BY id DESC";
                $params = array($firstname, $lastname);
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $found = false;
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $found = true;
                    $treatment = htmlspecialchars($row['medicine'] ?? '') ?: htmlspecialchars($row['physical_treatment'] ?? '');
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
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

                if (!$found) {
                    session_start();
                    $_SESSION['modal_title'] = 'Alert';
                    $_SESSION['modal_message'] = 'No History found';
                    header("Location: /view/pages/studentlist.php");
                    exit;
                }
            }
            ?>
        </tbody>
    </table>

    <script>
        function goBack() {
            const backURL = sessionStorage.getItem("lastPage");
            if (backURL) {
                window.location.href = backURL;
            } else {
                window.location.href = "visit_history.php?page=visit";
            }
        }
    </script>
</main>