<?php

namespace App\Controllers\Service;

use App\Models\MemberModel;
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
        $MemberModel = new MemberModel();
        $members = $MemberModel->orderBy('id', 'DESC')->findAll();

        return view('list_members');
    }
    // Show update member form
    public function showUpdateMemberForm($id = 0)
    {
        $MemberModel = new MemberModel();
        $positions = (new PositionsModel())->orderBy('display_index', 'ASC')->findAll();
        $categories = (new PositionCategoryModel())->orderBy('display_index', 'ASC')->findAll();
        $member = $MemberModel->find($id);
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
        $MemberModel = new MemberModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'position_id' => $this->request->getPost('position_id'),
            'position_category_id' => $this->request->getPost('position_category_id'),
            'address' => $this->request->getPost('address'),
            'image' => $this->request->getPost('image'),
        ];
        $MemberModel->update($id, $data);
        return redirect()->to(site_url('members/list'))->with('success', 'Member updated!');
    }
}