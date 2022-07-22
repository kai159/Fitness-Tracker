function set_add(id, name) {
    $(document).ready(function () {

      let arr = id.split("_");
      var table = document.getElementById(arr[0]);
      var check_hide = table.rows[table.rows.length-1].cells[4].style.display;
      var row = table.insertRow(table.rows.length);
      row.innerHTML = '<input type="hidden" name="'+ id + '_fkex_' + (table.rows.length - 1)+'"/input>';
  
      var cell = row.insertCell(0);
      cell.innerHTML = 'Satz ' + (table.rows.length - 1);
      cell.classList.add('d-none'); 
      cell.classList.add('d-lg-block');

      cell = row.insertCell(1);
      cell.innerHTML = '<input type="number" name="'+ name +'_rep_'+  (table.rows.length - 1) +'"/input>';

      cell = row.insertCell(2);
      cell.innerHTML = '<input type="number" name="'+ name +'_weight_'+  (table.rows.length - 1) +'" step="0.001"/input>';

      cell = row.insertCell(3);
      cell.innerHTML = '<input type="text" name="'+ name +'_type_'+  (table.rows.length - 1) +'" value="Standard"/input>';
      var type_cell = cell;
      
      cell = row.insertCell(4);
      cell.innerHTML = '<input type="text" name="'+ name +'_comment_'+  (table.rows.length - 1) +'"/input>';
      var comment_cell = cell;
      

      type_cell.classList.add('hide')
      comment_cell.classList.add('hide')
      if(check_hide == "table-cell"){
        type_cell.style.display = "table-cell";
        comment_cell.style.display = "table-cell";
      } 
    });
  }
  

  function set_sub(id) {
    $(document).ready(function () {
      let arr = id.split("_");
      var table = document.getElementById(arr[0]);
      
      if (table.rows.length > 2){
        table.deleteRow(table.rows.length-1);
      }      
    });
  }

  function set_sub_edit(id) {
    $(document).ready(function () {
      let arr = id.split("_");
      var table = document.getElementById(arr[0]);
      
      if ((table.rows.length - 1) > arr[2]){
        table.deleteRow(table.rows.length-1);
      }      
    });
  }

  function extra_hidden() {
    $(document).ready(function () {
      let x = document.getElementsByClassName("hide");
      var str = "table-cell";
      if (x[0].style.display == "table-cell") {
        str = "none";
      }
      for (i = 0; i < x.length; i++) {
        x[i].style.display = str;
      }
    });
  }