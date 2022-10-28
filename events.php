<?php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
} else {
  require_once('config.php');
// List of events
$json = array();

// Query that retrieves events
$request = "SELECT * FROM events where id_user = ".$_SESSION['id']." ORDER BY idi";


// Execute the query
$result = $pdo->query($request) or die(print_r($bdd->errorInfo()));

// sending the encoded result to success page
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
}
?>