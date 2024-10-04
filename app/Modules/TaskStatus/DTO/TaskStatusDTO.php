<?php

namespace App\Modules\TaskStatus\DTO;

class TaskStatusDTO
{
    public function __construct(
        public ?int $id,
        public string $name
    ) {}
}
