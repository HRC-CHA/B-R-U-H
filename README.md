# B.R.U.H.

FuelPHPベースの植物管理Webアプリです。  
ユーザーはスポット（場所）と植物を登録し、水やり状態や成長記録を確認できます。

## アプリ概要

- **Dashboard**
  - 選択中スポットの天気・降雨情報を確認
  - 植物ごとの水やり状態を確認し、Waterボタンで更新
  - 降雨チャートの自動更新（トグル）に対応
- **Track & Manage**
  - スポット/植物の作成・編集・削除
  - 植物の成長ログ（チャート）を確認
  - Growth Analytics領域に最終更新日を表示
- **Settings / Auth**
  - ログイン/新規登録/ログアウト
  - パスワード変更、アカウント削除

## 技術スタック

- PHP 7.3
- FuelPHP 1.8
- MySQL 8.0
- ApexCharts
- Knockout.js

## 実行環境

基本的にDocker環境で実行します。

1. リポジトリをクローン
2. `docker` ディレクトリへ移動
3. `docker-compose.yml` の `MYSQL_DATABASE` を設定
4. イメージをビルド: `docker-compose build`
5. コンテナを起動: `docker-compose up -d`
6. ブラウザで `localhost` にアクセス

MySQL基本情報:

- Host: `localhost`
- Port: `3306`
- User: `root`
- Password: `root`
- Database: `MYSQL_DATABASE` に設定した名前

## 主要設定ポイント

- APIキーは `.env` ベースで管理
- アプリ設定は `fuel/app/config/weather.php` で管理
  - キャッシュTTL
  - 外部天気APIのURL
  - 降雨チャートのポーリング間隔
  - 降雨時間スロット間隔

## Update Log 

(2026-04-20)

- **Knockout.js対応**
  - Dashboardの降雨チャート領域をKnockout view modelベースに変更
  - ローディング/エラー/最終更新表示と自動更新トグルを追加
- **Configカスタマイズ**
  - `fuel/app/config/weather.php` を追加
  - 天気/降雨関連のハードコード値（URL・周期・TTL）を `Config::get` に移行
- **DBクラス使用**
  - Dashboardで植物作成からの経過日数を `\DB::select(...)` で取得してカードに表示
- **UI改善**
  - Dashboard植物カードで更新バッジ位置を調整し、経過日表示を簡潔化（`Nd`）
  - TrackカードのGrowth Analytics領域を2行（`GROWTH ANALYTICS`, `Last updated: YYYY/MM/DD`）に整理
  - Trackで1か月以上更新がない場合、`Last updated` を赤色表示
