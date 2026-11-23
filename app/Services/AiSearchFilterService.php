<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Industry;
use Illuminate\Support\Facades\Http;

class AiSearchFilterService
{
    public function extractFilters(string $query): array
    {
        // بنجيب أسامي الفئات والصناعات الحقيقية عشان Gemini يختار منها بس
        $categories = Category::whereHas('products')->pluck('name')->map(fn ($n) => $n['ar'] ?? '')->filter()->values();
        $industries = Industry::pluck('name')->map(fn ($n) => $n['ar'] ?? '')->filter()->values();

        $response = Http::withHeaders([
            'x-goog-api-key' => config('services.gemini.api_key'),
            'Content-Type' => 'application/json',
        ])
            ->retry(3, 2000)
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent', [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $this->buildPrompt($query, $categories, $industries)],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'responseSchema' => $this->schema(),
                ],
            ]);

        $json = $response->json();
        $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

        return json_decode($text, true) ?? [];
    }


    public function buildFilterString(array $filters): string
    {
        $filterParts = [];

        if (! empty($filters['category'])) {
            $filterParts[] = 'categories_ar = "' . $filters['category'] . '"';
        }

        if (! empty($filters['industry'])) {
            $filterParts[] = 'industry_ar = "' . $filters['industry'] . '"';
        }

        if (! empty($filters['min_price'])) {
            $filterParts[] = 'price >= ' . $filters['min_price'];
        }

        if (! empty($filters['max_price'])) {
            $filterParts[] = 'price <= ' . $filters['max_price'];
        }

        return implode(' AND ', $filterParts);
    }

    private function buildPrompt(string $query, $categories, $industries): string
    {
        return "أنت مساعد بيحوّل طلب بحث مكتوب باللغة العادية لفلاتر بحث منظمة لمتجر منتجات.

الفئات المتاحة بالظبط:       " . $categories->implode('، ') . "
الصناعات/الماركات المتاحة بالظبط:       " . $industries->implode('، ') . "

اختر الفئة أو الصناعة من القوائم دي بس، من غير ما تخترع اسم جديد. لو الطلب مفيهوش فلتر معين، سيبه فاضي (null).

طلب اليوزر: \"      {$query}\"";

    }


    private function schema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'category' => ['type' => 'string', 'nullable' => true],
                'industry' => ['type' => 'string', 'nullable' => true],
                'min_price' => ['type' => 'number', 'nullable' => true],
                'max_price' => ['type' => 'number', 'nullable' => true],
                'keywords' => ['type' => 'string', 'nullable' => true],
            ],
        ];
    }
}
