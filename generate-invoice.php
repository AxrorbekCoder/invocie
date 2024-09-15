<?php
require 'autoload.php'; // Подключаем автозагрузчик

use PhpOffice\PhpWord\TemplateProcessor;

// Подключение к базе данных
$host = 'localhost';
$db = 'clientdb';
$user = 'root';
$pass = '';

// Подключение к базе данных
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientId = $_POST['clientId'];
    $trackCode = $_POST['trackCode'];

    // Получение данных клиента из базы данных
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$clientId]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        // Проверка полученных данных
        echo '<pre>';
        print_r($client);
        echo '</pre>';

        // Загрузка шаблона .docx
        $templatePath = 'templates/template.docx';
        $templateProcessor = new TemplateProcessor($templatePath);

        // Замена плейсхолдеров в шаблоне
        $templateProcessor->setValue('NAME', $client['name']);
        $templateProcessor->setValue('PHONE', $client['phone']);
        $templateProcessor->setValue('ADDRESS', $client['address']);
        $templateProcessor->setValue('LANDMARK', $client['landmark'] ?: 'Не указан');
        $templateProcessor->setValue('TRACK_CODE', $trackCode);

        // Сохранение заполненного документа
        $invoicePath = 'invoices/invoice-' . $clientId . '.docx';
        $templateProcessor->saveAs($invoicePath);

        // Проверка успешности сохранения
        if (file_exists($invoicePath)) {
            echo "Инвойс успешно сохранен: $invoicePath";
        } else {
            echo "Ошибка при сохранении инвойса.";
        }

        // Отправка ссылки на файл
        header("Location: success.php?invoice=$invoicePath");
        exit();
    } else {
        echo "Клиент не найден.";
    }
}
?>
