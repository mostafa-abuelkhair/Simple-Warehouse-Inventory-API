<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateWarehouseDto;
use App\DTO\UpdateWarehouseDto;
use App\Models\Warehouse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WarehouseService
{
    public function getAll(): LengthAwarePaginator
    {
        return Warehouse::paginate(15);
    }

    public function show(Warehouse $warehouse): Warehouse
    {
        return $warehouse;
    }

    public function create(CreateWarehouseDto $dto): Warehouse
    {
        return Warehouse::create($dto->toArray());
    }

    public function update(Warehouse $warehouse, UpdateWarehouseDto $dto): Warehouse
    {
        $warehouse->update($dto->toArray());

        return $warehouse->fresh();
    }

    public function delete(Warehouse $warehouse): bool
    {
        return $warehouse->delete();
    }
}
