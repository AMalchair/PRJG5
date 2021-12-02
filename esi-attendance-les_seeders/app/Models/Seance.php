<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class Seance extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'seance';
    protected $primaryKey = 'id';
    protected $fillable = ['date', 'local'];
    public $incrementing = true;
    public $timestamps = false;
    use HasFactory;

    /**
     * Get all the seances in the table Seance.
     */
    public static function getAll()
    {
        $seances = Seance::join('teacher', 'teacher.id', '=', 'seance.teacherId')
            ->join('course', 'course.id', '=', 'seance.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->orderBy('dateTime', 'asc')
            ->get(['group.acronym as groupId', 'teacher.last_name', 'course.title as acronym', 'seance.dateTime', 'seance.courseId', 'seance.teacherId', 'seance.id']);
        return $seances;
    }
    // Get all the seances that happens today
    public static function getAllToday()
    {
        $seances = DB::select("SELECT `group`.acronym as groupId,teacher.last_name,course.title as acronym,seance.dateTime,seance.courseId,seance.teacherId,seance.id 
                               FROM seance
                               JOIN teacher on teacher.id = seance.teacherId
                               JOIN course on course.id = seance.courseId
                               JOIN `group` on `group`.id = seance.groupId
                               WHERE DATE(dateTime) = CURRENT_DATE;");
        return $seances;
    }
    // Get all seances from a specify teacher
    public static function getAllSortedByTeacher($teacher)
    {
        $seances = DB::select("SELECT `group`.acronym as groupId,teacher.last_name,course.title as acronym,seance.dateTime,seance.courseId,seance.teacherId,seance.id FROM seance
                               JOIN teacher on teacher.id = seance.teacherId
                               JOIN course on course.id = seance.courseId
                               JOIN `group` on `group`.id = seance.groupId
                               WHERE teacher.last_name = '$teacher';");
        return $seances;
    }
    //Get all seances of a specific teacher today
    public static function getAllTodaySortedByTeacher($teacher)
    {
        $seances = DB::select("SELECT `group`.acronym as groupId,teacher.last_name,course.title as acronym,seance.dateTime,seance.courseId,seance.teacherId,seance.id FROM seance
                               JOIN teacher on teacher.id = seance.teacherId
                               JOIN course on course.id = seance.courseId
                               JOIN `group` on `group`.id = seance.groupId
                               WHERE DATE(dateTime) = CURRENT_DATE AND teacher.last_name='$teacher';");
        return $seances;
    }
    //Add a seance to the database if it doesn't already exist.
    public static function addSeance($courseId, $profId, $groupId, $date, $local)
    {
        for ($i = 0; $i < sizeof($courseId); $i++) {
            $teacher = Teacher::where('acronym', $profId[$i])->get()->first();
            $group = Group::where('acronym', $groupId[$i])->get()->first();
            $course = Course::where('title', $courseId[$i])->get()->first();
            $seanceOccurence = Seance::where([
                ['courseId', $course->id],
                ['teacherId', $teacher->id],
                ['local', $local[$i]],
                ['groupId', $group->id],
                ['dateTime', $date[$i]],
            ])->get()->first();

            if ($seanceOccurence === null) {
                $seance = new Seance();
                $seance->courseId = $course->id;
                $seance->teacherId = $teacher->id;
                $seance->groupId = $group->id;
                $seance->dateTime = $date[$i];
                $seance->local = $local[$i];
                $seance->save();
            }
        }
    }
}
