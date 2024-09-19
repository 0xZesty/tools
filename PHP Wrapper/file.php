<?php 
// CS{PHP_Wr4pp3r_R34d_S0urc3_F0r_Fun_4nD_Pr0F1t}
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$file = $_FILES['upload']['name'];
	$tmp_name  = $_FILES['upload']['tmp_name'];

	$ext = pathinfo($file);
	if($ext['extension'] == 'php' || $ext['extension'] == 'php5' ||$ext['extension'] == 'php7' ||$ext['extension'] == 'php8' ||$ext['extension'] == 'phtml' ||$ext['extension'] == 'phar' ||$ext['extension'] == 'html' ||$ext['extension'] == 'htm'){
		$error ='Extension not allowed!';
	}
	if(!$error){
		$dir = rand();
		mkdir('./files/'.$dir);
		if(move_uploaded_file($tmp_name, "./files/".$dir.'/'.$file)){
			$success=true;
		}else{
			$error="Upload file error, try again!!";
		}

	}


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload and Share Files</title>
	<style>
@import url(https://fonts.googleapis.com/css?family=Nunito);
html {
  height: 100%;
}
body{
	background: #EEF2F6 url(https://static.tumblr.com/26l8vc7/q7Glbweh4/bg.jpg);

}
.upload-box {
  display: -webkit-flex;
  display: flex;
  -webkit-align-items: center;
  align-items: center;
  -webkit-justify-content: center;
  justify-content: center;
  margin-top: 150px;
  height: 100%;
  width: 100%;
  background: #EEF2F6 url(https://static.tumblr.com/26l8vc7/q7Glbweh4/bg.jpg);
  font-family: Nunito;
  color: #888;
}
.files-box{
	text-align:center;
}
a {
  color: #51ADED;
}

.fileUpload {
  /*
  &:before, &:after {
    content: '';
    position: absolute;
    top: -20px;
    left: 0;
    width: 100%;
    height: 20px;
    @include scallop($formBgColor);
  }
  &:after {
    top: auto;
    bottom: -20px;
    background-position: 0 -15px;
  }*/
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
  background-color: #EEF2F6;
  width: 300px;
  padding: 30px;
}
.fileUpload h4 {
  font-size: 18px;
  font-weight: normal;
  margin: 20px 0 5px 0;
  padding: 0;
}
.fileUpload progress {
  appearance: none;
  border: 0;
  width: 100%;
  height: 15px;
  color: #51ADED;
  background-color: #ccc;
  border-radius: 10px;
}
.fileUpload progress::-moz-progress-bar {
  background-color: #51ADED;
  border-radius: 10px;
}
.fileUpload progress::-webkit-progress-bar {
  background-color: #ccc;
  border-radius: 10px;
}
.fileUpload progress::-webkit-progress-value {
  position: relative;
  background-color: #51ADED;
  border-radius: 10px;
}
.fileUpload p {
  font-size: 80%;
  padding: 0;
  margin: 0;
  text-align: center;
}
.fileUpload .fileElem {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  width: 300px;
  position: absolute;
  top: 30px;
  left: 30px;
  z-index: 1;
  height: 50px;
  opacity: 0;
  cursor: pointer;
}
.fileUpload .fileElem:focus {
  outline: none;
}
.fileUpload .fileSelect {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  display: inline-block;
  text-align: left;
  padding-left: 110px;
  width: 100%;
  height: 50px;
  background-color: #51ADED;
  border-radius: 3px;
  border-bottom: 3px solid rgba(0, 0, 0, 0.1);
  position: relative;
  font-size: 20px;
  line-height: 50px;
  color: white;
}
.fileUpload .fileSelect:before {
  font-family: Entypo;
  content: '+';
  position: absolute;
  top: 0;
  left: 80px;
}

	</style>
</head>
<body>
<div class="upload-box">
<form id="uploadFile" class="fileUpload" method="POST" enctype="multipart/form-data">
<br>
<?php
if(isset($error)){
	?> <b style="color: red"><?=$error?></b> <?php
}
?>
<br>
  <label class="fileSelect">Upload File

	<input style="display: none;" type="file" name="upload" onchange="sub(this)">
  </label>

  <br>
  <b id="selected"></b>
  <br>
  <h4>Usage</h4>
  <progress value="<?=intval(folderSize('./files/'))?>" max="1000000000"></progress>
  <?php 
  function folderSize($dir){
	$count_size = 0;
	$count = 0;
	$dir_array = scandir($dir);
	  foreach($dir_array as $key=>$filename){
		if($filename!=".." && $filename!="."){
		   if(is_dir($dir."/".$filename)){
			  $new_foldersize = foldersize($dir."/".$filename);
			  $count_size = $count_size+ $new_foldersize;
			}else if(is_file($dir."/".$filename)){
			  $count_size = $count_size + filesize($dir."/".$filename);
			  $count++;
			}
	   }
	 }
	return $count_size;
	}
	function sizeFormat($bytes){ 
		$kb = 1024;
		$mb = $kb * 1024;
		$gb = $mb * 1024;
		$tb = $gb * 1024;
		
		if (($bytes >= 0) && ($bytes < $kb)) {
		return $bytes . ' B';
		
		} elseif (($bytes >= $kb) && ($bytes < $mb)) {
		return ceil($bytes / $kb) . ' KB';
		
		} elseif (($bytes >= $mb) && ($bytes < $gb)) {
		return ceil($bytes / $mb) . ' MB';
		
		} elseif (($bytes >= $gb) && ($bytes < $tb)) {
		return ceil($bytes / $gb) . ' GB';
		
		} elseif ($bytes >= $tb) {
		return ceil($bytes / $tb) . ' TB';
		} else {
		return $bytes . ' B';
		}
		}
			echo sizeFormat(folderSize('./files/'));
  ?>
  <p><?=sizeFormat(folderSize('./files/'))?> out of 1 GB (<a href="#" class="upgrade">Upgrade</a>)</p>

  <script>

function sub(obj) {
  var file = obj.value;
  var fileName = file.split("\\");
  document.getElementById("selected").innerHTML = fileName[fileName.length - 1];
  document.getElementById('uploadFile').submit();
  event.preventDefault();
}
  </script>
</form>
</div>


<br>
<br>
<div class="files-box">
<h2>Uploded Files</h2>
<?php 
$dirs = scandir('./files/');

	foreach($dirs as $dir){
		if($dir == '.' || $dir == '..') continue;
		$files = scandir('./files/'.$dir);
		foreach($files as $file){
			if($file == '.' || $file == '..' || $file == $dir) continue;
			
			?>
				<a href="/download.php?fid=./files/<?php echo $dir."/".$file; ?>"><?=$file?></a>
				<a href="/delete.php?fid=./files/<?php echo $dir."/".$file; ?>">Delete</a>
				<br>
			<?php

		}
	}

?>
</div>
</body>
</html>
