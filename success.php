<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Инвойс создан</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Инвойс успешно создан!</h1>
    <p><a href="<?php echo htmlspecialchars($_GET['invoice']); ?>">Скачать ваш инвойс</a></p>
</body>
</html>
