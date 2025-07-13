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

if (isset($_SESSION['username'])) {
  if ($_SESSION['user_role'] != "admin") {
    header("Location: userpage.php");
  } else if ($_SESSION['user_role'] != "student") {
    header("Location: index.php");
    exit();
  }
}
?>
<?php
include('../components/body.php');
?>

<body class="flex items-center justify-center w-lvw h-dvh">
  <form
    action="../../Controller/studentreg.php"
    method="POST"
    class="z-10 gap-5 p-6.5 flex flex-col flex-wrap justify-center shadow-[5px_5px_10px_rgba(0,0,0,0.1)] md:w-88 rounded-lg [&>input]:uppercase items-center">
    <section>
      <h1 class="text-center text-[40px] mb-[8px] poppins">MyRi Clinic</h1>
      <h2 class="text-center mb-[30px] text-[20px] poppins">
        Rosario Institute Clinic
      </h2>
    </section>

    <section
      class="flex flex-col w-full gap-5 md:flex-row [&>input]:uppercase">
      <input
        class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[100%]"
        type="text"
        name="firstname"
        placeholder="first Name"
        required />

      <input
        class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[100%]"
        type="text"
        name="lastname"
        placeholder="last name"
        required />
    </section>
    <input
      class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 appearance-none rounded-lg w-[100%]"
      type="number"
      name="username"
      placeholder="Student LRN"
      required />
    <input
      class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 appearance-none rounded-lg w-[100%]"
      type="password"
      name="password"
      placeholder="PASSWORD"
      required />

    <input
      class="placeholder:poppins placeholder:textlg border-1 py-2.5 px-4.5 rounded-lg w-[100%]"
      type="password"
      name="confirm_password"
      placeholder="CONFIRM PASSWORD"
      required />
    <button

      name="register"
      class="poppins py-3.5 px-4.5 w-[80%] p-[8px] mt-3 rounded-lg bg-[#06118E] text-amber-50 hover:bg-[#2532CA] uppercase shadow-2xl duration-[0.1s] cursor-pointer">
      Sign up
    </button>
    <section class="relative w-full text-center">
      <hr class="absolute top-3 w-30 md:w-32" />
      <p class="inline px-2 z-20">OR</p>
      <hr class="absolute right-0 top-3 w-30 md:w-32" />
    </section>
    <p>
      Already Have An Account?
      <a href="./index.php" class="text-blue-500">Sign in</a>
    </p>
  </form>
  <img
    class="absolute h-dvh object-cover w-full"
    src="../public/ri-img.png "
    alt="" />
</body>

</html>