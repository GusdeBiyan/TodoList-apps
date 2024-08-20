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
use Illuminate\Container\Attributes\Log;



class TaskController extends Controller
{

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
        return new TaskResource(true, 'Data Berhasil diambil', $categories);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user.name'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'user.username' => 'required|string|alpha_dash|unique:users,username|max:255',
            'user.email'    => 'required|regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/|unique:users,email|max:255',
            'todos'         => 'required|array|min:1',
            'todos.*.judul' => 'required|string|max:255',
            'todos.*.kategori' => 'required|string|max:255',
        ], [
            'user.name.required' => 'The name field is required.',
            'user.name.string' => 'The name must be a string.',
            'user.name.max' => 'The name may not be greater than 255 characters.',
            'user.name.regex'    => 'The name must not contain numbers or special characters.',
            'user.username.required' => 'The username field is required.',
            'user.username.string' => 'The username must be a string.',
            'user.username.alpha_dash' => 'The username may only contain letters, numbers, dashes, and underscores.',
            'user.username.unique' => 'The username has already been taken.',
            'user.username.max' => 'The username may not be greater than 255 characters.',
            'user.email.required' => 'The email field is required.',
            'user.email.regex' => 'The email must be a valid email address.',
            'user.email.unique' => 'The email has already been taken.',
            'user.email.max' => 'The email may not be greater than 255 characters.',
            'todos.required' => 'The todos field is required.',
            'todos.array' => 'The todos must be an array.',
            'todos.min' => 'You must add at least one todo item.',
            'todos.*.judul.required' => 'The judul field is required for each todo item.',
            'todos.*.judul.string' => 'The judul must be a string.',
            'todos.*.judul.max' => 'The judul may not be greater than 255 characters.',
            'todos.*.kategori.required' => 'The kategori field is required for each todo item.',
            'todos.*.kategori.string' => 'The kategori must be a string.',
            'todos.*.kategori.max' => 'The kategori may not be greater than 255 characters.',
        ]);



        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $customErrors = [];

            foreach ($errors as $key => $messages) {

                $field = str_replace(['user.', 'todos.*.'], '', $key);
                $customErrors[$field] = $messages;
            }

            return response()->json([
                'status' => 'error',
                'errors' => $customErrors
            ], 422);
        }


        $userData = $request->input('user');
        $todos = $request->input('todos');


        try {
            $user = User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
            ]);

            foreach ($todos as $todo) {
                Task::create([
                    'user_id' => $user->id,
                    'category_id' => $todo['kategori'],
                    'description' => $todo['judul'],
                ]);
            }

            return new TaskResource(true, 'Data Post Berhasil Ditambahkan!', $user, $todos);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }

        return new TaskResource(true, 'Data Post Berhasil Ditambahkan!', $user, $todos);
    }
}
