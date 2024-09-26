<?php

namespace App\DTO;

class TaskDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public int $statusId,
        public int $userId
    ) {}
}
