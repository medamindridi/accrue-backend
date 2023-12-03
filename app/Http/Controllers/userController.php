<?php

namespace App\Http\Controllers;
use App\User;
use App\Xp;
use App\Stat;
use App\Achievement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function getUsers(){
        $users = User::with(["achievements","xps","stats"])->get();

        return response()->json($users);
    }
    public function adduser(){
        $data = request()->all();
        $user = new User;
        $user->Name = $data["name"];
        $user->Dept = $data["dept"];
        $user->Post = $data["post"];
        $user->joinedAt = $data["joinedat"];
        $user->save();
        return response()->json($user);
    }
    public function addstat(){
        $data = request()->all();
        $stat = new Stat;
        $stat->user_id = $data["user_id"];
        $stat->Punctuallity = $data["punctuallity"];
        $stat->DeadLines = $data["deadlines"];
        $stat->Absence = $data["absence"];
        $stat->QualityWork = $data["quality"];
        $stat->Respect = $data["respect"];
        $stat->TeamSpirit = $data["teamspirit"];
        $stat->save();

    }
    public function addachievement(){
        $data = request()->all();
        $achievement = new Achievement;
        $achievement->type = $data["type"];
        $achievement->user_id = $data["user_id"];

    }
    public function getUser($id){
        $response = new \stdClass();

        $user = User::find($id);
        $achievements = $user->achievements;
        $response->user = $user;
        $response->xps = $user->xps->sum("Amount");
        return response()->json($response);
    }
    public function addXp(){
        $data = request()->all();
        $xp = new Xp;
        $xp->user_id = $data["user_id"];
        $xp->Category = $data["category"];
        $xp->Amount = $data["amount"];
        $xp->save();
        if($data["amount"]==1000){
            $achievement = Achievement::where("user_id",$data["user_id"])->where("type","xp");
            if(!empty($achievement)){
                $achievement = new Achievement;
                $achievement->user_id = $data["user_id"];
                $achievement->type="xp";
                $achievement->save();
            }
        }
        return response()->json($xp);
    }
    public function departements(){
        $departments = DB::select("SELECT
        users.Dept,
        SUM(Amount) AS XP,
        COUNT(stats.id) AS TotalStats,
        AVG(stats.Punctuallity) AS AvgPunctuality,
        AVG(stats.Deadlines) AS AvgDeadlines,
        AVG(stats.Absence) AS AvgAbsence,
        AVG(stats.QualityWork) AS AvgQualityWork,
        AVG(stats.Respect) AS AvgRespect,
        AVG(stats.TeamSpirit) AS AvgTeamSpirit
    FROM
        users
    JOIN stats ON users.id = stats.user_id
    JOIN achievements ON users.id = achievements.user_id
    JOIN xps ON xps.user_id = users.id
    GROUP BY
        users.Dept;");
        return response()->json($departments);
    }


}
