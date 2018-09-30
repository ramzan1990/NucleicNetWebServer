<?php
  putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:/opt/conda/bin:/var/www/html/NucleicNet/utils/dssp");
  putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");
  $content = $_POST["sequence"];
  $data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; whoami; bash score.sh '. $content . ' 2>&1');
  echo $data;
?>
