<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "Cookie";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>