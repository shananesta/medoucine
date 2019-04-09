<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCities()
    {
        $db = json_decode(file_get_contents(database_path('db.json')), true); 
        $cities = [];
        
        foreach($db as $entry) {
            if(!isset($cities[$entry['city']])) {
                $cities[$entry['city']] = [];
            }

            foreach($entry['practices'] as $practice) {
                if(!in_array($practice, $cities[$entry['city']])) {
                    $cities[$entry['city']][] = $practice;
                }
            }
        }

        return response()->json($cities, 200);
    }
    /**
     * Display a listing of cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPractices()
    {
        $db = json_decode(file_get_contents(database_path('db.json')), true); 
        $practices = [];
        
        foreach($db as $entry) {
            foreach($entry['practices'] as $practice) {
                if(!in_array($practice, $practices)) {
                    $practices[] = $practice;
                }
            }
        }

        return response()->json($practices, 200);
    }


    /**
     * Display a listing of therapists.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTherapists()
    {
        return file_get_contents(database_path('db.json'));
    }

}
