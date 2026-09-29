# zerocode-snapshots

zerocode の教材で作るチャットアプリ（`chat-app`）を、章の終わりの形に戻すコマンドです。完成コードを貼っても直らないときに、教材の早見表と困ったときのページから使います。

```bash
curl -fsSL https://raw.githubusercontent.com/coachtech-material/zerocode-snapshots/v1/sync.sh | bash -s -- <名前>
```

`<名前>` は `3-1`・`3-2`・`3-3`・`4-1`・`4-2`・`4-3`・`4-4`・`4-5`・`4-6` のどれかです。置き直す前の形は `~/zerocode-backup` に控えられます。

- `sync.sh`: 戻すコマンド本体（置き直すものと触らないものは先頭のコメント）
- `states/<名前>/`: 章の終わりの形。教材の完成コードを雛形から順に当てて書き出したもの（教材リポジトリの `build_states.py` で作る）
