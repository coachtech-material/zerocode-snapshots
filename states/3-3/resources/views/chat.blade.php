<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャット</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
  <div class="max-w-md mx-auto h-screen flex flex-col bg-gray-200 shadow-lg">

    <header class="bg-white px-4 py-3 shadow-sm">
      <h1 class="font-bold text-center">チャット</h1>
    </header>

    <main class="flex-1 overflow-y-auto p-4">
      @foreach ($messages as $message)
        <div class="mb-3">
          <p class="text-xs text-gray-500 mb-1">{{ $message->name }}</p>
          <div class="bg-white rounded-2xl px-4 py-2 inline-block max-w-[75%] shadow-sm">
            <p>{{ $message->body }}</p>
          </div>
        </div>
      @endforeach
    </main>
    <footer class="bg-white p-3">
      <form action="/chat" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="name" placeholder="名前" value="{{ old('name') }}"
          class="w-24 shrink-0 bg-gray-100 rounded-full px-4 py-2">
        <input type="text" name="body" placeholder="メッセージを入力" value="{{ old('body') }}"
          class="flex-1 bg-gray-100 rounded-full px-4 py-2">
        <button type="submit" class="shrink-0 bg-green-500 text-white font-bold rounded-full px-5 py-2">送信</button>
      </form>
      @error('name')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
      @enderror
      @error('body')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
      @enderror
    </footer>

  </div>
</body>
</html>
