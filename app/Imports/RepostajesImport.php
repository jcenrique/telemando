<?php

namespace App\Imports;

use App\Models\Kilometraje;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RepostajesImport implements ToCollection
{
    
    public function collection(Collection $rows)
    {

        dd($rows);
        // foreach ($rows as $row) 
        // {
        //     User::create([
        //         'name' => $row[0],
        //     ]);
        // }
    }
    
	
}
