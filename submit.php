<?php
$host = 'localhost';
$db = 'clientdb';
$user = 'root';
$pass = '';

// Подключение к базе данных
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pinfl = $_POST['pinfl'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $landmark = $_POST['landmark'];

    // Загрузка файла
    $photo = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $photoPath = 'uploads/' . basename($photo);

    if (move_uploaded_file($photoTmp, $photoPath)) {
        // Вставка данных в базу данных
        $stmt = $pdo->prepare("INSERT INTO clients (pinfl, phone, address, landmark, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$pinfl, $phone, $address, $landmark, $photo]);

        // Перенаправление на страницу с успешным сохранением
        header("Location: success.php?pinfl=$pinfl&phone=$phone&address=$address&landmark=$landmark&photo=$photo");
        exit();
    } else {
        echo "Ошибка при загрузке файла.";
    }
}
?>
