let categoryOptions = [];

document.addEventListener("DOMContentLoaded", function () {
    axios
        .get("/api/categories")
        .then(function (response) {
            // Menyimpan data kategori dalam array
            categoryOptions = response.data;

            const allSelects = document.querySelectorAll(
                "select[name='kategori']"
            );

            allSelects.forEach((select) => {
                select.innerHTML = ""; // Clear existing options

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
        // Dapatkan ID item dari data atribut tombol
        const itemId = event.target
            .closest(".btn-delete")
            .getAttribute("data-id");

        // Konfirmasi penghapusan
        Swal.fire({
            title: "Are you sure?",
            text: "This item will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus item dari DOM jika konfirmasi diterima
                const item = document.getElementById(itemId);
                if (item) {
                    item.remove();
                }

                // Tampilkan pesan sukses
                Swal.fire("Deleted!", "Your item has been deleted.", "success");

                updateDeleteButtons();
            }
        });
    }
});

function saveTodos() {
    const form = document.querySelector("form");

    // Periksa apakah form valid
    if (!form.checkValidity()) {
        // Jika tidak valid, tampilkan pesan kesalahan atau berikan feedback visual
        form.reportValidity();
        return; // Hentikan eksekusi jika form tidak valid
    }
    const todos = [];

    // Mengambil data dari elemen todo-item
    document.querySelectorAll(".todo-item").forEach((item) => {
        const judul = item.querySelector("input[name^='judul']").value;
        const kategori = item.querySelector("select[name^='kategori']").value;

        todos.push({ judul, kategori });
    });

    // Mengambil data dari input user
    const userData = {
        name: document.getElementById("name").value,
        username: document.getElementById("username").value,
        email: document.getElementById("email").value,
    };
    console.log(todos);
    console.log(userData);

    // Mengirim data ke server menggunakan axios
    axios
        .post(
            "/api/tasks", // URL endpoint API
            {
                todos, // Mengirim data todos
                user: userData, // Mengirim data user
            },
            {
                headers: {
                    "Content-Type": "application/json", // Mengatur tipe konten
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"), // Menambahkan token CSRF
                },
            }
        )
        .then((response) => {
            console.log("Data berhasil dikirim:", response.data); // Menampilkan respon jika berhasil
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data berhasil di simpan",
                showConfirmButton: false,
                timer: 1500,
            });
        })
        .catch((error) => {
            // Handle error
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                if (errors) {
                    // Combine all error messages into a single string
                    let errorMessages = "";
                    Object.keys(errors).forEach((key) => {
                        errorMessages += `${errors[key].join(", ")}\n`;
                    });

                    // Display the combined error messages
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
                // Handle other errors or unexpected cases
                alert("An error occurred. Please try again.");
            }
        });
}

document.getElementById("tambahTodo").addEventListener("click", addTodoItem);
document.getElementById("simpanTask").addEventListener("click", saveTodos);
