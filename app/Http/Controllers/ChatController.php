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
        \Log::info('Chat store method called', [
            'carId' => $carId,
            'userId' => $userId,
            'request_data' => $request->all(),
            'is_ajax' => $request->ajax(),
            'content_type' => $request->header('Content-Type')
        ]);

        try {
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $message = Message::create([
                'car_id' => $carId,
                'sender_id' => Auth::id(),
                'receiver_id' => $userId,
                'message' => $request->message
            ]);

            // Load relationships for the response
            $message->load(['sender', 'receiver']);

            \Log::info('Message created successfully', [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'car_id' => $carId
            ]);

            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'message' => [
                        'id' => $message->id,
                        'message' => $message->message,
                        'sender_id' => $message->sender_id,
                        'receiver_id' => $message->receiver_id,
                        'created_at' => $message->created_at->format('M d, H:i'),
                        'sender_name' => $message->sender->name,
                        'is_read' => $message->is_read
                    ]
                ];
                
                \Log::info('Chat message sent via AJAX', [
                    'message_id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'car_id' => $carId,
                    'response' => $response
                ]);
                
                return response()->json($response);
            }

            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in chat store', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error in chat store method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage()
                ], 500);
            }
            
            throw $e;
        }
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

    // New method to get new messages (for polling)
    public function getNewMessages(Request $request, $carId, $userId)
    {
        $user = Auth::user();
        $otherUser = \App\Models\User::findOrFail($userId);
        $lastMessageId = $request->get('last_message_id', 0);

        $newMessages = Message::where('car_id', $carId)
            ->where('id', '>', $lastMessageId)
            ->where(function($query) use ($user, $otherUser) {
                $query->where(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $otherUser->id);
                })->orWhere(function($q) use ($user, $otherUser) {
                    $q->where('sender_id', $otherUser->id)
                      ->where('receiver_id', $user->id);
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark received messages as read
        Message::where('car_id', $carId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $newMessages->map(function($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at->format('M d, H:i'),
                    'sender_name' => $message->sender->name,
                    'is_read' => $message->is_read
                ];
            })
        ]);
    }
} 