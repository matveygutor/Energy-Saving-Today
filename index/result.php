<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Cardo:400i|Open+Sans:700|Raleway:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../teststyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php    
    $answerCount = 0;
    $numberOfCorrectAnswers = 0;
    if (is_array($_GET['answer'])) {
        foreach ($_GET['answer'] as $value) {
            $answerCount++;
            if ($value == 1) {
                $countOfCorrectAnswers++;
            }
        }
    }
    if ($answerCount != $_COOKIE['questionCount']) {
        echo "<div class = 'resultMessage'>";
        echo "<p>Вы ответили не на все вопросы</p></br>";
        echo "</div>";
        if (isset($_COOKIE["testId"])) {
            $testId = $_COOKIE['testId'];
        }
        setcookie("testId", $testId, time() + 300);
        echo "<form action = 'test.php' method = 'get'>";
        // Кнопка завершения тестирования
        echo"<div class='download' id='result'>";
        echo    "<div class='container'>";
        echo        "<button type = 'submit' class='btn  btn--red  btn--long' name = 'id' value = ". $testId .">Вернуться к тестированию</button>";
        echo    "</div>";
        echo"</div>";
        echo "</form>";
    }
    else {
        if (isset($_COOKIE["questionCount"])) {
            $pro = ($countOfCorrectAnswers/$_COOKIE['questionCount'])*100;
        }
        echo "<div class = 'resultMessage'>";
        echo "<p>Количество правильных ответов: {$countOfCorrectAnswers} из ". $_COOKIE['questionCount'] ."</p></br>";
        echo "<p>Вы усвоили материал на {$pro}%</p></br>";
        echo "</div>";
        // Кнопка завершения тестирования
        echo"<div class='download' id='result'>";
        echo    "<div class='container'>";
        echo        "<a class='btn  btn--red  btn--long' href='index.html'>Завершить тестирование</a>";
        echo    "</div>";
        echo"</div>";
    }
?>
</body>
</html>