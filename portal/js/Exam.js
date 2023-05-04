var hms = JSON.parse(localStorage["cbt_detail"]).cbt_duration;
var [hours, minutes, seconds] = hms.split(":");
var seconds = +hours * 60 * 60 + +minutes * 60 + +seconds;

let timeInterval = setInterval(() => {
  document.getElementById("cbt_duration").innerHTML = toHHMMSS(seconds);
  seconds--;

  if (seconds < 1800) {
    $("#cbt_duration").css("color", "yellow");
    $("#cbt_duration").fadeOut(500);
    $("#cbt_duration").fadeIn(500);
  }

  if (seconds < 900) {
    $("#cbt_duration").css("color", "red");
    $("#cbt_duration").fadeOut(500);
    $("#cbt_duration").fadeIn(500);
  }

  if (seconds == -1) {
    clearInterval(timeInterval);
    $("#endExamModalCenter").modal("show");
    setTimeout(function () {
      // SCROLL TO CENTER
      document.getElementById("cbt_view").scrollIntoView({ block: "center" });
      submitCBT(true);
    }, 1000);
  }
}, 1000);

// function preview(e) {
//   let id = e.target.id.substr(1);
//   let question = document.getElementById("l" + id).textContent;
//   let answer = CKEDITOR.instances["q" + id].document.getBody().getHtml();

//   if (answer) {
//     document.getElementById(
//       "questionModalTitle"
//     ).innerHTML = `<p>${question}</p>`;
//     document.getElementById("questionModalContent").innerHTML = answer;

//     $("#questionModalCenter").modal("show");
//   }
// }

// function save(id) {
//   if (!navigator.onLine) {
//     alert("No Internet Connection");
//     return;
//   }
//   let form = document.getElementById("exam");

//   for (let i = 0; i < form.elements.length; i++) {
//     if (form.elements[i].type == "textarea") {
//       let element = form.elements[i];
//       element.innerHTML = CKEDITOR.instances[element.id].document
//         .getBody()
//         .getHtml();
//     }
//   }

//   document.getElementById("saveSpinner").classList.add("spinner-border");
//   document.getElementById("saveSpinner").classList.add("spinner-border-sm");
//   if (id) {
//     document.getElementById("spinner" + id).classList.add("spinner-grow");
//     document.getElementById("spinner" + id).classList.add("spinner-grow-sm");
//   }

//   $.ajax({
//     type: "POST",
//     url: "./api/save_exam.php",
//     data: new FormData(form),
//     contentType: false,
//     cache: false,
//     processData: false,
//     success: function (resp) {
//       if (resp.data == 1) {
//         alert(resp.message);
//       } else {
//         alert("Something Wrong Happened! Please contact Support!");
//       }
//     },
//     fail: function (xhr, textStatus, errorThrown) {
//       alert("Save failed");
//     },
//     error: function (e) {
//       document.getElementById("saveSpinner").classList.remove("spinner-border");
//       document
//         .getElementById("saveSpinner")
//         .classList.remove("spinner-border-sm");
//       if (id) {
//         document
//           .getElementById("spinner" + id)
//           .classList.remove("spinner-grow");
//         document
//           .getElementById("spinner" + id)
//           .classList.remove("spinner-grow-sm");
//       }
//       alert("Save was not successful! Please Retry!");
//     },
//   }).done(function () {
//     document.getElementById("saveSpinner").classList.remove("spinner-border");
//     document
//       .getElementById("saveSpinner")
//       .classList.remove("spinner-border-sm");
//     if (id) {
//       document.getElementById("spinner" + id).classList.remove("spinner-grow");
//       document
//         .getElementById("spinner" + id)
//         .classList.remove("spinner-grow-sm");
//     }
//   });
// }

// function replaceAll(str, find, replace) {
//   return str.replace(new RegExp(find, "g"), replace);
// }
// $(document).ready(function (e) {
//   // Submit form data via Ajax
//   $("#exam").on("submit", function (e) {
//     if (!navigator.onLine) {
//       alert("No Internet Connection");
//       return;
//     }

//     e.preventDefault();
//     submitExam = confirm(
//       "Are you sure you want to submit the examination! If you submit it is assumed that you have ended the Examination"
//     );
//     if (submitExam === false) {
//       return;
//     }
//     let form = document.getElementById("exam");

//     for (let i = 0; i < form.elements.length; i++) {
//       if (form.elements[i].type == "textarea") {
//         let element = form.elements[i];
//         element.innerHTML = CKEDITOR.instances[element.id].document
//           .getBody()
//           .getHtml();
//       }
//     }

//     document.getElementById("submitSpinner").classList.add("spinner-border");
//     document.getElementById("submitSpinner").classList.add("spinner-border-sm");
//     document
//       .getElementById("submitSpinnerExamEnded")
//       .classList.add("spinner-border");
//     document
//       .getElementById("submitSpinnerExamEnded")
//       .classList.add("spinner-border-sm");
//     $.ajax({
//       type: "POST",
//       url: "./api/submit_exam.php",
//       data: new FormData(this),
//       contentType: false,
//       cache: false,
//       processData: false,
//       success: function (resp) {
//         if (resp.data == 1) {
//           alert(resp.message);
//           alert("Please fill the feed back form at the Exam List page.");
//           window.location = "ExamList.php";
//         } else {
//           alert("Something Wrong Happened! Please contact Support!");
//         }
//       },
//       fail: function (xhr, textStatus, errorThrown) {
//         alert("Submission failed");
//       },
//       error: function (e) {
//         alert("Submit not successful! Please Retry!");
//         done();
//       },
//     }).done(function () {
//       done();
//     });
//   });
// });

// function done() {
//   document.getElementById("submit").disabled = false;
//   document.getElementById("submitSpinner").classList.remove("spinner-border");
//   document
//     .getElementById("submitSpinner")
//     .classList.remove("spinner-border-sm");
//   document
//     .getElementById("submitSpinnerExamEnded")
//     .classList.remove("spinner-border");
//   document
//     .getElementById("submitSpinnerExamEnded")
//     .classList.remove("spinner-border-sm");
// }

Number.prototype.toHHMMSS = function () {
  var sec_num = this;
  var hours = Math.floor(sec_num / 3600);
  var minutes = Math.floor((sec_num - hours * 3600) / 60);
  var seconds = sec_num - hours * 3600 - minutes * 60;

  if (hours < 10) {
    hours = "0" + hours;
  }
  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  return hours + ":" + minutes + ":" + seconds;
};

function toHHMMSS(num) {
  var sec_num = num;
  var hours = Math.floor(sec_num / 3600);
  var minutes = Math.floor((sec_num - hours * 3600) / 60);
  var seconds = sec_num - hours * 3600 - minutes * 60;

  if (hours < 10) {
    hours = "0" + hours;
  }
  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  return hours + ":" + minutes + ":" + seconds;
}

// let count = 0;
// let numImages = 0;
// let interval = window.setInterval(function () {
//   //pictureInterval change to 30
//   if (count % 30 == 0) {
//     captureImageAndUpload();
//     numImages++;
//   }

//   /*if (numImages == numPicturesToTake){
//             clearInterval(interval);
//         }*/
//   count++;
// }, 1000);

// function captureImageAndUpload() {
//   let context = canvas.getContext("2d");
//   let video = document.getElementById("videoScreen");
//   if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//     navigator.mediaDevices
//       .getUserMedia({ video: true })
//       .then(function (stream) {
//         // video.src = window.URL.createObjectURL(stream);
//         video.srcObject = stream;
//         video.play();

//         window.setTimeout(function () {
//           context.drawImage(video, 0, 0, 640, 480);
//           stream.getTracks().forEach(function (track) {
//             track.stop();
//           });

//           uploadCapturedImage();
//         }, 500);
//       });
//   }
// }

// // Converts canvas to an image
// function convertCanvasToImageURL() {
//   let canvas = document.getElementById("canvas");
//   var image = new Image();
//   image.src = canvas.toDataURL("image/jpeg");

//   return image.src;
// }

// function uploadCapturedImage() {
//   let imgUrl = convertCanvasToImageURL();
//   uploadImage(imgUrl);
// }

// function uploadImage(imgUrl) {
//   $.ajax({
//     type: "POST",
//     url: "https://bucbt.bowen.edu.ng/upload.php",
//     data: {
//       image: imgUrl,
//       course: course,
//       matric: matric,
//     },
//     success: function () {
//       // console.log("image uploaded");
//     },
//     fail: function () {
//       // console.log("image not uploaded");
//     },
//   });
// }

// function onFileSelected(e) {
//   // if(e.target.files[0].size > 2097152){
//   if (false) {
//     // to accomodate for music file uploads
//     alert(
//       `Image Selected ${(e.target.files[0].size / 1048576).toFixed(
//         2
//       )}MB is larger than 2MB please reduce the size of the Image`
//     );
//     e.target.value = "";
//     return;
//   }
//   let id = e.target.id.slice(1);
//   if (e.target.files[0] == undefined) {
//     document.getElementById("customFileLabel" + id).innerHTML =
//       "Choose Sheet " + id.split("-").slice(-1);
//     document.getElementById("text" + id).value =
//       "Choose Sheet " + id.split("-").slice(-1);
//   } else {
//     let fileList = "";
//     fileList += e.target.files[0].name;
//     document.getElementById("customFileLabel" + id).innerHTML = fileList;
//     document.getElementById("text" + id).setAttribute("value", "[upload]");
//   }
// }

// function tabClicked(e) {
//   let id = e.target.id;

//   if (id == "nav-hwe-tab") {
//     document
//       .getElementById("meet")
//       .setAttribute(
//         "style",
//         "border:0.5px solid black;height:320px; position: relative !important;top: 58px; background-color: black; z-index:2;"
//       );
//   } else {
//     document
//       .getElementById("meet")
//       .setAttribute(
//         "style",
//         "border:0.5px solid black;height:320px; position: relative !important;top: 58px; background-color: black; z-index:2; display:none !important;"
//       );
//   }
// }

// function uploadsheet(fid, id) {
//   var course = $("#course").val();
//   var matric = $("#matric").val();
//   if (!$("#" + fid).val()) {
//     alert("No file Selected");
//   } else {
//     //  alert('There is a file');

//     $("#btn" + id).html(
//       '<span class="spinner-border spinner-border-sm"></span>Loading..'
//     );
//     var fd = new FormData();
//     var files = $("#" + fid)[0].files[0];
//     fd.append("file", files);
//     fd.append("charlie", course);
//     fd.append("mike", matric);
//     fd.append("sierra", id);
//     $.ajax({
//       url: "uploadsheet.php",
//       type: "post",
//       data: fd,
//       contentType: false,
//       processData: false,
//       success: function (response) {
//         if (response != 0) {
//           //$('#pfile'+id).html("<a target='_blank' href='previewdoc.php?id="+id+"'><img src='images/doc.svg' width='50px' alt='Preview' ></a>");

//           $("#btn" + id).html(' <i class="fas fa-check"></i> Uploaded');
//           $("#btn" + id).attr("disabled", true);
//           save();
//         } else {
//           $("#btn" + id).html("Try Again");
//         }
//       },
//     });
//   }
// }

// function previewsheet(id) {
//   if (!$("#" + id).val()) {
//     alert("No file Selected");
//   } else {
//     var reader = new FileReader();

//     reader.onload = function (e) {
//       $("#blah").attr("src", e.target.result);
//     };

//     reader.readAsDataURL($("#" + id)[0].files[0]); // convert to base64 string
//     $("#id" + id).change(function () {
//       readURL(this);
//     });
//     $("#myModal").modal("toggle");
//   }
// }
