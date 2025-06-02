#!/bin/bash

echo "===== Laravel �{�ԃf�v���C�J�n ====="

cd ~/reserve_public

# GitHub����ŐV�R�[�h���擾
# pull�Ɏ��s�����瑦�I��
git pull origin main || { echo "Git Pull �Ɏ��s���܂���"; exit 1; }

# .env ��{�ԗp�ɐ؂�ւ�
cp .env.public .env

# Composer�icomposer.phar �o�R�j
php ~/composer.phar install --no-dev --optimize-autoloader

# Laravel�L���b�V���N���A���Đ���
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# �r���h�ς݃t�@�C�������J�t�H���_�ɃR�s�[
cp -r public/build ~/www/

# index.php �𕜌�
cp ~/index_backup.php ~/www/index.php

echo "===== �{�ԃf�v���C���� ====="
