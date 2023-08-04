<?php

require_once 'database.php';

$db = new Database();
$db->connect("localhost", "root", "", "users");

if (isset($_POST['delete'])) {
    $table = $_POST['table'];
    $id = $_POST['id'];
    
    $db->delete($table, $id);
}