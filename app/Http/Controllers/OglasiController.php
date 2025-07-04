<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OglasiController extends Controller
{
    public function updateFile(Request $request)
    {
        // dd(213, $request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $tehnologije = $request->input('tehnologije', []);
        $tehnologije = json_decode($tehnologije, true);
        $data = Excel::toArray([], $file);
        array_shift($data[0]);
        
        // dd($data[0], $tehnologije);

        //filtriranje podataka
        $filteredData = array_filter($data[0], function ($row) use ($tehnologije) {
            if (empty($tehnologije)) {
                return true; // If no technologies are selected, include all rows
            }

            $rowTechnologies = explode(',', $row[4]);
            foreach ($tehnologije as $tech) {
                if (in_array($tech, $rowTechnologies)) {
                    return true; // Include row if it contains any of the selected technologies
                }   
            }
            return false; // Exclude row if it does not contain any of the selected technologies
        });

        return response()->json(array_values($filteredData));
    }
}
