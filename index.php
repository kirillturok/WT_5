<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>lab4</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main>
        <div class="form">
            <form method="post">
                <p><h1>Введите запрос</h1></p>
                <p><input type="text" name="inputText"></p>
                <p><input type="submit"></p>
            </form>
        </div>
            <?php
                if(array_key_exists('inputText', $_POST)) runTask(strip_tags($_POST['inputText']));

                function runTask($input){
                    //echo strip_tags($_POST['inputText']);
                    
                    $db=mysqli_connect("localhost", "kiryl", "!@#Qwerty10","wt_lab5");
                    if(!$db) exit("error".mysqli_connect_error());
                    //else echo "ok";
                    mysqli_set_charset($db, "utf8");
                    $queryArray = preg_split("/;/",$input);
                    foreach($queryArray as $query){
                       // echo "!!!$query!!!\n";
                        if(!empty($query))
                            startDB($db,$query);
                    }
                }

                function startDB($db, $query){
                    echo "<div class query>";
                    echo "<h3>Запрос: ".$query."</h3>";
                    $time=microtime(true);
                    $memory=memory_get_usage();
                    $res=mysqli_query($db,$query);
                    $memory=memory_get_usage()-$memory;
                    $time=microtime(true)-$time;
                    if(!$res) echo "<p>Не удалось выполнить запрос<p>";
                    else drawTable($res);
                    echo "<p>Время выполнения запроса: ".$time . ' ms</p>';
                    echo "<p>Использованная оперативная память: ".$memory." байт</p>";
                    echo "</div>";
                }
                
                function drawTable($arr){
                    $arr0=mysqli_fetch_assoc($arr);
                    //var_dump($arr0);
                    $keys = array_keys($arr0);
                    echo '<table><tr>';
                    foreach($keys as $key)
                        echo "<th>$key</th>";
                    echo '</tr>';
                    echo '<tr>';
                    foreach($keys as $key)
                        echo "<td>$arr0[$key]</td>";
                    echo '</tr>';
                    while($row=mysqli_fetch_array($arr)){
                        echo '<tr>';
                        foreach($keys as $key)
                            echo "<td>$row[$key]</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            ?>
        </main>
    </body>
</html>