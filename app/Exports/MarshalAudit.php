<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Http\Controllers\GeneralController as GC;

class MarshalAudit implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
	protected $data;

	// Constructor
    public function __construct($data)
    {
    	// $logs = EmployeeLog::all();
     	$this->data = $data;
    }	

    // Array
    public function array(): array
    {
    	$d = array();

    	foreach($this->data as $a) {
    		array_push($d, [
    			$a,
    			$a,
    			$a,
    			$a,
    			$a,
    			$a,
    		]);

    	}

    	return $d;
    }

    // Heading
    public function headings(): array
    {
        return [
            'Marshal Name',
            'Total Audit',
            'Total Compliance',
            'Total Verified Compliance',
            'Total Non Compliance',
            'Total Verified Non Compliance',
        ];
    }

    // Styles
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}

