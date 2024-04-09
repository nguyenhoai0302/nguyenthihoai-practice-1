<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

/**
 * @OA\Post(
 *     path="/api/posts",
 *     summary="Create a new post",
 *     description="Create a new post with the provided title and description",
 *     tags={"Post"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description"},
 *             @OA\Property(property="title", type="string", example="New Post Title"),
 *             @OA\Property(property="description", type="string", example="This is a new post description")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *     )
 * )
 */

class PostController extends Controller
{
    private $posts;

    public function __construct()
    {
        $this->posts = new Post();
    }


    public function index()
    {
        return $this->posts->getAllPosts();
    }


    public function swagger(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post = Post::create($validatedData);
        return response()->json($post, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Kiểm tra xem trường 'title' có tồn tại trong yêu cầu hay không
        if (!$request->has('title')) {
            return response()->json(['error' => 'Trường title không được gửi kèm'], 400);
        }

        // Lấy dữ liệu từ yêu cầu
        $dataInsert = [
            'title' => $request->title,
            'description' => $request->description
        ];

        // Thêm dữ liệu vào cơ sở dữ liệu
        $insert = $this->posts->insertData($dataInsert);

        // Kiểm tra kết quả thêm dữ liệu
        if ($insert) {
            return response()->json("success", 200);
        } else {
            return response()->json(['error' => 'Đã xảy ra lỗi khi thêm dữ liệu'], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->posts->getOnePost($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'title' => $request->title,
            'description' => $request->description
        ];
        $data = $this->posts->updatePost($id, $dataUpdate);
        if ($data) {
            return response()->json('sucess', 200);
        } else {
            return response()->json(['message' => 'Cannot update'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->posts->deletePost($id);
        if ($data) {
            return response()->json('sucess', 200);
        } else {
            return response()->json(['message' => 'Cannot delete'], 404);
        }
    }
}
