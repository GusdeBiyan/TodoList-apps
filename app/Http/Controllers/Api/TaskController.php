<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Http\Requests\StoreUserRequest;

class TaskController extends Controller
{

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(StoreUserRequest  $request)
    {

        $validator = Validator::make($request->all(), [
            'user.name'     => 'required|string',
            'user.username'     => 'required|unique:users,username',
            'user.email'   => 'required|email|unique:users,email',
            'todos' => 'required',
            'todos.*.judul' => 'required',
            'todos.*.kategori' => 'required',
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $customErrors = [];

            foreach ($errors as $key => $messages) {
                // Ganti prefix 'user.' atau 'todos.*.' dengan nama field yang lebih bersih
                $field = str_replace(['user.', 'todos.*.'], '', $key);
                $customErrors[$field] = $messages;
            }

            return response()->json([
                'status' => 'error',
                'errors' => $customErrors
            ], 422);
        }

        // Mengambil data user dan todos dari request
        $userData = $request->input('user');
        $todos = $request->input('todos');

        // Menyimpan data user
        $user = User::create([
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
        ]);

        // Menyimpan todos
        foreach ($todos as $todo) {
            Task::create([
                'user_id' => $user->id,
                'category_id' => $todo['kategori'],
                'description' => $todo['judul'],

            ]);
        }



        return new TaskResource(true, 'Data Post Berhasil Ditambahkan!', $user, $todos);
    }
}
