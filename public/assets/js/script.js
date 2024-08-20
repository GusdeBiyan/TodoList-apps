let categoryOptions = [];

document.addEventListener("DOMContentLoaded", function () {
    axios
        .get("/api/categories")
        .then(function (response) {
            categoryOptions = response.data;

            const allSelects = document.querySelectorAll(
                "select[name='kategori']"
            );

            allSelects.forEach((select) => {
                select.innerHTML = "";

                categoryOptions.forEach(function (category) {
                    const option = document.createElement("option");
                    option.value = category.id;
                    option.textContent = category.name;
                    select.appendChild(option);
                });
            });
        })
        .catch(function (error) {
            console.error("Error fetching categories:", error);
        });

    updateDeleteButtons();
});

let todoCounter = 2;

function updateDeleteButtons() {
    const todoItems = document.querySelectorAll("#todo .todo-item");
    const deleteButtons = document.querySelectorAll("#todo .btn-delete");

    if (todoItems.length === 1) {
        deleteButtons.forEach((button) => {
            button.disabled = true;
            button.style.cursor = "not-allowed";
            button.style.opacity = "0.5";
        });
    } else {
        deleteButtons.forEach((button) => {
            button.disabled = false;
            button.style.cursor = "pointer";
            button.style.opacity = "1";
        });
    }
}

function addTodoItem() {
    const container = document.getElementById("todo");

    const uniqueId = "todo" + todoCounter;

    const todoItemHTML = `
        <div class="todo-item" id="${uniqueId}">
            <div class="form-group judul-input">
                <label for="judul-${uniqueId}">Judul To Do</label>
                <input class="form-control" type="text" name="judul${uniqueId}" id="judul-${uniqueId}" placeholder="Contoh : Perbaikan api master">
            </div>
            <div class="form-group">
                <label for="kategori-${uniqueId}">Kategori</label>
                <select class="form-select" name="kategori" id="kategori-${uniqueId}">
                </select>
            </div>
            <button class="btn-delete" type="button" data-id="${uniqueId}">
                <img src="/assets/icon/ic_trash.png" alt="">
            </button>
        </div>
    `;

    container.insertAdjacentHTML("beforeend", todoItemHTML);

    const select = document.getElementById(`kategori-${uniqueId}`);
    categoryOptions.forEach(function (category) {
        const option = document.createElement("option");
        option.value = category.id;
        option.textContent = category.name;
        select.appendChild(option);
    });

    todoCounter++;
    updateDeleteButtons();
}

document.getElementById("todo").addEventListener("click", function (event) {
    if (event.target.closest(".btn-delete")) {
        const itemId = event.target
            .closest(".btn-delete")
            .getAttribute("data-id");

        Swal.fire({
            title: "Apakah anda yakin?",
            text: "To do yang dihapus tidak dapat dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                const item = document.getElementById(itemId);
                if (item) {
                    item.remove();
                }

                Swal.fire("To do berhasil dihapus", "success");

                updateDeleteButtons();
            }
        });
    }
});

function saveTodos() {
    const form = document.querySelector("form");

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    const todos = [];

    document.querySelectorAll(".todo-item").forEach((item) => {
        const judul = item.querySelector("input[name^='judul']").value;
        const kategori = item.querySelector("select[name^='kategori']").value;

        todos.push({ judul, kategori });
    });

    const userData = {
        name: document.getElementById("name").value,
        username: document.getElementById("username").value,
        email: document.getElementById("email").value,
    };
    console.log(todos);
    console.log(userData);

    axios
        .post(
            "/api/tasks",
            {
                todos,
                user: userData,
            },
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }
        )
        .then((response) => {
            console.log("Data berhasil dikirim:", response.data);

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data berhasil di simpan",
                showConfirmButton: false,
                timer: 1500,
            });
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                if (errors) {
                    let errorMessages = "";
                    Object.keys(errors).forEach((key) => {
                        errorMessages += `${errors[key].join(", ")}\n`;
                    });

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorMessages,
                    });
                } else {
                    alert(
                        "Validation errors received but no specific errors found."
                    );
                }
            } else {
                alert("An error occurred. Please try again.");
            }
        });
}

document.getElementById("tambahTodo").addEventListener("click", addTodoItem);
document.getElementById("simpanTask").addEventListener("click", saveTodos);
