function exercise_delete_submit(id_exercise) {
    $(document).ready(function () {
      var arr = id_exercise.split("_");
      id_exercise = arr[0];
      id_training = arr[1];
      document.getElementById(arr[0]).remove();
      $.ajax({
        type: "POST",
        url: "includes/training_edit.inc.php",
        data: {
          id_exercise: id_exercise,
          id_training: id_training,
        },
      });
    });
  }
  