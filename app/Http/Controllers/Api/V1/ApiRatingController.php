<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ApiRatingController extends Controller
{
    //
    public function create(Request $request)
    {
        $rating = new Rating();
        $rating->score = $request->input('score');
        $rating->client_id = $request->input('client_id');
        $rating->guid_id = $request->input('guid_id');
        $rating->save();
        return $rating;
    }
}
