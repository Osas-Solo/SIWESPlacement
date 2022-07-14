const collegeSelect = document.getElementById("college-select");
const departmentSelect = document.getElementById("department-select");

updateDepartmentSelect();

function updateDepartmentSelect() {
    clearDepartmentOptions();

    const college = (collegeSelect.value != "") ? collegeSelect.value : "College";

    const departmentListRequest = new XMLHttpRequest();

    departmentListRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const departmentList = JSON.parse(this.responseText);

            const emptyOption = document.createElement("option");
            departmentSelect.appendChild(emptyOption);

            for (const department of departmentList) {
                const option = document.createElement("option");

                option.value = department.departmentID;
                option.innerHTML = department.departmentName;

                departmentSelect.appendChild(option);
            }
        }
    };

    departmentListRequest.open("POST", "department-list-updater.php", true);
    departmentListRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    departmentListRequest.send("college=" + college);
}

function clearDepartmentOptions() {
    const numberOfDepartmentOptions = departmentSelect.childElementCount;

    for (let i = 0; i < numberOfDepartmentOptions; i++) {
        departmentSelect.removeChild(departmentSelect.lastElementChild);
    }
}

function selectDepartment(departmentID) {
    const numberOfDepartmentOptions = departmentSelect.childElementCount;

    for (let i = 0; i < numberOfDepartmentOptions; i++) {
        console.log("Department: " + departmentSelect.children[i].innerHTML);

        const currentDepartmentOption = departmentSelect.children[i];

        if (departmentID == currentDepartmentOption.value) {
            currentDepartmentOption.setAttribute("selected", "selected");
        }
    }
}