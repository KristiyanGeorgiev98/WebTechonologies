<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Choose option</title>
  <link type="text/css" rel="stylesheet" href="./style/styleForChoose.css">
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
<?php
	session_start();
   	$_SESSION["workspace"] = "php";
?>
<div class="main">
  <a class="btn_separate" type="button" onclick="location.href='http://localhost/project/separate.html';" value="Separate presentation">Separate presentation <i class='fas fa-expand-arrows-alt' style='font-size:24px'></i> </a>
<a class="btn_gather" type="button" onclick="location.href='http://localhost/project/gather.html';" value="Gather slim files ">Gather slim files <i class='fas fa-compress-arrows-alt' style='font-size:24px'></i> </a>
  </div>
</body>
</html>
