<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index($category_position_id=1): string
    {
        $db = \Config\Database::connect();
        // Assuming members table has position_id and positions table has category_id
        $builder = $db->table('members');
        $builder->select('members.*, positions.title as position_title, position_category.title as category_title');
        $builder->join('positions', 'positions.id = members.position_id', 'left');
        $builder->join('position_category', 'position_category.id = members.position_category_id', 'left');
        $builder->orderBy('positions.display_index', 'ASC');
        $builder->where('position_category.id', $category_position_id);
         $members = $builder->get()->getResultArray();
        return view('member_list', ['members' => $members]);

    }
}
