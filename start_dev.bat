@echo off
echo ===== Laravel 開発モード開始 =====

REM ① Laravel プロジェクトディレクトリに移動
cd /d C:\Xampp\htdocs\予約システム\reserve_public

REM ② .env.local に切り替え
copy .env.local .env

REM ③ npm run dev を別ターミナルで起動（開発用ビルド監視）
start cmd /k "npm run dev"

REM ④ php artisan serve を別ターミナルで起動（ローカルサーバー）
start cmd /k "php artisan serve"

echo Laravel 開発モードを開始しました。
pause
