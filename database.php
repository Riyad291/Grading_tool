<?php
function createDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = ""; // Update if you have a MySQL password
    $dbname = "grading_tool";

    return new mysqli($servername, $username, $password, $dbname);
}
?>
