<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Inventory([
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity']
        ]);
    }
}