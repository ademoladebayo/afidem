var ip = localStorage["ip"];
var domain = localStorage["domain"];

window.addEventListener("online", () => {
  toastr.remove();
  successtoast("<b>You are online</b>");
});

window.addEventListener("offline", () => {
  toastr.remove();
  errortoast("<b>You are offline</b>");
});

// VAR
var profit_list = {};

var newObj = {};

collapseSidebar();

function loadSideNav(page) {
  document.getElementById("side_nav").innerHTML = `
    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
    <li class="nav-item">
      <a   id="customers" href="customers.html" class="nav-link"><i class="fas fa-users"></i><span>Customers</span></a>
    </li>
    <li class="nav-item">
      <a  id="index" href="dashboard.html?#dashboard" class="nav-link"><i class="fas fa-credit-card"></i><span>POS</span></a>
      <!-- <ul>
        <li class="nav-item">
          <a id="transaction-history" href="dashboard.html?#paginate0" class="nav-link"><i class="fas fa-hand-holding-usd"></i><span>Transaction History</span></a>
        </li>
      </ul> -->
    </li>

    <li class="nav-item">
      <a   id="ajo" href="ajo.html" class="nav-link"><i class="fas fa-piggy-bank"></i><span>Ajo</span></a>
    </li>

    <li class="nav-item">
      <a   id="loan" href="loan.html" class="nav-link"><i class="fas fa-handshake"></i><span>Loan</span></a>
    </li>

    <li class="nav-item">
      <a   id="service-room" href="service-room.html" class="nav-link"><i class="fas fa-bed"></i><span>Service Room</span></a>
    </li>

    <li class="nav-item">
        <a   id="financial-summary" href="financial-summary.html" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Financial Summary</span></a>
    </li>

    <li class="nav-item">
        <a   id="change-password" href="#?change-password.html" class="nav-link"><i
                class="flaticon-settings"></i><span>Change Password</span></a>
    </li>
    <li class="nav-item">
        <a  onclick="goTo('');" href="#" class="nav-link"><i class="flaticon-turn-off"></i><span>Log
                Out</span></a>
    </li>

   <!-- <li class="nav-item">
       <a  style="cursor: pointer; color:white" id="" onclick="window.parent.location.assign('${domain + "/admin/dashboard.html"
    }')" class="nav-link"><span><b>GOTO ADMIN</b></span></a>
    </li> --!>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <a  href="" class="nav-link"><i class=""></i><span></span></a>
    <!-- <li class="nav-item">
        <a  href="" class="nav-link"><i class=""></i><span></span></a>
    </li>
    <li class="nav-item">
        <a  href="" class="nav-link"><i class=""></i><span></span></a>
    </li> -->


</ul>
    
    
    
    `;

  document.getElementById(page).className += " menu-active";
}

function signIn() {
  var id = document.getElementById("id").value;
  var password = document.getElementById("password").value;
  if (id != "" && password != "") {
    // PUSH TO API
    document.getElementById("signin").innerHTML = `<i
        class="fa fa-spinner fa-spin"></i> Processing ...`;
    fetch(ip + "/api/signin", {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-type": "application/json",
      },
      body: JSON.stringify({
        id: id,
        password: password,
      }),
    })
      .then(function (res) {
        console.log(res.status);
        if (res.status == 401) {
          openAuthenticationModal();
        }
        return res.json();
      })

      .then((data) => {
        toastr.remove();
        if (data.success) {
          localStorage.setItem("user_data", JSON.stringify(data));
          localStorage.setItem("token", data.token);
          username = JSON.parse(localStorage["user_data"]).data.username;
          id = JSON.parse(localStorage["user_data"]).data.id;
          localStorage.setItem("user_id", id);
          localStorage.setItem("username", username);
          initFirebaseMessagingRegistration();
          // setTimeout(function () {
          //   window.location.href = "account/dashboard.html";
          // }, 1000);
        } else {
          errortoast("<b>" + data.message + "</b>");
        }
      })
      .catch((err) => {
        document.getElementById("signin").innerHTML = `Sign in`;
        errortoast("Error occurred please try again");
      });
  } else {
    warningtoast("<b>Please check that no field is empty.</b>");
  }
}

function reAuth() {
  var id = localStorage["username"];
  var password = document.getElementById("password").value;
  if (id != "" && password != "") {
    // PUSH TO API
    document.getElementById("signin").innerHTML = `<i
    class="fa fa-spinner fa-spin"></i> Processing ...`;
    fetch(ip + "/api/signin", {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-type": "application/json",
      },
      body: JSON.stringify({
        id: id,
        password: password,
      }),
    })
      .then(function (res) {
        console.log(res.status);
        if (res.status == 401) {
          openAuthenticationModal();
        }
        return res.json();
      })

      .then((data) => {
        toastr.remove();
        if (data.success) {
          successtoast("<b>Welcome back, </b>" + localStorage["username"]);
          localStorage.setItem("user_data", JSON.stringify(data));
          localStorage.setItem("token", data.token);
          username = JSON.parse(localStorage["user_data"]).data.username;
          id = JSON.parse(localStorage["user_data"]).data.id;
          localStorage.setItem("username", username);
          localStorage.setItem("user_id", id);
          setTimeout(function () {
            parent.$("#authenticationModal").modal("hide");
            parent.document.getElementById("authenticationModal").remove();
          }, 1000);
        } else {
          errortoast(data.message);
        }
        document.getElementById("signin").innerHTML = `Sign In`;
      })
      .catch((err) => console.log(err));
  } else {
    warningtoast("<b>Please check that no field is empty.</b>");
  }
}

function changeLogo() {
  document.getElementById("logo").innerHTML =
    document.getElementById("logo").innerHTML != "" ?
      "" :
      `<h1 style="font-weight: bold; font-family: Rowdies; color:white;"> AFIDEM </h1>`;
}

function reloadEditFrame() {
  var iframe = document.getElementById("edit_frame");
  temp = iframe.src;
  iframe.src = "";
  iframe.src = temp;
}

function formatNumber(number) {
  console.log("NUMBER: " + number);
  return number.toLocaleString(
    undefined, // leave undefined to use the visitor's browser
    // locale or a string like 'en-US' to override it.
    { minimumFractionDigits: 0 }
  );
}

function loadDashBoardInformation() {
  document.getElementById("user_name").innerHTML = `<b>${JSON.parse(localStorage["user_data"]).data.username
    }</b>`;
  document.getElementById("user_name1").innerHTML = `<b>${JSON.parse(localStorage["user_data"]).data.username
    }</b>`;
}

function loadStations() {
  document.getElementById("station").innerHTML = "";
  station = JSON.parse(localStorage["user_data"]).station;
  station.forEach((st) => {
    document.getElementById(
      "station"
    ).innerHTML += `<option value="${st.id}">${st.username} (${st.terminal_id})</option>`;
  });
}

function getStationByURL() {
  var parentUrl = window.parent.location.href;
  if (parentUrl.includes("/ajo.html")) {
    return 7;
  } else if (parentUrl.includes("/loan.html")) {
    return 8;
  } else if (parentUrl.includes("/room-service.html")) {
    return 9;
  } else {
    return window.parent.document.getElementById("station").value;
  }

}

function goTo(page) {
  if (page == "") {
    localStorage.clear();
    window.parent.location.assign(domain);
    return 0;
  }
  window.parent.location.assign(domain + "/" + page);
}

// EXPENSE MANAGEMENT
function createExpense() {
  var description = document.getElementById("description").value;
  var amount = document.getElementById("amount").value;
  var date = changeDateFormat(document.getElementById("date").value);

  admin_station = getStationByURL();

  if (description != "" && amount != "" && date != "") {
    openSpinnerModal("Add expense");

    // PUSH TO API
    // warningtoast("<b>Processing ... Please wait</b>");
    fetch(ip + "/api/transaction/create-expense", {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-type": "application/json",
        Authorization: "Bearer " + localStorage["token"],
      },
      body: JSON.stringify({
        description: description,
        amount: amount,
        date_incurred: date,
        admin_station: admin_station,
      }),
    })
      .then(function (res) {
        console.log(res.status);
        if (res.status == 401) {
          removeSpinnerModal();
          openAuthenticationModal();
        }
        return res.json();
      })

      .then((data) => {
        toastr.remove();
        // removeSpinnerModal();
        if (data.success) {
          successtoast("<b>" + data.message + "</b>");
          setTimeout(function () {
            closeModal("modalYT");
            // window.parent.location.reload();
            window.parent.processReport();
          }, 1000);
        } else {
          errortoast("<b>" + data.message + "</b>");
        }
      })
      .catch((err) => console.log(err));
  } else {
    warningtoast("<b>Please check that compulsory field is not empty.</b>");
  }
}

function getAllExpense() {
  start_date = document.getElementById("start_date").value;
  end_date = document.getElementById("end_date").value;
  date = "";
  admin_station = getStationByURL();
  if (start_date == "") {
    // START AND END DATE DEFAULF AS TODAY
    date =
      changeDateFormat(getDate().split("~")[1]) +
      "~" +
      changeDateFormat(getDate().split("~")[1]);
  } else {
    date = changeDateFormat(start_date) + "~" + changeDateFormat(end_date);
  }

  openSpinnerModal("Fetch expense");

  fetch(ip + "/api/transaction/all-expense", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      date: date,
      admin_station: admin_station,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();
      c = 1;

      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate1")) {
        $("#paginate1").DataTable().destroy();
      }

      if (data.length > 0) {
        document.getElementById("expense_table").innerHTML = ``;
        for (i in data) {
          document.getElementById("expense_table").innerHTML += `
              <tr class='${c % 2 == 0 ? "even" : "odd"}'>
      
              <td>${c}.</td>
              <td>${data[i].description}</td>
              <td>${formatNumber(parseInt(data[i].amount))}</td>
              <td>${data[i].date}</td>
              <td>
                  <a  onmouseover="reloadEditFrame();localStorage.setItem('editExpense','${data[i].id
            }~${data[i].description}~${data[i].date}~${data[i].amount
            }')" href="#" class="btn btn-warning" data-bs-toggle="modal"
                      data-bs-target="#editModal"><i class="fas fa-edit"></i> Edit</a>
                  <a  onclick="deleteExpense(${data[i].id
            })" href="#" class="btn btn-danger"><i
                          class="fas fa-trash"></i>
                      Delete</a>
              </td>
             </tr>
              `;
          c = c + 1;
        }

        $("#paginate1").DataTable();
      } else {
        document.getElementById("expense_table").innerHTML = `<td colspan="12">
        <center>No expense found</center>
    </td>`;
      }

      // $(".dataTables_length").addClass("bs-select");
    })
    .catch((err) => console.log(err));
}

function editExpenseDetails() {
  document.getElementById("description").value =
    localStorage["editExpense"].split("~")[1];

  document.getElementById("date").value =
    localStorage["editExpense"].split("~")[2];

  document.getElementById("amount").value =
    localStorage["editExpense"].split("~")[3];
}

function updateExpense() {
  var description = document.getElementById("description").value;
  var amount = document.getElementById("amount").value;
  var date = changeDateFormat(document.getElementById("date").value);

  if (description != "" && amount != "" && date != "") {
    // PUSH TO API
    // warningtoast("<b>Processing ... Please wait</b>");

    openSpinnerModal("Update Expense");

    fetch(ip + "/api/transaction/edit-expense", {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-type": "application/json",
        Authorization: "Bearer " + localStorage["token"],
      },
      body: JSON.stringify({
        expense_id: localStorage["editExpense"].split("~")[0],
        description: description,
        amount: amount,
        date_incurred: date,
        last_modified: getDate().split("~")[1],
        session: localStorage["current_session"],
        term: localStorage["current_term"],
      }),
    })
      .then(function (res) {
        console.log(res.status);
        if (res.status == 401) {
          removeSpinnerModal();
          openAuthenticationModal();
        }
        return res.json();
      })

      .then((data) => {
        //toastr.remove();
        removeSpinnerModal();
        if (data.success) {
          successtoast("<b>" + data.message + "</b>");
          setTimeout(function () {
            closeModal("editModal");
            // window.parent.location.reload();
            window.parent.getAllExpense();
          }, 1000);
        } else {
          errortoast("<b>" + data.message + "</b>");
        }
      })
      .catch((err) => console.log(err));
  } else {
    warningtoast("<b>Please check that compulsory field is not empty.</b>");
  }
}

function deleteExpense(id) {
  if (!confirm("Are you sure you want to delete ?")) {
    return 0;
  }

  openSpinnerModal("Delete Expense");

  fetch(ip + "/api/transaction/delete-expense/" + id, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();
      toastr.remove();
      if (data.success) {
        successtoast("<b>" + data.message + "</b>");
        getAllTransaction();
        getAllExpense();
      } else {
        errortoast("<b>" + data.message + "</b>");
      }
    })
    .catch((err) => console.log(err));
}

function uploadTransactionReport() {
  upload = document.getElementById("file-upload");
  report = upload.files;
  if (report.length < 1) {
    return alert("Please upload a report !");
  }

  const formData = new FormData();
  formData.append("report_type", "UPLOAD");
  formData.append("file", report[0]);
  formData.append("admin_station", document.getElementById("station").value);
  // Select your input type file and store it in a variable

  // This will upload the file after having read it

  openSpinnerModal("Report Upload");

  return fetch(ip + "/api/transaction/report", {
    method: "POST",
    headers: {
      Accept: "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: formData,
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();
      toastr.remove();
      if (data.success) {
        successtoast("<b>" + data.message + "</b>");
        setTimeout(function () {
          // parent.getAllStudentForTable();
          // parent.$("#modalYT").modal("hide");
          window.parent.getAllTransaction();
        }, 1000);
      } else {
        errortoast("<b>" + data.message + "</b>");
      }
    })
    .catch((err) => console.log(err));
}

function getAllTransaction() {
  start_date = document.getElementById("start_date").value;
  end_date = document.getElementById("end_date").value;
  date = "";
  if (start_date == "") {
    // START AND END DATE DEFAULF AS TODAY
    date =
      changeDateFormat(getDate().split("~")[1]) +
      "~" +
      changeDateFormat(getDate().split("~")[1]);
  } else {
    date = changeDateFormat(start_date) + "~" + changeDateFormat(end_date);
  }

  openSpinnerModal("Fetch Transaction");

  fetch(ip + "/api/transaction", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      admin_station: document.getElementById("station").value,
      date: date,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      console.log("RESPONSE CAME HERE " + res);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();

      // CLEAR LIST
      profit_list = {};

      localStorage.setItem("ALLOWED_REPORT_TYPE", data.ALLOWED_REPORT_TYPE);
      checkAllowedReportType();

      // POPULATE CHART
      document.getElementById("d_profit").innerHTML = formatNumber(
        parseInt(data.daily_stat.withdrawal) +
        parseInt(data.daily_stat.card_transfer) +
        parseInt(data.daily_stat.transfer) +
        parseInt(data.daily_stat.airtime) +
        parseInt(data.daily_stat.purchase) +
        parseInt(data.daily_stat.pos_transfer) +
        parseInt(data.daily_stat.bill_payment)
      );
      document.getElementById("d_withdrawal").innerHTML = formatNumber(
        parseInt(data.daily_stat.withdrawal)
      );
      document.getElementById("d_card_transfer").innerHTML = formatNumber(
        parseInt(data.daily_stat.card_transfer)
      );

      document.getElementById("d_transfer").innerHTML = formatNumber(
        parseInt(data.daily_stat.transfer)
      );

      document.getElementById("d_airtime").innerHTML = formatNumber(
        parseInt(data.daily_stat.airtime)
      );

      document.getElementById("d_purchase").innerHTML = formatNumber(
        parseInt(data.daily_stat.purchase)
      );

      document.getElementById("d_pos_transfer").innerHTML = formatNumber(
        parseInt(data.daily_stat.purchase)
      );

      document.getElementById("d_bill_payment").innerHTML = formatNumber(
        parseInt(data.daily_stat.bill_payment)
      );

      document.getElementById("d_trans_count").innerHTML = formatNumber(
        parseInt(data.daily_stat.trans_count)
      );

      document.getElementById("m_profit").innerHTML = formatNumber(
        parseInt(data.montly_stat.withdrawal) +
        parseInt(data.montly_stat.card_transfer) +
        parseInt(data.montly_stat.transfer) +
        parseInt(data.montly_stat.airtime) +
        parseInt(data.montly_stat.purchase) +
        parseInt(data.montly_stat.pos_transfer) +
        parseInt(data.montly_stat.bill_payment)
      );
      document.getElementById("m_withdrawal").innerHTML = formatNumber(
        parseInt(data.montly_stat.withdrawal)
      );
      document.getElementById("m_card_transfer").innerHTML = formatNumber(
        parseInt(data.montly_stat.card_transfer)
      );

      document.getElementById("m_transfer").innerHTML = formatNumber(
        parseInt(data.montly_stat.transfer)
      );

      document.getElementById("m_airtime").innerHTML = formatNumber(
        parseInt(data.montly_stat.airtime)
      );

      document.getElementById("m_purchase").innerHTML = formatNumber(
        parseInt(data.montly_stat.purchase)
      );

      document.getElementById("m_trans_count").innerHTML = formatNumber(
        parseInt(data.montly_stat.trans_count)
      );

      document.getElementById("m_pos_transfer").innerHTML = formatNumber(
        parseInt(data.montly_stat.pos_transfer)
      );

      document.getElementById("m_bill_payment").innerHTML = formatNumber(
        parseInt(data.montly_stat.bill_payment)
      );

      document.getElementById("m_expense").innerHTML = formatNumber(
        parseInt(data.montly_stat.expense)
      );

      c = 1;
      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate0")) {
        $("#paginate0").DataTable().destroy();
      }

      //$("#paginate0").DataTable().clear();
      if (data.transaction_history.length > 0) {
        document.getElementById("transaction_table").innerHTML = ``;
        for (i in data.transaction_history) {
          earnings = data.transaction_history[i].earnings.split(" ");
          document.getElementById("transaction_table").innerHTML += `
              <tr>
      
              <td>${c}.</td>
              <td>${data.transaction_history[i].payer} <b>|</b> ${data.transaction_history[i].payee
            }</td>
              <td>${data.transaction_history[i].payer_fi} <b>|</b> ${data.transaction_history[i].payee_fi
            }</td>
              <td>${data.transaction_history[i].terminal_id}</td>
              <td>${data.transaction_history[i].transaction_time}</td>
              <td>${data.transaction_history[i].transaction_type}</td>
              <td>${formatNumber(
              parseInt(data.transaction_history[i].amount)
            )}</td>
              <td style='color: ${earnings[0] == 'DR' ? `red` : `green`}'><b>${formatNumber(parseInt(earnings[1]))
            }</b></td>
              <td class="allownumeric" style="font-style:bold; font-size: 18px; color: ${data.transaction_history[i].profit == 0 ? "red" : "green"
            }" oninput=" addToProfitList('${data.transaction_history[i].id
            }','profit',parseInt(this.innerHTML))" contenteditable="true">${data.transaction_history[i].profit
            }</td>
          <td id="allowKeyboard"  oninput="addToProfitList('${data.transaction_history[i].id
            }','comment',this.innerHTML)" contenteditable="true">${data.transaction_history[i].comment
            }</td>
          <td>
          <a ${data.transaction_history[i].report_type != "MANUAL" ? `hidden` : ``
            }   onclick="deleteTransaction(${data.transaction_history[i].id
            })" href="#" class="btn btn-danger"><i
                  class="fas fa-trash"></i>
              Delete</a>
              </td>
             </tr>
              `;
          c = c + 1;
        }
        $("#paginate0").DataTable();
      } else {
        document.getElementById(
          "transaction_table"
        ).innerHTML = `<td colspan="12">
        <center>No transaction found</center>
    </td>`;
      }

      // $(".dataTables_length").addClass("bs-select");
    })
    .catch((err) => console.log(err));
}

function processReport() {
  getAllTransaction();
  getAllExpense();
}

function addToProfitList(id, name, value) {
  let profit_obj = {};

  // CHECK IF KEY EXIST
  if (profit_list[id]) {
    profit_list[id][name] = value;
  } else {
    profit_obj[name] = value;
    profit_list[id] = profit_obj;
  }
  console.log(profit_list);
}

function uploadProfit() {
  if (Object.keys(profit_list).length === 0) {
    errortoast("No profit added");
    return 0;
  }

  openSpinnerModal("Upload Profit");

  fetch(ip + "/api/transaction/profit", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify(profit_list),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        successtoast(data.message);
        processReport();
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function createTransaction() {
  if (Object.keys(newObj).length < 9) {
    errortoast("Please check that no field is empty");
    return 0;
  }

  newObj["admin_station"] =
    window.parent.document.getElementById("station").value;
  openSpinnerModal("Create Transaction");

  fetch(ip + "/api/transaction/report", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      report_type: "MANUAL",
      data: newObj,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        successtoast(data.message);
        processReport();
        newObj = {};
        resetFormInputs();
        closeModal("transModal");
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function deleteTransaction(id) {
  if (!confirm("Are you sure you want to delete ?")) {
    return 0;
  }

  openSpinnerModal("Delete Transaction");

  fetch(ip + "/api/transaction/delete-transaction/" + id, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();
      toastr.remove();
      if (data.success) {
        successtoast("<b>" + data.message + "</b>");
        getAllTransaction();
      } else {
        errortoast("<b>" + data.message + "</b>");
      }
    })
    .catch((err) => console.log(err));
}

function getFinancialSummary() {
  custom_date =
    document.getElementById("year").value +
    "-" +
    document.getElementById("month").value;
  date = "";
  if (custom_date == "") {
    date = changeDateFormat(getDate().split("~")[1]);
  } else {
    date = custom_date;
  }

  openSpinnerModal("Fetch Financial Summary");

  fetch(ip + "/api/transaction/financial-summary", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      date: date,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();

      c = 1;
      m_total_income = 0;
      m_total_expense = 0;
      m_total_gross_profit = 0;

      y_total_income = 0;
      y_total_expense = 0;
      y_total_gross_profit = 0;

      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate0")) {
        $("#paginate0").DataTable().destroy();
      }

      if ($.fn.DataTable.isDataTable("#paginate1")) {
        $("#paginate1").DataTable().destroy();
      }

      if (data.length > 0) {
        document.getElementById("month_summary").innerHTML = ``;
        document.getElementById("year_summary").innerHTML = ``;

        for (i in data) {
          document.getElementById("month_summary").innerHTML += `
              <tr>
      
              <td>${c}.</td>
              <td>${data[i].station_name}</td>
              <td>${formatNumber(data[i].monthly.income)}</td>
              <td></td>
              <td>${formatNumber(data[i].monthly.expense)}</td>
              <td></td>
              <td> <a onclick="getBreakdown('${date}','${data[i].station_id
            }', '${data[i].station_name}')" data-bs-toggle="modal"
                  data-bs-target="#viewModal" href="#">${formatNumber(
              data[i].monthly.gross_profit
            )}</a></td>
             </tr>
              `;

          document.getElementById("year_summary").innerHTML += `
              <tr>
      
              <td>${c}.</td>
              <td>${data[i].station_name}</td>
              <td>${formatNumber(data[i].yearly.income)}</td>
              <td></td>
              <td>${formatNumber(data[i].yearly.expense)}</td>
              <td></td>
              <td>${formatNumber(data[i].yearly.gross_profit)}</td>
             </tr>
              `;
          c = c + 1;

          // INCREMENT VALUE
          m_total_income += data[i].monthly.income;
          m_total_expense += data[i].monthly.expense;
          m_total_gross_profit += data[i].monthly.gross_profit;

          y_total_income += data[i].yearly.income;
          y_total_expense += data[i].yearly.expense;
          y_total_gross_profit += data[i].yearly.gross_profit;
        }

        // POPULATE TOTALS
        document.getElementById("month_summary").innerHTML += `
        <tr>
            <td></td>
            <td>TOTAL :</td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          m_total_income
        )}</td>
            <td></td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          m_total_expense
        )}</td>
            <td></td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          m_total_gross_profit
        )}</td>
        </tr>
        `;

        document.getElementById("year_summary").innerHTML += `
        <tr>
            <td></td>
            <td>TOTAL :</td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          y_total_income
        )}</td>
            <td></td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          y_total_expense
        )}</td>
            <td></td>
            <td style=" border-top: 2px solid black; border-bottom: 6px double black;">${formatNumber(
          y_total_gross_profit
        )}</td>
        </tr>
        `;

        // $("#paginate0").DataTable();
        // $("#paginate1").DataTable();
      } else {
        document.getElementById("month_summary").innerHTML = `<td colspan="12">
        <center>No record found</center>
    </td>`;

        document.getElementById("year_summary").innerHTML = `<td colspan="12">
    <center>No record found</center>
</td>`;
      }
    })
    .catch((err) => console.log(err));
}

function getBreakdown(date, station_id, station_name) {
  resetBreakdownTable();
  openSpinnerModal("Transaction Breakdown");
  fetch(ip + "/api/transaction/financial-summary/breakdown", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      date: date,
      station_id: station_id,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {
      removeSpinnerModal();
      total_expense = 0;
      total_trans_count = 0;
      total_profit = 0;

      const dat = new Date(date);
      const year = dat.getFullYear();
      const month = dat.toLocaleDateString("en-US", { month: "long" });

      document.getElementById("pd_label").innerHTML =
        station_name +
        "'s TRANSACTION BREAKDOWN FOR " +
        month.toUpperCase() +
        " " +
        year;

      if (data.transaction.length > 0) {
        c = 1;
        document.getElementById("daily_profit").innerHTML = ``;
        data.transaction.forEach((transaction) => {
          document.getElementById("daily_profit").innerHTML += `<tr>
            <td>${c}.</td>
            <td>${dateToWord(transaction.day)}</td>
            <td>${transaction.description.replace('NGN', '₦')}</td>
            <td>₦${formatNumber(parseInt(transaction.profit))}</td>
        </tr>
        `;

          if (transaction.count != null) {
            total_trans_count += parseInt(transaction.count);
          } else {
            total_trans_count = data.transaction.length;
          }
          total_profit += parseInt(transaction.profit);

          c = c + 1;
        });
      }

      if (data.expense.length > 0) {
        c = 1;
        document.getElementById("expense_table").innerHTML = ``;
        data.expense.forEach((expense) => {
          document.getElementById("expense_table").innerHTML += `<tr>
            <td>${c}.</td>
            <td>${expense.description}</td>
            <td>₦${formatNumber(parseInt(expense.amount))}</td>
            <td>${expense.date}</td>
        </tr>
        `;
          total_expense += parseInt(expense.amount);
          c = c + 1;
        });
      }

      document.getElementById("total_expense").innerHTML =
        "₦" + formatNumber(total_expense);
      document.getElementById("total_income").innerHTML =
        "₦" + formatNumber(total_profit);
      document.getElementById("transaction_count").innerHTML =
        formatNumber(total_trans_count);
      document.getElementById("gross_profit").innerHTML =
        "₦" + formatNumber(total_profit - total_expense);
    })
    .catch((err) => console.log(err));
}

function resetBreakdownTable() {
  document.getElementById("total_expense").innerHTML = "₦" + formatNumber(0);
  document.getElementById("total_income").innerHTML = "₦" + formatNumber(0);
  document.getElementById("transaction_count").innerHTML = formatNumber(0);
  document.getElementById("gross_profit").innerHTML = "₦" + formatNumber(0);
  document.getElementById("daily_profit").innerHTML = `
      <tr>
          <td colspan="12">
              <center>No data yet</center>
          </td>

      </tr>`;

  document.getElementById("expense_table").innerHTML = `
      <tr>
          <td colspan="12">
              <center>No data yet</center>
          </td>

      </tr>`;
}

function addToNewObject(name, value) {
  newObj[name] = value;
  console.log(newObj);
}

/* START USERS SECTION */
function getAllUsers(element, service) {
  fetch(ip + "/api/user/" + service, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      // POPULATE USERS
      data.forEach(user => {
        document.getElementById(element).innerHTML += ` <option value ="${user.id}">${user.first_name + " " + user.last_name}</option> `
      });


      if (service == "AJO") {
        data.forEach(user => {
          document.getElementById('ajo_user_2').innerHTML += ` <option value ="${user.id}">${user.first_name + " " + user.last_name}</option> `
        });
      }

    })
    .catch((err) => console.log(err));
}

function createCustomer() {
  openSpinnerModal("Create Customer");

  var selectedService = Array.from(document.getElementById("service").selectedOptions).map(option => option.value);
  var selectedValuesString = selectedService.join(",");

  fetch(ip + "/api/user", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      first_name: document.getElementById("first_name").value,
      last_name: document.getElementById("last_name").value,
      phone: document.getElementById("phone").value,
      address: document.getElementById("address").value,
      service: selectedValuesString,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        successtoast(data.message);
        getAllCustomer();
        resetFormInputs();
        closeModal("createCustomerModal");
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function updateCustomer() {
  openSpinnerModal("Update Customer");

  var selectedService = Array.from(document.getElementById("u_service").selectedOptions).map(option => option.value);
  var selectedValuesString = selectedService.join(",");

  fetch(ip + "/api/user", {
    method: "PUT",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      user_id: document.getElementById("u_user_id").value,
      first_name: document.getElementById("u_first_name").value,
      last_name: document.getElementById("u_last_name").value,
      phone: document.getElementById("u_phone").value,
      address: document.getElementById("u_address").value,
      status: document.getElementById("u_status").value,
      service: selectedValuesString,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        successtoast(data.message);
        getAllCustomer();
        resetFormInputs();
        closeModal("updateCustomerModal");
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function getAllCustomer() {
  openSpinnerModal("Customers");
  fetch(ip + "/api/user", {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();

      // STAT 
      document.getElementById("total_user").innerHTML = data.stat.all;
      document.getElementById("ajo_user").innerHTML = data.stat.ajo;
      document.getElementById("loan_user").innerHTML = data.stat.loan;
      document.getElementById("service_room_user").innerHTML = data.stat.service_room;

      if ($.fn.DataTable.isDataTable("#paginate0")) {
        $("#paginate0").DataTable().destroy();
      }

      var c = 1;
      if (data.customer.length > 0) {
        document.getElementById("customer_table").innerHTML = ``;
        data.customer.forEach(data => {

          //SERVICE MAP
          services = '';
          data.service.split(",").forEach(service => {
            services += `<span class='badge bg-primary'><b>${service}</b></span> `
          });

          document.getElementById("customer_table").innerHTML += `
              <tr>
              <td>${c}.</td>
              <td>${data.first_name}</td>
              <td>${data.last_name}</td>
              <td>${data.phone}</td>
              <td>${data.address}</td>
              <td>${services}</td>
              <td><span class="badge ${data.status == 'ACTIVE' ? `bg-success` : `bg-danger`} "><b>${data.status}</b></span></td>
              <td>${dateToWord(data.created_at)}</td>
              <td>
                <a  onclick ="editCustomer(${JSON.stringify(data)
              .replace(/'/g, "")
              .replace(
                /"/g,
                "'"
              )})" class="btn btn-warning" data-bs-toggle="modal"
                data-bs-target="#updateCustomerModal"><i class="fas fa-edit"></i></a>
          
      
              </td>
          
          </tr>`;

          c = c + 1;
        });
      } else {
        document.getElementById(
          "customer_table"
        ).innerHTML = `<h4 style="text-align:center;">NO RECORD FOUND</h4>`;
      }
      $("#paginate0").DataTable();
    })
    .catch((err) => console.log(err));
}

function editCustomer(data) {
  //document.getElementById("collateral").hidden = true;

  document.getElementById("u_user_id").value = data.id;
  document.getElementById("u_first_name").value = data.first_name;
  document.getElementById("u_last_name").value = data.last_name;
  document.getElementById("u_phone").value = data.phone;
  document.getElementById("u_address").value = data.address;

  services = data.service.split(",");
  Array.from(document.getElementById("u_status").options).forEach(option => {
    if (option.value == data.status) {
      option.selected = true;
    }
  });

  Array.from(document.getElementById("u_service").options).forEach(option => {
    option.selected = services.includes(option.value);
  });

  $('.select2').trigger('change');
}
/* END USERS SECTION */




/* AJO SECTION */
function createAjoTransaction() {
  ajoUser = document.getElementById('ajo_user_2').value;
  transactionType = document.getElementById('transaction_type').value;
  transactionDate = document.getElementById('txn_date').value;
  amount = document.getElementById('amount').value;

  if (ajoUser != '' && transactionType != '' && transactionDate != '' && amount != '') {
    openSpinnerModal("Create Ajo Transaction");

    fetch(ip + "/api/ajo/transaction", {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-type": "application/json",
        Authorization: "Bearer " + localStorage["token"],
      },
      body: JSON.stringify({
        user_id: ajoUser,
        txn_type: transactionType,
        date: transactionDate,
        amount: amount,
      }),
    })
      .then(function (res) {
        console.log(res.status);
        if (res.status == 401) {
          removeSpinnerModal();
          openAuthenticationModal();
        }
        return res.json();
      })
      .then((data) => {
        removeSpinnerModal();
        if (data.success) {
          closeModal('transModal');
          successtoast(data.message);
          getAjoTransaction();
        } else {
          errortoast(data.message);
        }
      })
      .catch((err) => console.log(err));
  } else {
    warningtoast('Check that no field is empty !')
  }
}


function getAjoTransaction(ajoUser) {
  getAllExpense();
  start_date = changeDateFormat(document.getElementById("start_date").value);
  end_date = changeDateFormat(document.getElementById("end_date").value);
  //ajoUser = document.getElementById('ajo_user_1').value;
  ajoUser = "-";

  openSpinnerModal("Fetch Ajo Transaction");

  fetch(ip + "/api/ajo/transaction/" + start_date + "/" + end_date + "/" + ajoUser, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();
      // POPULATE CHART
      document.getElementById("total_user").innerHTML = formatNumber(parseInt(data.data.total_user)
      );
      document.getElementById("contribution_count").innerHTML = formatNumber(
        parseInt(data.data.contribution_count)
      );
      document.getElementById("total_credit").innerHTML = formatNumber(
        parseInt(data.data.total_credit)
      );

      document.getElementById("total_debit").innerHTML = formatNumber(
        parseInt(data.data.total_debit)
      );

      document.getElementById("profit").innerHTML = formatNumber(
        parseInt(data.data.profit)
      );

      document.getElementById("total_bal").innerHTML = formatNumber(
        parseInt(data.data.balance)
      );

      document.getElementById("total_avail_bal").innerHTML = formatNumber(
        parseInt(data.data.available_balance)
      );

      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate1")) {
        $("#paginate1").DataTable().destroy();
      }


      // TRANSACTION SUMMARY
      c = 1;
      if (data.data.txn_summary.length > 0) {
        document.getElementById("transaction_summary_table").innerHTML = ``;
        for (i in data.data.txn_summary) {
          document.getElementById("transaction_summary_table").innerHTML += `
                        <tr>
                
                        <td>${c}.</td>
                        <td>${data.data.txn_summary[i].user.first_name + " " + data.data.txn_summary[i].user.last_name}</td>
                        <td style='color:red'>₦${formatNumber(parseInt(data.data.txn_summary[i].total_debit))}</td>
                        <td style='color:green'>₦${formatNumber(parseInt(data.data.txn_summary[i].total_credit))}</td>
                        <td style='color:red'>₦${formatNumber(parseInt(data.data.txn_summary[i].total_charge))}</td>
                        <td style='color:black'>₦${formatNumber(parseInt(data.data.txn_summary[i].balance))}</td>
            
                        <td> <a onclick="getAjoTransactionForAPerson('${start_date}','${end_date}','${data.data.txn_summary[i].user.id}')" data-bs-toggle="modal"
                              data-bs-target="#viewModal" href="#" style='color:blue'>${formatNumber(parseInt(data.data.txn_summary[i].available_balance))}</a></td>
                      
                      </tr>
                        `;
          c = c + 1;
        }
        $("#paginate1").DataTable();
      } else {
        document.getElementById(
          "transaction_summary_table"
        ).innerHTML = `<td colspan="12">
              <center>No transaction found</center>
          </td>`;
      }

      // $(".dataTables_length").addClass("bs-select");
    })
    .catch((err) => console.log(err));

}


function getAjoTransactionForAPerson(start_date, end_date, ajoUser) {

  openSpinnerModal("Fetch Transaction Breakdown");

  fetch(ip + "/api/ajo/transaction/" + start_date + "/" + end_date + "/" + ajoUser, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();

      //STAT
      document.getElementById("b_total_credit").innerHTML = formatNumber(
        parseInt(data.data.total_credit)
      );

      document.getElementById("b_total_debit").innerHTML = formatNumber(
        parseInt(data.data.total_debit)
      );

      document.getElementById("b_profit").innerHTML = formatNumber(
        parseInt(data.data.profit)
      );

      document.getElementById("b_contribution_count").innerHTML = formatNumber(
        parseInt(data.data.contribution_count)
      );

      document.getElementById("b_avail_bal").innerHTML = formatNumber(
        parseInt(data.data.available_balance)
      );

      // TRANSACTION BREAKDOWN
      c = 1;
      // Destroy the existing DataTable
      // if ($.fn.DataTable.isDataTable("#paginate0")) {
      //   $("#paginate0").DataTable().destroy();
      // }


      if (data.data.txn_history.length > 0) {
        document.getElementById("transaction_table").innerHTML = ``;
        for (i in data.data.txn_history) {
          document.getElementById("transaction_table").innerHTML += `
                                <tr>
                        
                                <td>${c}.</td>
                                <td>${data.data.txn_history[i].user.first_name + " " + data.data.txn_history[i].user.last_name}</td>
                                <td style='color: ${data.data.txn_history[i].txn_type == 'DEBIT' ? `red` : `white`}'><b>${data.data.txn_history[i].txn_type == 'DEBIT' ? `- ₦${formatNumber(parseInt(data.data.txn_history[i].amount))
              }` : ``} 
                              </b></td>

                                <td style='color: ${data.data.txn_history[i].txn_type == 'CREDIT' ? `green` : `white`}'><b>${data.data.txn_history[i].txn_type == 'CREDIT' ? `+ ₦${formatNumber(parseInt(data.data.txn_history[i].amount))
              }` : ``} 
                                </b></td>

                                <td>₦${formatNumber(parseInt(data.data.txn_history[i].bal_before))}</td>
                                <td>₦${formatNumber(parseInt(data.data.txn_history[i].bal_after))}</td>
                                <td>${dateToWord(data.data.txn_history[i].date)}</td>
                              
                              </tr>
                                `;
          c = c + 1;
        }
        // $("#paginate0").DataTable();
      } else {
        document.getElementById(
          "transaction_table"
        ).innerHTML = `<td colspan="12">
                      <center>No transaction found</center>
                  </td>`;
      }
    })
    .catch((err) => console.log(err));

}

/* END AJO SECTION /




/* START USERS SECTION */




/* LOAN SECTION */

function createLoanTransaction() {
  loanUser = document.getElementById('loan_user_1').value;
  openSpinnerModal("Create Loan Transaction");

  fetch(ip + "/api/loan/transaction", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      user_id: loanUser,
      amount: document.getElementById('amount').value,
      duration: document.getElementById('duration').value,
      loan_type: document.getElementById('loan_type').value,
      rate: document.getElementById('rate').value,
      commission: document.getElementById('loan_commission').value,
      disbursement_date: document.getElementById('disbursement_date').value,
      due_date: document.getElementById('loan_due_date').value,
      collateral: document.getElementById('collateral').value
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        closeModal('transModal');
        successtoast(data.message);
        getLoanTransaction();
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function getLoanTransaction() {
  // getAllExpense();
  start_date = changeDateFormat(document.getElementById("start_date").value);
  end_date = changeDateFormat(document.getElementById("end_date").value);

  openSpinnerModal("Fetch Loan Transaction");

  fetch(ip + "/api/loan/transaction/" + start_date + "/" + end_date, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();
      // POPULATE CHART

      // DEBITOR
      document.getElementById("debitor").innerHTML = formatNumber(parseInt(data.data.debitor.total_user)
      );

      //DEBITOR
      document.getElementById("unpaid").innerHTML = formatNumber(
        parseInt(data.data.debitor.unpaid)
      );

      document.getElementById("interest_expected").innerHTML = formatNumber(
        parseInt(data.data.debitor.interest_unpaid)
      );

      document.getElementById("paid_debt").innerHTML = formatNumber(
        parseInt(data.data.debitor.paid)
      );

      document.getElementById("interest_earned").innerHTML = formatNumber(
        parseInt(data.data.debitor.interest_paid)
      );



      //CREDITORS
      document.getElementById("creditor").innerHTML = formatNumber(parseInt(data.data.creditor.total_user)
      );

      document.getElementById("credit_unpaid").innerHTML = formatNumber(
        parseInt(data.data.creditor.unpaid)
      );

      document.getElementById("credit_interest_unpaid").innerHTML = formatNumber(
        parseInt(data.data.creditor.interest_unpaid)
      );

      document.getElementById("credit_paid").innerHTML = formatNumber(
        parseInt(data.data.creditor.paid));


      document.getElementById("credit_interest_paid").innerHTML = formatNumber(
        parseInt(data.data.debitor.interest_paid)
      );



      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate1")) {
        $("#paginate1").DataTable().destroy();
      }

      if ($.fn.DataTable.isDataTable("#paginate0")) {
        $("#paginate0").DataTable().destroy();
      }


      // DEBITOR
      c = 1;
      if (data.data.debitor.data.length > 0) {
        document.getElementById("loan_debitor_table").innerHTML = ``;
        data.data.debitor.data.forEach(data => {
          document.getElementById("loan_debitor_table").innerHTML +=
            `
          <tr>
    
            <td>${c}.</td>
            <td>${data.user.first_name + " " + data.user.last_name}</td>
            <td style='color:red'>₦${formatNumber(parseInt(data.amount))}</td>
            <td style='color:black'>${formatNumber(parseInt(data.rate))}%</td>
            <td style='color:green'>₦${formatNumber(parseInt(data.commission))}</td>
            <td><span class="badge ${data.status == 'PAID' ? `bg-success` : `bg-danger`} "><b>${data.status}</b></span></td>
            <td style='color:black'>(${formatNumber(parseInt(data.duration))})Month(s)</td>
            <td>${data.collateral}</td>
            <td>${dateToWord(data.disbursement_date)}</td>
            <td>${dateToWord(data.due_date)}</td>
            <td>
              <a  onclick ="editLoanTransaction(${JSON.stringify(data)
              .replace(/'/g, "")
              .replace(
                /"/g,
                "'"
              )})" class="btn btn-warning" data-bs-toggle="modal"
              data-bs-target="#updateLoanModal"><i class="fas fa-edit"></i></a>
        
    
            </td>
          
          </tr>
          `;
          c = c + 1;
        });

      } else {
        // document.getElementById(
        //   "loan_debitor_table"
        // ).innerHTML = `<td colspan="12">
        //       <center>No transaction found</center>
        //   </td>`;
      }

      // CREDITOR
      c = 1;
      if (data.data.creditor.data.length > 0) {
        document.getElementById("loan_creditor_table").innerHTML = ``;
        data.data.creditor.data.forEach(data => {
          document.getElementById("loan_creditor_table").innerHTML +=
            `
    <tr>

      <td>${c}.</td>
      <td>${data.user.first_name + " " + data.user.last_name}</td>
      <td style='color:red'>₦${formatNumber(parseInt(data.amount))}</td>
      <td style='color:black'>${formatNumber(parseInt(data.rate))}%</td>
      <td style='color:green'>₦${formatNumber(parseInt(data.commission))}</td>
      <td><span class="badge ${data.status == 'PAID' ? `bg-success` : `bg-danger`} "><b>${data.status}</b></span></td>
      <td style='color:black'>(${formatNumber(parseInt(data.duration))})Month(s)</td>
      <td>${data.collateral}</td>
      <td>${dateToWord(data.disbursement_date)}</td>
      <td>${dateToWord(data.due_date)}</td>
      <td>
        <a  onclick ="editLoanTransaction(${JSON.stringify(data)
              .replace(/'/g, "")
              .replace(
                /"/g,
                "'"
              )})" class="btn btn-warning" data-bs-toggle="modal"
        data-bs-target="#updateLoanModal"><i class="fas fa-edit"></i></a>
  

      </td>
    
    </tr>
    `;
        });

      } else {
        //     document.getElementById(
        //       "loan_creditor_table"
        //     ).innerHTML = `<td colspan="12">
        //     <center>No transaction found</center>
        // </td>`;
      }

      $("#paginate0").DataTable();
      $("#paginate1").DataTable();

    })
    .catch((err) => console.log(err));

}

function getLoanMonthlyDebitors() {
  start_date = changeDateFormat(document.getElementById("start_date").value);
  end_date = changeDateFormat(document.getElementById("end_date").value);

  openSpinnerModal("Fetch Monthly Debitors");

  fetch(ip + "/api/loan/transaction/" + start_date + "/" + end_date + "/-/MD", {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();

      // DEBITOR SUMMARY
      c = 1;
      if (data.data.length > 0) {
        document.getElementById("debt_table").innerHTML = ``;
        data.data.forEach(data => {
          document.getElementById("debt_table").innerHTML +=
            `
          <tr>
    
            <td>${c}.</td>
            <td>${data.period}</td>
            <td style='color:red'>₦${formatNumber(parseInt(data.loan))}</td>
            <td style='color:red'>₦${formatNumber(parseInt(data.commission))}</td>
            <td data-bs-toggle="modal"
            data-bs-target="#debitorBreakdownReportModal" onclick="getLoanMonthlyDebitorsBreakdown('${data.period}','${data.date}')" style='color:red'>₦${formatNumber(parseInt(data.commission) + parseInt(data.loan))}</td>
            </td>
          
          </tr>
          `;
        });

      } else {
        // document.getElementById(
        //   "debt_table"
        // ).innerHTML = `<td colspan="12">
        //       <center>No transaction found</center>
        //   </td>`;
      }


      // $("#paginate0").DataTable();
      // $("#paginate1").DataTable();

    })
    .catch((err) => console.log(err));

}

function getLoanMonthlyDebitorsBreakdown(period, date) {
  document.getElementById('month').innerHTML = period.toUpperCase();
  start_date = changeDateFormat(document.getElementById("start_date").value);
  end_date = changeDateFormat(document.getElementById("end_date").value);

  openSpinnerModal("Fetch " + period + " Debitors");

  fetch(ip + "/api/loan/transaction/" + date + "/" + end_date + "/-/MDB", {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();

      // DEBITOR BREAKDOWN
      c = 1;
      if (data.data.length > 0) {
        document.getElementById("debt_breakdown").innerHTML = ``;
        data.data.forEach(data => {
          document.getElementById("debt_breakdown").innerHTML +=
            `
          <tr>
    
            <td>${c}.</td>
            <td>${data.name}</td> 
            <td style='color:red'>₦${formatNumber(parseInt(data.loan))}</td>
            <td style='color:red'>₦${formatNumber(parseInt(data.commission))}</td>
            <td style='color:red'>₦${formatNumber(parseInt(data.commission) + parseInt(data.loan))}</td>
            <td style='color:black'>₦${dateToWord(data.disbursement_date)}</td>
          </tr>
          `;
        });

      } else {
        // document.getElementById(
        //   "debt_table"
        // ).innerHTML = `<td colspan="12">
        //       <center>No transaction found</center>
        //   </td>`;
      }


      // $("#paginate0").DataTable();
      // $("#paginate1").DataTable();

    })
    .catch((err) => console.log(err));

}



function editLoanTransaction(data) {
  document.getElementById("loan_id").value = data.id;
  Array.from(document.getElementById("e_loan_user_1").options).forEach(option => {
    if (option.value == data.user.id) {
      option.selected = true;
    }
  });

  Array.from(document.getElementById("e_loan_type").options).forEach(option => {
    if (option.value == data.loan_type) {
      option.selected = true;
    }
  });

  Array.from(document.getElementById("loan_status").options).forEach(option => {
    if (option.value == data.status) {
      option.selected = true;
    }
  });

  document.getElementById("e_amount").value = data.amount;
  document.getElementById("e_rate").value = data.rate;
  document.getElementById("e_duration").value = data.duration;
  document.getElementById("e_collateral").value = data.collateral;
  document.getElementById("e_loan_return").innerHTML = formatNumber(parseInt(data.amount) + parseInt(data.commission));
  document.getElementById("e_due_date").innerHTML = dateToWord(data.due_date);


  document.getElementById("e_loan_due_date").value = data.due_date;
  document.getElementById("e_loan_commission").value = data.commission;

  $('.select2').trigger('change');
  document.getElementById("e_disbursement_date").value = data.disbursement_date.split(" ")[0];
}


function updateLoanTransaction() {
  var dropdown = document.getElementById("e_loan_user_1");
  var selectedIndex = dropdown.selectedIndex;
  var name = dropdown.options[selectedIndex].text;
  loan_type = document.getElementById('e_loan_type').value;

  return_amount = document.getElementById("e_loan_return").innerHTML;
  due_date = document.getElementById("e_due_date").innerHTML;

  if (loan_type == "CREDITOR") {
    if (!confirm("You are expected to return ₦" + return_amount + " to " + name + " on " + due_date + " ?")) {
      return 0;
    }

  } else {
    if (!confirm(name + " is expected to return ₦" + return_amount + " on " + due_date + " ?")) {
      return 0;
    }
  }

  openSpinnerModal("Update Loan Transaction");

  loanUser = document.getElementById('e_loan_user_1').value;

  fetch(ip + "/api/loan/transaction", {
    method: "PUT",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      id: document.getElementById("loan_id").value,
      user_id: loanUser,
      duration: document.getElementById('e_duration').value,
      status: document.getElementById('loan_status').value,
      amount: document.getElementById('e_amount').value,
      loan_type: document.getElementById('e_loan_type').value,
      rate: document.getElementById('e_rate').value,
      commission: document.getElementById('e_loan_commission').value,
      disbursement_date: document.getElementById('e_disbursement_date').value,
      due_date: document.getElementById('e_loan_due_date').value,
      collateral: document.getElementById('e_collateral').value
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        closeModal('updateLoanModal');
        successtoast(data.message);
        getLoanTransaction();
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

/*END LOAN SECTION */



/*SERVICE ROOM SECTION */

function createRoomBooking() {
  room_user = document.getElementById('room_user_1').value;
  openSpinnerModal("Book Room");

  fetch(ip + "/api/service-room", {
    method: "POST",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      user_id: room_user,
      room: document.getElementById('room').value,
      amount: document.getElementById('amount').value,
      checked_in: document.getElementById('checked_in').value,
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        closeModal('transModal');
        successtoast(data.message);
        getBookedRooms();
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

function getBookedRooms() {
  start_date = changeDateFormat(document.getElementById("start_date").value);
  end_date = changeDateFormat(document.getElementById("end_date").value);

  openSpinnerModal("Booked Rooms");

  fetch(ip + "/api/service-room/" + start_date + "/" + end_date, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    }
  })
    .then(function (res) {
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })

    .then((data) => {

      removeSpinnerModal();
      // POPULATE CHART

      document.getElementById("total_user").innerHTML = formatNumber(parseInt(data.total_user)
      );

      document.getElementById("available_room").innerHTML = data.room.stat

      document.getElementById("total_sales").innerHTML = formatNumber(
        parseInt(data.total_sales)
      );


      //Append available rooms
      document.getElementById("room").innerHTML = ``;

      data.room.available_rooms.forEach(room => {
        document.getElementById("room").innerHTML += ` <option value="${room}">ROOM ${room}</option>`;
      });


      // Destroy the existing DataTable
      if ($.fn.DataTable.isDataTable("#paginate0")) {
        $("#paginate0").DataTable().destroy();
      }


      c = 1;
      if (data.data.length > 0) {
        document.getElementById("booked_room_table").innerHTML = ``;
        data.data.forEach(data => {
          document.getElementById("booked_room_table").innerHTML +=
            `
          <tr>
    
            <td>${c}.</td>
            <td>${data.user.first_name + " " + data.user.last_name}</td>
            <td style='color:black'>Room ${data.room_no}</td>
            <td>   ${data.duration == '-' ? ` <span class="badge bg-warning"><b>USAGE IN PROGRESS</b></span>` : `<span class="badge bg-success"><b>${data.duration} Day(s)</b></span>`}
            </td>
            <td>${dateToWord(data.checked_in)}</td>
            <td>${data.checked_out == null ? `<span class="badge bg-danger"><b>NOT CHECKED OUT</b></span>` : dateToWord(data.checked_out)}</td>
            <td style='color:black'>${formatNumber(parseInt(data.amount))}/ Day</td>
            <td style='color:green'>₦${formatNumber(parseInt(data.total_charge))}</td>
            <td>
              <a  onclick ="editBookedRoom(${JSON.stringify(data)
              .replace(/'/g, "")
              .replace(
                /"/g,
                "'"
              )})" class="btn btn-warning" data-bs-toggle="modal"
              data-bs-target="#editBookingModal"><i class="fas fa-edit"></i></a>
        
    
            </td>
          
          </tr>
          `;
        });

      } else {
        // document.getElementById(
        //   "loan_debitor_table"
        // ).innerHTML = `<td colspan="12">
        //       <center>No transaction found</center>
        //   </td>`;
      }


      $("#paginate0").DataTable();

    })
    .catch((err) => console.log(err));

}

function editBookedRoom(data) {
  document.getElementById("booking_id").value = data.id;
  Array.from(document.getElementById("e_room_user_1").options).forEach(option => {
    if (option.value == data.user.id) {
      option.selected = true;
    }
  });

  Array.from(document.getElementById("e_room").options).forEach(option => {
    if (option.value == data.room) {
      option.selected = true;
    }
  });


  document.getElementById("e_amount").value = data.amount;
  document.getElementById("e_checked_in").value = data.checked_in.split(' ')[0];
  document.getElementById("e_checked_out").value = data.checked_out ? data.checked_out.split(' ')[0] : "";

  $('.select2').trigger('change');
}

function updateRoomBooking(duration, total_charge) {
  room_user = document.getElementById('e_room_user_1').value;
  openSpinnerModal("Update Booked Room");

  fetch(ip + "/api/service-room", {
    method: "PUT",
    headers: {
      Accept: "application/json",
      "Content-type": "application/json",
      Authorization: "Bearer " + localStorage["token"],
    },
    body: JSON.stringify({
      id: document.getElementById('booking_id').value,
      user_id: room_user,
      room: document.getElementById('e_room').value,
      amount: document.getElementById('e_amount').value,
      checked_in: document.getElementById('e_checked_in').value,
      checked_out: document.getElementById('e_checked_out').value,
      duration: duration,
      total_charge: total_charge
    }),
  })
    .then(function (res) {
      console.log(res.status);
      if (res.status == 401) {
        removeSpinnerModal();
        openAuthenticationModal();
      }
      return res.json();
    })
    .then((data) => {
      removeSpinnerModal();
      if (data.success) {
        closeModal('editBookingModal');
        successtoast(data.message);
        getBookedRooms();
      } else {
        errortoast(data.message);
      }
    })
    .catch((err) => console.log(err));
}

/*END SERVICE ROOM SECTION */




/* GET TODAY'S DATE */
function getDate() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();
  time = today.getHours() + ":" + today.getMinutes();
  date = dd + "/" + mm + "/" + yyyy;

  return time + "~" + date;
}

function dateToWord(date) {
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const formattedDate = new Date(date).toLocaleDateString("en-US", options);
  return formattedDate;
}


// PAGENATION
function paginateTable() {
  $("#paginate").DataTable();
  $(".dataTables_length").addClass("bs-select");
}

$(document).click(function (e) {
  if (!$(e.target).closest("#authenticationModal").length) {
    var modalExist = parent.document.getElementById("authenticationModal");
    if (modalExist != null) {
      modalExist.remove();

      parent.document.querySelectorAll(".modal-backdrop").forEach((el) => {
        console.log(el);
        el.remove();
      });
    }
  }

  spinnerModal = parent.document.getElementById("spinnerModal");
  authenticationModal = parent.document.getElementById("authenticationModal");
  if (spinnerModal == null && authenticationModal == null) {
    const backdrop = document.getElementsByClassName(
      "modal-backdrop fade show"
    );
    Array.from(backdrop).forEach(function (bd) {
      bd.remove();
    });
  }

  document.body.style.overflow = "auto";
});


function download(filename) {
  filename = filename == null ? "file" : filename;
  const payment_slip = this.document.getElementById("payment-slip");
  console.log(payment_slip);
  console.log(window);
  var opt = {
    margin: 0.1,
    filename: filename + ".pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2, useCORS: true },
    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  };
  html2pdf().from(payment_slip).set(opt).save();
}

// RE - AUTHENTICATION MODAL
function openAuthenticationModal() {
  modal = `<div class="modal fade" id="authenticationModal" tabindex="-1" role="dialog"
aria-labelledby="endModalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 style="font-family: Poppins; font-weight: bold;"
                class="modal-title col-12 text-center" id="authenticationModalTitle">
                <b>Session Timeout !</b>
            </h4>

        </div>
        <div class="modal-body text-center">
            <div class="row">
                <div class="col-lg-12 img-box">
                    <img src="../asset/images/login-banner.png" alt="">
                </div>
                <div class="col-lg-12 no-padding">
                    <div class="login-box">
                        <link rel="stylesheet" type="text/css" href="../asset/css/style.css" />
                        <link href="../assets/css/lib/toastr/toastr.min.css" rel="stylesheet">
                        <link href="../assets/css/lib/sweetalert/sweetalert.css" rel="stylesheet">
                        <div style="display: flex;
                        justify-content: center;" class="row">

                            <b>
                                <h3 style="font-weight: bold; font-family: Rowdies; color:#051f3e;">
                                   AFIDEM GLOBAL RESOURCE
                                </h3>
                            </b>

                        </div>
                        <br>

                        <h5 style="color: #ff9d01; font-family: Poppins; font-weight: bold;">Hi
                           ${localStorage["username"]},</script> please
                            signin
                            to continue
                        </h5>
                       <form autocomplete="off">   
                            <label for=""><i class="fas fa-unlock-alt"></i> Password</label>
                            <div class="login-row row no-margin">
                               
                                <input id="password" type="password" autocomplete="new-password"
                                    class="form-control form-control-sm">
                                    <br>
                                    <small id="togglePass" style="cursor:pointer; font-style:bold">Show password</small>
                            </div>
                        </form>    
                        <br>
                        <a  style="float: right; color: red;" onclick="goTo('');">Log out</a>


                        <div class="login-row btnroo row no-margin">
                            <button id="signin" onclick="reAuth()"
                                class="btn btn-primary btn-sm ">Sign
                                In</button>
                        </div>

                        <br />

                    </div>
                    <footer class="footer">
                        <div style="display: flex;
                        justify-content: center;" class="copyright">© <a  style="color: #051f3e;"
                                href="../#"><b>
                                    Dextroux Technologies</b></a></div>
                    </footer>
                </div>

            </div>
            <script>
                const password = document.querySelector('#password');
                togglePass.addEventListener('click', function (e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    parent.document.getElementById('togglePass').innerHTML = parent.document.getElementById('togglePass').innerHTML == 'Show password' ? 'Hide password' : 'Show password';
                })
            </script>
            <script src="../assets/js/lib/toastr/toastr.min.js"></script>
            <script src="../assets/js/lib/toastr/toastr.init.js"></script>
            <script src="../assets/js/lib/sweetalert/sweetalert.min.js"></script>
            <script src="../assets/js/lib/sweetalert/sweetalert.init.js"></script>
        </div>
    </div>
</div>
</div>
`;

  authenticationModal = parent.document.getElementById("authenticationModal");
  if (authenticationModal != null) {
    return 0;
  }

  parent.$("body").append(modal);
  parent
    .$("#authenticationModal")
    .modal({ backdrop: "static", keyboard: false });
  parent.$("#authenticationModal").modal("show");
}

function openSpinnerModal(message) {
  if (!navigator.onLine) {
    return 0;
  }

  modal = `<div class="modal fade" id="spinnerModal" tabindex="-1" role="dialog"
aria-labelledby="endModalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body text-center">
        <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-secondary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-success" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-danger" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-warning" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-info" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-light" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <div class="spinner-grow text-dark" role="status">
        <span class="sr-only">Loading...</span>
      </div>
        </div>

        <h4 style="font-family: Poppins; font-weight: bold;"
                class="modal-title col-12 text-center" id="spinnerModalTitle">
                <b>${message != null || message != "" ? message : ``} </b><br/>
                <b>Processing ...</b>
            </h4>
            <br>
    </div>
</div>
</div>
`;

  spinnerModal = parent.document.getElementById("spinnerModal");
  if (spinnerModal != null) {
    return 0;
  }

  parent.$("body").append(modal);
  parent.$("#spinnerModal").modal({ backdrop: "static", keyboard: false });
  parent.$("#spinnerModal").modal("show");
}

function removeSpinnerModal() {
  spinnerModal = parent.document.getElementById("spinnerModal");
  if (spinnerModal != null) {
    parent.$("#spinnerModal").modal("hide");
    parent.document.getElementById("spinnerModal").remove();
  }
}

function collapseSidebar() {
  if (
    navigator.userAgent.match(/Android/i) ||
    navigator.userAgent.match(/webOS/i) ||
    navigator.userAgent.match(/iPhone/i) ||
    // navigator.userAgent.match(/iPad/i) ||
    navigator.userAgent.match(/iPod/i) ||
    navigator.userAgent.match(/BlackBerry/i) ||
    navigator.userAgent.match(/Windows Phone/i)
  ) {
    // MOBILE
    a = true;
  } else {
    // DESKTOP
    wrapper = document.getElementById("wrapper");
    if (wrapper != null) {
      if ((wrapper.className = "wrapper bg-ash")) {
        wrapper.className = "wrapper bg-ash sidebar-collapsed";
        if (document.getElementById("logo").innerHTML != "") {
          changeLogo();
        }
      }
    }
  }
}

function closeModal(id) {
  parent.$("#" + id).modal("hide");
  el = parent.document.getElementById("#" + id);
  el != null ? el.remove() : ``;
}

function changeDateFormat(prevdate) {
  dd = prevdate.split("/")[0];
  mm = prevdate.split("/")[1];
  yyyy = prevdate.split("/")[2];
  return yyyy + "-" + mm + "-" + dd;
}

function resetFormInputs() {
  var elements = document.getElementsByClassName("form-input");
  for (var i = 0; i < elements.length; i++) {
    elements[i].value = "";
  }
}

// TOAST
function successtoast(message, time) {
  toastr.success(message, "", {
    timeOut: time,
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-center",
    preventDuplicates: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: false,
  });
}
function warningtoast(message, time) {
  toastr.warning(message, "", {
    positionClass: "toast-top-center",
    timeOut: 10000,
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    preventDuplicates: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: false,
  });
}
function errortoast(message, time) {
  toastr.error(message, "", {
    positionClass: "toast-top-center",
    timeOut: time,
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    preventDuplicates: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: false,
  });
}

window.addEventListener("fetch", function (event) {
  if (!navigator.onLine) {
    toastr.remove();
    errortoast("You are offline, connect to the internet.");
  }
});

if ("serviceWorker" in navigator) {
  navigator.serviceWorker.addEventListener("message", (event) => {
    const data = event.data;
    if (data.success) {
      successtoast(data.message);
    } else {
      errortoast(data.message);
    }
  });
}