<?php


namespace App\Dto;


class CountryDto {

    public static function CountryToApi($data, $key) {
        $dataPoints = [];
        foreach ($data[$key] as $entry) {
            $dataPoints[] = [['date' => $entry['date']],[
                    'cases' => [
                        'new' => $entry['new_cases'],
                        'total' => $entry['total_cases'],
                    ],
                    'deaths' => [
                        'new' => $entry['new_deaths'],
                        'total' => $entry['total_deaths'],
                    ],
                ]];
        }

        return ['country' => $key, 'data' => $dataPoints];
    }

    public static function TimelineToApi($data, $dates) {

        $dto = [];
        foreach ($dates as $date) {
            $counties = [];
            foreach ($data[$date] as $entry) {
                $counties[] = [
                    'location' => $entry['location'],
                    'cases' => [
                        'new' => $entry['new_cases'],
                        'total' => $entry['total_cases']
                    ],
                    'deaths' => [
                        'new' => $entry['new_deaths'],
                        'total' => $entry['total_deaths']
                    ]
                ];
            }

            $dto[] = ['date' => $date, 'data' => $counties];

        }

        return $dto;
    }

}
