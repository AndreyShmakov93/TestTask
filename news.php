<!DOCTYPE html>
<html>
<head>
	<title>Список новостей</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php 
$db_host='localhost';
$db_name='test';
$db_user='testuser';
$db_pass='4815162342';
$mysql_connection=new mysqli($db_host, $db_user, $db_pass, $db_name);
$total_records = $mysql_connection->query('SELECT COUNT(id) FROM news')->fetch_Column();
$records_per_page = 5;
$total_pages=ceil($total_records / $records_per_page);
$current_page=isset($_GET['page']) ? $_GET['page'] : 1;
if($current_page<=0){
$current_page=1;
}
if($current_page>$total_pages){
$current_page=$total_pages;
}
$visible_links=5;
$half_visible_links=floor($visible_links / 2);
$start_page=max($current_page - $half_visible_links, 1);
$end_page=min($start_page + $visible_links - 1, $total_pages);
$previous_page=max($current_page - 1, 1);
$next_page=min($current_page + 1, $total_pages);
$show_dots_start=($start_page > 1);
$show_dots_end=($end_page < $total_pages);
$offset=($current_page - 1) * $records_per_page;
$result=$mysql_connection->query("SELECT id, title, announce, idate FROM news ORDER BY idate DESC LIMIT $offset, $records_per_page");
while ($row=$result->fetch_assoc()) {
echo '  <div class="card">
        <div class="card-body">
	    <h5 class="card-title">'.$row['title'].'</h5>
        <p class="card-text">'.$row['announce'].'</p>
        <p class="card-text"><small class="text-muted">'.gmdate("d.m.Y",$row['idate']).'</small></p>
        <a href="view.php?id='.$row['id'].'" class="btn btn-primary">Подробнее</a>
        </div>
	    </div>';
}
?>
<?php if ($total_pages > 1): ?>
    <nav aria-label="...">
		<ul class="pagination justify-content-center" >
			<li class="page-item <?php echo ($current_page==1)?'disabled':'' ?>">
				<a class="page-link" aria-label="Предыдущая" href="news.php?page=<?php echo $previous_page; ?>"><span aria-hidden="true">&laquo;</span></a>
			</li>
		<?php if ($show_dots_start): ?>
	        <li class="page-item">
             <a class="page-link" href="news.php?page=1">1</a>
            </li>
			<li class="page-item disabled">
             <span class="page-link">...</span>
            </li>
		<?php endif; ?>
		<?php for ($page = $start_page; $page <= $end_page; $page++): ?>
            <?php if ($page == $current_page): ?>
				  <li class="page-item active" aria-current="page">
					<span class="page-link" ><?php echo $page; ?></span>
				  </li>
			<?php else: ?>
				  <li class="page-item">
					<a class="page-link" href="news.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
				  </li>
            <?php endif; ?>
		<?php endfor; ?>
		<?php if ($show_dots_end): ?>
			<li class="page-item disabled">
				<span class="page-link">...</span>
			</li>
			<li class="page-item">
				<a class="page-link" href="news.php?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
            </li>
		<?php endif; ?>
			<li class="page-item <?php echo ($current_page==$total_pages)?'disabled':'' ?>">
				<a class="page-link" aria-label="Следующая" href="news.php?page=<?php echo $next_page; ?>"><span aria-hidden="true">&raquo;</span></a>
			</li>
		</ul>
	</nav>
<?php endif;?>
</body>
</html>