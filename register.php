<?php
session_start();
require_once('config.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['sex'], $_POST['age'], $_POST['email'], $_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['sex']) && !empty($_POST['age']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $sex = trim($_POST['sex']);
        $age = trim($_POST['age']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $options = array("cost" => 4);
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        $date = date('d-m-Y H:i:s');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = 'select * from members where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email' => $email];
            $stmt->execute($p);

            if ($stmt->rowCount() == 0) {
                $sql = "insert into members (first_name, last_name, sex, age, email, `password`, created_at,updated_at) values(:fname,:lname,:sex,:age,:email,:pass,:created_at,:updated_at)";

                try {
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':fname' => $firstName,
                        ':lname' => $lastName,
                        ':sex' => $sex,
                        ':age' => $age,
                        ':email' => $email,
                        ':pass' => $hashPassword,
                        ':created_at' => $date,
                        ':updated_at' => $date
                    ];

                    $handle->execute($params);

                    $success = 'L utilisateur a été créé avec succès';
                } catch (PDOException $e) {
                    $errors[] = $e->getMessage();
                }
            } else {
                $valFirstName = $firstName;
                $valLastName = $lastName;
                $valsex = $sex;
                $valage = $age;
                $valEmail = '';
                $valPassword = $password;

                $errors[] = 'L adresse email est déjà enregistrée';
            }
        } else {
            $errors[] = "adress Email non valid";
        }
    } else {
        if (!isset($_POST['first_name']) || empty($_POST['first_name'])) {
            $errors[] = 'Prenom est  requis ';
        } else {
            $valFirstName = $_POST['first_name'];
        }
        if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
            $errors[] = 'Nom est requis ';
        } else {
            $valLastName = $_POST['last_name'];
        }

        if (!isset($_POST['sex']) || empty($_POST['sex'])) {
            $errors[] = 'sex est requis';
        } else {
            $valsex = $_POST['sex'];
        }
        if (!isset($_POST['age']) || empty($_POST['age'])) {
            $errors[] = 'l âge est requis';
        } else {
            $valage = $_POST['age'];
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'Email est requis';
        } else {
            $valEmail = $_POST['email'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'Password is required';
        } else {
            $valPassword = $_POST['password'];
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body style="background-color: #000442;">
    <nav class="navbar  justify-content-between" ">
            <a class=" navbar-brand" style="color:white;font-weight: bold;"> <i class="fa fa-arrow-left"></i> Formulaire d'inscription </a>
    </nav>
    <section class="container">
        
    <div class="row" style="margin-top: 5%;">      
    <div class="col"style="text-align: center; justify-content: center;"> <img src="vector/best.png" width="370" height="370" style="margin-top: -4%; margin-left:-4%" /></div>

                
                    
                   
                <div class="col">
                <p style="color:#bfeaff;opacity: 0.7;">Merci de fournir vos iformations</p>
                <form style="width:600px; " method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" style="background-color: #000442; color:#bfeaff" name="first_name" placeholder="Prénom" value="<?php echo ($valFirstName ?? '') ?>">
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" style="background-color: #000442; color:#bfeaff" name="last_name" ,placeholder="Nom" value="<?php echo ($valLastName ?? '') ?>">
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <select class="custom-select my-1 mr-sm-2" style="background-color: #000442; color:#bfeaff" name="sex" value="<?php echo ($valsex ?? '') ?>">
                            <option selected value="1">homme</option>
                            <option value="2">femme</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" style="background-color: #000442; color:#bfeaff" class="form-control" name="age" value="<?php echo ($valage ?? '') ?>" placeholder="Age" min="10" max="100" required>
                    </div>
                    <div class="form-group">
                        <input type="email" style="background-color: #000442; color:#bfeaff" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" value="<?php echo ($valEmail ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="password" style="background-color: #000442; color:#bfeaff" class="form-control" name="password" placeholder="Mot de passe" value="<?php echo ($valPassword ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="confirmpassword" style="background-color: #000442; color:#bfeaff" class="form-control" id="exampleInputPassword1" placeholder="Confirmer le mot de passe" required>
                    </div>
                    <div class="col" style="text-align: center;">
                        <p style="text-align: center; margin: 1%; opacity: 0.7;color:#bfeaff">
                            Vous avez déjà un compte ? <a style="color:#36bbce; " href="login.php">Connecter</a></p>
                        <button class="btn " name="submit" style=" width:130px ;margin-top: 1%; color: white; background-color: #36bbce;" type="submit">Inscrire</button>
                    </div>
                    <div >
                        
                        <?php
                        if (isset($errors) && count($errors) > 0) {
                            foreach ($errors as $error_msg) {
                                echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                            }
                        }

                        if (isset($success)) {

                            echo '<div class="alert alert-success">' . $success . '</div>';
                        }
                        ?>
                    </div>
                </form>

                </div>
    </div>
       
    </section>
</body>

</html>