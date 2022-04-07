LINEボット「Latin Word Origins」のWeb版です（PHP・MySQL・HTML）。 

<!DOCTYPE html>
<html>
<head>

    <html lang="ja">
    <meta charset="utf-8">
    <title>ラテン語源検索</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300;400&display=swap" rel="stylesheet"> 
    <style>
            body {
        font-family: 'M PLUS Rounded 1c', sans-serif;
    }

    img {
    border-radius: 20px;
}
    </style>
        <link rel="shortcut icon" href="img\favicon.png">

</head>

<body>

<div class="p-3 mb-2 bg-light text-dark">
    <center>
    <img src="img\top.png" alt="top" width="200" height="200">
        <div class="container mt-5 pt-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
<h3 class="mb-5 text-center">            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-search" viewBox="0 0 20 20"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>ラテン語源検索（動作確認に「ab」を入力して頂ければと思います）</h3>
            </div>
        </div>
        </div>

        <div class="mb-5">
            <form action="" method="POST">
            <div class="form-group col-5">
                    <input type="text" name="keyword" placeholder="語源を半角英字で入力して下さい" class="form-control" required/>
            </div>
            <div class="form-group col-5">
            <input type="submit" value="検索" class="btn btn-primary form-control"/>
            </div>
            </form>
        </div>

    <div class="col-10 px-5">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th class="table-primary">語源</th>
					<th class="table-secondary">意味</th>
					<th class="table-success">種類</th>
                    <th class="table-danger">使用例</th>
				</tr>
			</thead>
            <tbody>
                <tr>
    <?php

    $dsn = 'mysql:*****;dbname=soukanaiofficial_lwotable';
    $username = '*****';
    $password = '*****';

    if (isset($_POST['keyword'])) {
        try {

            $dbh = new PDO($dsn, $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $searchWord = $_POST['keyword'];

            if($searchWord == "" || $searchWord == " "){

              echo "<td>検索フォームに語源を半角英字で入力して下さい</td>";

            }
            else{

                $sql ="select * from lwotable where wordorigin like '".$searchWord."%'";
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

<div class="container mt-5 pt-3">
     <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 20 20">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg>ラテン語源追加</h3>
        </div>
     </div>
    </div>

<form action="" method="post">
    <div class="form-group col-5">
        <input type="text" name="insertedword" placeholder="語源を半角英字で入力して下さい" class="form-control" required/>
    </div>
    <div class="form-group col-5">
    <input type="text" name="insertedmeaning" placeholder="語源の意味を入力して下さい" class="form-control" required/>
    </div>
    <div class="form-group col-5">
                    <select name="insertedtype" class="form-control" required>
                    　　　　 <option disabled selected value="語源の種類を選択して下さい">語源の種類を選択して下さい</option>
                            <option value="接頭辞">接頭辞</option>
                            <option value="接尾辞">接尾辞</option>
                            <option value="語根">語根</option>
                            <option value="指小辞">指小辞</option>
                    </select>
    </div>
    <div class="form-group col-5">
                    <input type="text" name="insertedexample" placeholder="使用例を入力して下さい" class="form-control" required/>
    </div>
    <div class="form-group col-5">
    　　    <input type="submit" name="add" value="追加" class="btn btn-primary form-control" required/>
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

    echo "<center>語源「".$insertedWord."」という「".$insertedMeaning."」という意味の「".$insertedType."」が使用例「".$insertedExample."」としてデータベースに追加されました！</center>";

    } catch (PDOException $e) {

    exit('データベースに接続できませんでした。' . $e->getMessage());

    }

}


?>
<div class="container mt-5 pt-3">
     <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="mb-5 text-center"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-line" viewBox="0 0 20 20">
  <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z"/>
</svg>ラテン語源検索（LINEボット版）</h3>
        </div>
     </div>
    </div>

<img src="https://qr-official.line.me/sid/M/602bpvjy.png?shortenUrl=true">

<div class="container mt-3 pt-3">
    <h7>Copyright © 2022 金井　想</h7>
</div>
</center>
</div>
</body>
</html>
