<?php

namespace App\Http\Controllers;

use App\Imports\TestImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class TestImportController extends Controller
{
    public function import(){
        return view('test-import');
    }

    public function toPdf(Request $request){
        // data is request['data'] file
        ini_set('max_execution_time', '0');
        ini_set("pcre.backtrack_limit", "9999999999999999");
        $data = $request->file('data');
        $excel_data = Excel::toArray(new TestImport, $data);
        $excel_data = array_slice($excel_data[0], 8002);
        $pdf = \PDF::loadView('pdf.test-pdf', ['data' => $excel_data]);
        $pdf->mpdf->autoScriptToLang = true;
        $pdf->mpdf->autoLangToFont = true;
        return $pdf->download("all.pdf");
        return view('pdf.test-pdf',["data"=>$excel_data]);
    }
}
