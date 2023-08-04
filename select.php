<?php

require_once 'database.php';

$db = new Database();
$db->connect("localhost", "root", "", "users");

if (isset($_POST['select'])) {
    $table = $_POST['table'];
    
    $data = $db->select($table);
    
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}