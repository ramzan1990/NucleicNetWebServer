<?php

  #shell_exec ( 'rm -r NucleicNet/protein_RNA_interaction_package/GridData');
  #shell_exec ( 'rm -r NucleicNet/protein_RNA_interaction_package/Out');
  #shell_exec ( 'rm -r NucleicNet/protein_RNA_interaction_package/DL_output');
function tempdir($dir=NULL,$prefix=NULL) {
  $template = "{$prefix}XXXXXX";
  if (($dir) && (is_dir($dir))) { $tmpdir = "--tmpdir=$dir"; }
  else { $tmpdir = '--tmpdir=' . sys_get_temp_dir(); }
  return exec("mktemp -d $tmpdir $template");
}



    $tempdir =  tempdir('NucleicNet/protein_RNA_interaction_package/webruns');
    mkdir($tempdir . '/GridData',0777);
    mkdir($tempdir . '/Out',0777);
    mkdir($tempdir . '/DL_output',0777);
    mkdir($tempdir . '/DL',0777);
    shell_exec("cp -a NucleicNet/protein_RNA_interaction_package/DL $tempdir");
    
    move_uploaded_file($_FILES['file']['tmp_name'], "$tempdir/GridData/1111.pdb");

    $tempdir = str_replace("NucleicNet/protein_RNA_interaction_package/","",$tempdir);
    putenv("PATH=/usr/local/cuda/bin:/usr/local/cuda-8.0/bin:/usr/local/cuda-9.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin:/opt/conda/bin:/var/www/html/NucleicNet/utils/dssp");
    putenv("LD_LIBRARY_PATH=/usr/local/cuda/lib64");

$gd = $tempdir . "/GridData";
    $data = 
    shell_exec ( "cd NucleicNet/protein_RNA_interaction_package/; bash commandNAGenerateBlindGrid.sh $gd 2>&1");
    echo '-----------------------------------------------------------------------------------------------------------------<br />';
    echo nl2br($data);
  $data = shell_exec ( "cd NucleicNet/protein_RNA_interaction_package/; bash dl_prediction.sh $tempdir 2>&1");
  echo '-----------------------------------------------------------------------------------------------------------------<br />';
  echo nl2br($data);
  echo "bash commandNAAnalyseGridPrediction_legacy.sh {$tempdir}/Out {$tempdir}/DL_output {$tempdir}/Out";
  $data = shell_exec ( "cd NucleicNet/protein_RNA_interaction_package/; bash commandNAAnalyseGridPrediction_legacy.sh {$tempdir} 2>&1");
  echo '-----------------------------------------------------------------------------------------------------------------<br />';
  echo nl2br($data);
    echo '-----------------------------------------------------------------------------------------------------------------<br />';

  echo '<div id="viewport" style="width:600px; height:600px;"></div>';
  $str = <<<MY_MARKER
  <script src="js/ngl.js"></script>
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
