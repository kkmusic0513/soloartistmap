# 🎵 Solo Artist Map

**Solo Artist Map** は、ソロアーティスト活動を支援するための Web アプリケーションです。  
Laravel 12 をベースに構築され、Gmail API 連携などの自動メール送信機能を備えています。

---

## 🚀 開発環境

- **Framework:** Laravel 12.x  
- **PHP:** 8.3 以上  
- **Database:** MySQL 8.x  
- **Mail:** Gmail API  
- **Node.js:** 18.x 以上（ビルド・フロントエンド用）

---

## ⚙️ 初期設定手順

1. リポジトリをクローン

   ```bash
   git clone https://github.com/kkmusic0513/soloartistmap.git
   cd soloartistmap
.env ファイルを作成

bash
コードをコピーする
cp .env.example .env
アプリケーションキーを生成

bash
コードをコピーする
php artisan key:generate
依存パッケージをインストール

bash
コードをコピーする
composer install
npm install
Gmail API 用の認証設定

Google Cloud Console にて「OAuth 2.0 クライアントID」を作成し、
client_secret.json をプロジェクト直下に配置します。

.env に必要な情報（GOOGLE_CLIENT_ID など）を追加します。

開発サーバーを起動

bash
コードをコピーする
php artisan serve
💌 Gmail API 連携について
このアプリでは、Gmail API を使用して自動メール送信を行います。
Laravel の Google_Client を利用し、OAuth 2.0 認証を実装済みです。

初回認証時にトークンを生成し、storage/app/google/token.json に保存します。

トークンが失効した場合は自動的にリフレッシュされます。

📁 ディレクトリ構成（主要部）
コードをコピーする
soloartistmap/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── GmailController.php
│   └── Models/
├── resources/
│   └── views/
│       └── ...
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── google/
│           └── token.json
├── .env.example
├── composer.json
└── README.md
🧠 今後の予定
ユーザー認証機能（アーティスト登録）

イベント・現場カレンダー機能

メール通知の自動スケジュール化（Gmail API活用）

📝 ライセンス
このプロジェクトは MIT License のもとで公開されています。
