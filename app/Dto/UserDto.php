<?php

namespace App\Dto;

use Illuminate\Http\Request;

class UserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $username,
        public readonly string $password,
        public readonly string $role,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name') ?? $request->name,
            username: $request->validated('username') ?? $request->username,
            password: $request->validated('password') ?? $request->password,
            role: $request->validated('role') ?? '3',
        );
    }
}
