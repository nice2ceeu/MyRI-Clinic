let inputs = document.getElementsByTagName("input");
let edit_mode = document.getElementById("edit_mode");
let save_mode = document.getElementById("save_mode");
let cancel_mode = document.getElementById("cancel_mode");

let food_allergies = document.getElementById("new_food_allergic");
let insect_bites = document.getElementById("new_insect_bites");
let new_food_allergies_yes = document.getElementById("new_food_allergies_yes");
let new_food_allergies_no = document.getElementById("new_food_allergies_no");
let new_insect_allergy_yes = document.getElementById("new_insect_allergy_yes");
let new_insect_allergy_no = document.getElementById("new_insect_allergy_no");

edit_mode.onclick = function () {
  for (let i = 0; inputs.length; i++) {
    if (i == 22 || i == 25 || i == 26) {
      continue;
    }
    inputs[i].disabled = false;
    inputs[i].style.color = "black";
  }
};
new_food_allergies_yes.addEventListener("change", function () {
  if (new_food_allergies_yes.checked) {
    food_allergies.removeAttribute("readonly");
    food_allergies.removeAttribute("disabled");
    food_allergies.style.color = "black";
  }
});

new_food_allergies_no.addEventListener("change", function () {
  if (new_food_allergies_no.checked) {
    food_allergies.setAttribute("readonly", true);
    food_allergies.setAttribute("disabled", true);
    food_allergies.style.color = "#808080b0";
  }
});

new_insect_allergy_yes.addEventListener("change", function () {
  if (new_insect_allergy_yes.checked) {
    insect_bites.removeAttribute("readonly");
    insect_bites.removeAttribute("disabled");
    insect_bites.style.color = "black";
  }
});

new_insect_allergy_no.addEventListener("change", function () {
  if (new_insect_allergy_no.checked) {
    insect_bites.setAttribute("readonly", true);
    insect_bites.setAttribute("disabled", true);
    insect_bites.style.color = "#808080b0";
  }
});

cancel_mode.onclick = function () {
  for (let i = 0; inputs.length; i++) {
    inputs[i].disabled = true;
    inputs[i].style.color = "#808080b0";
  }
};
