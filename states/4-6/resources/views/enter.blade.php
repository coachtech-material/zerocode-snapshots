<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>チャットアプリ</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
  <div class="max-w-md mx-auto h-screen flex flex-col justify-center bg-gray-200 shadow-lg p-6">

    <h1 class="text-2xl font-bold text-center mb-2">チャットアプリ</h1>
    <p class="text-sm text-gray-500 text-center mb-8">ニックネームを決めて入室しましょう</p>

    <form action="/enter" method="POST" class="bg-white rounded-2xl p-4 shadow-sm">
      @csrf
      <input type="text" name="nickname" placeholder="ニックネーム" value="{{ session('nickname') }}"
        class="w-full bg-gray-100 rounded-full px-4 py-2 mb-3">
      @error('nickname')
        <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
      @enderror
      <button type="submit" class="w-full bg-blue-500 text-white font-bold rounded-full px-4 py-2">入室する</button>
    </form>

  </div>
</body>
</html>
