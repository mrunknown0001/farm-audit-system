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

class CaretakerAudit implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell, WithColumnWidths
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
    			$a['caretaker'],
    			$a['assignments'],
    			$a['total_audit'],
    			$a['total_compliance'],
    			$a['total_non_compliance'],
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
                'Caretacker',
                'assignments',
                'Total Audit',
                'Total Compliance',
                'Total Non Compliance',
            ]
        ];
    }

    // Styles
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 18]],
            3    => ['font' => ['bold' => true, 'size' => 14]],
            4    => ['font' => ['bold' => false, 'size' => 14]],
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

