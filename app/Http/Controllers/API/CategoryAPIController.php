<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;

class CategoryAPIController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/categories",
     *     summary="Get category list",
     *     tags={"Category"},
     *     description="Get category list",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="name",
     *          description="Filter by category name",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="Category list",
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
     *                      property="category",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Category")
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
        $categories = Category::get();

        return response()->json([
            'success' => true,
            'message' => 'Category list',
            'data' => $categories->toArray()
        ]);
    }

     /**
     * @SWG\Post(
     *     path="/categories",
     *     summary="Create new category",
     *     tags={"Category"},
     *     description="Create new category",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="name",
     *          description="name",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="Category was stored successfully",
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
     *                      property="category",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Category")
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
     * 
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:35'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields',
                'data' => []
            ], 400);
        }

        $category = Category::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Category was stored successfully',
            'data' => $category
        ]);
    }

     /**
     * @SWG\Put(
     *     path="/categories",
     *     summary="Update category",
     *     tags={"Category"},
     *     description="Update category",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="name",
     *          description="name",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="Category was updated successfully",
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
     *                      property="category",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Category")
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
     * 
     *     @SWG\Response(
     *          response=500,
     *          description="Server Error"
     *     )
     * )
     */

    public function update(Category $category, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:35'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields',
                'data' => []
            ]);
        }
        
        $category->fill($request->all());
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'Category was updated successfully',
            'data' => $category
        ], 400);
    }

    /**
     * @SWG\Delete(
     *     path="/categories",
     *     summary="Delete category",
     *     tags={"Category"},
     *     description="Delete category",
     *     produces={"application/json"},
     * 
     *     @SWG\Parameter(
     *          name="name",
     *          description="name",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      
     *      @SWG\Response(
     *          response=200,
     *          description="Category was deleted successfully",
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
     *                      property="category",
     *                      type="array",
     *                      
     *                      @SWG\Items(ref="#/definitions/Category")
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

    public function delete(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category was deleted successfully',
            'data' => []
        ]);
    } 

}