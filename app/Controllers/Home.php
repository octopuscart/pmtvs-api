<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $userModel = new \App\Models\UserModel();
        $members = $userModel->orderBy('id', 'DESC')->findAll();
        return view('member_list', ['members' => $members]);

    }
}
