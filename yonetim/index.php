<?php require_once('../Connections/frisby.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "giris.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php include 'header.php'; ?>
<?php

$oyunsayi = mysql_query("SELECT * FROM oyunlar");
$toplam_oyun = mysql_num_rows($oyunsayi);
$katsayi = mysql_query("SELECT * FROM kategoriler");
$toplam_kat = mysql_num_rows($katsayi);
$yorsayi = mysql_query("SELECT * FROM yorumlar");
$toplam_yor = mysql_num_rows($yorsayi);
$uyeler = mysql_query("SELECT * FROM uyeler");
$toplam_uy = mysql_num_rows($uyeler);
 ?>
<body>

<?php include 'sidebar.php'; ?>
<div id="icerik">
	<div class="toplam"><span><?php echo $toplam_oyun; ?></span> Oyun</div>
    <div class="toplam"><span><?php echo $toplam_kat; ?></span> Kategori</div>
    <div class="toplam"><span><?php echo $toplam_yor; ?></span> Yorum</div>
    <div class="toplam"><span><?php echo $toplam_uy; ?></span> Üye</div>
</div>
</body>
</html>