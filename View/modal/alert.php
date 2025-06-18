<?php

include("../components/body.php");
?>


<div
  id="alertModal"
  class="fixed poppins inset-0 backdrop-blur-[2px] bg-[#b8b8b81f] bg-opacity-50 flex items-center hidden justify-center z-50">
  <div
    class="bg-white flex flex-col gap-y-5 items-center relative p-6 rounded-xl shadow-lg max-w-sm w-full">
    <img
      onclick="closeModal()"
      class="absolute invert opacity-70 cursor-pointer top-2 right-2"
      src="../assets/icons/close-icon.svg"
      alt="close-icon" />
    <h1
      class="text-4xl uppercase font-[500] flex items-center gap-3"
      id="alertHeader">
      <img
        class="size-12 animate-pulse duration-[0.1s]"
        src="../assets/icons/alert-icon.svg"
        alt="alert-icon" />
      Login failed
    </h1>
    <p class="text-center tracking-wide text-md" id="alertDetails"></p>
    <button
      onclick="closeModal()"
      class="mt-4 w-1/4 bg-[#06118e] cursor-pointer font-semibold text-white px-4 py-2 rounded-lg">
      Ok
    </button>
  </div>
</div>
</body>
<script>
  function showModal(message) {
    document.getElementById("alertDetails").innerText = message;
    document.getElementById("alertModal").classList.remove("hidden");
  }

  function closeModal() {
    document.getElementById("alertModal").classList.add("hidden");
  }
</script>

</html>