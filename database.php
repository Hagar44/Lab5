<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    
    public function connect($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function insert($table, $columns) {
        $columnNames = implode(", ", array_keys($columns));
        $columnValues = array_values($columns);
        $placeholders = str_repeat("?, ", count($columnValues) - 1) . "?";
        
        $stmt = $this->conn->prepare("INSERT INTO $table ($columnNames) VALUES ($placeholders)");
        $stmt->bind_param(str_repeat("s", count($columnValues)), ...$columnValues);
        
        if ($stmt->execute()) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    public function select($table) {
        $stmt = $this->conn->prepare("SELECT * FROM $table");
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        $stmt->close();
        
        return $data;
    }
    
    public function update($table, $id, $fields) {
        $setStatements = "";
        
        foreach ($fields as $column => $value) {
            $setStatements .= "$column = ?, ";
        }
        
        $setStatements = rtrim($setStatements, ", ");
        
        $stmt = $this->conn->prepare("UPDATE $table SET $setStatements WHERE id = ?");
        
        $stmt->bind_param(str_repeat("s", count($fields)) . "i",array_values($fields), $id);
        
        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    public function delete($table, $id) {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    public function __destruct() {
        $this->conn->close();
    }
}