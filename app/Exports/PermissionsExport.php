<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Spatie\Permission\Models\Permission;

class PermissionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Permission::all(); // Semua data akan dieksport
    }
}
