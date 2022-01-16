# SeichiRanking
整地鯖のランキング

## 動作環境
- PHP 7.4
- Laravel Framework 6.20
- Docker Compose

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

## リリース運用メモ
- masterブランチの更新内容は本番環境側のbash&cronで毎日本番環境に取り込むようにしています。

No License
