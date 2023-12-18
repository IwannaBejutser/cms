<?php
	// $query = "SELECT slug, title FROM pages";
	// $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	// for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);
	
	// $content = '';
	// foreach ($data as $page) {
	// 	$content .= '
	// 		<div>
	// 			<a href="/page/'  . $page['slug'] . '">' . $page['title'] . '</a>
	// 		</div>
	// 	';
	// }
	
	// $page = [
	// 	'title' => 'список всех страниц',
	// 	'content' => $content
	// ];
	
	// return $page;

	// require 'bd.php';

	// $query = "SELECT pages.slug, pages.title, categories.slug as category_slug FROM pages
	// 	LEFT JOIN categories ON categories.id=pages.category_id";

	// $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

	// $data = [];
	// while ($row = mysqli_fetch_assoc($res)) {
	// 	$data[] = $row;
	// }

	// $content = '';
	// foreach ($data as $page) {
	// 	$content .= '
	// 		<div>
	// 			<a href="/page/' . $page['category_slug'] . '/' . $page['slug'] . '">' . $page['title'] . '</a>
	// 		</div>
	// 	';
	// }

	// $layout = file_get_contents('layout.php');
	// $layout = str_replace('{{ title }}', 'Список всех страниц', $layout);
	// $layout = str_replace('{{ content }}', $content, $layout);

	// echo $layout;
?>

<?php
require 'bd.php';

$query = "SELECT pages.slug, pages.title, categories.slug as category_slug, categories.name as category_name FROM pages
    LEFT JOIN categories ON categories.id=pages.category_id";

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}

// Группировка по категориям
$groupedPages = [];
foreach ($data as $page) {
    $groupedPages[$page['category_slug']][] = $page;
}

$content = '';
foreach ($groupedPages as $categorySlug => $pages) {
    $categoryContent = '';
    foreach ($pages as $page) {
        $categoryContent .= '
            <div>
                <a href="/page/' . $categorySlug . '/' . $page['slug'] . '">' . $page['title'] . '</a>
            </div>
        ';
    }

    $content .= '
        <div>
            <h2>' . $pages[0]['category_name'] . '</h2>
            ' . $categoryContent . '
        </div>
    ';
}

$layout = file_get_contents('layout.php');
$layout = str_replace('{{ title }}', 'Список всех страниц', $layout);
$layout = str_replace('{{ content }}', $content, $layout);

echo $layout;
?>
