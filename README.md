cp .env.example .env

docker-compose up -d --build

make seed
