<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeliveryTimeResource;
use App\Models\Branch;
use App\Models\DeliveryTime;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DeliveryTimeController extends Controller
{
    use ApiResponseTrait;
    public function index(Branch $branch)
    {
        $times = DeliveryTime::active()->with('branch')->get();

        return $this->successResponse(
            __('messages.delivery_time.index'),
            DeliveryTimeResource::collection($times)
        );
    }
}
