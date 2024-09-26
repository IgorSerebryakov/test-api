<?php

namespace App\DTO;

class TaskStatusDTO
{
    public function __construct(
        public ?int $id,
        public string $name
    ) {}
}
