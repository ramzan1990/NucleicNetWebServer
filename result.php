<?php
	function EmptyDir($dir) {
  	$handle=opendir($dir);
  	while (($file = readdir($handle))!==false) {
      if(is_file($dir.'/'.$file)){
        unlink($dir.'/'.$file);
      }
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
  #echo '-----------------------------------------------------------------------------------------------------------------<br />';
  #echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash dl_prediction.sh' . " 2>&1");
	#echo '-----------------------------------------------------------------------------------------------------------------<br />';
	#echo nl2br($data);
	$data = shell_exec ( 'cd NucleicNet/protein_RNA_interaction_package/; bash commandNAAnalyseGridPrediction_legacy.sh' . " 2>&1");
	#echo '-----------------------------------------------------------------------------------------------------------------<br />';
	#echo nl2br($data);
  #echo '-----------------------------------------------------------------------------------------------------------------<br />';
  #echo 'Out<br />';
  #$dir    = 'NucleicNet/protein_RNA_interaction_package/Out';
	#$files1 = scandir($dir);
	#print_r($files1);
  #echo '-----------------------------------------------------------------------------------------------------------------<br />';
  #echo 'GridData<br />';
	#$dir    = 'NucleicNet/protein_RNA_interaction_package/GridData';
	#$files1 = scandir($dir);
	#print_r($files1);
	#echo '-----------------------------------------------------------------------------------------------------------------<br />';
	#echo 'DL_output<br />';
	#$dir    = 'NucleicNet/protein_RNA_interaction_package/DL_output';
	#$files1 = scandir($dir);
	#print_r($files1);
	echo '<div id="viewport" style="width:600px; height:600px;"></div>';
	$str = <<<MY_MARKER
  <script src="js/ngl.js"></script>
  <script>
      
function render(rad, opacity, scale, smooth, bg){
  var stage = new NGL.Stage( "viewport", {backgroundColor:bg} );

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
      probeRadius: rad,
      smooth: smooth,
      scaleFactor: scale,
      flatShaded: false,
      opacity: opacity,
      lowResolution: false,
      side: "front",
      color: schemeId,
    })
    o.autoView()
  })
}
function setParams(){
  document.getElementById("viewport").innerHTML = "";
  var rad = parseFloat(document.getElementById("radius").value);
  var opacity = parseFloat(document.getElementById("opacity").value);
  var scale = parseFloat(document.getElementById("scale").value);
  var smooth = parseFloat(document.getElementById("smooth").value);
  var bg = document.getElementById("color").value;
  render(rad, opacity, scale, smooth, bg);
}

    </script>
    <br />
    <label style="display: inline-block;width: 140px;text-align: left;">Radius</label> <input id="radius" value="0.1"> <br />
    <label style="display: inline-block;width: 140px;text-align: left;">Opacity</label> <input id="opacity" value="0.5"> <br />
    <label style="display: inline-block;width: 140px;text-align: left;">Scale</label> <input id="scale" value="2.0"> <br /> 
    <label style="display: inline-block;width: 140px;text-align: left;">Smoothing</label> <input id="smooth" value="2"> <br /> 
    <label style="display: inline-block;width: 140px;text-align: left;">Background</label> <select id="color"> 
    <option value="black">black</option>
    <option value="white">white</option>
    <option value="red">red</option>
    <option value="blue">blue</option>
    <option value="green">green</option>
    </select> <br /><br />
<button onclick="setParams()">Render</button>
<script>setParams();</script>
MY_MARKER;
    echo $str;
    echo "<br />";
    echo "<br />";
    echo "<a href='". "NucleicNet/protein_RNA_interaction_package/Out/1111_pymol.pse" ."'>Download PSE</a>";
?>
