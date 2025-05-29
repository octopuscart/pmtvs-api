<?php

namespace App\Controllers\Service;

use App\Models\UserModel;
use App\Models\PositionsModel;
use App\Models\PositionCategoryModel;
use CodeIgniter\Controller;

class Members extends Controller
{
    /**
     * List all members (web page).
     */
    public function listMembers()
    {
        $userModel = new UserModel();
        $members = $userModel->orderBy('id', 'DESC')->findAll();

        return view('list_members', ['members' => $members]);
    }
    // Show update member form
    public function showUpdateMemberForm($id = 0)
    {
        $userModel = new UserModel();
        $positions = (new PositionsModel())->orderBy('display_index', 'ASC')->findAll();
        $categories = (new PositionCategoryModel())->orderBy('display_index', 'ASC')->findAll();
        $member = $userModel->find($id);
        if (!$member) {
            $member = [
                'id' => 0,
                'name' => '',
                'position_id' => '',
                'position_category_id' => '',
                'address' => '',
                'image' => ''
            ];
        }
        return view('update_member', [
            'member' => $member,
            'positions' => $positions,
            'categories' => $categories
        ]);
    }

    // Update member
    public function updateMember($id)
    {
        $userModel = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'position_id' => $this->request->getPost('position_id'),
            'position_category_id' => $this->request->getPost('position_category_id'),
            'address' => $this->request->getPost('address'),
            'image' => $this->request->getPost('image'),
        ];
        $userModel->update($id, $data);
        return redirect()->to(site_url('members/list'))->with('success', 'Member updated!');
    }
}