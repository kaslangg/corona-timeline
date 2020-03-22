<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index(){
        return view('index');
    }

    public function uploadFile(Request $request){

        if ($request->input('submit') != null ){

            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array('csv');

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){

                // Check file size
                if($fileSize <= $maxFileSize){

                    // File upload location
                    $location = 'uploads';

                    // Upload file
                    $file->move($location,$filename);

                    // Import CSV to Database
                    $filepath = public_path($location. '/' .$filename);

                    // Reading file
                    $file = fopen($filepath, 'rb');

                    $importData_arr = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ',')) !== FALSE) {
                        $num = count($filedata );

                        // Skip first row (Remove below comment if you want to skip the first row)
                        if($i == 0){
                           $i++;
                           continue;
                        }
                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                        }
                        $i++;
                    }
                    fclose($file);
                    Page::emptyTable();

                    // Insert to MySQL database
                    foreach($importData_arr as $importData){

                        $insertData = array(
                            "date"=>$importData[0],
                            "location"=>$importData[1],
                            "new_cases"=>$importData[2],
                            "new_deaths"=>$importData[3],
                            "total_cases"=>$importData[4],
                            "total_deaths"=>$importData[5]);
                        Page::insertData($insertData);

                    }

                }

            }

        }

        // Redirect to index
        return redirect()->action('PagesController@index');
    }
}
