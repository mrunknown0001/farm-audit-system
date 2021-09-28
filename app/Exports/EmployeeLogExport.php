<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Http\Controllers\GeneralController as GC;
use App\EmployeeLog;

class EmployeeLogExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
	protected $data;

	// Constructor
    public function __construct()
    {
    	$logs = EmployeeLog::all();
        $this->data = $logs->toArray();
    }	

    // Array
    public function array(): array
    {
    	$d = array();

    	foreach($this->data as $a) {
    		array_push($d, [
    			GC::getLastName($a['user_id']),
    			GC::getFirstName($a['user_id']),
    			$a['type'],
    			date('h:i:s A', strtotime($a['created_at'])),
    			date('F j, Y', strtotime($a['created_at'])),
    		]);

    	}

    	return $d;
    }

    // Heading
    public function headings(): array
    {
        return [
            'Last Name',
            'First Name',
            'Type',
            'Time',
            'Date',
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
