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
$ docker-compose exec web01 php artisan key:generate
$ docker cp seichiranking-web01-1:/var/www/html/.env .
$ docker compose exec web01 php artisan migrate
```

2. 2回目以降は

```
$ docker compose up -d
$ docker compose exec web01 php artisan migrate
```

http://localhost/ でつながる

## リリース運用メモ
- masterブランチの更新内容は本番環境側のbash&cronで毎日本番環境に取り込むようにしています。

No License
