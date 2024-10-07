# Install

cp .env.example .env

docker-compose up -d --build

make seed

# Swagger

http://localhost:8876/api/documentation

# Admin-panel

http://localhost:8876/admin

Login: admin@admin.com
Pass: admin
