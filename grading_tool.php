<?php
$servername = "localhost";
$username = "root";
$password = ""; // Set your MySQL password if any
$dbname = "grading_tool";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function calculateFinalGrade($grades) {
    $homeworkScores = [$grades['homework1'], $grades['homework2'], $grades['homework3'], $grades['homework4'], $grades['homework5']];
    $homeworkAverage = array_sum($homeworkScores) / count($homeworkScores) * 0.2;

    $quizScores = [$grades['quiz1'], $grades['quiz2'], $grades['quiz3'], $grades['quiz4'], $grades['quiz5']];
    sort($quizScores);
    array_shift($quizScores); // Drop the lowest quiz score
    $quizAverage = array_sum($quizScores) / count($quizScores) * 0.1;

    $midtermWeighted = $grades['midterm'] * 0.3;
    $finalProjectWeighted = $grades['final_project'] * 0.4;

    $finalGrade = round($homeworkAverage + $quizAverage + $midtermWeighted + $finalProjectWeighted);
    return $finalGrade;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $grades = [
        'homework1' => $_POST['homework1'], 'homework2' => $_POST['homework2'], 'homework3' => $_POST['homework3'],
        'homework4' => $_POST['homework4'], 'homework5' => $_POST['homework5'],
        'quiz1' => $_POST['quiz1'], 'quiz2' => $_POST['quiz2'], 'quiz3' => $_POST['quiz3'],
        'quiz4' => $_POST['quiz4'], 'quiz5' => $_POST['quiz5'],
        'midterm' => $_POST['midterm'], 'final_project' => $_POST['final_project']
    ];

    $finalGrade = calculateFinalGrade($grades);

    $sql = "INSERT INTO grades (student_id, homework1, homework2, homework3, homework4, homework5, quiz1, quiz2, quiz3, quiz4, quiz5, midterm, final_project)
            VALUES ('$student_id', '{$grades['homework1']}', '{$grades['homework2']}', '{$grades['homework3']}', '{$grades['homework4']}', '{$grades['homework5']}',
                    '{$grades['quiz1']}', '{$grades['quiz2']}', '{$grades['quiz3']}', '{$grades['quiz4']}', '{$grades['quiz5']}', '{$grades['midterm']}', '{$grades['final_project']}')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Grade recorded successfully. Final grade: " . $finalGrade;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grading Tool</title>
</head>
<body>

<h1>Enter Grades for Students</h1>
<form method="POST" action="">
    <label for="student_id">Select Student:</label>
    <select name="student_id" required>
        <?php
        $students->data_seek(0); // Reset result pointer
        while ($student = $students->fetch_assoc()) {
            echo "<option value='{$student['student_id']}'>{$student['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Homework Scores:</label><br>
    <input type="number" name="homework1" required> 
    <input type="number" name="homework2" required> 
    <input type="number" name="homework3" required> 
    <input type="number" name="homework4" required> 
    <input type="number" name="homework5" required> <br><br>

    <label>Quiz Scores:</label><br>
    <input type="number" name="quiz1" required> 
    <input type="number" name="quiz2" required> 
    <input type="number" name="quiz3" required> 
    <input type="number" name="quiz4" required> 
    <input type="number" name="quiz5" required> <br><br>

    <label>Midterm Score:</label><br>
    <input type="number" name="midterm" required><br><br>

    <label>Final Project Score:</label><br>
    <input type="number" name="final_project" required><br><br>

    <input type="submit" value="Submit Grades">
</form>

<h1>Final Grades</h1>
<table border="1">
    <tr><th>Student</th><th>Final Grade</th></tr>
    <?php
    $students->data_seek(0); // Reset result pointer
    while ($student = $students->fetch_assoc()) {
        $student_id = $student['student_id'];
        $gradeRecord = $conn->query("SELECT * FROM grades WHERE student_id=$student_id")->fetch_assoc();
        
        if ($gradeRecord) {
            $finalGrade = calculateFinalGrade($gradeRecord);
            echo "<tr><td>{$student['name']}</td><td>{$finalGrade}</td></tr>";
        } else {
            echo "<tr><td>{$student['name']}</td><td>No Grades Entered</td></tr>";
        }
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
