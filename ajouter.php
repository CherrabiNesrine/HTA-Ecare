<?php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
} else {
  require_once('config.php');


  if (isset($_POST['submit'])) {;
    if (isset($_POST['sys'], $_POST['dia'], $_POST['pul']) && !empty($_POST['sys']) && !empty($_POST['dia']) && !empty($_POST['pul'])) {





      $sys = trim($_POST['sys']);
      $dia = trim($_POST['dia']);
      $pul = trim($_POST['pul']);
      $date = date('d-m-Y H:i:s');



      $sql1 = "SELECT * FROM results WHERE  `date` >= CURDATE() AND `date` < CURDATE() + INTERVAL 1 DAY";

      $result_count =  $pdo->prepare($sql1);
      $result_count->execute();
      if ($result_count->rowCount() == 0) {
        echo "yes";
        $sql = "insert into results (date,sys, dia, pul, id_user) values(DATE_FORMAT(NOW(),'%Y-%m-%d %h:%i'),:sys,:dia,:pul,:id)";

        try {
          $handle = $pdo->prepare($sql);
          $params = [
            ':sys' => $sys,
            ':dia' => $dia,
            ':pul' => $pul,
            ':id' => $_SESSION['id'],

          ];

          $handle->execute($params);

          $success = 'Le resultat a été ajouté avec succès';
        } catch (PDOException $e) {
          $errors[] = $e->getMessage();
        }
      } else {

        $sql1 = "SELECT * FROM results WHERE `date` < NOW() - INTERVAL 1 HOUR AND ( `date` >= CURDATE() AND `date` < CURDATE() + INTERVAL 1 DAY )  ";
        $result_count =  $pdo->prepare($sql1);
        $result_count->execute();
        if ($result_count->rowCount() == 0) {

          $sql = "insert into results (date,sys, dia, pul, id_user) values(DATE_FORMAT(NOW(),'%Y-%m-%d %h:%i'),:sys,:dia,:pul,:id)";

          try {
            $handle = $pdo->prepare($sql);
            $params = [
              ':sys' => $sys,
              ':dia' => $dia,
              ':pul' => $pul,
              ':id' => $_SESSION['id'],

            ];

            $handle->execute($params);

            $success = 'Le resultat a été ajouté avec succès';
          } catch (PDOException $e) {
            $errors[] = $e->getMessage();
          }
        } else {
          echo "CURDATE()";
          $sql2 = " DELETE FROM results WHERE `date` < NOW() - INTERVAL 1 HOUR AND ( `date` >= CURDATE() AND `date` < CURDATE() + INTERVAL 1 DAY ) ";
          $pdo->exec($sql2);
          $success = 'DELETED SUCCSFULLY ';

          $sql = "insert into results (date,sys, dia, pul, id_user) values(DATE_FORMAT(NOW(),'%Y-%m-%d %h:%i'),:sys,:dia,:pul,:id)";

          try {
            $handle = $pdo->prepare($sql);
            $params = [
              ':sys' => $sys,
              ':dia' => $dia,
              ':pul' => $pul,
              ':id' => $_SESSION['id'],

            ];

            $handle->execute($params);

            $success = 'Le resultat a été ajouté avec succès';
          } catch (PDOException $e) {
            $errors[] = $e->getMessage();
          }
        }
      }
    } else {
      if (!isset($_POST['sys']) || empty($_POST['sys'])) {
        $errors[] = 'La Pression artérielle systolique est  requise ';
      } else {
        $valSys = $_POST['sys'];
      }
      if (!isset($_POST['dia']) || empty($_POST['dia'])) {
        $errors[] = 'La Pression artérielle diastolique requise ';
      } else {
        $valDia = $_POST['dia'];
      }

      if (!isset($_POST['pul']) || empty($_POST['pul'])) {
        $errors[] = 'La fréquence cardiaque ou pouls requise';
      } else {
        $valPul = $_POST['pul'];
      }
    }
  } else {
    $_SESSION['submit'] = 'NULL';
  }
}








?>

<!DOCTYPE html>
<html>

<head>


  ​<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #f5f5f5;
    }
  </style>




  <meta charset="utf-8" />



  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <script src="https://jsuites.net/v4/jsuites.js"></script>
  <script src="https://jsuites.net/v4/jsuites.webcomponents.js"></script>
  <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">





<body style="background-color: #000442;">
<nav class="navbar  justify-content-between" ">
            <a class=" navbar-brand" style="color:white;font-weight: bold;"> <i class="fa fa-arrow-left"></i> Liste des résultats</a>

  </nav>


  <!-- Button trigger modal -->
  <section class="container" style="margin-top:2%">
    <div class="row" ">




    <div class=" col">


      <div class="row">
        <div class="col mb-3">
          <div class="card mb-3">
            <div class="card-body" style="background-color: #000442;">
              <div class="e-profile">
                <div class="row">

                  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                      <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:#bfeaff"> <?php echo ucfirst($_SESSION['first_name']); ?></h4>


                    </div>
                    <div class="text-center text-sm-right">
                      <span class="badge badge-primary" style="background-color:#36bbce">HTA-Ecare</span>

                    </div>
                  </div>
                </div>
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="" class="active nav-link" style="background-color: #000442;color:#bfeaff">Informations</a></li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane active">
                    <form class="form" novalidate="">
                      <div class="row">
                        <div class="col" style="color:#bfeaff">
                          <div class="row">
                            <div class="col">
                              <div class="form-group" style="color:#bfeaff">
                                <label>Nom</label>
                                <input class="form-control" type="text" style="background-color: #000442; color:#bfeaff" name="name" placeholder="Farid" value=<?php echo ucfirst($_SESSION['last_name']); ?>>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label>Prénom</label>
                                <input class="form-control" style="background-color: #000442; color:#bfeaff" type="text" name="prenom" placeholder="prénom" value=<?php echo ucfirst($_SESSION['first_name']); ?>>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
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
                              <div class="form-group">
                                <label>Age</label>
                                <input style="background-color: #000442; color:#bfeaff" class="form-control" type="number" value=<?php echo ucfirst($_SESSION['age']); ?>>
                              </div>
                            </div>
                          </div>


                        </div>
                      </div>

                    </form>

                  </div>
                </div>
              </div>





              <!-- Modal -->
              <div class="e-profile">
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="" class="active nav-link" style="background-color: #000442;color:#bfeaff">Résultats</a></li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane active">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter Résultat</h5>

                          </div>
                          <div class="modal-body">
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                              <div class="form-group">
                                <input type="number" class="form-control" id="sys" name="sys" placeholder="SYS: Pression artérielle systolique (mmHg)" min=0 value="<?php echo ($valSys ?? '') ?>" require>
                              </div>
                              <div class="form-group">
                                <input type="number" class="form-control" id="dia" name="dia" placeholder="DIA: Pression artérielle diastolique (mmHg)" min=0 value="<?php echo ($valDia ?? '') ?>" require>
                              </div>
                              <div class="form-group">
                                <input type="number" class="form-control" id="pul" name="pul" placeholder="PULSE / PUL :  fréquence cardiaque ou pouls (/min)" min=0 value="<?php echo ($valPul ?? '') ?>" require>
                              </div>


                              <button name="submit" type="submit" class="btn btn-primary" style="background-color: #36bbce;color: white; text-align: center; width:130px"> Enregistrer</button>
                            </form>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                          </div>

                        </div>
                      </div>
                    </div>

                    <section >
                      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="input-group mb-4" style="border:#6f00ff solid 1px; background-color:#000442">






                          <span class="input-group-text" id="basic-addon">Filtrer de : </span>
                          <input id="calendar" class="form-control" name="from" style="background-color: #f3f3f3 ;" aria-describedby="basic-addon">

                          <span class="input-group-text" id="basic-addon1"> à : </span>
                          <input id="calendar1" name="to" class="form-control" aria-describedby="basic-addon1" style="background-color: #f3f3f3 ;">


                          <script>
                            jSuites.calendar(document.getElementById('calendar'), {
                              time: true,
                              format: 'DD-MM-YYYY h:mm',
                            });
                            jSuites.calendar(document.getElementById('calendar1'), {
                              time: true,
                              format: 'DD-MM-YYYY h:mm',
                            });
                          </script>

                          <button class="btn btn-primary" style="background-color:#36bbce" id="advanced-search-button" name="search" type="submit">
                            <i class="fa fa-search"></i>
                          </button>
                          <button class="btn btn-primary" style="background-color:#36bbce" id="advanced-search-button" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-plus"></i>
                          </button>
                          <a class="btn btn-primary" style="background-color:#36bbce" id="advanced-search-button" type="button" href="print.php">
                            <i class="fa fa-print" style="color: white;"></i>
                          </a>

                        </div>
                      </form>
                      <table style="color:#bfeaff">
                        <tr>
                          <th>DATE</th>
                          <th>SYS</th>
                          <th>DIA</th>
                          <th>PUL</th>
                        </tr>

                        <?php

                        if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                          $page_no = $_GET['page_no'];
                        } else {
                          $page_no = 1;
                        }
                        $total_records_per_page = 5;
                        $offset = ($page_no - 1) * $total_records_per_page;
                        $previous_page = $page_no - 1;
                        $next_page = $page_no + 1;
                        $adjacents = "2";


                        $sql = "SELECT * FROM results ";

                        $result_count =  $pdo->prepare($sql);
                        $result_count->execute();

                        $total_records = $result_count->rowCount();
                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                        $second_last = $total_no_of_pages - 1;


                        if (isset($_POST['search'])) {

                          if (isset($_POST['from'], $_POST['to']) && !empty($_POST['from']) && !empty($_POST['to'])) {
                            $from = $_POST['from'];
                            $to = $_POST['to'];
                            $dfrom = date("Y-m-d h:i:s", strtotime($from));
                            $dto = date("Y-m-d h:i:s", strtotime($to));
                            $sql = "SELECT DATE_FORMAT(date, '%d-%m-%Y %h:%i') as `date`,sys,dia,pul FROM results where id_user = " . $_SESSION['id'] . " AND `date` between '" . $dfrom . "' AND  '" . $dto . "' LIMIT $offset,$total_records_per_page";
                            $result = $pdo->prepare($sql);
                            $result->execute();
                          }
                        } else {
                          $sql = "SELECT DATE_FORMAT(date, '%d-%m-%Y %h:%i') as `date`,sys,dia,pul FROM results where id_user = " . $_SESSION['id'] . " LIMIT $offset,$total_records_per_page";
                          $result = $pdo->prepare($sql);
                          $result->execute();
                        }
                        if ($result->rowCount() > 0) :
                          $rows = $result->fetchAll();
                          foreach ($rows as $row) :

                        ?>
                            <tr style="background-color:#000442; border: 1px solid #36bbce;">
                              <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
                              <td><?php echo $row['date']; ?></td>
                              <td><?php echo $row['sys']; ?></td>
                              <td><?php echo $row['dia']; ?></td>
                              <td><?php echo $row['pul']; ?></td>
                            </tr>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </table>

                      <div style="margin-top: 2%;">
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
                      <section style="margin-top:4%; ">
                      <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC; color:#bfeaff'>
        <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
      </div>
                        <nav aria-label="Page navigation example " >
                          <ul class="pagination justify-content-end" >
                            <?php if ($page_no > 1) {
                              echo "<li style='border:#6f00ff solid 2px' class='page-item'><a class='page-link' href='?page_no=1'>First Page</a></li>";
                            } ?>
                            <li style="border:#6f00ff solid 2px" class="page-item" <?php if ($page_no <= 1) {
                                                    echo "class='disabled'";
                                                  } ?>><a class="page-link" <?php if ($page_no > 1) {
                                                                              echo "href='?page_no=$previous_page'";
                                                                            } ?>>Previous</a></li>
                            <li style="border:#6f00ff solid 2px"class="page-item" <?php if ($page_no >= $total_no_of_pages) {
                                                    echo "class='disabled'";
                                                  } ?>><a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                                              echo "href='?page_no=$next_page'";
                                                                            } ?>>Next</a></li>
                            <?php if ($page_no < $total_no_of_pages) {
                              echo "<li style='border:#6f00ff solid 2px'class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                            } ?>
                          </ul>
                        </nav>
                        
                      </section>






                    </section>
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
              <h6 class="card-title font-weight-bold"><i class="fa fa-fw fa-th mr-1"></i><span>Indication</span></h6>
              <p class="card-text" style="margin-left:-14%;list-style: none;">

                <p><i class="fa fa-search"></i> : Recherche sur les dates filtrées</p>
                <p><i class="fa fa-plus"></i> :  Ajouter les résultats </p>
                <p><i class="fa fa-print"></i>  : imprimer le tableau </p>
              
                          </p>

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
  </section>
</body>

</html>