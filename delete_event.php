//delete.php

<?php

session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
} 

else {
  require_once('config.php');
if(isset($_POST["idi"]))
{
 
 $query = "DELETE from events WHERE idi=:idi AND id_user=".$_SESSION['id'];
 $statement = $pdo->prepare($query);
 $statement->execute(
  array(
   ':idi' => $_POST['idi']
  )
 );
}
}
?>


