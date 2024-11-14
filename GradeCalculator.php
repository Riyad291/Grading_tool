<?php
class GradeCalculator {
    public function calculateFinalGrade($grades) {
        $homeworkScores = [$grades['homework1'], $grades['homework2'], $grades['homework3'], $grades['homework4'], $grades['homework5']];
        $homeworkAverage = array_sum($homeworkScores) / count($homeworkScores) * 0.2;

        $quizScores = [$grades['quiz1'], $grades['quiz2'], $grades['quiz3'], $grades['quiz4'], $grades['quiz5']];
        sort($quizScores);
        array_shift($quizScores); // Drop the lowest quiz score
        $quizAverage = array_sum($quizScores) / count($quizScores) * 0.1;

        $midtermWeighted = $grades['midterm'] * 0.3;
        $finalProjectWeighted = $grades['final_project'] * 0.4;

        return round($homeworkAverage + $quizAverage + $midtermWeighted + $finalProjectWeighted);
    }
}
?>
