// Bei klick auf Beschreibung/Bild ändern wird dieser Code ausgeführt.
function show_form_desc() {
  $(document).ready(function () {
    let x = document.getElementsByClassName("form_desc");
    var str = "block";
    if (x[0].style.display == "block") {
      str = "none";
    }
    for (i = 0; i < x.length; i++) {
      x[i].style.display = str;
    }
  });
}

function show_form_img() {
  $(document).ready(function () {
    let x = document.getElementsByClassName("form_img");
    var str = "block";
    if (x[0].style.display == "block") {
      str = "none";
    }
    for (i = 0; i < x.length; i++) {
      x[i].style.display = str;
    }
  });
}
