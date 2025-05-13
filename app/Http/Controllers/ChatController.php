<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all unique conversations (grouped by car and other user)
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['car', 'sender', 'receiver'])
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->car_id . '_' . ($message->sender_id === $user->id ? $message->receiver_id : $message->sender_id);
            });

        return view('chat.index', compact('conversations'));
    }

    public function show($carId, $userId)
    {
        $car = Car::findOrFail($carId);
        $otherUser = \App\Models\User::findOrFail($userId);
        $user = Auth::user();

        // Get all messages for this conversation
        $messages = Message::where('car_id', $carId)
            ->where(function($query) use ($user, $otherUser) {
                $query->where(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $otherUser->id);
                })->orWhere(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $otherUser->id)
                      ->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('car_id', $carId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.show', compact('car', 'otherUser', 'messages'));
    }

    public function store(Request $request, $carId, $userId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        Message::create([
            'car_id' => $carId,
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message
        ]);

        return redirect()->back();
    }

    public function startChat($carId)
    {
        $car = Car::findOrFail($carId);
        
        // Check if conversation already exists
        $existingMessage = Message::where('car_id', $carId)
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->first();

        if ($existingMessage) {
            $otherUserId = $existingMessage->sender_id === Auth::id() 
                ? $existingMessage->receiver_id 
                : $existingMessage->sender_id;
            return redirect()->route('chat.show', [$carId, $otherUserId]);
        }

        return view('chat.start', compact('car'));
    }
} 