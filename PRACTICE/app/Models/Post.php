<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description'];

    public $timestamps = false;

    public function insertData($data){
        return DB::table('posts')->insert($data);
    }

    public function getAllPosts()
    {
        return DB::table('posts')->get();
    }

    public function getOnePost($id)
    {
        return DB::table('posts')->find($id);
    }

    // public function getOnePost($id){
    //     return DB::table('posts')->where('id', $id)->first();
    // }
    public function updatePost($id, $data){
        return DB::table('posts')->where('id', $id)->update($data);
    }
    public function deletePost($id){
        return DB::table('posts')->where('id', $id)->delete();
    }
}

