
//load.php 

<?php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
} else {
  require_once('config.php');
   /* Values received via ajax */
$idi = $_POST['idi'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
// update the records
$sql = "UPDATE events SET title=?, start=?, end=? WHERE idi=?";
$q = $bdd->prepare($sql);
$q->execute(array($title, $start, $end, $idi));
}

?>