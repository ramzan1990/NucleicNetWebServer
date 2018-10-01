<?php
  putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:/opt/conda/bin:/var/www/html/NucleicNet/utils/dssp");
  putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");
  $content = $_POST["sequence"];
  $seqs = explode(',', $content);  
  $data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash score.sh '. $content);
  $scores = explode(PHP_EOL, $data);
  echo "<table><tr><th>Sequence</th><th>Score</th></tr>";
  for ($x = 0; $x < count($seqs); $x++) {
      echo "<tr>";
      echo "<td>" . $seqs[$x] . "</td>";
      echo "<td>" . $scores[$x] . "</td>";
      echo "</tr>";
  }
  echo "</table>";
?>
