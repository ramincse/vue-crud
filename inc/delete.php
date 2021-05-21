<?php
$id = $_GET['id'];

$conn = new mysqli('localhost', 'root', '', 'vue_crud2');
$data = $conn->query("DELETE FROM users WHERE id='$id'");