<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

class SeanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp():void{
        parent::setUp();
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed TeacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
        $this->artisan('db:seed paeSeeder');
    }
    /**
     * A test of the list of seance sorted by date
     */
    public function testDisplaySeancesByDate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/seances');

            $seancesDate = $browser->driver->findElements(WebDriverBy::className('dateTime'));
            $sorted = true;
            for($i=0;$i<count($seancesDate)-1 && $sorted;$i++){
                if($seancesDate[$i]->getAttribute('title')>$seancesDate[$i+1]->getAttribute('title')){
                    $sorted = false;
                }
            }
            $this->assertTrue($sorted);
        });
    }
}
