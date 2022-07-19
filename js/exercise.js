function training_add_submit(id_exercise) {
  $(document).ready(function () {
    var bind = "select_" + id_exercise;
    var temp = document.getElementById(bind);
    var id_training = temp.options[temp.selectedIndex].value;
    $.ajax({
      type: "POST",
      url: "includes/exercise.inc.php",
      data: {
        id_exercise: id_exercise,
        id_training: id_training,
      },
    });
  });
}
