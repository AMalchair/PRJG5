<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SeanceCtrl extends Controller
{
    public function index(){
        $teachers = Teacher::getAll();
        if(isset($_GET['id'])){
        if($_GET['today']=="true") {
            if($_GET['id']=="tous"){
                $seances = Seance::getAllToday();
            } else {
                $seances= Seance::getAllTodaySortedByTeacher($_GET["id"]);
            }
        } else {
            if($_GET['id']=="tous"){
                $seances = Seance::getAll();
            } else {
                $seances= Seance::getAllSortedByTeacher($_GET["id"]);
            }
        }
    } else {
        $seances = Seance::getAll();
    }
        return view("/seances",compact("seances","teachers"));
    }
}
