<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;

class LoginController extends Controller
{
    public function submitForm(UserRequest $request)
    {
        return "Data berhasil divalidasi!";
    }
}