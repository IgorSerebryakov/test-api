seed-TaskStatus:
	docker exec -it app php artisan db:seed --class=TaskStatusSeeder

seed: seed-TaskStatus
