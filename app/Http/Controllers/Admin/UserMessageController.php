<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Mail\MessageReplyMail;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = UserMessage::query()
            ->with('user')
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate($request->query('per_page',10));

        return view('messages.index', compact('messages') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(userMessage $message)
    {
        if($message->status === MessageStatus::Unread )
        {
            $message->update([
                'status' => 'read'
            ]);
        }
        $message->load('user');
        return view('messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reply(Request $request, UserMessage $message)
    {
        $validated = $request->validate([
            'reply_body' => 'required|string',
        ]);

        Mail::to($message->user->email)->send(new MessageReplyMail($message, $validated['reply_body']));

        $message->update(['status' => 'replied']);

        return redirect()
            ->route('messages.show', $message)
            ->with('success', 'Reply sent successfully.');
    }
}
