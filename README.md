# Install

cp .env.example .env

docker-compose up -d --build

make seed 

# Tests

make test

# Swagger

http://localhost:8876/api/documentation

# Admin-panel

http://localhost:8876/admin

Login: admin@admin.com
Pass: admin

# Graylog

http://localhost:9000

Login: admin
Pass: admin

System > Inputs > Select Input ---> GELF UDP > Launch new input

## Test GrayLog

http://localhost:8876/test-logging
