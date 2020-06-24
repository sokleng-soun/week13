<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CategoryAPIController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Category list',
            'data' => []
        ]);
    }
}