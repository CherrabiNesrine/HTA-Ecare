<?php

//insert.php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
} 

else {
  require_once('config.php');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events 
 (title, start, end,id_user) 
 VALUES (:title, :start, :end,".$_SESSION['id'].")";
 $statement = $pdo->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start' => $_POST['start'],
   ':end' => $_POST['end']
  )
 );
}
}

?>

