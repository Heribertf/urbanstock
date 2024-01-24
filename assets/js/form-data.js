// modal buttons action
const form1 = document.getElementById("form1");
const form2 = document.getElementById("form2");

const populateMpesa = document.getElementById("mpesa");
const populatePaypal = document.getElementById("paypal");

populateMpesa.onclick = function () {
  // Get selected values from the first form
  var amount = document.getElementById("amountInput").value;
  var stockSelect = document.getElementById("stockSelect");
  var selectedStock = stockSelect.options[stockSelect.selectedIndex].value;
  var durationSelect = document.getElementById("durationSelect");
  var selectedDuration =
    durationSelect.options[durationSelect.selectedIndex].value;

  var dataVar = document.getElementById("dataVariable").value;

  document.getElementById("payment-amount").textContent = "Amount: " + amount;

  document.getElementById("capital").value = amount;
  document.getElementById("stock_invest").value = selectedStock;
  document.getElementById("plan_invest").value = selectedDuration;
  document.getElementById("paying_user_id").value = dataVar;
};

populatePaypal.onclick = function () {
  // Get selected values from the first form
  var amount = document.getElementById("amountInput").value;
  var stockSelect = document.getElementById("stockSelect");
  var selectedStock = stockSelect.options[stockSelect.selectedIndex].value;
  var durationSelect = document.getElementById("durationSelect");
  var selectedDuration =
    durationSelect.options[durationSelect.selectedIndex].value;
  var dataVar = document.getElementById("dataVariable").value;

  const calculatedAmt = amount / 150;
  const result = calculatedAmt.toFixed(2);

  // Update modal form fields
  document.getElementById("amount").value = result;
  document.getElementById("stock_id").value = selectedStock;
  document.getElementById("plan_id").value = selectedDuration;
  document.getElementById("custom_val").value = dataVar + "|stock|" + selectedDuration;

  // Update stock_name and plan based on selected values
  if (selectedStock == 1) {
    document.getElementById("p_stock_name").value = "Apple";
    // document.getElementById('chosen-stock').textContent = 'Apple';
  } else if (selectedStock == 2) {
    document.getElementById("p_stock_name").value = "Microsoft";
    // document.getElementById('chosen-stock').textContent = 'Microsoft';
  } else if (selectedStock == 3) {
    document.getElementById("p_stock_name").value = "Google";
    // document.getElementById('chosen-stock').textContent = 'Google';
  } else if (selectedStock == 4) {
    document.getElementById("p_stock_name").value = "Tesla";
    // document.getElementById('chosen-stock').textContent = 'Google';
  } else if (selectedStock == 5) {
    document.getElementById("p_stock_name").value = "Amazon";
    // document.getElementById('chosen-stock').textContent = 'Google';
  }

  if (selectedDuration == 1) {
    document.getElementById("plan").value = "1 Month";
    // document.getElementById('chosen-plan').textContent = '1 Month';
  } else if (selectedDuration == 2) {
    document.getElementById("plan").value = "1 Week";
    // document.getElementById('chosen-plan').textContent = '1 Week';
  } else if (selectedDuration == 3) {
    document.getElementById("plan").value = "1 Day";
    // document.getElementById('chosen-plan').textContent = '1 Day';
  }
};

var machineOne = document.getElementById("machine-one");
var machineTwo = document.getElementById("machine-two");
var machineThree = document.getElementById("machine-three");


machineOne.onclick = function () {
  var machine_amount = document.getElementById("v1").value;
  var machine_id = document.getElementById("v1-id").value;
  var machine_name = document.getElementById("v-series").textContent;

  const calculatedAmt = machine_amount / 150;
  const result = calculatedAmt.toFixed(2);
  // const result = Math.round(calculatedAmt);

  document.getElementById("machine-pay-amount").textContent = "Amount: Kes " + machine_amount + " ($" + result + " USD)";
  document.getElementById("machine-name").textContent = "Machine: " + machine_name;

  document.getElementById("machine-payment-amount").textContent = "Amount: Kes " + machine_amount;
  document.getElementById("capital_invested").value = machine_amount;
  document.getElementById("machine_invest").value = machine_id;

  document.getElementById("machine_id").value = machine_id;
  document.getElementById("machine_amount").value = result;
  document.getElementById("machine_name").value = machine_name;

}

machineTwo.onclick = function () {
  var machine_amount = document.getElementById("m1").value;
  var machine_id = document.getElementById("m1-id").value;
  var machine_name = document.getElementById("m-series").textContent;

  const calculatedAmt = machine_amount / 150;
  const result = calculatedAmt.toFixed(2);

  document.getElementById("machine-pay-amount").textContent = "Amount: Kes " + machine_amount + " ($" + result + " USD)";
  document.getElementById("machine-name").textContent = "Machine: " + machine_name;

  document.getElementById("machine-payment-amount").textContent = "Amount: Kes " + machine_amount;
  document.getElementById("capital_invested").value = machine_amount;
  document.getElementById("machine_invest").value = machine_id;
  document.getElementById("machine_id").value = machine_id;
  document.getElementById("machine_amount").value = result;
  document.getElementById("machine_name").value = machine_name;

}

machineThree.onclick = function () {
  var machine_amount = document.getElementById("k1").value;
  var machine_id = document.getElementById("k1-id").value;
  var machine_name = document.getElementById("k-series").textContent;

  const calculatedAmt = machine_amount / 150;
  const result = calculatedAmt.toFixed(2);

  document.getElementById("machine-pay-amount").textContent = "Amount: Kes " + machine_amount + " ($" + result + " USD)";
  document.getElementById("machine-name").textContent = "Machine: " + machine_name;

  document.getElementById("machine-payment-amount").textContent = "Amount: Kes " + machine_amount;
  document.getElementById("capital_invested").value = machine_amount;
  document.getElementById("machine_invest").value = machine_id;
  document.getElementById("machine_id").value = machine_id;
  document.getElementById("machine_amount").value = result;
  document.getElementById("machine_name").value = machine_name;


}
// modal
const openBtn = document.querySelectorAll("[data-open-modal]");
const mpesa = document.querySelector("[data-open-mpesa-modal]");
const paypal = document.querySelector("[data-open-paypal-modal]");
const closeBtns = document.querySelectorAll("[data-close-modal]");
const modals = document.querySelectorAll("[data-modal]");


const machineOpenBtn = document.querySelectorAll("[data-open-modal-machine]");
const mpesaMachine = document.getElementById("machine-mpesa");
const paypalMachine = document.getElementById("machine-paypal");
const modalsMachine = document.querySelectorAll("[data-modal-machine]");
const closeBtnsMachine = document.querySelectorAll("[data-close-modal-machine]");


const modalOverlay = document.createElement("div");
modalOverlay.classList.add("modal-overlay");

document.body.appendChild(modalOverlay);

function openModal(modal) {
  modal.showModal();
  modalOverlay.style.display = "block";
  document.body.classList.add("modal-open");
}

function closeModal(modal) {
  modal.close();
  modalOverlay.style.display = "none";
  document.body.classList.remove("modal-open");
}

// openBtn.addEventListener("click", () => {
//   var condition_check = document.getElementById("conditionCheck").value;

//   // var conditionCheck = JSON.parse(condition_check);

//   if (condition_check == "true") {
//     closeModal(modals[1]);
//     closeModal(modals[2]);
//     openModal(modals[0]);
//   } else {
//     window.location.href = "./login";
//   }
// });

openBtn.forEach((opnBtn) => {
  opnBtn.addEventListener("click", () => {
    var condition_check = document.getElementById("conditionCheck").value;

    // var conditionCheck = JSON.parse(condition_check);

    if (condition_check == "true") {
      closeModal(modals[1]);
      closeModal(modals[2]);
      openModal(modals[0]);
    } else {
      window.location.href = "./login";
    }
  });
});


machineOpenBtn.forEach((mOpnBtn) => {
  mOpnBtn.addEventListener("click", () => {
    var condition_check = document.getElementById("conditionCheck").value;

    // var conditionCheck = JSON.parse(condition_check);

    if (condition_check == "true") {
      closeModal(modalsMachine[1]);
      closeModal(modalsMachine[2]);
      openModal(modalsMachine[0]);
    } else {
      window.location.href = "./login";
    }
  });
});


mpesa.addEventListener("click", () => {
  closeModal(modals[0]);
  openModal(modals[1]);
});

paypal.addEventListener("click", () => {
  closeModal(modals[0]);
  openModal(modals[2]);
});


mpesaMachine.addEventListener("click", () => {
  const durationSelect = document.getElementById("durationSelection");
  const selectedDuration =
    durationSelect.options[durationSelect.selectedIndex].value;

  const dataVar = document.getElementById("dataVariable").value;

  document.getElementById("investment_plan").value = selectedDuration;
  document.getElementById("client_id").value = dataVar;


  closeModal(modalsMachine[0]);
  openModal(modalsMachine[1]);
});

paypalMachine.addEventListener("click", () => {
  const durationSelect = document.getElementById("durationSelection");
  const selectedDuration =
    durationSelect.options[durationSelect.selectedIndex].value;
  const dataVar = document.getElementById("dataVariable").value;


  document.getElementById("chosen_plan_id").value = selectedDuration;

  document.getElementById("machine_custom_val").value = dataVar + "|machine|" + selectedDuration;


  if (selectedDuration == 1) {
    document.getElementById("chosen_plan").value = "1 Month";
  } else if (selectedDuration == 2) {
    document.getElementById("chosen_plan").value = "1 Week";
  } else if (selectedDuration == 3) {
    document.getElementById("chosen_plan").value = "1 Day";
  }

  closeModal(modalsMachine[0]);
  openModal(modalsMachine[2]);
});


closeBtns.forEach((closeBtn, index) => {
  closeBtn.addEventListener("click", () => closeModal(modals[index]));
  closeBtn.addEventListener("click", () => closeModal(modalsMachine[index]));

});

closeBtnsMachine.forEach((closeBtnMachine, index) => {
  closeBtnMachine.addEventListener("click", () => closeModal(modalsMachine[index]));

});

modalOverlay.addEventListener("click", () => closeModal(modals));



document.addEventListener("DOMContentLoaded", function () {
  const mpesaForm = document.getElementById("mpesa-payment-form");
  const machineMpesaForm = document.getElementById("machine-mpesa-payment-form");

  // $(submitBtn).on('click', function (e) {
  //     e.preventDefault();
  mpesaForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Ensure the FormData constructor receives the form element
    const formData = new FormData(mpesaForm);

    $.ajax({
      type: "POST",
      url: "./mpesa-handler",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          closeModal(modals[1]);
          Swal.fire({
            title: "Payment Sent",
            text: response.message,
            timer: 5000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
            },
          }).then((result) => {
            window.location.href = "./investment";
            // location.reload();
          });
        } else {
          closeModal(modals[1]);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: response.message,
          });
        }
      },
      error: function (xhr, status, error) {
        closeModal(modals[1]);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
      },
    });
  });

  machineMpesaForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Ensure the FormData constructor receives the form element
    const formData = new FormData(machineMpesaForm);

    $.ajax({
      type: "POST",
      url: "./machine-mpesa-handler",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          closeModal(modals[1]);
          Swal.fire({
            title: "Payment Sent",
            text: response.message,
            timer: 5000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
            },
          }).then((result) => {
            window.location.href = "./investment";
            // location.reload();
          });
        } else {
          closeModal(modals[1]);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: response.message,
          });
        }
      },
      error: function (xhr, status, error) {
        closeModal(modals[1]);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
      },
    });
  });
});
