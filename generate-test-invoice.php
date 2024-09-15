<?php
require 'autoload.php'; // Подключаем автозагрузчик

use PhpOffice\PhpWord\TemplateProcessor;

// Путь к шаблону
$templatePath = 'templates/simple-template.docx';
$templateProcessor = new TemplateProcessor($templatePath);

// Замена плейсхолдера в шаблоне
$templateProcessor->setValue('PLACEHOLDER', 'Тестовое значение');

// Путь для сохранения заполненного документа
$invoicePath = 'invoices/test-invoice.docx';
$templateProcessor->saveAs($invoicePath);

// Проверка сохранения и вывод ссылки на файл
if (file_exists($invoicePath)) {
    echo "Инвойс успешно сохранен: <a href='$invoicePath'>Скачать</a>";
} else {
    echo "Ошибка при сохранении инвойса.";
}
?>
