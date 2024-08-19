<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('/assets/sweet-alert/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/assets/sweet-alert/sweetalert2.min.css') }}">
</head>

<body>
    <div class="container">

        <header class="header">
            <div class="logo">
                <img src="/assets/img/logo.png" alt="Logo">
            </div>
        </header>

        <form id="form">
            <section class="user-details">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" name="name" type="text" placeholder="Name"
                        required>

                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" name="username" type="text" placeholder="Username"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="text" placeholder="Email"
                        required>
                </div>
            </section>

            <section class="todo-section">
                <div class="todo-header">
                    <h2>To Do List</h2>
                    <button id="tambahTodo" type="button">
                        <span>+</span> Tambah To Do</button>
                </div>
                <div id="todo" class="todo-body">
                    <div class="todo-item" id="todo1">
                        <div class="form-group judul-input">
                            <label for="judul-todo1">Judul To Do</label>
                            <input class="form-control" type="text" name="judultodo1" id="judul-todo1"
                                placeholder="Contoh : Perbaikan api master" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori-todo1">Kategori</label>
                            <select class="form-select" name="kategori" id="kategori-todo1" required>
                            </select>
                        </div>
                        <button class="btn-delete" type="button" data-id="todo1">
                            <img src="/assets/icon/ic_trash.png" alt="">
                        </button>
                    </div>

                </div>

                <div class="btn-simpan">

                    <button class="btn-simpan" type="button" id="simpanTask">SIMPAN</button>
                </div>
            </section>
        </form>




    </div>

    <script src="/assets/js/script.js"></script>
</body>

</html>
