<?php
    move_uploaded_file($_FILES['file']['tmp_name'], 'NucleicNet/protein_RNA_interaction_package/GridData/1.pdb');
    putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:");
    putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");
    $data = shell_exec ( 'NucleicNet/protein_RNA_interaction_package/commandNAGenerateBlindGrid.sh && NucleicNet/protein_RNA_interaction_package/dl_prediction.sh && NucleicNet/protein_RNA_interaction_package/commandNAAnalyseGridPrediction.sh ' . " 2>&1" );
    $needle = "This is the final result!!";
    
    echo $data;
?>
