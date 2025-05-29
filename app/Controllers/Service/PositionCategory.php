<?php

namespace App\Controllers\Service;
use App\Models\PositionCategoryModel;
use App\Models\PositionModel; // Create this model for the positions table
use CodeIgniter\Controller;

class PositionCategory extends Controller
{
    protected $model;
    protected $viewTitle;
    protected $requestType;

    protected function setModel()
    {
        // Use ?type=positions or ?type=categories in the URL to switch
        $type = $this->request->getGet('type');
        if ($type === 'positions') {
            $this->viewTitle = 'Positions';
            $this->requestType = 'positions';
            $this->model = new PositionModel();
        } else {
            $this->viewTitle = 'Categories';
            $this->requestType = 'category';
            $this->model = new PositionCategoryModel();
        }
    }

    public function index()
    {
        $this->setModel();
        $categories = $this->model->orderBy('display_index', 'ASC')->findAll();
        return view(
            'position_categories',
            [
                'categories' => $categories,
                'viewtitle' => $this->viewTitle,
                'requestType' => $this->requestType,
            ]
        );
    }

    public function add()
    {
        $this->setModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'display_index' => $this->request->getPost('display_index') ?? 0,
        ];
        $this->model->insert($data);
        return redirect()->to(site_url('position-categories?type=' . ($this->request->getGet('type') ?? 'categories')));
    }

    public function updateOrder()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        $this->setModel();
        $order = $this->request->getPost('order');
        foreach ($order as $index => $id) {
            $this->model->update($id, ['display_index' => $index]);
        }
        return $this->response->setJSON(['success' => true]);
    }

    public function inlineEdit()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        $this->setModel();
        $id = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');

        if (!$id || !$field || !in_array($field, ['title', 'description'])) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Invalid request']);
        }

        $this->model->update($id, [$field => $value]);
        return $this->response->setJSON(['success' => true]);
    }
}
?>