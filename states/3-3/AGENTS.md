# chat-app について

教材に沿って作っているチャットアプリです（Laravel・SQLite）。

## いつも守ること

- 画面は resources/views に1画面1ファイルで書く。共通のレイアウト（@extends やコンポーネント）は使わず、同じ枠でもファイルごとに html から書く
- 見た目は Tailwind CSS。head の中の `<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>` の1行で読み込む。npm と Vite は使わない。パッケージも足さない
- Laravel の標準の形で書く。表はマイグレーション、データの読み書きはモデル（app/Models）、サンプルのデータはシーダー、フォームから送られたときの処理はコントローラに書く。これらのファイルは php artisan make: でつくる
- 入力チェックの文は日本語で、コントローラの validate の中に書く
- 本物のログイン（パスワード）、リアルタイム通信（WebSocket など）、外部向けの API は作らない
- 確かめるときは、php artisan の route:list・db:table・migrate:status と php -l を使う。テストのファイルを書いたり、php -r・その場で書いた PHP・sqlite3 で動かしたりしない
- サーバー（php artisan serve）は学習者が別のターミナルで動かしている。起動も停止もしない
- この作業部屋は Codespaces のポート転送で開いている。リダイレクトの住所が正しくなるよう、bootstrap/app.php の withMiddleware に `$middleware->trustProxies(at: '*');` を入れる
