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
            'image' => 'required',
        ];

        if (!$this->validate($validationRule)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $userModel = new \App\Models\UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'address' => $this->request->getPost('address'),
            'image' => $this->request->getPost('image'),
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
        $members = $userModel->orderBy('id', 'DESC')->findAll();

        return view('list_members', ['members' => $members]);
    }
    public function membersListApi()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        $userModel = new \App\Models\UserModel();
        $members = $userModel->orderBy('id', 'DESC')->findAll();
        foreach ($members as &$member) {
            $member['image_url'] = $member['image']
                ? base_url('uploads/' . $member['image'])
                : null;
        }
        return $this->respond([
            'success' => true,
            'members' => $members
        ]);
    }

    public function uploadImage()
    {
        helper(['form', 'url']);

        $validationRule = [
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

        return $this->respond([
            'success' => true,
            'image' => $newName,
            'url' => base_url('uploads/' . $newName)
        ]);
    }
}