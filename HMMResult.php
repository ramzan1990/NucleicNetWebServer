<?php
  $query_name = "single_" . time();
  $new_file = "files/" . $query_name .'.csv';
  $content = $_POST["sequence"];
  file_put_contents($new_file, $content);
  $data = shell_exec ( 'bash score.sh '. $new_file . ' 2>&1');
  echo $data;
?>
