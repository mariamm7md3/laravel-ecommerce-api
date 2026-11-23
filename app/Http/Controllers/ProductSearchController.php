<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\AiSearchFilterService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    use ApiResponseTrait;

    // semantic filter
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2']);

        $products = Product::search($request->q)
            ->options([
                // send it to meili search
                // hybrid -> 2 type of search -> full-text , semantic
                'hybrid' => [
                // الدرجة النهائية = (درجة البحث النصي × (1 - semanticRatio)) + (درجة البحث الدلالي × semanticRatio)
                    'semanticRatio' => 0.5,
                    'embedder'=> 'gemini',
                ],
            ])
            ->get();

        return $this->successResponse('success search with ai' , $products , 200);

    }


    // ai assisted natural lang
    public function searchNaturalLang(Request $request, AiSearchFilterService $aiService)
    {
        $request->validate(['q' => 'required|string|min:2']);

        $filters = $aiService->extractFilters($request->q);
        $filterString = $aiService->buildFilterString($filters);

        $products = Product::search($filters['keywords'] ?? $request->q)
            ->options([
                'hybrid' => [
                    'semanticRatio' => 0.5,
                    'embedder' => 'geminin',
                ],
                'filter' => $filterString,
            ])
            ->get();

        return $this->successResponse('success search with ai', $products, 200);
    }

}
