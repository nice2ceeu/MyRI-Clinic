<?php

use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;
use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

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
?>
<?php
include('../components/body.php');
include('../components/navbar.php');
?>

<section class="md:sm:ml-24  lg:ml-72 md:h-dvh xl:lg:ml-82 overflow-x-hidden uppercase">


    <section class="relative mt-5 text-[max(3vw,2rem)] ">
        <h1 class="poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
            Medicine Inventory
        </h1>
        <hr class="absolute z-[-1] text-[#acacac] top-1/2 w-full" />
    </section>

    <section class="flex gap-5 mt-5 items-center flex-wrap poppins uppercase  py-3.5  w-full">
        <form
            action="../../controller/addmeds.php"
            method="POST"
            class="mx-8.5 gap-3.5 uppercase flex  flex-wrap w-full md:basis-[73%] ">
            <section class="relative basis-xm  ">
                <label
                    id="medicine"
                    class="absolute text-nowrap inline top-0 bg-white ml-2 px-1 leading-1"
                    for="medicine">medicine name</label>

                <input
                    id="medicine_name"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="medicine_name"
                    type="text" />

            </section>
            <section class="relative basis-xm ">
                <label
                    id="medicine_qty"
                    class="absolute inline top-0 bg-white ml-2 px-1 leading-1"
                    for="medicine_qty">quantity</label>

                <input
                    id="medicine_qty"
                    required
                    class="border-1 py-2.5 w-full px-4.5 rounded-lg"
                    name="medicine_qty"
                    type="number" />
            </section>


            <section class="relative basis-xm">
                <label
                    id="expiration"

                    class="absolute inline top-0 bg-white ml-2 px-1 leading-1"
                    for="expiration">expiration date</label>
                <input
                    id="expiration"
                    required
                    class="border-1 py-2.5 px-4.5 rounded-lg w-full"
                    name="expiration"
                    type="date" />
            </section>

            <section
                class="poppins text-white bg-primary rounded-lg relative cursor-pointer">
                <button
                    type="submit"
                    name="add"
                    class="uppercase w-full py-2.5 px-9 flex gap-5 items-center justify-evenly cursor-pointer">
                    <p>Add</p>
                    <img class src="../assets/icons/check-icon.svg" alt="" />
                </button>
            </section>


        </form>

        <button
            id="view-comsume"
            class="uppercase bg-primary text-white border-1 rounded-lg py-2.5 px-5  flex gap-5 items-center justify-evenly cursor-pointer">
            <p class="text-nowrap">view comsume</p>
            <img class="size-5.5" src="../assets/icons/view-icon.svg" alt="" />
        </button>
    </section>

    <section class="relative mt-12">
        <hr class="absolute text-[#acacac] z-[-1] w-full bottom-0" />
    </section>

    <!-- sort section -->

    <section class="flex gap-5 flex-wrap poppins uppercase place-self-left py-3.5 mx-8.5">
        <form class=" flex items-center flex-wrap gap-5" action="" method="POST">

            <div class="relative">
                <label
                    id="label"
                    class="absolute text-nowrap inline top-0 ml-2 bg-white px-1 leading-1"
                    for="complaint">
                    Stock Status
                </label>
                <select required name="status" id="status" class="border rounded px-7.5 py-1.5">
                    <option disabled selected>Select to filter</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                    <option value="out_of_stocks">Out of stocks</option>
                </select>
            </div>

            <button
                disabled
                type="submit"
                id="filter-stocks"
                name="filter-stocks"
                class="uppercase bg-primary text-white rounded-lg py-2 px-5 flex gap-5 items-center justify-evenly cursor-pointer">
                <p>Filter</p>
                <img class="size-5.5" src="../assets/icons/filter-icon.svg" alt="" />
            </button>
            <script>
                const status = document.getElementById('status');

                const filterButton = document.getElementById('filter-stocks');

                function checkInputs() {


                    // Enable button only if one or both inputs have value
                    if (status !== '') {
                        filterButton.disabled = false;
                    } else {
                        filterButton.disabled = true;
                    }
                }

                // Listen to input events
                status.addEventListener('input', checkInputs);
            </script>
        </form>

        <form action="" method="POST">
            <button

                type="submit"
                id="show-all"
                name="show-all"
                class="uppercase border-1 rounded-lg py-2 px-5 leading-5 flex gap-5 items-center justify-evenly cursor-pointer">
                <p>Show All</p>
            </button>
        </form>
    </section>




    <div
        class="uppercase mt-22 py-10 px-8.5 w-full max-w-full overflow-x-auto">
        <table class="min-w-full poppins">
            <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-22">
                <tr>
                    <th>Med ID</th>
                    <th>medicine name</th>
                    <th>quantity</th>
                    <th>expiration date</th>
                    <th>status of stock</th>
                    <th>Issued</th>
                    <th>Delete Medicine</th>
                </tr>
            </thead>
            <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
                <?php
                include('../../config/database.php');

                if (isset($_POST['filter-stocks'])) {
                    $status = $_POST['status'];
                    $today = date("Y-m-d");

                    try {
                        if ($status === 'available') {
                            $query = "SELECT * FROM meds WHERE Med_Quantity > 0 AND Expiration_Date > ? ORDER BY Medicine_Name ASC";
                            $params = [$today];
                        } else if ($status === 'unavailable') {
                            $query = "SELECT * FROM meds WHERE Expiration_Date < ? ORDER BY Medicine_Name ASC";
                            $params = [$today];
                        } else {
                            $query = "SELECT * FROM meds WHERE Med_Quantity = 0 ORDER BY Medicine_Name ASC";
                            $params = [];
                        }

                        $stmt = sqlsrv_prepare($conn, $query, $params);

                        if ($stmt && sqlsrv_execute($stmt)) {
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $_id = htmlspecialchars($row['id']);
                                $medName = htmlspecialchars($row['Medicine_Name']);
                                $qty = htmlspecialchars($row['Med_Quantity']);
                                $epx = $row['Expiration_Date'];


                                echo "<tr>";
                                echo "<td>$_id</td>";
                                echo "<td>$medName</td>";
                                echo "<td>$qty</td>";

                                if ($epx <= $today) {
                                    echo "<td><span style='color:red'>EXPIRED</span></td>";
                                } else {
                                    echo "<td>$epx</td>";
                                }

                                $statusText = ($epx <= $today) ? "Unavailable" : ($qty == 0 ? "Out of stocks" : "Available");
                                $statusColor = ($epx <= $today) ? "red" : ($qty == 0 ? "orange" : "green");
                                echo "<td><span style='color:$statusColor;'>$statusText</span></td>";

                                echo "<td>" . $row['issued'] . "</td>";
                                echo "<td>
                        <form action='../../controller/delete.php' method='POST'>
                            <input type='hidden' name='id' value='$_id'>
                            <button class='flex rounded-lg gap-5 px-7 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete'>
                                <span>Delete</span>
                            </button>
                        </form>
                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No records found for the selected status.</td></tr>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    $today = date("Y-m-d");
                    try {
                        $query = "SELECT * FROM meds ORDER BY Medicine_Name ASC";
                        $stmt = sqlsrv_prepare($conn, $query);

                        if ($stmt && sqlsrv_execute($stmt)) {
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $_id = htmlspecialchars($row['id']);
                                $qty = htmlspecialchars($row['Med_Quantity']);
                                $epx = $row['Expiration_Date'];


                                echo "<tr>";
                                echo "<td>$_id</td>";
                                echo "<td>" . htmlspecialchars($row['Medicine_Name']) . "</td>";
                                echo "<td>$qty</td>";

                                if ($epx <= $today) {
                                    echo "<td><span style='color:red'>EXPIRED</span></td>";
                                } else {
                                    echo "<td>$epx</td>";
                                }

                                $statusColor = ($epx <= $today) ? "red" : ($qty == 0 ? "orange" : "green");
                                $statusText = ($epx <= $today) ? "Unavailable" : ($qty == 0 ? "Out of stocks" : "Available");
                                echo "<td><span style='color:$statusColor;'>$statusText</span></td>";

                                echo "<td>" . $row['issued'] . "</td>";
                                echo "<td>
                        <form action='../../controller/delete.php' method='POST'>
                            <input type='hidden' name='id' value='$_id'>
                            <button class='flex rounded-lg gap-5 px-7 py-2.5 bg-red-500 cursor-pointer text-white' type='submit' name='delete'>
                                <span>Delete</span>
                            </button>
                        </form>
                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center bg-[#d4d4d40c]'>No Medicine Found.</td></tr>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>


            </tbody>
        </table>

    </div>


    <!-- pop of view consume -->



    <div id="blur" class="fixed  h-full backdrop-blur-xs top-[-20px] bg-white/30 z-0 w-full"></div>

    <div id="consumed-medicine" class="absolute top-1/4 md:w-[60%] w-[90%] right-5 md:right-1/8 overflow-y-auto overflow-x-hidden shadow-xl z-10 p-5  bg-white">
        <img id="close" class="invert absolute top-2  right-2 cursor-pointer" src="../assets/icons/close-icon.svg" alt="">
        <section class=" relative mt-5 text-[min(4vw,2rem)] ">
            <h1 class=" poppins uppercase font-[500] bg-white ml-12 px-5 inline z-20 ">
                Consumed medicine
            </h1>
            <hr class=" absolute z-[-1] text-[#acacac] top-1/2 w-full" />
        </section>
        <table class="w-full poppins uppercase mt-10">
            <thead class="[&>tr>th]:px-4 text-left [&>tr>th]:pb-12">
                <tr>
                    <th>Med ID</th>
                    <th>medicine name</th>
                    <th>quantity</th>
                    <th>Last Date of Use</th>
                </tr>
            </thead>
            <tbody class="text-left [&>tr]:odd:bg-[#a8a8a829] [&>tr>td]:px-4 [&>tr>td]:py-4.5">
                <?php
                include('../../config/database.php');

                $today = date("Y-m-d");
                try {
                    $query = "SELECT * FROM used_meds ORDER BY Medicine_Name ASC";
                    $stmt = sqlsrv_prepare($conn, $query);

                    if ($stmt && sqlsrv_execute($stmt)) {
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $_id = htmlspecialchars($row['id']);
                            $medName = htmlspecialchars($row['Medicine_Name']);
                            $qty = htmlspecialchars($row['Med_Quantity']);
                            $dateConsumed = isset($row['Date_Consumed']) && $row['Date_Consumed'] instanceof DateTime
                                ? $row['Date_Consumed']->format('Y-m-d')
                                : htmlspecialchars($row['Date_Consumed']);

                            echo "<tr>";
                            echo "<td>$_id</td>";
                            echo "<td>$medName</td>";
                            echo "<td>$qty</td>";
                            echo "<td>$dateConsumed</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center bg-[#ffc5c541]'>No Medicine Found.</td></tr>";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>


            </tbody>
        </table>
    </div>

</section>
</section>
</body>
<script>
    const view = document.getElementById("view-comsume")
    const container = document.getElementById("consumed-medicine")
    const blur = document.getElementById("blur")
    const close = document.getElementById("close")
    let click = false
    container.classList.add("hidden")
    blur.classList.add("hidden")

    view.addEventListener("click", (e) => {
        e.preventDefault()
        if (!click) {
            container.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            container.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })

    close.addEventListener("click", () => {

        if (!click) {
            container.classList.remove("hidden")
            blur.classList.remove("hidden")
            click = true
        } else {
            container.classList.add("hidden")
            blur.classList.add("hidden")
            click = false
        }
    })
</script>

</html>