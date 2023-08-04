<?php

require_once 'database.php';

$db = new Database();
$db->connect("localhost", "root", "", "users");

if (isset($_POST['update'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    $fields = [
        'column1' => $_POST['column1'],
        'column2' => $_POST['column2'],
        'column3' => $_POST['column3']
    ];
    
    $db->update($table, $id, $fields);
}