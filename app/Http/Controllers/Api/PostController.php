<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\ApiStatus;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiStatus;

    public function index(): JsonResponse
    {
        $response = array();
        $response['posts'] = Post::orderby('id', 'desc')->paginate(5);
        $response['message'] = 'Post List';

        return $this->successResponse($response);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'body'  => 'required',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        $input = $validator->validated();

        DB::beginTransaction();

        try {
            $post = Post::create($input);
            DB::commit();

            $response['post'] = $post;
            $response['message'] = 'Post Saved Successfully';
            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'Post can not save properly';
            return $this->failureResponse($response);
        }
    }

    public function show(Post $post): JsonResponse
    {
        $response['post'] = $post;
        $response['message'] = 'Post View';

        return $this->successResponse($response);
    }

    public function update(Request $request, Post $post): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'body'  => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        DB::beginTransaction();

        try {
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->save();
            DB::commit();

            $response['post'] = $post;
            $response['message'] = 'Post Updated Successfully';

            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'Post can not save properly';

            return $this->failureResponse($response);
        }
    }

    public function destroy(Post $post): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            $response['message'] = 'Post Successfully Deleted';

            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'Post can not Delete properly';

            return $this->failureResponse($response);
        }
    }
}
