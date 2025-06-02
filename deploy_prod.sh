#!/bin/bash

echo "===== Laravel 本番デプロイ開始 ====="

cd ~/reserve_public

# GitHubから最新コードを取得
# pullに失敗したら即終了
git pull origin main || { echo "Git Pull に失敗しました"; exit 1; }

# .env を本番用に切り替え
cp .env.public .env

# Composer（composer.phar 経由）
php ~/composer.phar install --no-dev --optimize-autoloader

# Laravelキャッシュクリア＆再生成
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# ビルド済みファイルを公開フォルダにコピー
cp -r public/build ~/www/

# index.php を復元
cp ~/index_backup.php ~/www/index.php

echo "===== 本番デプロイ完了 ====="
