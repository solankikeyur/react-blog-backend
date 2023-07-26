<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Blog\BlogRequest;
use App\Models\Blog;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends ApiController
{
    CONST IMAGE_PATH = "blog";

    public function add(BlogRequest $request) {
        try {
            $params = $request->validated();
            $params["user_id"] = auth()->user()->id;
            if(!empty($request->file("image"))) {
                $params["image"] = $request->file("image")->store(self::IMAGE_PATH, "public");
            }
            $blog = Blog::create($params);
            return $this->getSuccessResponse(["message" => "Blog Created."]);
        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function get(Request $request) {
        try {

            $id = $request->id;
            if(empty($id)) {
                throw new Exception("No blog found.");
            }
            $blog = Blog::where("id", $id)->with("user:id,name")->first();
            if(empty($blog)) {
                throw new Exception("No blog found.");
            }
            return $this->getSuccessResponse(["blog" => $blog]);

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function delete(Request $request) {
        try {

            $id = $request->id;
            if(empty($id)) {
                throw new Exception("No blog found.");
            }
            $blog = Blog::where("id", $id)->where("user_id", auth()->user()->id)->first();
            if(empty($blog)) {
                throw new Exception("No blog found.");
            }
            $blog->delete();
            return $this->getSuccessResponse(["message" => "Blog deleted."]);

        } catch(Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function update() {
        try {

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function getUserBlogs() {
        try {

            $blogs = Blog::where("user_id", auth()->user()->id)->with("user:id,name")->get();
            return $this->getSuccessResponse(["blogs" => $blogs]);

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function getAllBlogs() {
        try {

            $blogs = Blog::with("user:id,name")->get();
            return $this->getSuccessResponse(["blogs" => $blogs]);

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }
}
