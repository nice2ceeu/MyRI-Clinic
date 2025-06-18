<?php

include('../components/body.php');

?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
} else {
    include('../../config/database.php');

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];


    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM visitor WHERE firstname = ? AND lastname = ? ");
        $stmt->bind_param("ss", $firstname, $lastname);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = htmlspecialchars($row['count']);
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<nav class="poppins uppercase font-semibold text-white text-center py-5 bg-[#06118e] text-[max(2vw,3rem)] w-full">Visit History</nav>
<a class="flex bg-[#06118e] poppins uppercase font-semibold text-white w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly text-[max(1vw,1rem)]" href="userprofile.php"><span>Back</span><img src="../assets/icons/back-icon.svg" alt="back-icon"></a>
<main
    class="uppercase mt-22 px-8.5 ">
    <table class="w-full poppins">
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
            </tr>

        </thead>


        <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">

            <?php
            include("../../config/database.php");

            $firstname = $_SESSION['firstname'];
            $lastname = $_SESSION['lastname'];


            try {
                $stmt = $conn->prepare("SELECT * FROM visitor where firstname =? AND lastname =? order by id desc");
                $stmt->execute([$firstname, $lastname]);
                $result = $stmt->get_result();

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
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='9' class='text-center bg-[#d4d4d40c]'>" . "No Visit Records." . "</td>";
                    echo "</tr>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>

        </tbody>
    </table>
</main>

<script src="../script/navbaruser.js"></script>
</body>

</html>