<?php
        function downloadFile() {
            $dir = __DIR__;
            $zipFilepath = $dir . "/splitSlims.zip";
            header("Content-Type: ". mime_content_type($zipFilepath));
            header("Content-Length: ". intval(filesize($zipFilepath)));
            header("Content-Disposition: attachment; filename=". $zipFilepath);
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            ob_clean();
            // Print data
            echo file_get_contents($zipFilepath);
        }

        session_start();
        $workspace = $_SESSION["workspace"];
        // Connect to the database
        $dbLink = new mysqli('127.0.0.1', 'root', '', 'mysql');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
 
        // Fetch the files information
        $query = "
            SELECT `mime`, `name`, `size`, `data`
            FROM `files`
            WHERE `workspace` LIKE '{$workspace}'";
        $result = $dbLink->query($query);
        if($result) {
            $zip = new ZipArchive;
            $dir = __DIR__;
            // Make sure the result is valid
            while($row = mysqli_fetch_assoc($result)) { 
                $zipFilepath = $dir . "/splitSlims.zip";
                if ($zip->open($zipFilepath , ZipArchive::CREATE) === TRUE) {
                    $zip->addFromString($row['name'], $row['data']);
                }
            }
            downloadFile();
        }
        // Free the mysqli resources
        @mysqli_free_result($result);
        @mysqli_close($dbLink);
?>