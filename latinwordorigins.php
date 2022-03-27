LINEボット「Latin Word Origins」のWeb版です（PHP・MySQL・HTML）。 

<!DOCTYPE html>
<html>
<head>
    <html lang="ja">
    <meta charset="utf-8">
    <title>Latin Word Origins</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <center>
    <h1>Latin Word Origins</h1>

    <form action="" method="POST">
        <input type="text" name="keyword" />　<input type="submit" value="Search" />
    </form>

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
    $dsn = 'mysql:host=localhost;dbname=latinwordorigins';
    $username = 'root';
    $password = '2230';
    if ($_POST) {
        try {
            $dbh = new PDO($dsn, $username, $password);
            $searchWord = $_POST['keyword'];
            if($searchWord==""){
              echo "語源を入力して下さい";
            }
            else{
                $sql ="select * from list where origin like '".$searchWord."%'";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();
                if($result){
                    foreach ($result as $row) {
                        echo "<td>".$row['origin']."</td><td>".$row['meaning']."</td><td>".$row['type']."</td><td>".$row['example']."</td>";
                    }
                }
                else{
                    echo "一致する語源が有りませんでした";
                }
            }
        }catch (PDOException $e) {
            echo  "<p>Failed : " . $e->getMessage()."</p>";
            exit();
        }
    }
    ?>
    </td>
    </tbody>
</center>
</body>
</html>
