<?php

namespace App\Modules\Task\DTO;

class TaskDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $status,
        public int $userId
    ) {}
}
