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

        $MemberModel = new \App\Models\MemberModel();
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
            $MemberModel->update($id, $data);
            $message = 'Member updated successfully';
        } else {
            // Create new member
            $MemberModel->insert($data);
            $id = $MemberModel->getInsertID();
            $message = 'Member created successfully';
        }
        return $this->respond([
            'success' => true,
            'message' => $message,
            'id' => $id,
            'data' => $data
        ]);
    }

    public function membersListApi($category_position_id = 1)
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
        // Determine folder based on 'type' parameter (default: 'uploads')
        $type = $this->request->getGetPost('type'); // accepts GET or POST param
        $folder = ($type === 'post') ? 'post_uploads' : 'uploads';

        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/' . $folder, $newName);
        }

        return $this->respond([
            'success' => true,
            'image' => $newName,
            'url' => base_url($folder . '/' . $newName)
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

    public function createDailyPost()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        helper(['form', 'url']);

        $validationRule = [
            'image' => 'required',
            'description' => 'required',
            'date' => 'required|valid_date'
        ];

        if (!$this->validate($validationRule)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $model = new \App\Models\DailyPostModel();
        $id = $this->request->getPost('id');

        $data = [
            'image' => $this->request->getPost('image'),
            'description' => $this->request->getPost('description'),
            'date' => $this->request->getPost('date'),
        ];

        if ($id) {
            // Update existing post
            $model->update($id, $data);
            $message = 'Post updated successfully';
        } else {
            // Create new post
            $model->insert($data);
            $id = $model->getInsertID();
            $message = 'Post created successfully';
        }

        return $this->respond([
            'success' => true,
            'message' => $message,
            'id' => $id,
            'data' => $data
        ]);
    }

    public function listDailyPosts()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 12);

        $model = new \App\Models\DailyPostModel();

        $total = $model->countAll();
        $posts = $model
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'default', $page);

        // Add full image URL
        foreach ($posts as &$post) {
            $post['image_url'] = $post['image']
                ? base_url('post_uploads/' . $post['image'])
                : null;
        }

        return $this->respond([
            'success' => true,
            'posts' => $posts,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage)
            ]
        ]);
    }
    public function deleteMember()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->fail('Member ID is required', 400);
        }
        $MemberModel = new \App\Models\MemberModel();
        if ($MemberModel->delete($data['id'])) {
            return $this->respond(['success' => true]);
        } else {
            return $this->fail('Failed to delete member', 500);
        }
    }
}