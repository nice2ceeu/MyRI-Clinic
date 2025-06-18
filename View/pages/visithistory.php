<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>
<?php
include('../components/body.php');
include('../components/navbar.php');
?>


<section class="md:sm:ml-24 lg:ml-72 md:h-dvh xl:lg:ml-82">
  <section class="relative py-7.5 pt-12">
    <h1 class="poppins uppercase bg-white lg:ml-12 px-5 inline z-20 text-3xl">
      visit history
    </h1>
    <hr class="absolute z-[-1] w-full top-17" />
  </section>



  <?php
  include('../components/visitorlist.php');
  ?>
</section>
</body>

</html>