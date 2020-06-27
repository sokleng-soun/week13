<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Post;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostAPIController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/post",
     *     summary="Get post list",
     *     tags={"Post"},
     *     description="Get post list",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="category_id",
     *          description="Filter by category_id",
     *          type="integer",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="title",
     *          description="Filter by title",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="content",
     *          description="Filter by content",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *     @SWG\Parameter(
     *          name="author",
     *          description="Filter by author",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Post list",
     *          
     *          @SWG\Schema(
     *              type="object",
     *              
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     * 
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     * 
     *                  @SWG\Property(
     *                      property="post",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Post")
     *                  ),
     *              ),
     * 
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     * 
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */
    public function index()
    {
        $posts = Post::get();

        return response()->json([
            'success' => true,
            'message' => 'Post list',
            'data' => $posts->toArray()
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/post",
     *     summary="Create new post",
     *     tags={"Post"},
     *     description="Create new post",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="category_id",
     *          description="Filter by category_id",
     *          type="integer",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="title",
     *          description="Filter by title",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="content",
     *          description="Filter by content",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *     @SWG\Parameter(
     *          name="author",
     *          description="Filter by author",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Post was stored successfully",
     *          
     *          @SWG\Schema(
     *              type="object",
     *              
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     * 
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     * 
     *                  @SWG\Property(
     *                      property="post",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Post")
     *                  ),
     *              ),
     * 
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     * 
     *     @SWG\Response(
     *          response=400,
     *          description="Missing required fields"
     *     ),
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields',
                'data' => $request->all()
            ], 400);
        }

        $apiToken = $request->bearerToken();
        $user = User::where('api_token', '=', $apiToken)->first();
        if(empty($user)){
            return response()->json([
                'success' => false,
                'message' => 'Please login first.',
                'data' => []
            ]);
        }

        $input = $request->all(); 
        $input['creator_id'] = $user->id;
        $post = Post::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Post was stored successfully',
            'data' => $post
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/post",
     *     summary="Update post",
     *     tags={"Post"},
     *     description="Update post",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="category_id",
     *          description="Filter by category_id",
     *          type="integer",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="title",
     *          description="Filter by title",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="content",
     *          description="Filter by content",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *     @SWG\Parameter(
     *          name="author",
     *          description="Filter by author",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Post was updated successfully",
     *          
     *          @SWG\Schema(
     *              type="object",
     *              
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     * 
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     * 
     *                  @SWG\Property(
     *                      property="post",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Post")
     *                  ),
     *              ),
     * 
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     * 
     *     @SWG\Response(
     *          response=400,
     *          description="Missing required fields"
     *     ),
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */
    public function update(Post $post, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields',
                'data' => $request->all()
            ], 400);
        }
        
        $post->fill($request->all());
        $post->save();
        return response()->json([
            'success' => true,
            'message' => 'Post was updated successfully',
            'data' => $post
        ]);
    }

    /**
     * @SWG\Delete(
     *     path="/post",
     *     summary="Delete post",
     *     tags={"Post"},
     *     description="Delete post",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="category_id",
     *          description="Filter by category_id",
     *          type="integer",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="title",
     *          description="Filter by title",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="content",
     *          description="Filter by content",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *     @SWG\Parameter(
     *          name="author",
     *          description="Filter by author",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Post was deleted successfully",
     *          
     *          @SWG\Schema(
     *              type="object",
     *              
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     * 
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     * 
     *                  @SWG\Property(
     *                      property="post",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Post")
     *                  ),
     *              ),
     * 
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      ),
     * 
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */
    public function delete(Post $post)
    {
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post was deleted successfully',
            'data' => []
        ]);
    } 
}