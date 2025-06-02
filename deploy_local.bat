@echo off
echo ===== Laravel ローカルデプロイ開始 =====

REM .env.local を .env にコピー
copy .env.local .env

REM npm ビルド
call npm install
call npm run build

REM Laravelキャッシュのクリア＆再生成
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear

call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

REM Laravel 開発サーバー起動
call php artisan serve

pause
echo ===== Laravel ローカルデプロイ完了 =====