<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Chat</title>
</head>
<body>
    <h1>Percakapan dengan Pengguna ID: {{ request()->route('userId') }}</h1>

    <div>
        @foreach ($thread as $message)
            <p>
                <strong>{{ $message->from_id == auth()->id() ? 'Anda' : 'Pengguna' }}:</strong> {{ $message->body }}
            </p>
        @endforeach
    </div>

    <!-- Form untuk membalas chat -->
    <form action="{{ route('chats.reply') }}" method="post">
        @csrf
        <input type="hidden" name="to_id" value="{{ request()->route('userId') }}">
        <textarea name="body" placeholder="Tulis balasan Anda"></textarea>
        <button type="submit">Kirim Balasan</button>
    </form>
</body>
</html>
