<!DOCTYPE html>
<html lang="en">
<head>
  <title>Workspaces</title>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <link rel="stylesheet" type="text/css" media="all" href="style/styleForWorkspaces.css">
</head>
<body>
    <?php
    session_start();
    $username = $_SESSION["username"];
    echo "Username : " . $username;
    if( $_SESSION["loggedin"] == false) {
      header("location: index.php");
    }
    $dbLink = new mysqli('127.0.0.1', 'root', '', 'mysql');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
 
        // Fetch the files information
        $query = "
            SELECT `html`, `css`, `js`, `php`
            FROM `users`
            WHERE `username` LIKE '{$username}'";
        $result = $dbLink->query($query);
        if($result) {
            // Make sure the result is valid
            if($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
                if($row['html'] == 1){
                    echo '<div class = "pic1">
                    <a href = "http://localhost/project/chooseHtml.php">
                    <img src="./img/html-logo-transparent.png" width="150" height="150">
                    </a>
                    </div>';
                }
                if($row['php'] == 1){
                    echo '<div class = "pic2">
                    <a href = "http://localhost/project/choosePhp.php">
                    <img src="./img/php-logo-transparent.png" width = "160">
                    </a>
                    </div>';
                }
                if($row['css'] == 1){
                    echo '<div class = "pic3"> <a href = "http://localhost/project/chooseCss.php">
                    <img src="./img/css-logo-transparent.png" width = "130">
                    </a>
                    </div>';
                }
                if($row['js'] == 1){
                    echo '<div class = "pic4" > 
                    <a href = "http://localhost/project/chooseJs.php">
                    <img src="./img/javascript-logo-transparent.png" width="232" height="132">
                    </a>
                    </div>';
                }
            }
            // Free the mysqli resources
            @mysqli_free_result($result);
        }
    ?>
    <div>
      <form action="index.php" method="get">
      <button class="btn">Login</button>
      </form>
    </div>
    <h1>Workspaces</h1>
    </div>
  </body>
</html>