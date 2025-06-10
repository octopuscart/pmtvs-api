<?php

namespace App\Controllers\Service;

use App\Models\DailyPostModel;
use CodeIgniter\Controller;

class DailyPost extends Controller
{
    /**
     * List all posts (web page).
     */
    public function listPosts()
    {
        

        return view('post_list');
    }

    // Show update post form
    public function showUpdatePostForm($id = 0)
    {
        $postModel = new DailyPostModel();

        $post = $postModel->find($id);
        if (!$post) {
            $post = [
                'id' => 0,
                'description' => '',
                'date' => '',
                'image' => ''
            ];
        }
        return view('update_post', [
            'post' => $post,
        ]);
    }

}