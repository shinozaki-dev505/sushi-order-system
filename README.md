# 寿司注文管理システム (Sushi Order System)

店舗でのテーブル注文、厨房での注文管理、会計・売上分析、およびメニュー管理を一体化したウェブアプリケーションです。

---

##　💡概要

「寿司注文管理システム」は、顧客のリアルタイムな注文処理から厨房での調理ステータス管理、管理者の売上確認やメニューの追加・編集までをスムーズに行うためのシステムです。  
SPA（Single Page Application）ライクな快適な操作性を実現し、店舗業務の効率化を目指して開発しました。

---

##  ✨主な機能

### 1. 注文機能（顧客/ホール用）
- **テーブル別注文:** テーブル番号を指定して商品を選択・注文。
- **リアルタイムステータス:** 注文履歴や現在の提供状況の確認。

### 2. 厨房管理機能（キッチン用）
- **注文一覧表示:** 届いた注文のリアルタイム表示。
- **調理ステータス更新:** 「受付」「調理中」「提供済み」などの状態変更。

### 3. 管理者機能（バックオフィス用）
- **ダッシュボード / 売上管理:** 日別・時間帯別の注文数や売上データの集計・確認。
- **メニュー管理 (CRUD):** 寿司ネタやサイドメニューの登録・編集・削除・画像設定。

---

## ✨ 画面イメージ
- **寿司注文管理システムシステム　（顧客/ホール用）**

<img width="1208" height="945" alt="localhost_table_1" src="https://github.com/user-attachments/assets/ef53a324-1e88-42e3-b611-547cd0d994aa" />

- **寿司注文管理システムシステム　厨房管理機能（キッチン用）**
ステータス変更
<img width="500" height="500" alt="localhost_kitchen" src="https://github.com/user-attachments/assets/c2ac5b6c-6e4a-428a-a115-04c332f26b48" />
<img width="500" height="500" alt="localhost_kitchen (1)" src="https://github.com/user-attachments/assets/4d764731-5a16-49fd-8d56-3f3f525e0da4" />
<img width="500" height="500" alt="localhost_kitchen (2)" src="https://github.com/user-attachments/assets/cc4debca-75ef-48c8-b670-ae6c92a982f7" />

- **寿司注文管理システムシステム　会計画面（顧客/ホール）**
<img width="1208" height="973" alt="localhost_checkout_1" src="https://github.com/user-attachments/assets/af4b3f92-5837-4362-9743-7af68935c290" />

- **寿司注文管理システムシステム　管理者機能（バックオフィス用）　メニュー管理**
<img width="1208" height="1126" alt="localhost_admin_menus_index" src="https://github.com/user-attachments/assets/0b3567be-4c46-474e-9767-631b1daae52b" />

- **寿司注文管理システムシステム　管理者機能（バックオフィス用）　売上管理**
<img width="1208" height="1641" alt="localhost_admin_sales_index" src="https://github.com/user-attachments/assets/2364611f-3bde-47c0-b93f-ac95ec434cd0" />

- **寿司注文管理システムシステム　管理者機能（バックオフィス用）　ユーザー管理**
<img width="1226" height="911" alt="localhost_admin_users" src="https://github.com/user-attachments/assets/69005464-a2f5-420f-bcdb-def059756023" />

---

## 使用技術 (Tech Stack)

### バックエンド
- **PHP** 8.x
- **Laravel** 10.x / 11.x
- **MySQL**

### フロントエンド
- **React**
- **Inertia.js**
- **JavaScript / TypeScript**
- **Tailwind CSS**

### 開発環境・ツール
- **Docker / Laravel Sail**
- **Vite**
- **Git / GitHub**

---

## 動作環境・セットアップ手順

### 前提条件
- Docker Desktop がインストールされていること

### 1. リポジトリのクローン
```bash
git clone https://github.com/shinozaki-dev505/sushi-order-system.git
```

### 2. 環境変数の設定
```bash
cp .env.example .env
```

### 3. パッケージのインストール & アプリ起動
```bash
# Composer パッケージのインストール & Sail 起動
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v \$(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install

./vendor/bin/sail up -d
```

### 4. アプリケーションキーの生成 & マイグレーション
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 5. フロントエンドのビルド・起動
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### 6. アクセス
- **ブラウザで http://localhost にアクセスしてください。


### 開発の工夫・こだわりポイント
1. Inertia.js × React によるシームレスなUI/UX:

- **ブレードテンプレートとSPAの長所を併せ持つInertia.jsを採用し、ページ遷移のないスムーズな操作感を実現しました。

2. 役割に応じた画面設計:

- **ホール・厨房・管理者それぞれの業務フローに特化した直感的な画面設計を意識しました。

3. データベースの効率的な設計:

- **注文と注文明細、メニューの依存関係を考慮したリレーション構築とシードデータの準備を行いました。
