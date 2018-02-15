<?php

namespace App\Models;

use Faker\Provider\zh_CN\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\Table;
use Carbon\Carbon;
use Auth;

class Comment extends Model
{

    public function getCommentRating($id)
    {
        $rating = DB::table('comments')

            ->select('comments.rating', 'comments.rating_count')

            ->where('id', $id)

            ->get();

        return $rating;
    }

    public function insertComment($text, $branch)
    {

            $answer = 1;


        DB::table('comments')->insert(
            ['description' => $text, 'branch' => $branch, 'answer' => $answer, 'user_id' => Auth::user()->id, 'rating' => 1, 'rating_count' => 0, 'created_at' =>  Carbon::now(), 'updated_at' => Carbon::now()]
        );
    }

    public function editCommentRating($id, $rating)
    {
        DB::table('comments')

            ->where('id', $id)

            ->update(array('rating' => $rating));
    }

    public function getBranch($id)
    {
        $comments = DB::table('comments')

            ->join('users', 'users.id', '=', 'comments.user_id')

            ->select('comments.*', 'users.name')

            ->where('comments.branch', $id)

            ->get();


        return $comments;
    }

    public function editComment($id, $message)
    {
        DB::table('comments')

            ->where('id', $id)

            ->update(array('description' => $message));
    }

    public function getBranches()
    {
        $branches = DB::table('comments')

            ->select('comments.*')

            ->where('comments.answer', 0)

            ->get();


        return $branches;
    }

    public function deleteComment($id)
    {

        $main = DB::table('comments')

            ->join('users', 'users.id', '=', 'comments.user_id')

            ->select('comments.answer')

            ->where('comments.id', $id)

            ->get();

         if($main[0]->answer == 0)
         {
             $message = "Комментарий удален";

             DB::table('comments')

                 ->where('id', $id)

                 ->update(array('description' => $message));

             return $message;
         }
         else
         {
             DB::table('comments')

                 ->where('id', '=', $id)

                 ->delete();

             return "delete";
         }
    }
}
