<?php
$perpage = 1;
$mysqli = new mysqli('localhost','root','','ariyak');
if($mysqli->connect_error){
    die('Error : ('.$mysqli->connect_errno.')'.$mysqli->connect_error);
}
$numpage = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
if(!is_numeric($numpage)){
    header('HTTP/1.1 500 Invalid page number!');
    exit();
}
$posisi = (($numpage-1) * $perpage);
$hasil = $mysqli->prepare("SELECT id, titre , descriptif FROM offresguide LIMIT ?, ?");
$hasil->bind_param("dd", $posisi, $perpage);
$hasil->execute();
$hasil->bind_result($id, $titre, $descriptif);
while($hasil->fetch()){
    echo "<div class='well well-sm'><b>".$id.". ".$titre."</b><br/>".$descriptif."</div>";
}
?>