<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
	require_once('inc/class_curriculum_graph.php');

	$v = (!empty($_GET)) ? $_GET : $_POST;

	$graph = new Curriculum_graph($v['id']);
	$graph->print();
?>
</body>
</html>