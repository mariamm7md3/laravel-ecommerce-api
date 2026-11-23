<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\AppInfo;
use App\Models\UserMessage;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Event\MessageEvent;

class ContactController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){

        $request->validate([
            'title' => 'required|string|max:100',
            'body'  => 'required|string',
        ]);

        $userMessage = UserMessage::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        event(new MessageSent($userMessage));

        return $this->successResponse(__('messages.contact.sent'),null,201);
    }

    public function show()
    {
        $contact = AppInfo::first();

        if(!$contact){
            return $this->errorResponse(__('messages.contact.not_found'),404);
        }

        return $this->successResponse(__('messages.contact.info'),$contact);
    }
}
