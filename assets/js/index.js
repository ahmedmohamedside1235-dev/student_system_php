$(document).ready(function () {
    getStudentsByPageNumber(1);
});

let searchValue = '',
    statusBtn = "show";
$("#FormSearch").submit(function (e) {
    e.preventDefault();
    let inputSearch = new FormData(this);
    searchValue = inputSearch.get('search');
    getStudentsByPageNumber(1);
});

function getStudentsByPageNumber(pageNumber) {
    $.ajax({
        url: "backend/getStudents.php",
        type: "POST",
        data: { "pageNumber": pageNumber, "search": searchValue },
        success: function (response) {
            showStudents(response.students);
            showPagination(response.totalPages, response.currentPage);
        },

        error: function (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: error.responseJSON.message,
            });
        }
    });
}

function showPagination(totalPages, currentPage) {
    let htmlPagination = "";

    if (totalPages <= 1) {
        $("#Pagination").html("");
        return;
    }

    let prevPage = currentPage === 1 ? totalPages : currentPage - 1;

    htmlPagination += `
        <li class="page-item">
            <button class="page-link ${currentPage === 1 ? 'disabled' : ''}" onclick="getStudentsByPageNumber(${prevPage})">Previous</button>
        </li>`;

    for (let i = 1; i <= totalPages; i++) {
        htmlPagination +=
            `
            <li class="page-item"><button class="page-link ${currentPage === i ? 'active' : ''}" onclick="getStudentsByPageNumber(${i})">${i}</button></li>
            `
    }

    let nextPage = currentPage === totalPages ? 1 : currentPage + 1;

    htmlPagination += `
        <li class="page-item">
            <button class="page-link ${currentPage === totalPages ? 'disabled' : ''}" onclick="getStudentsByPageNumber(${nextPage})">Next</button>
        </li>`;

    $("#Pagination").html(htmlPagination);
}

function showStudents(students) {
    let emptyParagraph = document.querySelector(".empty");
    $("#TableBody").html("");


    if (students.length <= 0) {
        emptyParagraph.classList.remove("d-none");
        return;
    }

    let htmlTr = "";
    emptyParagraph.classList.add("d-none");
    students.forEach(student => {
        let shortPass = student['password'].slice(0, 15);
        htmlTr += `
            <tr data-id='${student['id']}'>
                <th>${student['id']}</th>
                <td>${student['first_name']} ${student['last_name']}</td>
                <td>${student['email']}</td>
                <td>${shortPass}...</td>
                <td>${student['age']}</td>
                <td>${student['phone']}</td>
                <td>
                    <div class="buttons">
                        <button class="btn btn-info text-light"${statusBtn == 'hide' ? 'disabled' : ''} onclick='getStudent(${student['id']})'><i class="fa-solid fa-pen-to-square text-light"></i> Edit</button>
                        <button class="btn btn-danger" ${statusBtn == 'hide' ? 'disabled' : ''} onclick='deleteStudent(${student['id']})'><i class="fa-solid fa-trash text-light"></i> Delete</button>
                    </div>
                </td>
            </tr>
        `
    });

    $("#TableBody").html(htmlTr);
    return;
}

function deleteStudent(studentId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("ok");
            $.ajax({
                url: "backend/deleteStudent.php",
                type: "POST",
                data: { "student_id": studentId },
                success: (response) => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Student deleted successfully",
                        icon: "success"
                    });

                    $(`tr[data-id='${studentId}']`).remove();
                },
                error: (error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.responseJSON?.message ?? "Error in Database",
                    });
                },
            });
        }
    });
}

function insertValuesInInputs(student) {
    let inputs = document.querySelectorAll("form .input"),
        form = document.querySelector(".formStudent"),
        inputId = document.querySelector("form .inputId"),
        btnEdit = document.querySelector("#Submit"),
        btnCancel = document.querySelector("#Cancel");
    inputId.value = student.id;

    form.setAttribute("action", "./backend/editStudentForm.php");
    toggleBtn("edit");

    inputs.forEach((input) => {
        input.value = student[input.name];
    });

    disableBtns("edit");
    removeError();
    
}

function disableBtns(status) {
    let btnTable = document.querySelectorAll("#Table-student #TableBody button");
    if (status === "cancel") {
        btnTable.forEach(btn => {
            btn.disabled = false;
        });
        return;
    }

    btnTable.forEach(btn => {
        btn.disabled = true;
    });

    return;
}

function removeError() {
    let paragraphError = document.querySelectorAll(".api-error-banner") ?? null;
    if (!paragraphError) return;
    paragraphError.forEach((para) => para.remove());
}

function cancelEdit() {
    let form = document.querySelector(".formStudent"),
        inputs = document.querySelectorAll("form .input");
    form.setAttribute("action", "./backend/register.php");
    form.reset();
    toggleBtn("add");
    inputs.forEach((input) => {
        input.value = "";
    });
    disableBtns("cancel");
    window.location.href = './backend/cancelEdit.php';
}

function getStudent(studentId) {
    $.ajax({
        url: 'backend/getStudent.php',
        type: "POST",
        data: { "student_id": studentId },

        success: (response) => {
            let student = {
                "id": response.student["id"],
                "firstName": response.student["first_name"],
                "lastName": response.student["last_name"],
                "email": response.student["email"],
                "age": response.student["age"],
                "phone": response.student["phone"]
            }
            insertValuesInInputs(student);
        },
        error: (error) => {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: error.responseJSON?.message ?? "Faild to get student",
            });
        },
    })
}

function toggleBtn(status) {
    let btnEdit = document.querySelector("#Submit"),
        btnCancel = document.querySelector("#Cancel");

    if (status === "edit") {
        btnCancel.classList.remove("d-none");
        btnEdit.textContent = "Edit Your Account";
        btnEdit.classList.remove("btn-success");
        btnEdit.classList.add("btn-info", "text-light");
        statusBtn = "hide";
        return;
    }

    btnCancel.classList.add("d-none");
    btnEdit.textContent = "Add your account";
    btnEdit.classList.add("btn-success");
    btnEdit.classList.remove("btn-info", "text-light");
    statusBtn = "show";

}
