<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    public function createMember()
    {
        helper(['form', 'url']);

        $validationRule = [
            'name' => 'required',
            'position' => 'required',
            'address' => 'required',
            'image' => [
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/gif]|max_size[image,4096]',
                'errors' => []
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $img = $this->request->getFile('image');
        $newName = null;
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads', $newName);
        }

        $userModel = new \App\Models\UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'address' => $this->request->getPost('address'),
            'image' => $newName
        ];
        $userModel->insert($data);

        return $this->respond([
            'success' => true,
            'data' => $data
        ]);
    }

    public function showCreateMemberForm()
    {
        return view('create_member');
    }

    public function listMembers()
    {
        $userModel = new \App\Models\UserModel();
        $members = $userModel->findAll();

        return view('list_members', ['members' => $members]);
    }
}