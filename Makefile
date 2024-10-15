admin:
	docker exec -it app php artisan orchid:admin admin admin@admin.com admin

refresh:
	docker exec -it app php artisan migrate:fresh

seed-TaskStatuses:
	docker exec -it app php artisan db:seed --class=TaskStatusSeeder

seed-Users:
	docker exec -it app php artisan db:seed --class=UserSeeder

seed-Tasks:
	docker exec -it app php artisan db:seed --class=TaskSeeder

seed: refresh seed-TaskStatuses seed-Users seed-Tasks admin

config-clear:
	docker exec -it app php artisan config:clear

test:
	docker exec -it app composer test
