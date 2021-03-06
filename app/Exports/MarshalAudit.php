<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Http\Controllers\GeneralController as GC;

class MarshalAudit implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell, WithColumnWidths
{
	protected $data;
    protected $title;

	// Constructor
	// parameter is the data passed to this export
    public function __construct($data, $title)
    {
        $this->data = $data;
        $this->title = $title;
    }	

    // Array
    public function array(): array
    {
    	$d = array();

    	foreach($this->data as $a) {
    		array_push($d, [
    			$a['auditor'],
    			$a['total_audit'],
    			$a['total_compliance'],
    			$a['total_verified_compliance'],
    			$a['total_non_compliance'],
    			$a['total_verified_non_compliance'],
    		]);

    	}

    	return $d;
    }

    // Heading
    public function headings(): array
    {
        return [
            [
                $this->title,
            ],
            [

            ],
            [
                'Marshal Name',
                'Total Audit',
                'Total Compliance',
                'Total Verified Compliance',
                'Total Non Compliance',
                'Total Verified Non Compliance',
            ]
        ];
    }

    // Styles
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            3    => ['font' => ['bold' => true]],
        ];
    }


    // row position
    public function startCell(): string
    {
        return 'A1';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,         
        ];
    }

}

