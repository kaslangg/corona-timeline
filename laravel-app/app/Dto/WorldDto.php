<?php


namespace App\Dto;


class WorldDto {
    public static function toApi($data) {
        $array = [];

        foreach ($data as $entry) {
            $array[] = [
                'date' => $entry['date'],
                'cases' => [
                    'new' => $entry['new_cases'],
                    'total' => $entry['total_cases'],
                ],
                'deaths' => [
                    'new' => $entry['new_deaths'],
                    'total' => $entry['total_deaths'],
                ],
            ];
        }

        return $array;
    }


}
