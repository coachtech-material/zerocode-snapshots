#!/usr/bin/env bash
# zerocode の chat-app を、教材の章の終わりの形に戻す。
# 使い方: curl -fsSL https://raw.githubusercontent.com/coachtech-material/zerocode-snapshots/v1/sync.sh | bash -s -- 3-3
#
# 置き直すもの: app/・routes/・resources/views/・database/（database.sqlite を含む）・bootstrap/app.php・
#   bootstrap/providers.php・AGENTS.md・CLAUDE.md。config/app.php は timezone の1行、composer.json は autoload だけ。
# 触らないもの: vendor/・.env・storage/・public/・composer.lock・composer.json の require。migrate は実行しない。
# AGENTS.md の「## 見た目の決まり」の欄は、いまのファイルから取り出して末尾に戻す。
# 置き直す前の形は ~/zerocode-backup/<日時>-<章>/ に控える（作業部屋の外）。
set -euo pipefail

REF="${ZEROCODE_SNAPSHOTS_REF:-v1}"
REPO="coachtech-material/zerocode-snapshots"
APP_DIR="/workspaces/zerocode/chat-app"
NAMES="3-1 3-2 3-3 4-1 4-2 4-3 4-4 4-5 4-6"
ITEMS="app routes resources/views database bootstrap/app.php bootstrap/providers.php AGENTS.md CLAUDE.md config/app.php composer.json"

stop() {
  printf '\n%s\n' "$@" >&2
  exit 1
}

# 1. chat-app があるか
if [ ! -f "$APP_DIR/artisan" ]; then
  stop "chat-app が見つかりません。プロジェクトをつくるところから進めてください。"
fi

# 2. 章の名前
STATE=""
for n in $NAMES; do
  if [ "${1:-}" = "$n" ]; then STATE="$n"; fi
done
if [ -z "$STATE" ]; then
  stop "戻す章の名前を、次のどれかで書いてください。" \
    "  $NAMES" \
    "例: curl -fsSL https://raw.githubusercontent.com/$REPO/$REF/sync.sh | bash -s -- 3-3"
fi

case "$STATE" in
  3-1) TITLE="Laravel 入門" ;;
  3-2) TITLE="データベース" ;;
  3-3) TITLE="メッセージ送信機能の開発" ;;
  4-1) TITLE="編集・削除機能の開発" ;;
  4-2) TITLE="トークルーム機能の開発" ;;
  4-3) TITLE="ニックネーム入室機能の開発" ;;
  4-4) TITLE="メッセージの出し分け機能の開発" ;;
  4-5) TITLE="自動更新とスマートフォン" ;;
  4-6) TITLE="カスタマイズ" ;;
esac
case "$STATE" in
  4-4 | 4-5 | 4-6) TIMEZONE="Asia/Tokyo" ;;
  *) TIMEZONE="UTC" ;;
esac

WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

# 3. 章の終わりの形を取り寄せる
if [ -n "${ZEROCODE_SNAPSHOTS_TARBALL:-}" ]; then
  cp "$ZEROCODE_SNAPSHOTS_TARBALL" "$WORK/snapshots.tar.gz"
elif ! curl -fsSL "https://github.com/$REPO/archive/$REF.tar.gz" -o "$WORK/snapshots.tar.gz"; then
  stop "章の終わりの形を取り寄せられませんでした。少し待ってから、もう一度同じ1行を打ってください。"
fi
tar -xzf "$WORK/snapshots.tar.gz" -C "$WORK"
SRC=""
for d in "$WORK"/*/states/"$STATE"; do
  if [ -d "$d" ]; then SRC="$d"; fi
done
if [ -z "$SRC" ]; then
  stop "章の終わりの形（$STATE）が見つかりませんでした。"
fi

cd "$APP_DIR"

# 4. いまの形を作業部屋の外に控える
BACKUP="$HOME/zerocode-backup/$(date +%Y%m%d-%H%M%S)-$STATE"
mkdir -p "$BACKUP"
for p in $ITEMS; do
  if [ -e "$p" ]; then
    mkdir -p "$BACKUP/$(dirname "$p")"
    cp -R "$p" "$BACKUP/$p"
  fi
done

# 5. 見た目の決まりの欄を取り出す
LOOK=""
if [ -f AGENTS.md ]; then
  LOOK="$(awk '/^## 見た目の決まり/ { keep = 1; print; next } keep && /^## / { keep = 0 } keep' AGENTS.md)"
fi

# 6. 置き直す（キャッシュは artisan より先に消す。消えたクラスを指したままだと artisan が起動しない）
rm -f bootstrap/cache/*.php
rm -rf app routes resources/views database
cp -R "$SRC/app" "$SRC/routes" "$SRC/database" .
mkdir -p resources
cp -R "$SRC/resources/views" resources/views
cp "$SRC/bootstrap/app.php" "$SRC/bootstrap/providers.php" bootstrap/
cp "$SRC/AGENTS.md" "$SRC/CLAUDE.md" .
if [ -f config/app.php ]; then
  sed -i "s|^\([[:space:]]*\)'timezone'[[:space:]]*=>.*|\1'timezone' => '$TIMEZONE',|" config/app.php
fi
if [ -n "$LOOK" ]; then
  printf '\n%s\n' "$LOOK" >> AGENTS.md
fi

fail() {
  printf '\n%s\n' \
    "chat-app を置き直しましたが、動くかの確かめで止まりました。" \
    "置き直す前の形は、次の場所に控えてあります。" \
    "  $BACKUP" \
    "" \
    "窓口に、次の枠の中をそのまま送ってください。" \
    "----------" \
    "戻すコマンド（$STATE）のあと、$1 で止まりました。" \
    "控え: $BACKUP" >&2
  tail -n 8 "$WORK/log" >&2
  printf '%s\n' "----------" >&2
  exit 1
}

# 7. composer.json の autoload
: > "$WORK/log"
AUTOLOAD=0
php -r '
  $now = json_decode(file_get_contents($argv[1]));
  $want = json_decode(file_get_contents($argv[2]));
  if (!is_object($now)) { fwrite(STDERR, "composer.json を読めません\n"); exit(2); }
  if (isset($now->autoload) && $now->autoload == $want->autoload) { exit(0); }
  $now->autoload = $want->autoload;
  file_put_contents($argv[1], json_encode($now, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
  exit(1);
' composer.json "$SRC/composer.json" >>"$WORK/log" 2>&1 || AUTOLOAD=$?
if [ "$AUTOLOAD" = 2 ]; then
  fail "composer.json"
elif [ "$AUTOLOAD" = 1 ]; then
  composer dump-autoload >>"$WORK/log" 2>&1 || fail "composer dump-autoload"
fi

# 8・9. キャッシュを消して、起動を確かめる
php artisan optimize:clear >>"$WORK/log" 2>&1 || fail "php artisan optimize:clear"
php artisan about >>"$WORK/log" 2>&1 || fail "php artisan about"

# 10. 結果
printf '\n%s\n' "「${TITLE}」の章の終わりの形に戻しました。" \
  "置き直す前の形は、$BACKUP に控えました。" \
  "AI を起動していたら、起動し直してください。" \
  "ブラウザで開き直してください。"
case "$STATE" in
  3-3) printf '%s\n' "チャット画面で、名前 ゆい・メッセージ 名前つきで送れました を1件送ってください。" ;;
  4-3 | 4-4 | 4-5 | 4-6) printf '%s\n' "入室していた名前は消えるので、入り直してください。" ;;
esac
printf '%s\n' "このあと保存の儀式をしておきましょう。"
