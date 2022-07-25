const offerSalaryCheckbox = document.getElementById("offer-salary-checkbox");
const salaryDiv = document.getElementById("salary-div");
const salaryInput = document.getElementById("salary-input");
const departmentCheckboxes = document.getElementsByClassName("department-checkboxes");
const studentsDivs = document.getElementsByClassName("students-divs");
const numberOfStudentsInputs = document.getElementsByClassName("number-of-students-inputs");

changeSalaryVisibility();
changeNumberOfStudentsVisibility();

function changeSalaryVisibility() {
    if (!offerSalaryCheckbox.checked) {
        salaryDiv.style.display = "none";
    } else {
        salaryDiv.style.display = "";
        salaryInput.setAttribute("required", "");
    }
}

function changeNumberOfStudentsVisibility() {
    for (let i = 0; i < departmentCheckboxes.length; i++) {
        if (!departmentCheckboxes[i].checked) {
            studentsDivs[i].style.display = "none";
        } else {
            studentsDivs[i].style.display = "";
            numberOfStudentsInputs[i].setAttribute("required", "");
        }
    }
}