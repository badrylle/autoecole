<?php
//session_cache_limiter('private_no_expire, must-revalidate');
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/jpg" href="autoecole.gif" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Auto Ecole</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Fuelux css -->
    <link href="css/fuelux.min.css" rel="stylesheet" />
    <!-- Auto Ecole css -->
    <link href="css/autoecole.css" rel="stylesheet" />
    <!-- Datepicker.js -->
    <link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker-bs3.css" />
    <!-- js jquery-->
	<script src="js/jquery.js"></script>
    <script src="js/jquery.autocomplete.min.js"></script>
    <script src="js/respond.min.js"></script>
    
    <!-- js autoecole-->
    <script src="js/autoecole.js"></script>
    <!-- js bootstrap-->
	<script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Fuelux js -->
    <script src="js/fuelux.min.js"></script>
    <!-- js moment-->
    <script type="text/javascript" src="js/moment.js"></script>
    <!-- js daterangepicker-->
      <script type="text/javascript" src="js/daterangepicker.js"></script>
      
      <!-- Javascript -->
<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js"></script>
<script type='text/javascript' src="assets/js/css3-mediaqueries.js"></script>   
 
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->
<style>
body {
color:black;
background-color:white;
background-image:url(autoecole1.jpg);
}
</style>
</head>
<body class="fuelux" style="background: url(radar.jpg) no-repeat;">
  <br /><br />
<?php
include("pages/fonctions.php");
  $mysqli = db_connexion();
$etat = "hidden";
$res=$mysqli->query("select * from etabliessement");
if($res){
    $row = $res->fetch_object();
    $societe = $row->Nom_Etablissement;
}
  
if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password = md5($password);
    $user = Comptes($mysqli,$email,$password);
    if($user!==""){
       $tab = explode("-",$user);
       $nomprenom = $tab[0];
       $typecompte = $tab[1];
       $idCompte = $tab[2];
       
       $_SESSION['email'] = $email;
       $_SESSION['password'] = $password;
       $_SESSION['nomprenom'] = $nomprenom;
       $_SESSION['typecompte'] = $typecompte;
       $_SESSION['IDCompte'] = $idCompte;
       
       $date = date("Y-m-j");
       $time = gmdate("H:i:s");
       //echo($date);
       $table = "connexions";
       $attributs = "IDComptes,DateConnect,HeureConnect,heureMaj,enCours";//,HeureConnect,HeureDeconnect";
       $valeurs = "'$idCompte','$date','$time','$time','1'";
       $res = insertData($mysqli,$table,$attributs,$valeurs);
       $idConnect = $mysqli->insert_id;
       $_SESSION['IDConnect'] = $idConnect;
       //echo($idConnect);
       if($res){
            //echo($nomprenom."et ".$typecompte); 
            print ("<script language = \"JavaScript\">"); 
           print ("location.href = 'pages/index.php';"); 
           print ("</script>");
       }
    }else{
        $etat = "";
        ?>
    
    <?php
    }
   
}
?>
    <div class="container">  
    <legend style="font-size: x-large;"><strong>Bienvenue dans votre application de gestion d'auto école</strong></legend>  
        <div class="alert alert-danger fade in" <?php echo($etat); ?>>
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong> Erreur d'identification à la plateforme, veuillez saisir les bonnes informations ou contactez l'administrateur de la plateforme </strong> 
        </div>
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">IDENTIFICATION << <?php echo($societe); ?>>></div>
                        <div style="float:right; font-size:x-large; position: relative; top:-25px"><a href="#"> </a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" action="index.php" method="POST">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="email" value="" placeholder="Votre Email" />                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="Mot de passe" />
                                    </div>
                                    
                                <div style="margin-top:10px; " class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <button id="valider" name="valider" class="btn btn-success"><span class="glyphicon glyphicon-lock"></span> Connexion</button>
                                    </div>
                                    <div class="col-sm-12 controls">
                                    <label>Email: <em>demo@demo.com</em> et mot de passe: <em>demo</em></label>
                                    </div>
                                </div>


                                  
                            </form>     



                        </div>                     
                    </div>  
        </div>
       
   
    

 <br /><br /><br /> 
   
     <!-- insertion du Footer -------------------->
    <?php include("pages/footer.php"); ?>
    </div> <!-- Fin du conteneur -->
    <!-- Fin du contenu de la page -->
    
    
  </body>
</html>