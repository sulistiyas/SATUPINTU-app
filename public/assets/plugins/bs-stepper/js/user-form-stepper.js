/* globals Stepper:false */

(function () {
    "use strict";

    var stepperFormEl = document.querySelector("#stepper1");
    window.stepper1 = new Stepper(stepperFormEl, {
        animation: true,
    });

    var btnNextList = [].slice.call(
        document.querySelectorAll(".btn-next-form")
    );
    var stepperPanList = [].slice.call(
        stepperFormEl.querySelectorAll(".bs-stepper-pane")
    );

    // Form 2
    // Step 1
    var employee_name = document.getElementById("employee_name");
    var employee_phone = document.getElementById("employee_phone");
    var employee_address = document.getElementById("employee_address");
    var employee_sex = document.getElementById("employee_sex");
    var employee_birth = document.getElementById("employee_birth");
    var employee_dob = document.getElementById("employee_dob");
    // Step 2

    var form = stepperFormEl.querySelector(".bs-stepper-content form");

    btnNextList.forEach(function (btn) {
        btn.addEventListener("click", function () {
            window.stepper1.next();
        });
    });

    stepperFormEl.addEventListener("show.bs-stepper", function (event) {
        form.classList.remove("was-validated");
        var nextStep = event.detail.indexStep;
        var currentStep = nextStep;

        if (currentStep > 0) {
            currentStep--;
        }

        var stepperPan = stepperPanList[currentStep];

        if (
            // Form2
            // Step 1
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_name.value.length) ||
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_phone.value.length) ||
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_address.value.length) ||
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_sex.value.length) ||
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_birth.value.length) ||
            (stepperPan.getAttribute("id") === "test-form-1" &&
                !employee_dob.value.length) ||
            // Step 2
            (stepperPan.getAttribute("id") === "test-form-2" &&
                !employee_dob.value.length)
        ) {
            event.preventDefault();
            form.classList.add("was-validated");
        }
    });
})();
