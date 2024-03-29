# SeichiRanking
整地鯖のランキングサイト。
**NOTE:** このプロジェクトはメンテナンスモードです。すなわち、機能の追加は行われず、バグフィックス、仕様の修正のみが提供されます。

## 動作環境
- PHP 8.1
- Laravel Framework 9
- Docker Compose
- 整地鯖開発環境のデータベース (SeichiAssistリポジトリ参照)

## 開発環境の動かし方

1. 最初だけこれをやる

```bash
$ cp .env.example .env
$ docker compose up -d
$ docker-compose exec app php artisan key:generate
$ docker compose up -d --build # .envの中身が書き換わったので明示的にビルドし直し
$ docker compose exec app php artisan migrate
```

2. 2回目以降は

```bash
$ docker compose up -d --build 
$ docker compose exec app php artisan migrate
```

3. 困ったときは

```bash
$ docker-compose exec app php artisan config:cache
$ docker-compose exec app php artisan config:clear
$ docker-compose exec app composer dump-autoload -o
$ docker compose exec app php artisan migrate
```

http://localhost/ でつながる

## 本番の動かし方

1. envがなければ開発環境と同じように作る

2. 最新のコミットをpullしてフロントエンドのビルドをする

```bash
$ git pull
$ docker-compose -f docker-compose.build.yml up
```

3. アプリケーションを立ち上げて、DBマイグレーション

```bash
$ docker pull ghcr.io/giganticminecraft/seichi-ranking:master
$ docker compose -f docker-compose.prd.yml up -d --build
$ docker compose -f docker-compose.prd.yml up exec app php artisan migrate
```

## リリース運用メモ
- ~~masterブランチの更新内容は本番環境側のbash&cronで毎日本番環境に取り込むようにしています。~~ サーバー移管に伴い自動化はTODO（将来的にはcompose-cdに寄せるかKubernetesに移し替えたい）
