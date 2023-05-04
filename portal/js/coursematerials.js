$(".error_msg").hide();
function getExtension(filename) {
  var parts = filename.split(".");
  return parts[parts.length - 1];
}

function isPDF(filename) {
  var ext = getExtension(filename);
  switch (ext.toLowerCase()) {
    case "pdf":
      //etc
      return true;
  }
  return false;
}

function checkbeforesubmit(id) {
  // var form = assigform;
  $("#addassignment" + id).attr("disabled", true);
  // $('$assigform'+id).submit(false);
  var file = $("#slideFile" + id);
  var input = document.getElementById("slideFile" + id);
  var upfile = input.files[0];
  var x = 0;
  var y = 0;
  if (isPDF(file.val())) {
    x = 1;
    $("#error_msgslide2" + id).hide();
  } else {
    x = 0;
    $("#error_msgslide2" + id).show();
  }
  if (upfile.size > 52428800) {
    y = 0;
    $("#error_msgslide" + id).show();
  } else {
    y = 1;
    $("#error_msgslide" + id).hide();
  }

  if (x == 1 && y == 1) {
    // $('$assigform'+id).submit(true);
    $("#addassignment" + id).attr("disabled", false);
  }

  return false; // prevent form submitting anyway - remove this in your environmentent form submitting anyway - remove this in your environment
}
function failValidation(msg) {
  alert(msg); // just an alert for now but you can spice this up later
  return false;
}

function takeattendance(id, t) {
  if (t == 1) {
    var type = "note";
  } else if (t == 2) {
    var type = "slide";
  } else if (t == 3) {
    var type = "audio";
  } else if (t == 4) {
    var type = "video";
  } else if (t == 5) {
    var type = "assignment";
  }
  //  alert(id);
  //alert(type)
  //alert(matric_id);
  $.post(
    "api/attendance.php",
    {
      type: type,
      content_id: id,
      matric: matric_id,
    },
    function (data, status) {
      //alert("Data: " + data + "\nStatus: " + status);
    }
  );
}

function load(x) {
  //alert(x);
  $("#addassignment" + x).html(
    '<span class="spinner-border spinner-border-sm"></span>Uploading..'
  );
}
