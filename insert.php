<?php

require_once 'database.php';

$db = new Database();
$db->connect("localhost", "root", "", "users");

if (isset($_POST['insert'])) {
    $table = $_POST['table'];
    $columns = [
        'column1' => $_POST['column1'],
        'column2' => $_POST['column2'],
        'column3' => $_POST['column3']
    ];
    
    $db->insert($table, $columns);
}