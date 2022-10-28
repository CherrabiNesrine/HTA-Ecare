<?php
session_start();
require_once('config.php');

if (isset($_POST['submit'])) {

  if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $sql = "select * from members where email = :email ";
      $handle = $pdo->prepare($sql);
      $params = ['email' => $email];
      $handle->execute($params);
      if ($handle->rowCount() > 0) {
        $getRow = $handle->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $getRow['password'])) {
          unset($getRow['password']);
          $_SESSION = $getRow;
          header('location:dashboard.php');
          exit();
        } else {
          $errors[] = "Wrong Email or Password";
        }
      } else {
        $errors[] = "Wrong Email or Password";
      }
    } else {
      $errors[] = "Email address is not valid";
    }
  } else {
    $errors[] = "Email and Password are required";
  }
}
?>




<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="background-color: #000442;">

  <nav class="navbar  justify-content-between" ">
            <a class=" navbar-brand" style="color:white;font-weight: bold;"> <i class="fa fa-arrow-left"></i> Formulaire de connexion</a>

  </nav>
  <section class="container ">


    <div style="text-align: center; justify-content: center;"> <img src="vector/best.png" width="240" height="200" style="margin-top: -2%;" /></div>



    <?php
    if (isset($errors) && count($errors) > 0) {
      foreach ($errors as $error_msg) {
        echo '<div class="alert alert-danger">' . $error_msg . '</div>';
      }
    }
    ?>

    <form style="width:600px; " class="container" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

      <p style="color:#bfeaff;opacity: 0.7;">Merci de fournir vos identifiants</p>
      <div class="form-group" ">

                <input type=" email" class="form-control" style="background-color: #000442; color:#bfeaff" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Email">

      </div>
      <div class="form-group">

        <input type="password" class="form-control" style="background-color: #000442; color:#bfeaff" id="exampleInputPassword1" name="password" placeholder="Mot de passe">
      </div>
      <div class="row">
        <div class="col">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1" style="opacity: 0.7; color:#bfeaff">se souvenir de moi </label>
          </div>
        </div>
        <div class="col" style="opacity: 0.7; text-align: end;"><a href="send_email.php" style="color:#36bbce;">Mot de passe oublier ?</a></div>


      </div>
      <div class="col" style="text-align: center;">
        <p style="text-align: center; margin: 5%; opacity: 0.7; color:#bfeaff"> vous n'avez pas de compte ? <a style="color:#36bbce;" href="register.php">S'inscrire</a></p>
        <button type="submit" class="btn " name="submit" style="background-color: #36bbce;color: white; text-align: center; width:130px"> Connecter </button>
      </div>
    </form>







  </section>
</body>

</html>