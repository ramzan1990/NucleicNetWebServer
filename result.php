<?php
	function EmptyDir($dir) {
	$handle=opendir($dir);
	while (($file = readdir($handle))!==false) {
	unlink($dir.'/'.$file);
	}
	closedir($handle);
	}

	EmptyDir('NucleicNet/protein_RNA_interaction_package/GridData');
	EmptyDir('NucleicNet/protein_RNA_interaction_package/Out');
	EmptyDir('NucleicNet/protein_RNA_interaction_package/DL_output');

    move_uploaded_file($_FILES['file']['tmp_name'], 'NucleicNet/protein_RNA_interaction_package/GridData/1111.pdb');
    putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:/opt/conda/bin:/var/www/html/NucleicNet/utils/dssp");
    putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");

    $data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash commandNAGenerateBlindGrid.sh' . " 2>&1");
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash dl_prediction.sh' . " 2>&1");
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash commandNAAnalyseGridPrediction_legacy.sh' . " 2>&1");
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo nl2br($data);
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo 'Out<br />';
    $dir    = 'NucleicNet/protein_RNA_interaction_package/Out';
	$files1 = scandir($dir);
	print_r($files1);
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo 'GridData<br />';
	$dir    = 'NucleicNet/protein_RNA_interaction_package/GridData';
	$files1 = scandir($dir);
	print_r($files1);
	echo '-----------------------------------------------------------------------------------------------------------------<br />';
	echo 'DL_output<br />';
	$dir    = 'NucleicNet/protein_RNA_interaction_package/DL_output';
	$files1 = scandir($dir);
	print_r($files1);
	echo '<div id="viewport" style="width:600px; height:600px;"></div>';
	$str = <<<MY_MARKER 
	<script>
       // Create NGL Stage object
var stage = new NGL.Stage( "viewport", {backgroundColor:"white"} );

var schemeId = NGL.ColormakerRegistry.addScheme(function (params) {
  this.atomColor = function (atom) {
    var name = atom.atomname.toUpperCase();
    if ( name == "CO" || name == "Y") {
      return 0xFF0000;  
    } else if (name == "U") {
      return 0xFF00FF;  
    }else if (name == "AR" || name == "PU") {
      return 0x0000FF;  
    }else if (name == "GE") {
      return 0x00FFFF;  
    }else if (name == "P") {
      return 0xFFFF00;  
    }else if (name == "RE") {
      return 0x00FF00;  
    } else {
      //console.log(atom.atomname);
      return 0xFFFFFF;  
    }
  };
});

var white1 = NGL.ColormakerRegistry.addScheme(function (params) {
  this.atomColor = function (atom) {
    return 0xFFFFFF;  
  };
});

stage.loadFile("NucleicNet/protein_RNA_interaction_package/Out/1111.pdb").then(function (o) {
  o.addRepresentation("ribbon", {
    color: white1
  })
  o.autoView()
})

stage.loadFile("NucleicNet/protein_RNA_interaction_package/Out/1111_strong_Bootstrap.pdb").then(function (o) {
  o.addRepresentation("surface", {
    color: schemeId,
    opacity:  0.5
  })
  o.autoView()
})

    </script>'
MY_MARKER;
    echo $str;
?>
