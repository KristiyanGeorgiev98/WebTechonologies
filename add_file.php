<!DOCTYPE html>
<html lang="en" >
<head>
    <link type="text/css" rel="stylesheet" href="./style/styleForBlueBack.css">
</head>
<body>
</body>
</html>
<?php
// Check if a file has been uploaded
// Initialize the session
session_start();
$username = $_SESSION["username"];
$workspace = $_SESSION["workspace"];
if( $_SESSION["loggedin"] == false) {
    header("location: index.php");
}
if(isset($_FILES['uploaded_file'])) {
    // Make sure the file was sent without errors
    if($_FILES['uploaded_file']['error'] == 0) {
        // Connect to the database
        $dbLink = new mysqli('127.0.0.1', 'root', '', 'mysql');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
        $filename = $_FILES['uploaded_file']['name'];
        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($extension, ['slim'])) {
        echo "You file extension must be .slim";
        } else{

            $myfile = fopen(($_FILES  ['uploaded_file']['tmp_name']), "rw") or die("Unable to open file!");
            $text = file_get_contents(($_FILES  ['uploaded_file']['tmp_name']));
            $startIndex = 0;
            while(strpos($text, "= slide", $startIndex) > -1) {
                $n = strpos($text, "= slide", $startIndex);
                $slimFile = "";
                for($i=$n; $i<strpos($text, '= slide', $n+1); $i++){
                    $slimFile = $slimFile . $text[$i];
                }
                $title = "";
                for ($i=9; $i < strpos($slimFile, "do")-2; $i++){
                 $title = $title . $slimFile[$i];
                }
                if ($title == "") {
                    break;
                }
                $metadata = "//lang=bg, needpass=false, format=slim \r\n";
                $slimFile = $metadata . $slimFile;
                $slim_file_name = $title .".slim";
                $dir = __DIR__;
                $fullpath = $dir . "/files/" . $slim_file_name;
                file_put_contents($fullpath, $slimFile);

                $name = $dbLink->real_escape_string($slim_file_name);
                $mime = $dbLink->real_escape_string(mime_content_type($fullpath));
                $data = $dbLink->real_escape_string(file_get_contents($fullpath));
                $size = intval(filesize($fullpath));                
                // Create the SQL query
                $query = "
                INSERT INTO `files` (
                    `name`, `mime`, `size`, `data`, `created` , `workspace`
                )
                VALUES (
                    '{$name}', '{$mime}', {$size}, '{$data}', NOW() , '{$workspace}'
                )";
            
                // Execute the query
                $result = $dbLink->query($query);
                $startIndex = $n + 1;
            }
            echo 'File uploaded successfully!See list files for more.';
        }
    }
    else {
        echo 'An error accured while the file was being uploaded. '
           . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    }
 
    // Close the mysql connection
    $dbLink->close();
}
else {
    echo 'Error! A file was not sent!';
}
 
// Echo a link back to the main page
echo '<p>Click <a href="separate.html">here</a> to go back</p>';
?>