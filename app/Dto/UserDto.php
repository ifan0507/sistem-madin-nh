<?php

namespace App\Dto;

use Illuminate\Http\Request;

class UserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $username,
        public readonly ?string $password,
        public readonly string $role,
        public readonly ?string $kode_guru = null,
        public readonly ?string $qr_activation = null,
        public readonly ?string $device_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name') ?? $request->name,
            username: $request->validated('username') ?? $request->username,
            password: $request->validated('password') ?? $request->password,
            role: $request->validated('role') ?? '3',
            kode_guru: $request->validated('kode_guru') ?? $request->kode_guru,
            qr_activation: $request->validated('qr_activation') ?? $request->qr_activation,
            device_id: $request->validated('device_id') ?? $request->device_id,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'role' => $this->role,
            'kode_guru' => $this->kode_guru,
            'qr_activation' => $this->qr_activation,
            'device_id' => $this->device_id,
        ]);
    }
}
