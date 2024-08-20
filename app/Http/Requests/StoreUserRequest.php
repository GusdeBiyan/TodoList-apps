<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Validasi untuk user
            'user.name'         => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Harus berupa huruf dan spasi saja
            'user.username'     => 'required|string|alpha_dash|unique:users,username|max:255',
            'user.email'        => 'required|email|unique:users,email|max:255',

            // Validasi untuk todos
            'todos'             => 'required|array|min:1',
            'todos.*.judul'     => 'required|string|max:255',
            'todos.*.kategori'  => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'user.name.required'        => 'The name field is required.',
            'user.name.string'          => 'The name must be a string.',
            'user.name.max'             => 'The name may not be greater than 255 characters.',
            'user.name.regex'           => 'The name must not contain numbers.',
            'user.username.required'    => 'The username field is required.',
            'user.username.string'      => 'The username must be a string.',
            'user.username.alpha_dash'  => 'The username may only contain letters, numbers, dashes, and underscores.',
            'user.username.unique'      => 'The username has already been taken.',
            'user.username.max'         => 'The username may not be greater than 255 characters.',
            'user.email.required'       => 'The email field is required.',
            'user.email.email'          => 'The email must be a valid email address.',
            'user.email.unique'         => 'The email has already been taken.',
            'user.email.max'            => 'The email may not be greater than 255 characters.',
            'todos.required'            => 'The todos field is required.',
            'todos.array'               => 'The todos must be an array.',
            'todos.min'                 => 'You must add at least one todo item.',
            'todos.*.judul.required'    => 'The judul field is required for each todo item.',
            'todos.*.judul.string'      => 'The judul must be a string.',
            'todos.*.judul.max'         => 'The judul may not be greater than 255 characters.',
            'todos.*.kategori.required' => 'The kategori field is required for each todo item.',
            'todos.*.kategori.string'   => 'The kategori must be a string.',
            'todos.*.kategori.max'      => 'The kategori may not be greater than 255 characters.',
        ];
    }
}
