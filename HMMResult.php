<?php
  $query_name = "single_" . time();
  $new_file = "files/" . $query_name .'.csv';
  $content = $_POST["sequence"];
  file_put_contents($new_file, $content);
  $data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; python Scripts/Nucleic-Bind_HMM_ScoreSomeSequences.py --PredictionFolder Apo --TestSequences ' . $new_file . ' --Targetname Apo' . ' 2>&1');
  echo $data;
?>
