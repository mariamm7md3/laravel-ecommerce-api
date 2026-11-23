<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;

class AddressController extends Controller
{
    use ApiResponseTrait;
    public function store (AddressRequest $request)
    {
        $data = $request->validated();
        if(!empty($data['is_main'])) {
            $request->user()->addresses()->where('is_main',true)->update(['is_main' => false]);
        }
        $address = $request->user()->addresses()->create($data);

        return $this->successResponse(
            __('messages.address.created'),
            new AddressResource($address) ,
            201
        );
    }

    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->active()->get();

        if($addresses->isEmpty())
        {
            return $this->successResponse(__('messages.address.empty'),[]);
        }

        return $this->successResponse(
            __('messages.address.fetched'),
            AddressResource::collection($addresses),
        );
    }

    public function show(Address $address)
    {
       $address = request()->user()->addresses()->find($address->id);

       if(!$address)
       {
           return $this->errorResponse(__('messages.address.not_found'),404);
       }

       return $this->successResponse(
           __('messages.address.fetched'),
           new AddressResource($address),
       );
    }

    public function update(AddressRequest $request, Address $address)
    {
        if ($address->user_id !== $request->user()->id) {
            return $this->errorResponse(__('messages.address.unauthorized'), 403);
        }
        $data = $request->validated();

        if(!empty($data['is_main'])) {
            $request->user()->addresses()->where('is_main',true)->update(['is_main' => false]);
        }

        $address->update($data);

        return $this->successResponse(
            __('messages.address.updated'),
            new AddressResource($address),
        );
    }

//    public function setMain(Request $request,Address $address)
//    {
//        if($address->user_id !== $request->user()->id) {
//            return $this->errorResponse('Unauthorized', 403);
//        }
//
//        $request->user()->addresses()->where('is_main',true)->update(['is_main' => false]);
//        $address->update(['is_main' => true]);
//        return $this->successResponse(
//            'addresses updated successfully',
//            new AddressResource($address),
//        );
//    }

    public function destroy(Address $address)
    {
        $address->delete();
        return $this->successResponse(__('messages.address.deleted'));
    }

}
