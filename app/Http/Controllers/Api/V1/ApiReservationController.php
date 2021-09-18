<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiReservationController extends Controller
{
    //
    public function getReservation($guide_id)
    {
        $reservations = DB::table('reservations')
            ->join("clients as c", "reservations.client_id", "=", "c.id")
            ->join("users as user", "c.user_id", "=", "user.id")
            ->select('reservations.id', 'reservations.date_res', 'user.name', 'user.avatar', 'user.email')
            ->where('reservations.guid_id', $guide_id)->where('reservations.is_accept', 0)
            ->get();
        return $reservations;
    }
    public function create(Request $request)
    {
        $reservation = new Reservation();
        $dt = new DateTime();
        $reservation->date_res = $dt->format('Y-m-d');
        $reservation->client_id = $request->input('client_id');
        $reservation->guid_id = $request->input('guid_id');
        $reservation->save();
        return $reservation;
    }
    public function updateIsAccept(Request $request)
    {
        if ($request->isMethod('patch')) {
            $id = $request->input('id');
            if (Reservation::where('id', $id)->update(['is_accept' => 1])) {
                return response()->json(['message' => "updated successfully"]);
            }
            return response()->json(['Error' => "update error"]);
        }
    }
    public function getCustomerReservation($clinet_id)
    {
        $reservations = DB::table('reservations')
            ->join("clients as c", "reservations.client_id", "=", "c.id")
            ->join("guids as g", "reservations.guid_id", "=", "g.id")
            ->join("users as u", "u.id", "=", "g.user_id")
            ->select('reservations.id', 'reservations.date_res', 'u.name', 'u.avatar', 'u.email', 'reservations.is_accept')
            ->where('c.id', $clinet_id)
            ->get();
        return $reservations;
    }
    public function getReservationByClient($clinet_id, $guid_id)
    {
        return  Reservation::where('client_id', $clinet_id)->where('guid_id', $guid_id)->where('is_accept', 1)->first();
    }
}
