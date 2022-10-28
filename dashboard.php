<?php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
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
            <a class=" navbar-brand" style="color:white;font-weight: bold;">HTA-Ecare</a>
    <form class="form-inline">
      <a class="btn btn-outline " href="cal.php" type="button" style="color: white; font-weight: bolder;"><i class="fa fa-fw fa-th mr-1"></i><span>Calendrier</span></a>
      <a class="btn btn-outline " href="ajouter.php" type="button" style="color: white; font-weight: bolder;"><i class="fa fa-plus  mr-2"></i><span>Ajouter</span></a></a>
      <a class="btn btn-outline " href="html/login.html" type="button" style="color: white; font-weight: bolder;"><i class="fa fa-sign-out"></i>
        déconnecter</a>

    </form>
  </nav>

  <div class="container mt-3" style="background-color: #000442;">
    <div class="row flex-lg-nowrap">


      <div class="col">
        <div class="row">
          <div class="col mb-3">
            <div class="card mb-3" style="background-color: #000442;">
              <div class="card-body">
                <div class="e-profile">
                  <div class="row">

                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                      <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:#bfeaff"> <?php echo ucfirst($_SESSION['first_name']); ?></h4>


                      </div>

                    </div>
                  </div>
                  <ul class="nav nav-tabs">
                    <li class="nav-item"><a href="" class="active nav-link" style="background-color: #000442; color:#bfeaff" ">Informations</a></li>
                          </ul>
                          <div class=" tab-content pt-3">
                        <div class="tab-pane active">
                          <form class="form" novalidate="">
                            <div class="row">
                              <div class="col">
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group" style="background-color: #000442; color:#bfeaff">
                                      <label>Nom</label>
                                      <input class="form-control" style="background-color: #000442; color:#bfeaff" type="text" name="name" placeholder="Farid" value=<?php echo ucfirst($_SESSION['last_name']); ?>>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group" style="background-color: #000442; color:#bfeaff">
                                      <label>Prénom</label>
                                      <input class="form-control" style="background-color: #000442; color:#bfeaff" type="text" name="prenom" placeholder="prénom" value=<?php echo ucfirst($_SESSION['first_name']); ?>>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group" style="background-color: #000442; color:#bfeaff">
                                      <label>Sex</label>
                                      <select style="background-color: #000442; color:#bfeaff" class="custom-select  mr-sm-2" id="inlineFormCustomSelectPref" value=<?php
                                                                                                                                                                    if ($_SESSION['first_name'] == 1) {
                                                                                                                                                                      echo 'homme';
                                                                                                                                                                    } else {
                                                                                                                                                                      echo 'femme';
                                                                                                                                                                    }
                                                                                                                                                                    ?>>
                                        <option selected value="1">homme</option>
                                        <option value="2">femme</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group" style="background-color: #000442; color:#bfeaff">
                                      <label>Age</label>
                                      <input style="background-color: #000442; color:#bfeaff" class="form-control" type="number" value=<?php echo ucfirst($_SESSION['age']); ?>>
                                    </div>
                                  </div>
                                </div>


                              </div>
                            </div>

                            <div class="row"style="text-align: center; margin-top:2%;">
                              <div class="col " >
                                <button class="btn btn-primary" style="background-color: #36bbce;color: white; text-align: center; width:130px" type="submit">Modifier</button>
                              </div>
                            </div>
                          </form>

                        </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-3 mb-3 mt-3">

          <div class="card mb-3 " style="color: #000442; border:#36bbce solid 6px">
            <div class="card-body">
              <h6 class="card-title font-weight-bold">HTA-Ecare</h6>
              <p class="card-text">l'application qui vous permette de sauvegarder e suiver vos résultats </p>

            </div>
          </div>

          <div class="card mb-3 " style="color: #000442; border:#6f00ff solid 6px">
            <div class="card-body">
              <h6 class="card-title font-weight-bold"><i class="fa fa-fw fa-th mr-1"></i><span>Ajouter</span></h6>
              <p class="card-text">Ajouter vos résultats mesurés </p>

            </div>
          </div>
          <div class="card mb-3 " style="color: #000442; border:#6f00ff solid 6px">
            <div class="card-body" style="text-align: center; justify-content: center;">
              
              <img src="vector/default.png" width="110" height="110" style="margin-top: -2%;" />
              

            </div>
          </div>


        </div>
        
      </div>
    </div>
  </div>

</body>

</html>