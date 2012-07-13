<?php session_start();?>
<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>App Asignacion</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link rel='stylesheet' href='http://localhost/ista/css/bootstrap.css' />
    <link rel="stylesheet" href="http://localhost/ista/css/smoothness/jquery-ui-1.8.16.custom.css" />
   <script src="http://localhost/ista/js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="http://localhost/ista/js/jquery.validate.min.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="http://localhost/ista/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="http://localhost/ista/js/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="http://localhost/ista/js/ui/i18n/jquery.ui.datepicker-es.js"></script>
	
	
    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      .container {
        width: 900px;
        
               
        /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
      }

      /* The white background content wrapper */
      .content {
        
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Styles you shouldn't keep as they are for displaying this base example only */
      .content .span10,
      .content .span4 {
        min-height: 500px;
      }
      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

    </style>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="http://localhost/ista/index.php"> <?php print NOMBRE ?></a>
          <ul class="nav">
            <li><a href="http://localhost/ista/index.php">Inico</a></li>
            <li><a href="http://localhost/ista/menu.php">Menu</a></li>
            <li><a href="#contact">contacto</a></li>
          </ul>
          <?php
          if(@$_SESSION["ok"]== TRUE){
              ?>
        <ul class="nav">
          <li>
              <a href="<?php print "http://localhost/ista/close.php"; ?>"><span class="label warning"> <?php print $_SESSION["usuario"] ?> <strong>Cerrar Sesi&oacute;n</strong></span></a>
          
                   
              
              
              </li>
        </ul>     
          <?php }else{
          ?>
          
          <form action="http://localhost/ista/logueo.php"  method="post">
            <input class="input-small" type="text" placeholder="Username" name="usuario" />
            <input class="input-small" type="password" placeholder="Password" name="clave" />
            <button class="btn" type="submit">Ingresar</button>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1><?php print NOMBRE ?> <small><?php print TITULO ?></small></h1>
        </div>
        <div class="row">
          <div class="span10">
