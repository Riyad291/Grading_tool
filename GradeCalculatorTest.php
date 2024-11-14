
<?php
use PHPUnit\Framework\TestCase;
require_once 'GradeCalculator.php';

class GradeCalculatorTest extends TestCase {
    public function testCalculateFinalGrade() {
        $calculator = new GradeCalculator();
        $grades = [
            'homework1' => 90, 'homework2' => 85, 'homework3' => 80,
            'homework4' => 95, 'homework5' => 100,
            'quiz1' => 80, 'quiz2' => 85, 'quiz3' => 70, 'quiz4' => 90, 'quiz5' => 88,
            'midterm' => 85, 'final_project' => 90
        ];
        $expectedGrade = 88; // Example expected result
        $this->assertEquals($expectedGrade, $calculator->calculateFinalGrade($grades));
    }
}
?>
