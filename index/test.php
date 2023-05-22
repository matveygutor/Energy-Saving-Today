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
    // Подключение к базе данных
    $conn = new mysqli('127.0.0.1:3306', 'root', '', 'Testingphp');
    // Проверка подключения
    if($conn->connect_error){
    die("[$conn->connect_errno] Ошибка подключения к базе данных: " . $conn->connect_error);
    }   
    $testID = 1;
    $idQuestion = 1;
    if(isset($_GET["id"])){
        $nameID = $_GET["id"];
        if ($nameID == 1) {
            $testID = 1;
            $idQuestion = 1;
        }
        if ($nameID == 2) {
            $testID = 2;
            $idQuestion = 6;
        }
        if ($nameID == 3) {
            $testID = 3;
            $idQuestion = 11;
        }
        if ($nameID == 4) {
            $testID = 4;
            $idQuestion = 16;
        }
    }
    // Запрос к базе данных на вывод вопросов
    $questionQuery = "SELECT Содержание FROM Вопрос WHERE ИдКатегории = $testID";
    $name = 1; // Начальное значения атрибута name тега <input>
    $id = 1; // Начальное значения атрибута id тега <input>
    $count = 0;
    $questionCount = 0;
    echo "<form name = 'form' action='result.php' method='get'>";
    // Вывод данных на страницу
    if($question = $conn->query($questionQuery)){
        foreach($question as $row){   
            echo "<div class = 'testcontainer'>";
            $questionCount++;
            // Вывод вопроса
            echo "<div class = 'question'>";
                echo "<p>". $questionCount .". ". $row["Содержание"] ."</p>";
            echo "</div>";
            // Запрос к базе данных на вывод вариантов ответа для вопросов
            $answerQuery = "SELECT Содержание, ПравильныйОтвет FROM ВариантОтвета WHERE ИдВопроса = $idQuestion";
            $idQuestion++; // Для перехода к следующему вопросу
            // Вывод вариантон ответа
            echo "<div class = 'answer'>";
            if($answer = $conn->query($answerQuery)){
                foreach($answer as $answerRow){   
                    echo "<input class = 'custom-radio' type='radio' id=". $id ." name='answer[". $name ."]' value=". $answerRow["ПравильныйОтвет"] .">";
                    echo "<label for=". $id .">". $answerRow["Содержание"] ."</label></br>";
                    $id++;   
                }   
                $name++;
            }
            echo "</div>"; 
            echo "</div>"; #testcontainer
        }
        setcookie("questionCount", $questionCount, time() + 300);
        setcookie("testId", $nameID, time() + 300);
        // Кнопка проверки ответа и вывода результата
        echo "<div class='download' id='download'>"; 
        echo    "<div class='container'>"; 
        echo        "<button type = 'submit' class='btn  btn--red  btn--long'>Проверить ответы</button>";
        echo    "</div>";
        echo "</div>";
        echo "</form>"; 
    // Очистка данных
    $question->free();
    } 
    else{
        echo "Ошибка: " . $conn->error;
    }
    // Закрытие подключения
    $conn->close();
    ?>
</body>
</html>