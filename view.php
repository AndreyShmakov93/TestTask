<?php 
$db_host='localhost';
$db_name='test';
$db_user='testuser';
$db_pass='4815162342';
$mysql_connection=new mysqli($db_host, $db_user, $db_pass, $db_name);
$current_id=isset($_GET['id']) ? $_GET['id'] : 0;
try{
	$result=$mysql_connection->query("SELECT title, content FROM news WHERE id=$current_id")->fetch_assoc();
}
catch(Exception $e){}
if (is_null($result)){
		http_response_code(404);
		include('my_404.php');
		die();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $result['title'] ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="card">
	<div class="card-body">
		<h5 class="card-title"><?php echo $result['title'] ?></h5>
		<p class="card-text"><?php echo $result['content'] ?></p>
		<a href="news.php?page=1" class="btn btn-primary">Все новости</a>
	</div>
</div>
</body>
</html>