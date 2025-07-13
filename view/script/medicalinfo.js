const edit_mode = document.getElementById("edit_mode");
const save_cancel_btn = document.getElementById("save_cancel_btn");
const cancel_mode = document.getElementById("cancel_mode");
const save_mode = document.getElementById("save_mode");

let isEditing = false;

edit_mode.addEventListener("click", (e) => {
  e.preventDefault();
  if (!isEditing) {
    edit_mode.classList.add("hidden");
    save_cancel_btn.classList.remove("hidden");
    isEditing = true;
  } else {
    edit_mode.classList.remove("hidden");
    save_cancel_btn.classList.add("hidden");
    isEditing = false;
  }
});
