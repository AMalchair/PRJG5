<?php

namespace Tests\Unit;

use App\Models\Seance;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Course;
use DateTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SeanceTest extends TestCase
{
    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed teacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_getAll()
    {
        $seances = Seance::getAll();
        $sorted = true;
        for ($i = 0; $i < $seances->count() - 1 && $sorted; $i++) {
            if ($seances[$i + 1]->dateTime < $seances[$i]->dateTime) {
                $sorted = false;
            }
        }
        $this->assertTrue($sorted);
    }

    public function test_getAllToday()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $datetime->setTime(23, 59, 59, 0); //To have a correct date

        $seance = new Seance();
        $seance->courseId = 1;
        $seance->teacherId = 1;
        $seance->groupId = 1;
        $seance->dateTime = $datetime;
        $seance->local = "004";
        $seance->save();
        $seances = Seance::getAllToday();
        $this->assertTrue(count($seances) > 0);
    }

    public function test_getAllSortedByTeacher()
    {
        $firstTeacher = Teacher::first();
        $seances = Seance::getAllSortedByTeacher($firstTeacher->last_name);
        $this->assertTrue(count($seances) > 0);
    }

    public function test_getAllTodaySortedByTeacher()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $datetime->setTime(23, 59, 59, 0);
        $seance = new Seance();
        $seance->courseId = 1;
        $seance->teacherId = 1;
        $seance->groupId = 1;
        $seance->dateTime = $datetime;
        $seance->local = "004";
        $seance->save();

        $firstTeacher = Teacher::where('id', '=', 1)->get()->first();

        $seances = Seance::getAllTodaySortedByTeacher($firstTeacher->last_name);
        $this->assertTrue(count($seances) > 0);
    }
}
