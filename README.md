### RESERVATION_PUBLIC とは

塾や習い事用のレッスン予約システムです。
LESSON_RESERVATION リポジトリを後継になります。

## 注意

このリポジトリは就活用デモ作品です。
`database/seeders` には初期表示確認のための仮アカウントが含まれます。
本番運用では必ず削除・変更してください。

# 教室予約管理システム - 運用ルール（2025 年版）

## ✅ 開発〜本番反映フロー

| フェーズ                                                                 | 操作内容                                               |
| ------------------------------------------------------------------------ | ------------------------------------------------------ |
| 1. XAMPP 起動                                                            | 手動で MySQL と Apache を起動                          |
| 2. 開発開始                                                              | ダブルクリックで `start_dev.bat` を実行                |
| → Laravel サーバー & Vite 開発ビルドを起動                               |
| 3. ローカル動作確認                                                      | ブラウザで http://127.0.0.1:8000 を表示                |
| （`start_dev.bat` により `php artisan serve` ＋ `npm run dev` が実行済） |
| 4. 開発完了                                                              | `deploy_local.bat` を実行                              |
| → `.env.local` を `.env` にコピー + ビルド + キャッシュ再構築            |
| 5. `build/` アップロード                                                 | WinSCP で `/reserve_public/public/` + `/www/` にコピー |
| ※CSS/JS を変更したときのみ必要                                           |
| 6. GitHub へ push                                                        | `main` ブランチに push                                 |
| 7. 本番反映                                                              | WinSCP のターミナル上で `sh deploy_prod.sh` を実行     |
| → Git pull + Laravel 再構築 + build コピー                               |

---

## ✅ ディレクトリ構成（本番サーバ）

| パス                               | 説明                          |
| ---------------------------------- | ----------------------------- |
| `/home/ユーザー名/reserve_public/` | Laravel プロジェクト一式      |
| `/home/ユーザー名/www/`            | 公開用 `index.php` + `build/` |

---

## ✅ 各スクリプトの役割

### `start_dev.bat`

-   Laravel 開発サーバ (`php artisan serve`) を起動
-   Vite 開発ビルド (`npm run dev`) を起動
-   依存：`.env.local` を `.env` にコピーしてから実行

### `deploy_local.bat`

-   `.env.local` を `.env` にコピー
-   `npm run build` により Vite の本番ビルド生成
-   Laravel キャッシュ再構築 (`php artisan config:cache` 等)

### `deploy_prod.sh`

-   `git pull origin main` で GitHub から最新コードを反映
-   `.env.public` を `.env` に切り替え（`cp`）
-   `composer install --no-dev --optimize-autoloader`
-   Laravel キャッシュクリア＆再構築
-   `public/build/` を `/www/` にコピー
-   `index_backup.php` を `index.php` に復元

---

## ✅ 注意点 & 補足

-   `.env` は環境ごとに分離：
    -   `deploy_local.bat`: `copy .env.local .env`
    -   `deploy_prod.sh`: `cp .env.public .env`
-   `public/build/` は Git に含まれないため WinSCP によるアップロードが必要
-   Git push 前にローカルで必ず動作確認を行う
    -   ブランチを使ってテストするとより安全
