<?php
    require 'bd.php';

	$url = $_SERVER['REQUEST_URI'];
	$slug = $params['slug'];
	$path = 'view' . $url . '.php';
	
	$query = "SELECT * FROM pages WHERE slug=?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "s", $slug);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$page = mysqli_fetch_assoc($res);
	mysqli_stmt_close($stmt);
	
	$route = '^/page/(?<catSlug>[a-z0-9_-]+)/(?<pageSlug>[a-z0-9_-]+)$';
	if (preg_match("#$route#", $url, $params)) {
		$page = include 'view/page/show.php';
	}
	
	$route = '^/page/(?<catSlug>[a-z0-9_-]+)$';
	if (preg_match("#$route#", $url, $params)) {
		$page = include 'view/page/category.php';
	}
	
	$route = '^/$';
	if (preg_match("#$route#", $url, $params)) {
		$page = include 'view/page/all.php';
	}
	
	if ($page) {
		$title = $page['title'];
		$content = $page['content'];
	} else {
		header('HTTP/1.0 404 Not Found');
		$content = file_get_contents('view/404.php');
		$title = 'Not Found';
	}
	
	preg_match('#{{ title: "(.+?)" }}#', $content, $match);
	$title = $match[1];
	
	$layout = file_get_contents('layout.php');
	$layout = str_replace('{{ title }}', $title, $layout);
	$layout = str_replace('{{ content }}', $content, $layout);
	
	echo $layout;
?>