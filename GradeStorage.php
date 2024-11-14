<?php
class GradeStorage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function recordGrade($student_id, $grades) {
        $sql = "INSERT INTO grades (student_id, homework1, homework2, homework3, homework4, homework5, quiz1, quiz2, quiz3, quiz4, quiz5, midterm, final_project)
                VALUES ('$student_id', '{$grades['homework1']}', '{$grades['homework2']}', '{$grades['homework3']}', '{$grades['homework4']}', '{$grades['homework5']}',
                        '{$grades['quiz1']}', '{$grades['quiz2']}', '{$grades['quiz3']}', '{$grades['quiz4']}', '{$grades['quiz5']}', '{$grades['midterm']}', '{$grades['final_project']}')";

        return $this->conn->query($sql);
    }

    public function getGradesByStudent($student_id) {
        $result = $this->conn->query("SELECT * FROM grades WHERE student_id=$student_id");
        return $result->fetch_assoc();
    }
}
?>
