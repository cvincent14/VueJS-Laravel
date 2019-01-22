<?php

namespace App\Http\Controllers;

use App\Comment;

class CommentsController extends Controller
{
    public function index($url)
    {
        $comments = Comment::where('url', base64_decode($url)) 
        ->whereNull('respond_to_id')
        ->paginate(3);

        return $comments;
    }

    public function store()
    {

        request()->validate([
            'body' => ['required'],
            'name' => ['required'],
            'url' => ['required'],
        ]);
        
        return Comment::create([
            'respond_to_id' => request('respond_to_id'),
            'name' => request('name'),
            'url' => request('url'),
            'body' => request('body'),
        ])->setRelation('children', collect());

    }
}
