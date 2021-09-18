<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Guid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ApiGuidController extends Controller
{
    //
    public function getGuides($id = null)
    {
        return $id ? Guid::with('user')->find($id)  : DB::table('guids')->leftjoin("ratings as r", "r.guid_id", "=", "guids.id")
            ->join("users as guideUser", "guids.user_id", "=", "guideUser.id")
            ->select('guids.id', 'guids.ville', 'guids.cover_img', 'guideUser.name', 'guideUser.avatar', 'guids.prix_min', DB::raw('SUM(r.score)/COUNT(guids.id) as totalscore'))
            ->where('guids.valid', 1)
            ->groupby('guids.id', 'guids.ville', 'guids.cover_img', 'guideUser.name', 'guideUser.avatar', 'guids.description', 'guids.prix_min')->orderBy('totalscore', 'DESC')
            ->take(6)->get();
    }
    public function create(Request $request)
    {

        $user = new User;
        $guide = new Guid;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $guide->cin = $request->input('cin');
        $guide->ville = $request->input('ville');
        $guide->tel = $request->input('tel');
        $guide->adresse = $request->input('adresse');
        $guide->description = $request->input('description');
        $guide->prix_min = $request->input('prix_min');
        $user->password = Hash::make($request->input('password'));
        if ($request->hasFile('avatar') && $request->hasFile('cover_img')) {

            $path = $request->file('avatar')->store('images');
            $pathCoverImg = $request->file('cover_img')->store('images');
            $user->avatar = Storage::url($path);
            $guide->cover_img = Storage::url($pathCoverImg);
        }
        $user->save();
        $guide->user()->associate($user)->save();
        return $guide;
    }
    public function getGuideComments($id)
    {
        return  Guid::select(

            "c.content",
            "clientUser.name as clientName",
            "clientUser.avatar as clientAvatar",
            "c.created_at"
        )
            ->join("comments as c", "c.guid_id", "=", "guids.id")
            ->join("clients as cli", "cli.id", "=", "c.client_id")
            ->join("users as guideUser", "guids.user_id", "=", "guideUser.id")
            ->join("users as clientUser", "cli.user_id", "=", "clientUser.id")
            ->where("guids.id", "=", $id)->get();
    }

    public function search($key)
    {
        $guides = DB::table('guids')->leftjoin("ratings as r", "r.guid_id", "=", "guids.id")
            ->join("users as guideUser", "guids.user_id", "=", "guideUser.id")
            ->select('guids.id', 'guids.ville', 'guids.cover_img', 'guideUser.name', 'guideUser.avatar', 'guids.prix_min', DB::raw('SUM(r.score)/COUNT(guids.id) as totalscore'))
            ->where('guids.ville', '=', $key)->orWhere('guideUser.name', '=', $key)->where('guids.valid', 1)
            ->groupby('guids.id', 'guids.ville', 'guids.cover_img', 'guideUser.name', 'guideUser.avatar', 'guids.prix_min')
            ->get();
        return $guides;
    }
    public function getUnverifiedGuides()
    {
        return Guid::with('user')->where('valid', 0)->get();
    }
    ///verify 
    public function updateIsValid(Request $request)
    {
        if ($request->isMethod('patch')) {
            $id = $request->input('id');
            if (Guid::where('id', $id)->update(['valid' => 1])) {
                return response()->json(['message' => "updated successfully"]);
            }
            return response()->json(['Error' => "update error"]);
        }
    }
}
