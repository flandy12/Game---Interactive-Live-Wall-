<?php

namespace App\Exports;

use App\Models\MasterMessage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonashExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0;

    public function collection()
    {
        return MasterMessage::select('name', 'message', 'institution', 'merged_image')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Message',
            'Institution',
            'Image',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,        // No
            $row->name,
            $row->message,
            $row->institution,
            env('APP_URL').'/storage/'.$row->merged_image,
        ];
    }
}
