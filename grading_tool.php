<?php
include 'database.php';
include 'GradeCalculator.php';
include 'GradeStorage.php';

$conn = createDatabaseConnection();
$calculator = new GradeCalculator();
$gradeStorage = new GradeStorage($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $grades = [
        'homework1' => $_POST['homework1'], 'homework2' => $_POST['homework2'], 'homework3' => $_POST['homework3'],
        'homework4' => $_POST['homework4'], 'homework5' => $_POST['homework5'],
        'quiz1' => $_POST['quiz1'], 'quiz2' => $_POST['quiz2'], 'quiz3' => $_POST['quiz3'],
        'quiz4' => $_POST['quiz4'], 'quiz5' => $_POST['quiz5'],
        'midterm' => $_POST['midterm'], 'final_project' => $_POST['final_project']
    ];

    $gradeStorage->recordGrade($student_id, $grades);
    $finalGrade = $calculator->calculateFinalGrade($grades);
    echo "Grade recorded successfully. Final grade: " . $finalGrade;
}
?>
