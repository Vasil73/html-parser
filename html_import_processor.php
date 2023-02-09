<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML parser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="pt-5">
        <form method="POST">
            <div class="mb-5">
                <label for="url" class="form-label">URL адрес</label>
                <input type="url" name="url" class="form-control w-50" id="url" aria-describedby="emailHelp" placeholder="https://go.skillbox.ru/" value="<?= $_POST['url']??'' ?>" required>
                <div id="urlHelp" class="form-text">Введите url страницы</div>
            </div>
            <button type="submit" class="btn btn-primary">Выполнить</button>
        </form>
    </div>
</div>
</body>
</html>


<?php

if (isset($_POST['url'])) {
    $url = htmlentities($_POST['url']);

    // Parsing page
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if (curl_exec($ch) === false) {
        echo 'Ошибка curl: ' . curl_error($ch);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    $object = [
        'raw_text' => $result,
    ];
    $json = json_encode($object);

    // Refact code
    $ch = curl_init($_SERVER['HTTP_HOST'] . '/html-parser/HtmlProcessor.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if (curl_exec($ch) === false) {
        echo 'Ошибка curl: ' . curl_error($ch);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    if ($data = json_decode($result)) {
        echo $data->formatted_text;
    } else {
        http_response_code(500);
        echo "Произошла ошибка url";
    }
}

?>