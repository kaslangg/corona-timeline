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

            $fileDownload = file_get_contents('https://covid.ourworldindata.org/data/ecdc/full_data.csv');


            // File upload location
            $location = 'uploads';

            // Upload file
            file_put_contents('./' . $location . '/covid_data.csv', $fileDownload);

            // Import CSV to Database
            $filepath = public_path($location . '/covid_data.csv');

            // Reading file
            $file = fopen($filepath, 'rb');

            $importData_arr = array();
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ',')) !== FALSE) {
                $num = count($filedata);

                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                }
                $i++;
            }
            fclose($file);
            Page::emptyTable();

            // Insert to MySQL database
            foreach ($importData_arr as $importData) {

                $insertData = array(
                    "date" => $importData[0],
                    "location" => $importData[1],
                    "new_cases" => $importData[2],
                    "new_deaths" => $importData[3],
                    "total_cases" => $importData[4],
                    "total_deaths" => $importData[5]
                );
                Page::insertData($insertData);

            }

        // Redirect to index
        return redirect()->action('PagesController@index');
    }
}
