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
      if($result_count->rowCount() == 0)
      {
      echo"yes";
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
    else {
      
      $sql1 = "SELECT * FROM results WHERE `date` < NOW() - INTERVAL 1 MINUTE AND ( `date` >= CURDATE() AND `date` < CURDATE() + INTERVAL 1 DAY )  ";
      $result_count =  $pdo->prepare($sql1);
      $result_count->execute();
      if($result_count->rowCount() == 0){

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
      else{
        echo"CURDATE()";
        $sql2 =" DELETE FROM results WHERE `date` < NOW() - INTERVAL 5 MINUTE AND ( `date` >= CURDATE() AND `date` < CURDATE() + INTERVAL 1 DAY ) ";
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

  }
  else{
    $_SESSION['submit']='NULL';
    
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





<body class="container" >



  <!-- Button trigger modal -->
  <div class="row" style="margin: 4% ;">


    

    <div class="col">


    <div class="row">
                  <div class="col mb-3">
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="e-profile">
                          <div class="row">
                            
                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                              <div class="text-center text-sm-left mb-2 mb-sm-0">
                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"> <?php echo ucfirst($_SESSION['first_name']); ?></h4>
                            
                              
                              </div>
                              <div class="text-center text-sm-right">
                                <span class="badge badge-primary" >HTA-Ecare</span>
                                
                              </div>
                            </div>
                          </div>
                          <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="" class="active nav-link">Informations</a></li>
                          </ul>
                          <div class="tab-content pt-3">
                            <div class="tab-pane active">
                              <form class="form" novalidate="">
                                <div class="row">
                                  <div class="col">
                                    <div class="row">
                                      <div class="col">
                                        <div class="form-group">
                                          <label>Nom</label>
                                          <input class="form-control" type="text" name="name" placeholder="Farid" value=<?php echo ucfirst($_SESSION['last_name']); ?>>
                                        </div>
                                      </div>
                                      <div class="col">
                                        <div class="form-group">
                                          <label>Prénom</label>
                                          <input class="form-control" type="text" name="prenom" placeholder="prénom" value=<?php echo ucfirst($_SESSION['first_name']); ?>>
                                        </div>
                                      </div>
                                      <div class="col">
                                        <div class="form-group">
                                            <label>Sex</label>
                                            <select class="custom-select  mr-sm-2" id="inlineFormCustomSelectPref"  
                                              value= <?php
                                              if ($_SESSION['first_name'] == 1){
                                                echo 'homme' ;
                                              }  
                                              else{
                                                echo 'femme';
                                              }
                                              ?> >
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
                                          <input class="form-control" type="number"  value=<?php echo ucfirst($_SESSION['age']); ?> >
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
                            <li class="nav-item"><a href="" class="active nav-link">Résultats</a></li>
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


                <button name="submit" type="submit" class="btn btn-primary"> Enregistrer</button>
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>

          </div>
        </div>
      </div>

      <section class="container">
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="container">
      
        <div class="input-group ">

          <span class="input-group-text" id="basic-addon">Filtrer de : </span>
          <input  id="calendar" class="form-control" name="from" style="background-color: #f3f3f3 ;" aria-describedby="basic-addon" >

          <span class="input-group-text" id="basic-addon1"> à : </span>
          <input  id="calendar1" name="to" class="form-control" aria-describedby="basic-addon1" style="background-color: #f3f3f3 ;">


          <script>
           
            jSuites.calendar(document.getElementById('calendar'), {
              time:true,
              format:'DD-MM-YYYY h:mm',
            });
            jSuites.calendar(document.getElementById('calendar1'), {
              time:true,
              format:'DD-MM-YYYY h:mm',
            });
          </script>

          <button class="btn btn-primary" id="advanced-search-button"  name="search" type="submit">
            <i class="fa fa-search"></i>
          </button>
          <button class="btn btn-large btn-primary" id="advanced-search-button" type="button" onClick="window.print()" >
            <i class="fa fa-print" style="color: white;"></i>
          </button>
         
         
          
        </div>
        </div>
        </form>
        <table>
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
        


          if(isset($_POST['search'])){
            
            if (isset($_POST['from'], $_POST['to'])&& !empty($_POST['from']) && !empty($_POST['to'])){
              $from=$_POST['from'];
              $to=$_POST['to'];
              $dfrom=date("Y-m-d h:i:s", strtotime($from));
              $dto=date("Y-m-d h:i:s", strtotime($to));
              $sql = "SELECT DATE_FORMAT(date, '%d-%m-%Y %h:%i') as `date`,sys,dia,pul FROM results where id_user = " . $_SESSION['id'] . " AND `date` between '". $dfrom . "' AND  '". $dto . "'";
              $result = $pdo->prepare($sql);
              $result->execute();
        
            }
        
          }

          else{
          $sql = "SELECT DATE_FORMAT(date, '%d-%m-%Y %h:%i') as `date`,sys,dia,pul FROM results where id_user = " . $_SESSION['id'];
          $result = $pdo->prepare($sql);
          $result->execute();
          }
          if ($result->rowCount() > 0) :
            $rows = $result->fetchAll();
            foreach ($rows as $row) :
              
          ?> 
              <tr>
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







      </section>
                            </div></div></div></div>
    </div>
                  </div>


  </div>
 
</body>

</html>