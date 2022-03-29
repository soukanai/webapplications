LINEボット「Latin Word Origins」のWeb版です（PHP・MySQL・HTML）。 

<!DOCTYPE html>
<html>
<head>
    <html lang="ja">
    <meta charset="utf-8">
    <title>ラテン語源検索</title>
        <!-- Bootstrap CSS -->
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="shortcut icon" href="img\favicon.png">
        <style>
        body {
            background: #f3f3f3;
            font-family: 'Noto Sans JP', sans-serif;
        }
    </style>
    </head>

<body>
    <center>

    <div class="container mt-5 pt-5">
     <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center">ラテン語源検索</h3>
        </div>
     </div>
    </div>

    <div class="mb-5">
        <form action="" method="POST">
        <div class="form-group col-5">
                <input type="text" name="keyword" placeholder="単語を入力して下さい" class="form-control"/>
        </div>
        <div class="form-group col-5">
                <input type="submit" value="検索" class="form-control"/>
        </div>
        </form>
    </div>

    <div class="col-xs-6 col-xs-offset-3">
		<table class="table">
			<thead>
				<tr>
					<th>語源</th>
					<th>意味</th>
					<th>種類</th>
                    <th>使用例</th>
				</tr>
			</thead>
            <tbody>
                <tr>
    <?php

    $dsn = 'mysql:host=localhost;dbname=lwotable';
    $username = 'root';
    $password = '2230';

    if (isset($_POST['keyword'])) {
        try {

            $dbh = new PDO($dsn, $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $searchWord = $_POST['keyword'];

            if($searchWord==""){

              echo "<td>語源を入力して下さい</td>";

            }
            else{

                $sql ="select * from lwolist where wordorigin like '".$searchWord."%'";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();

                if($result){

                    foreach ($result as $row) {

                        echo "<td>".$row['wordorigin']."</td><td>".$row['wordmeaning']."</td><td>".$row['wordtype']."</td><td>".$row['wordexample']."</td>";
                        
                    }
                }
                else{
                    echo "<td>一致する語源が有りませんでした</td>";
                }
            }
        }catch (PDOException $e) {
            echo  "<p>Failed : " . $e->getMessage()."</p>";
            exit();
        }
    }

    ?>

    </tr>
    </tbody>
</table>

<div class="container mt-5 pt-5">
     <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center">ラテン語源追加</h3>
        </div>
     </div>
    </div>

<form action="" method="post">
    <div class="form-group col-5">
        <input type="text" name="insertedword" placeholder="語源を半角英字で入力して下さい" class="form-control"/>
    </div>
    <div class="form-group col-5">
    <input type="text" name="insertedmeaning" placeholder="語源の意味を入力して下さい" class="form-control"/>
    </div>
    <div class="form-group col-5">
                    <select name="insertedtype" class="form-control">
                    　　　　 <option disabled selected value="語源の種類を選択して下さい">語源の種類を選択して下さい</option>
                            <option value="接頭辞">接頭辞</option>
                            <option value="接尾辞">接尾辞</option>
                            <option value="語根">語根</option>
                            <option value="指小辞">指小辞</option>
                    </select>
    </div>
    <div class="form-group col-5">
                    <input type="text" name="insertedexample" placeholder="使用例を入力して下さい" class="form-control"/>
    </div>
    <div class="form-group col-5">
    　　    <input type="submit" name="add" value="追加" class="form-control"/>
    </div>

</form>

<?php

if(isset($_POST['add'])) {

    try {

    $dbh2 = new PDO($dsn, $username, $password);
    $dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $insertedWord = $_POST['insertedword'];
    $insertedMeaning = $_POST['insertedmeaning'];
    $insertedType = $_POST['insertedtype'];
    $insertedExample = $_POST['insertedexample'];

    $sql2 = "INSERT INTO lwolist (wordorigin, wordmeaning, wordtype, wordexample) VALUES (:wordorigin, :wordmeaning, :wordtype, :wordexample)"; 
    $stmt2 = $dbh2->prepare($sql2); 
    $params = array(':wordorigin' => $insertedWord, ':wordmeaning' => $insertedMeaning, ':wordtype' => $insertedType, ':wordexample' => $insertedExample);
    $stmt2->execute($params);

    echo "<center>語源「".$insertedWord."」に「".$insertedMeaning."」という意味の「".$insertedType."」が使用例「".$insertedExample."」としてデータベースに追加されました！</center>";

    } catch (PDOException $e) {

    exit('データベースに接続できませんでした。' . $e->getMessage());

    }

} else {

    echo "<center>入力エラーが有りました</center>";

}


?>
	    
</center>
</body>
</html>
