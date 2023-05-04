function loadExam() {
  var d = new Date();
  console.log("work");
  window.parent.document.getElementById("iframe").src = "";
  var iframe = (window.parent.document.getElementById("iframe").src =
    "../exam.html?ver=" + d.getTime());

  //   iframe.src = "../exam.html";
}
