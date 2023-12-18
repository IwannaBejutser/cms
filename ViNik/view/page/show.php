<?php
	// $slug = $params[1];
	// $query  = "SELECT * FROM pages WHERE slug='$slug'";
	
	// $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
	// $page   = mysqli_fetch_assoc($res);
	
	// return $page;

	$catSlug = $params['catSlug'];
	$pageSlug = $params['pageSlug'];
	
	$query = "SELECT pages.title, pages.content
		FROM pages
	LEFT JOIN
		categories ON categories.id=pages.category_id
	WHERE
		pages.slug='$pageSlug' AND categories.slug='$catSlug'";
	
	$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$page = mysqli_fetch_assoc($res);
	
	return $page;
?>