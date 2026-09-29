<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ルーム一覧</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
  <div class="max-w-md mx-auto h-screen flex flex-col bg-gray-200 shadow-lg">

    <header class="bg-white px-4 py-3 flex items-center justify-between shadow-sm">
      <h1 class="font-bold">ルーム一覧</h1>
      <a href="/enter" class="text-sm text-gray-500">{{ session('nickname') }}</a>
    </header>

    <main class="flex-1 overflow-y-auto p-4">
      @foreach ($rooms as $room)
        <a href="/rooms/{{ $room->id }}"
          class="block bg-white rounded-2xl px-4 py-3 shadow-sm mb-3">
          {{ $room->name }}
        </a>
      @endforeach
    </main>

  </div>
</body>
</html>
