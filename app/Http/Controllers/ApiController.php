<?php

namespace App\Http\Controllers;

use App\ApiServices\ApiService;
use App\Http\Resources\EntityResource;
use App\Models\Category;
use App\Models\Entity;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    // Método para consultar la API y guardar las entradas
    public function storeEntries(): JsonResponse
    {
        $result = $this->apiService->getEntries();

        return response()->json($result);
    }

    // Método para devolver las entradas guardadas
    public function getEntitiesByCategory($category): JsonResponse
    {

        $category = Category::where('category', ucfirst($category))->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $entities = Entity::with('category')
            ->where('category_id', $category->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => EntityResource::collection($entities),
        ]);
    }

}
