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

            include("config/database.php");
            include('/components/body.php');

            if (isset($_POST['filter'])) {

                $studentGrade = $_POST['studentGrade'];
                $studentSection = $_POST['studentSection'];

                if ($studentGrade != '' && $studentSection != '') {
                    // grade and seciton
                    $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND section = ? AND _date = CURDATE()");
                    $stmt->bind_param("ss", $studentGrade, $studentSection);
                } else if ($studentGrade == '' && $studentSection != '') {
                    //section lang
                    $stmt = $conn->prepare("SELECT * FROM visitor WHERE section = ? AND _date = CURDATE()");
                    $stmt->bind_param("s", $studentSection);
                } else if ($studentGrade != '' && $studentSection == '') {
                    // grade lang
                    $stmt = $conn->prepare("SELECT * FROM visitor WHERE grade = ? AND _date = CURDATE()");
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
                            echo "<td>" . $status . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
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
            } else {
                try {
                    $query = "SELECT * FROM visitor where _date = CURDATE() order by checkin desc";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
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
                            echo "<td>" . $status . "</td>";
                            echo "<td>" . htmlspecialchars($row['checkin']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['_date']) . "</td>";
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



        </tbody>
    </table>
</main>