<?php

namespace App\Imports;

use App\Models\Discount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscountsImport implements ToModel, WithHeadingRow
{public function model(array $row)
    {
        return new Discount([
            'code' => $row['code'],
            'description' => $row['description'],
            'discount_percentage' => $row['discount_percentage'],
            'valid_from' => $row['valid_from'],
            'valid_to' => $row['valid_to'],
        ]);
    }
    
}