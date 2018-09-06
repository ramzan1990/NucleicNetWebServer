<?php
    move_uploaded_file($_FILES['file']['tmp_name'], 'NucleicNet/protein_RNA_interaction_package/GridData/' . time() . '.pdb');
    putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:/opt/conda/bin:/var/www/html/NucleicNet/utils/dssp");
    putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");

    $data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash commandNAGenerateBlindGrid.sh' . " 2>&1");
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash dl_prediction.sh' . " 2>&1");
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash commandNAAnalyseGridPrediction.sh' . " 2>&1");
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo nl2br($data);
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo 'Out<br />'
    $dir    = 'NucleicNet/protein_RNA_interaction_package/Out';
	$files1 = scandir($dir);
	print_r($files1);
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo 'GridData<br />'
	$dir    = 'NucleicNet/protein_RNA_interaction_package/GridData';
	$files1 = scandir($dir);
	print_r($files1);
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo 'DL_output<br />'
	$dir    = 'NucleicNet/protein_RNA_interaction_package/DL_output';
	$files1 = scandir($dir);
	print_r($files1);
?>
