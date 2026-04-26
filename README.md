## 使用技術

<img src="https://img.shields.io/badge/-Laravel-FF2D20.svg?logo=laravel&style=plastic">
<img src="https://img.shields.io/badge/-Php-777BB4.svg?logo=php&style=plastic">
<img src="https://img.shields.io/badge/-Node.js-339933.svg?logo=node.js&style=plastic">
<img src="https://img.shields.io/badge/-JavaScript-F7DF1E.svg?logo=javascript&style=plastic">
<img src="https://img.shields.io/badge/-TailwindCSS-06B6D4?logo=tailwindcss&style=plastic">
<img src="https://img.shields.io/badge/-NGINX-269539.svg?logo=nginx&style=plastic">
<img src="https://img.shields.io/badge/-MySql-4479A1.svg?logo=mysql&style=plastic">
<img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=plastic">


# Travel Planner（旅行プラン管理アプリ）
## 概要

ユーザーが旅行プランを作成・管理・共有できるWebアプリです。
日程ごとに訪問スポットを登録し、予算や条件に応じて検索できます。
また、お気に入り機能やユーザー認証機能を備えています。

## セットアップ方法
### 前提環境
- Docker / Docker Compose がインストールされていること

---

### 手順

1. リポジトリをクローン  
git clone https://github.com/ku100na/my-app.git  
cd my-app
2. Docker起動  
   docker compose up -d
3. PHP依存関係インストール  
   docker compose exec app composer install
4. フロントエンド依存関係インストール  
   docker compose exec app npm install
5. 環境設定  
   cp .env.example .env
6. アプリキー生成  
   docker compose exec app php artisan key:generate
7. データベース作成 & マイグレーション  
   docker compose exec app php artisan migrate
8. フロントビルド  
   docker compose exec app npm run dev
   
---

### アクセス

http://localhost:8000

## 機能一覧
### メイン機能
- 旅行プランの作成・編集・削除
- 旅行プランへの写真アップロード機能
- 日程ごとにスポットを追加し、所要時間を管理
- 予算・目的地・キーワードによる検索機能
- 自分のプラン・他ユーザーのプラン・お気に入りプランの表示切替機能
- プランのお気に入り登録機能
- プランの公開・非公開設定

### 認証機能
- ユーザー登録・ログイン機能
- メールアドレス変更機能
- メール認証機能
- パスワード再設定機能
- ユーザープロフィール編集機能

## 工夫した点

- 日程ごとにスポットを管理できるよう、daysとspotsを分けたリレーション構造を設計
- ボタン操作で日程やスポットの入力欄を動的に追加できるフォームを実装し、柔軟なプラン作成を可能にした
- 所要時間を「分」で一元管理し、表示時に時間と分へ変換することでデータの扱いやすさと表示の柔軟性を両立
- 予算検索でカンマ付き入力に対応し、ユーザーの入力しやすさを向上
- 表示用と送信用のinputを分け、フォーマット表示と正確なデータ送信を両立
- 予算・キーワード検索では入力値の正規化を行い、検索精度を向上
- 画面サイズに応じてレイアウトを切り替えることで、スマートフォンでも操作しやすいUIを実装
- 自分のプラン・他ユーザーのプラン・お気に入りプランを切り替えて表示できるようにし、目的に応じたプラン閲覧を可能にした

## 今後の課題

- 旅行プランに対してコメントできる機能の追加
- プラン詳細画面のユーザー名をリンク化し、同一ユーザーの他プラン閲覧を可能にすることで、回遊性を向上させる
- 予算・キーワードに加え、日付（旅行時期）や日数による検索機能の拡張
- 1プラン1画像の仕様を改善し、複数画像の登録およびスポット単位での画像追加機能の実装
- データ量増加を考慮した検索処理の最適化（インデックス設計やクエリ改善）
- サイト管理者向けの管理機能（ユーザー・投稿の管理）の追加