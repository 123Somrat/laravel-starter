<?php

namespace App\Http\Controllers\api;

use App\Http\Traits\ApiStatus;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiStatus;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index() {
        $response=array();
        $response['posts'] = Post::orderby('id', 'desc')->paginate(5); //show only 5 items at a time in descending order
        $response['message'] = 'Post List';
        return $this->successResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title'=>'required|max:100',
            'body' =>'required',
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
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'Post can not save properly';
            return $this->failureResponse($response);
        }
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        $response['post'] = $post;
        $response['message'] = 'Post View';
        return $this->successResponse($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $post = Post::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'=>'required|max:100',
            'body'=>'required',
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
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'Post can not save properly';
            return $this->failureResponse($response);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::findOrFail($id);
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            $response['message'] = 'Post Successfully Deleted';
            return $this->successResponse($response);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'Post can not Delete properly';
            return $this->failureResponse($response);
        }

    }
}
