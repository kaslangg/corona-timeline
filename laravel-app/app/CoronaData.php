<?php

namespace App;

use App\Dto\CountryDto;
use App\Dto\WorldDto;
use Illuminate\Database\Eloquent\Model;

class CoronaData extends Model
{
    //

    public static function getAllCountriesData(): array {
        $locations = array_diff(array_unique(CoronaData::pluck('location')->toArray()), ['World']);
        $locations = array_values($locations);
        $data =  CoronaData::all('location','date', 'new_cases', 'new_deaths', 'total_cases', 'total_deaths')->groupBy('location');

        $dataDto = [];
        foreach ($locations as $location) {
            $dataDto[] = CountryDto::CountryToApi($data, $location);
        }

        return $dataDto;
    }

    public static function getWorldData(): array {
        $data =  CoronaData::all('location','date', 'new_cases', 'new_deaths', 'total_cases', 'total_deaths')->groupBy('location');

        return WorldDto::toApi($data['World']);
    }
}
