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
        $data = Excel::toArray([], $file);
        array_shift($data[0]);
        
        return response()->json($data);
    }
}
