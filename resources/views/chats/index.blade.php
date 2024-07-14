<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Chat</title>
</head>
<body>
    <h1>Daftar Chat</h1>
    @if (isset($message))
        <p>{{ $message }}</p>
    @else
        <ul>
            @foreach ($threads as $thread)
                @php
                    $otherUserId = $thread->from_id == auth()->id() ? $thread->to_id : $thread->from_id;
                @endphp
                <li>
                    <a href="{{ route('chats.show', ['userId' => $otherUserId]) }}">
                        Percakapan dengan pengguna ID: {{ $otherUserId }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
