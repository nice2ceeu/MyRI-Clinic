<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
  body {

    overflow-x: hidden;

  }

  ::-webkit-scrollbar {
    width: 8px;
  }

  ::-webkit-scrollbar-thumb {
    background-color: #030841;
  }

  ::-webkit-scrollbar-track {
    background: white;
  }

  #SideBar {
    position: absolute;
    overflow-x: hidden;
  }

  @media (min-width: 768px) {
    #SideBar {
      position: fixed;
    }
  }
</style>

<header
  class="bg-primary flex poppins text-3xl justify-between px-7 py-4.5 items-center text-white md:hidden">
  <img
    id="home-btn"
    class="size-12 cursor-pointer"
    src="../assets/icons/school-icon.svg"
    alt="" />

  <h1 id="home-btn" class="cursor-pointer">MyRI Clinic</h1>
  <img
    id="menu-btn"
    class="z-60 size-9 cursor-pointer invert"
    src="../assets/icons/menu-icon.svg"
    alt="menu-btn" />
</header>

<nav
  id="SideBar"
  class="z-50 w-62 md:sm:w-24 lg:w-72 md:h-dvh xl:lg:w-82 translate-x-[50rem]  drop-shadow-2xl md:drop-shadow-none h-full md:translate-x-0 duration-500 right-0 top-1 md:top-0 md:left-0 md:block">
  <main
    class="grid text-white h-full grid-rows-[80px_1fr_80px]">
    <section
      class="row-start-1 invisible md:visible cursor-pointer shadow-2xl bg-secondary flex items-center justify-center text-2xl krona">
      <img
        class="md:block size-12 lg:hidden"
        src="../assets/icons/school-icon.svg"
        alt="school-img" />
      <h1 class="md:hidden text-4xl font-semibold  lg:block">MyRI Clinic</h1>
    </section>

    <!-- navlinks -->
    <section
      class="poppins overflow-auto scr row-start-2 bg-primary flex gap-y-3 flex-col  px-3 py-4 text-lg [&>a>img]:size-6 pt-5 [&>a]:text-[16px] [&>a]:lg:items-center [&>a]:tracking-wide">
      <!-- visitor link -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start "
        href="../pages/Clinic-Patient.php"><img src="../assets/icons/visit-icon.svg" alt="visitor-icon" />
        <p class="md:hidden lg:block">Clinic patient</p>
      </a>

      <!-- current patientn in clinic link -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/Current-Patients.php"><img src="../assets/icons/current-icon.svg" alt="visitor-icon" />
        <p class="md:hidden lg:block">Current patients</p>
      </a>

      <!-- visit history -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/Patient-History.php"><img src="../assets/icons/history-icon.svg" alt="history-icon" />
        <p class="md:hidden lg:block">Visitor history</p>
      </a>


      <!-- enrolled info -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/enrolledstudentlist.php"><img src="../assets/icons/enroll-icon.svg" alt="inforamation-icon" />
        <p class="md:hidden lg:block">Enrolled students</p>
      </a>

      <!-- medical forn  -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/medicalform.php"><img src="../assets/icons/medicalform-icon.svg" alt="inforamation-icon" />
        <p class="md:hidden lg:block">Medical form</p>
      </a>

      <!-- student info -->
      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/studentlist.php"><img src="../assets/icons/student-icon.svg" alt="inforamation-icon" />
        <p class="md:hidden lg:block">Student form list</p>
      </a>

      <!-- student info -->


      <a
        class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] rounded-lg md:flex md:justify-center lg:justify-start"
        href="../pages/inventory.php"><img src="../assets/icons/inventory-icon.svg" alt="inforamation-icon" />
        <p class="md:hidden lg:block">Medicine Inventory</p>
      </a>


      <section class="mt-auto uppercase">


        <a
          class="flex gap-x-4 px-3.5 py-3.5 leading-6 hover:bg-[#ffffff1f] items-center rounded-lg md:flex md:justify-center lg:justify-start"
          href="../pages/changepass.php">
          <img class="size-7" src="../assets/icons/manage-pass-icon.svg" alt="visitor-icon" />
          <p class="md:hidden text-[16px] lg:block">Manage account</p>
        </a>
        <hr class="text-[#f5f5f565]  w-full">
        <a
          class="flex gap-x-4 px-3.5 py-3.5 leading-6 rounded-lg md:flex md:justify-center lg:justify-start lg:items-center mt-3 hover:bg-[#ffffff1f]"
          href="">
          <img class="size-6 " src="../assets/icons/user-icon.svg" alt="visitor-icon" />
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
      <form class="w-full px-3.5" action="../../Controller/logout.php" method="POST">
        <button
          id="logout-btn"
          type="submit"
          name="submit"
          class="flex gap-x-4 px-3.5 leading-5 poppins  rounded-lg md:flex md:justify-center lg:justify-start lg:items-center w-full cursor-pointer"
          href="../pages/index.php"><img class="size-6" src="../assets/icons/exit-icon.svg" alt="inforamation-icon" />
          <p class="md:hidden lg:block">Logout</p>
        </button>
      </form>
    </section>
  </main>
</nav>


</body>
<script src="../script/navbar.js"></script>
</head>