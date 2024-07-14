<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $threads = ChatMessage::where('from_id', $userId)
            ->orWhere('to_id', $userId)
            ->distinct()
            ->get(['from_id', 'to_id']);
        
            dd($threads);

        if ($threads->isEmpty()) {
            return view('chats.index')->with('message', 'Tidak ada percakapan yang tersedia.');
        }

        return view('chats.index', compact('threads'));
    }



    public function show($userId)
    {
        // Ambil detail percakapan berdasarkan ID pengguna
        $thread = ChatMessage::where(function ($query) use ($userId) {
            $query->where('from_id', auth()->id())
                ->where('to_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_id', $userId)
                ->where('to_id', auth()->id());
        })->get();

        return view('chats.show', compact('thread'));
    }

    public function reply(Request $request)
    {
        // Kirim balasan dari admin ke pengguna
        $message = new ChatMessage();
        $message->from_id = auth()->id();
        $message->to_id = $request->input('to_id');
        $message->body = $request->input('body');
        $message->save();

        // Kirim notifikasi melalui Pusher atau metode real-time lainnya
        // Misalnya, dengan event broadcasting di Laravel

        return back(); // Kembali ke halaman sebelumnya setelah membalas chat
    }
}
