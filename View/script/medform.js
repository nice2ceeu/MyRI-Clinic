document.addEventListener("click", (e) => {
  const id = e.target.id;
  if (!id) return;

  // Check if clicked id ends with '-yes'
  if (id.endsWith("-yes")) {
    // Get the matching '-no' id by replacing '-yes' with '-no'
    const noId = id.replace("-yes", "-no");
    const noRadio = document.getElementById(noId);
    if (noRadio) noRadio.checked = false;
  }

  // // Check if clicked id ends with '-no'
  // if (id.endsWith("-no")) {
  //   // Get the matching '-yes' id by replacing '-no' with '-yes'
  //   const yesId = id.replace("-no", "-yes");
  //   const yesRadio = document.getElementById(yesId);
  //   if (yesRadio) yesRadio.checked = false;
  // }

  if (e.target.id === "other-no") {
    const specify = document.getElementById("specify");
    const opacity = document.getElementById("specifyOpacity");
    if (specify) {
      specify.value = "";
      // specify.disabled = true;
      opacity.classList.add("opacity-40");
    }
  }

  if (e.target.id === "other-yes") {
    const specify = document.getElementById("specify");
    const opacity = document.getElementById("specifyOpacity");
    if (specify) {
      specify.disabled = false;
      opacity.classList.remove("opacity-40");
    }
  }

  document.addEventListener("change", function (e) {
    if (e.target.id === "allergy-no") {
      const allergy = document.getElementById("allergy");
      if (allergy) {
        allergy.value = "";
        console.log(allergy.value);
        allergy.disabled = true;
        allergy.classList.add("opacity-40");
      }
    }

    if (e.target.id === "allergy-yes") {
      const allergy = document.getElementById("allergy");
      if (allergy) {
        allergy.disabled = false;
        allergy.classList.remove("opacity-40");
      }
    }
  });

  if (e.target.id === "hospitalized-yes") {
    const _year = document.getElementById("_year");
    const reason = document.getElementById("reason");
    const hospitalize = document.getElementById("hospitalize");

    if (_year) {
      _year.disabled = false;
      reason.disabled = false;
      hospitalize.classList.remove("opacity-30");
    }
  }
  if (e.target.id === "hospitalized-no") {
    const _year = document.getElementById("_year");
    const reason = document.getElementById("reason");
    const hospitalize = document.getElementById("hospitalize");
    if (_year) {
      _year.value = "";
      reason.value = "";
      _year.disabled = true;
      reason.disabled = true;
      hospitalize.classList.add("opacity-30");
    }
  }
});

const gender = document.getElementById("gender");
const femaleDiv = document.getElementById("femaleDiv");
const weight = document.getElementById("weight");
const height = document.getElementById("height");
const firstMens = document.getElementById("firstMens");

gender.addEventListener("blur", (e) => {
  let Currentvalue = e.target.value;
  let genderlowered = Currentvalue.toLowerCase();

  if (genderlowered === "female") {

    
    
    femaleDiv.classList.remove("opacity-40");
    weight.disabled = false;
    height.disabled = false;
    firstMens.disabled = false;
  } else {
    weight.value = "";
    height.value = "";
    firstMens.value = "";

    femaleDiv.classList.add("opacity-40");
    weight.disabled = true;
    height.disabled = true;
    firstMens.disabled = true;


  }
});
