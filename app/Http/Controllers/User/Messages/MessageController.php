<?php

namespace App\Http\Controllers\User\Messages;

use App\Models\Message;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function index(string $id, string $messagable)
    {
        $namespace = 'App\\Models\\'; 
        $messagableClassName = $namespace . $messagable; 
        $messagable = ucfirst($messagableClassName);
        if (class_exists($messagable)) {
            $messages = $messagable::findOrFail($id)->messages()->latest()->filter()->paginate(15);
            return view('user.messages.index', compact('messages'));
        }
        abort(404);
    }
    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return view('user.messages.show', compact('message'));
    }
}
