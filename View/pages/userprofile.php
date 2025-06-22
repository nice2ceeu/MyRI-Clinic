<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
} else {

    include('config/database.php');

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];

    try {
        $query = "SELECT COUNT(*) AS count FROM visitor WHERE firstname = ? AND lastname = ?";
        $params = array($firstname, $lastname);
        $stmt = sqlsrv_prepare($conn, $query, $params);

        if ($stmt && sqlsrv_execute($stmt)) {
            $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($result) {
                $count = htmlspecialchars($result['count']);
            }
        } else {
            echo "<p>Error executing statement.</p>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<?php
include('/components/body.php');
?>


<!-- navvvvvvvvvvv -->
<header
    class="bg-primary flex krona text-3xl justify-between px-7 py-4.5 items-center text-white md:hidden">
    <img
        id="home-btn"
        class="size-12 cursor-pointer"
        src="/assets/icons/school-icon.svg"
        alt="" />

    <h1 id="home-btn" class="cursor-pointer">MyRi Clinic</h1>

    <img
        id="menu-btn"
        class="z-21 size-9 cursor-pointer invert"
        src="/assets/icons/menu-icon.svg"
        alt="menu-btn" />
</header>
<nav
    id="SideBar"
    class="z-20 w-62 md:sm:w-24 lg:w-72 md:h-dvh xl:lg:w-82 translate-x-[50rem]  drop-shadow-2xl md:drop-shadow-none h-dvh md:translate-x-0 fixed duration-500 right-0 top-[-17px] md:top-0 md:left-0 md:block">
    <main
        class="grid text-white h-[70%] grid-rows-[100px_1fr_60px] md:h-dvh ">
        <section
            class="row-start-1 invisible md:visible cursor-pointer shadow-2xl bg-secondary flex items-center justify-center text-2xl krona">
            <img
                class="md:block size-12 lg:hidden"
                src="/assets/icons/school-icon.svg"
                alt="school-img" />
            <h1 class="md:hidden text-3xl lg:block">MyRi Clinic</h1>
        </section>

        <!-- navlinks -->
        <section
            class="poppins  row-start-2 bg-primary flex gap-y-3 flex-col  px-3 py-4 text-lg [&>a>img]:size-6 pt-5 [&>a]:text-[16px] [&>a]:lg:items-center [&>a]:tracking-wide">

            <!-- studnet info -->
            <a
                class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
                href="/pages/userformview.php">
                <img src="/assets/icons/medicalform-icon.svg" alt="medicalform-icon" />
                <p class="md:hidden lg:block">My medical form</p>
            </a>




            <a
                class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
                href="/pages/userhistory.php">
                <img src="/assets/icons/history-icon.svg" alt="visitor-icon" />
                <p class="md:hidden lg:block">My history</p>
            </a>




            <section class="mt-auto ">
                <a
                    class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] items-center rounded-lg md:flex md:justify-center lg:justify-start"
                    href="/pages/changepass.php">
                    <img class="size-7" src="/assets/icons/manage-pass-icon.svg" alt="visitor-icon" />
                    <p class="md:hidden text-[16px] lg:block">Manage account</p>
                </a>


                <hr class="text-[#f5f5f565]  w-full">
                <a

                    class="flex gap-x-4 px-3.5 uppercase py-3.5 leading-6 rounded-lg md:flex md:justify-center lg:justify-start lg:items-center mt-3 "
                    href="/pages/userprofile.php">
                    <img class=" size-6 " src=" /assets/icons/user-icon.svg" alt="visitor-icon" />
                    <div class="md:hidden lg:block flex flex-col">
                        <?php
                        echo "
            <div class='flex flex-row text-[15px] gap-2'>
              <p>{$_SESSION['firstname']}</p>
              <p>{$_SESSION['lastname']}</p>
            </div>
            <p class='text-sm opacity-50'>{$_SESSION['user_role']}</p>
            "; ?>
                    </div>
                </a>

            </section>
        </section>
        <section
            class="rounded-bl-2xl  md:rounded-none row-start-3 bg-secondary poppins   flex text-lg w-full items-center  gap-x-5">

            <!-- logout -->
            <form class="w-full px-3.5  " action="/controller/logout.php" method="POST">
                <button
                    id="logout-btn"
                    type="submit"
                    name="submit"
                    class="flex gap-x-4 px-3.5  poppins  rounded-lg md:flex md:justify-center lg:justify-start lg:items-center w-full cursor-pointer"
                    href="/pages/index.php"><img class="size-6" src="/assets/icons/exit-icon.svg" alt="inforamation-icon" />
                    <p class="md:hidden lg:block">Logout</p>
                </button>
            </form>
        </section>
    </main>
</nav>
<!-- navvvvvvvvvvv -->

<main class="md:sm:ml-24 h-dvh lg:ml-72 md:h-dvh xl:lg:ml-82  overflow-x-hidden bg-gradient-to-b from-[#edf3f2] to-[#626de2] ">
    <img src="/public/ri-img.png" class="h-52 object-cover w-full" alt="">


    <section class="flex flex-col  w-full ">
        <section class="flex flex-col md:flex-row poppins">
            <img src="/assets/icons/user-icon.svg" class="invert mx-10 size-32" alt="user-icon" />
            <div class="md:mt-auto mx-10 md:mx-0  space-y-2">
                <h1 class="text-nowrap text-[min(5vw,2rem)] capitalize font-semibold"><?php echo $firstname . " " . $lastname ?></h1>
                <p class="text-lg">LRN: <?php echo $username ?></p>
            </div>
            <h1 class="px-5 text-[min(2vw,1rem)] font-semibold bg-white rounded-lg mx-5 mt-auto ml-auto before:content-['Number_of_visits:_'] ">
                <?php if ($count != 0) {
                    echo $count;
                } else {
                    echo "0";
                } ?>
            </h1>


        </section>
        <hr class="w-full mt-5">


    </section>




</main>

<script src="/script/navbaruser.js"></script>
</body>

</html>