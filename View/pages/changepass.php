<?php
include("../components/body.php");
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include("../../view/modal/alert.php");
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
} else {
    include('../../config/database.php');

    $id = $_SESSION['id'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];
}
?>
<main class="flex items-center justify-center w-lvw h-dvh">
    <form class="z-10 popppins bg-white gap-7.5 p-6.5 flex flex-col justify-center shadow-[5px_5px_10px_rgba(0,0,0,0.1)] rounded-lg items-center" action='../../controller/resetpassword.php' method='POST'>

        <h3 class="text-4xl font-bold opacity-90">CHANGE PASSWORD</h3>


        <div class="relative opacity-80 cursor-not-allowed select-none uppercase w-[70%] ">
            <label
                class="absolute inline px-3 bg-white left-5.5 -top-3">full name</label>
            <p class="poppins  border-1 py-2.5 px-4.5 rounded-lg ">
                <?php echo $_SESSION['firstname']; ?>
                <?php echo $_SESSION['lastname']; ?>
            </p>

        </div>


        <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
        <section class="relative uppercase flex justify-center w-full">

            <label

                class="absolute inline px-3 bg-white left-15.5 -top-3"
                for='currentPass'>Current Password</label>
            <input
                class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[70%]"
                id='currentPass' type='password' name='currentPass' required>
        </section>
        <section class="relative uppercase flex justify-center w-full">

            <label class="absolute inline px-3 bg-white left-15.5 -top-3" for='newPass'>New Password</label>
            <input
                class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[70%]"
                id='newPass' type='password' name='newPass' required>
        </section>

        <section class="relative uppercase flex justify-center w-full">
            <label class="absolute inline px-3 bg-white left-15.5 -top-3" for='confirmPass'>Confirm Password</label>
            <input
                class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[70%]"
                id='confirmPass' type='password' name='confirmPass' required>
        </section>

        <div class="flex items-center gap-5">
            <button class="poppins py-3.5 px-4.5 w-[80%] p-[8px] mt-3 rounded-lg bg-[#06118E] text-amber-50 hover:bg-[#2532CA] shadow-2xl duration-[0.1s] cursor-pointer" type='submit' name='reset-password'>Confirm</button>
            <a class="poppins py-3.5 px-4.5 w-[80%] p-[8px] mt-3 rounded-lg bg-red-500 text-white shadow-2xl duration-[0.1s] cursor-pointer" <?php if ($_SESSION['user_role'] == 'admin') {
                                                                                                                                                    echo "href='clinic-patient.php'";
                                                                                                                                                } else {
                                                                                                                                                    echo "href='userprofile.php'";
                                                                                                                                                } ?>>cancel</a>
        </div>


    </form>

    <img
        class="absolute h-dvh top-0 object-cover w-full"
        src="../public/ri-img.png "
        alt="" />
</main>

</body>

</html>