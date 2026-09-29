<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メッセージの編集</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
  <div class="max-w-md mx-auto h-screen flex flex-col bg-gray-200 shadow-lg">

    <header class="bg-white px-4 py-3 flex items-center gap-3 shadow-sm">
      <a href="/chat" class="text-sm text-gray-500">← もどる</a>
      <h1 class="font-bold">メッセージの編集</h1>
    </header>

    <main class="flex-1 overflow-y-auto p-4">
      <form action="/messages/{{ $message->id }}" method="POST" class="bg-white rounded-2xl p-4 shadow-sm">
        @csrf
        @method('PATCH')
        <input type="text" name="body" value="{{ $message->body }}"
          class="w-full bg-gray-100 rounded-full px-4 py-2 mb-3">
        @error('body')
          <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
        @enderror
        <button type="submit" class="w-full bg-green-500 text-white font-bold rounded-full px-4 py-2">更新する</button>
      </form>
    </main>

  </div>
</body>
</html>
