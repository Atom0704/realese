<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{

    public function getBranch(Comment $comment, $id)
    {
        if(Auth::guest())
        {
            return redirect()->route('login');
        } else
        {
            $comments = $comment->getBranch($id);

            return view('branch.index', ['comments' => $comments]);
        }
    }

    public function index(Comment $comment)
    {
        if(Auth::guest())
        {
            return redirect()->route('login');
        } else
        {
            $branches = $comment->getBranches();

            return view('branches.index', ['branches' => $branches]);
        }
    }


    public function insert(Comment $comment)
    {
        $comment->insertComment($_POST['message'], $_POST['branch']);
    }

    public function edit(Comment $comment)
    {
        $comment->editComment($_POST["id"], $_POST["message"]);
    }

    public function delete(Comment $comment)
    {
        $result = $comment->deleteComment($_POST["id"]);

        return $result;
    }

    public function rating(Comment $comment)
    {
        $id = $_POST["id"];

        $rating = $_POST["rating"];

        $old_rating = $comment->getCommentRating($id);

        //dd($old_rating[0]->rating);

        if($old_rating[0]->rating > 0 && $old_rating[0]->rating_count > 0)
        {
            $new_rating = (($old_rating[0]->rating * $old_rating[0]->rating_count) + $rating) / ($old_rating[0]->rating_count + 1);
        } else
        {
            $new_rating = $rating;
        }

        $comment->editCommentRating($id, $new_rating);
    }

}
