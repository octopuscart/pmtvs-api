<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    public function createMember()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        helper(['form', 'url']);

        $validationRule = [
            'name' => 'required',
            'position_id' => 'required',
            'position_category_id' => 'required',
            'address' => 'required',
            'image' => 'required',
        ];

        if (!$this->validate($validationRule)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $userModel = new \App\Models\UserModel();
        $id = $this->request->getPost('id');

        $data = [
            'name' => $this->request->getPost('name'),
            'position_id' => $this->request->getPost('position_id'),
            'position_category_id' => $this->request->getPost('position_category_id'),
            'address' => $this->request->getPost('address'),
            'image' => $this->request->getPost('image'),
        ];

        if ($id) {
            // Update existing member
            $userModel->update($id, $data);
            $message = 'Member updated successfully';
        } else {
            // Create new member
            $userModel->insert($data);
            $id = $userModel->getInsertID();
            $message = 'Member created successfully';
        }
        return $this->respond([
            'success' => true,
            'message' => $message,
            'id' => $id,
            'data' => $data
        ]);
    }

    public function membersListApi($category_position_id=1)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        $db = \Config\Database::connect();
        // Assuming members table has position_id and positions table has category_id
        $builder = $db->table('members');
        $builder->select('members.*, positions.title as position_title, position_category.title as category_title');
        $builder->join('positions', 'positions.id = members.position_id', 'left');
        $builder->join('position_category', 'position_category.id = members.position_category_id', 'left');
               $builder->orderBy('positions.display_index', 'ASC');
        $builder->where('position_category.id', $category_position_id);
        $members = $builder->get()->getResultArray();

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
    public function getPositions()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $positions = (new \App\Models\PositionsModel())->orderBy('display_index', 'ASC')->findAll();
        return $this->respond([
            'success' => true,
            'positions' => $positions
        ]);
    }

    public function getPositionCategories()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $categories = (new \App\Models\PositionCategoryModel())->orderBy('display_index', 'ASC')->findAll();
        return $this->respond([
            'success' => true,
            'categories' => $categories
        ]);
    }
}