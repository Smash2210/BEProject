<?php

session_start();
  if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    header('Location: login.php');
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Dashboard by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <style type="text/css">
             /* Start by setting display:none to make this hidden.
             Then we position it in relation to the viewport window
             with position:fixed. Width, height, top and left speak
             for themselves. Background we set to 80% white with
             our animation centered, and no-repeating */
          .container .modal2 {
              display:    none;
              position:   absolute;
              z-index:    1000;
              top:        0;
              left:       0;
              height:     100%;
              width:      100%;
              background: rgba( 255, 255, 255, .8 ) 
                          url('img/ajax-loader.gif') 
                          50% 50% 
                          no-repeat;
          }

          /* When the body has the loading class, we turn
             the scrollbar off with overflow:hidden */
          body.loading .container .modal2 {
              overflow: hidden;   
          }

          /* Anytime the body has the loading class, our
             modal element will be visible */
          body.loading .container .modal2 {
              display: block;
          }
        </style>
        <script id="source" language="javascript" type="text/javascript">
    
  function submitftp_details() 
  {
    var data = $('#register-form').serialize();
    // document.write(data);
    //-----------------------------------------------------------------------
    // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
    //-----------------------------------------------------------------------
    $.ajax({                                      
      url: 'add_ftp_for_user.php',                  //the script to call to get data          
      data: data,    
      type: 'post',                    //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
                      //data format      
      success: function(data1)          //on recieve of reply
      {
       
          if(data1.includes("ok")){
            
           document.location.href = "dashboard.php";
          }
          else{
            
            document.getElementById("errormsg").style.display = "block";
          }

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert("some error"+errorThrown+" textStatus: "+textStatus);
  },
      complete: function(){

      }
    });
  }; 
</script>
  </head>
  <body>
    <div class="page login-page">
      <div class="container" >
        <div class="form-outer text-center d-flex align-items-center" >
          <div class="form-inner" style="width: 600px;">
            <div class="logo text-uppercase"><span><small>Data &nbsp;</small></span><strong class="text-primary">Analyser</strong></div>
            <div class="text-center"><p>Please Provide following Details!</p><a href="login.php"><p style = "position: relative;top: 3px;color: green; font-weight: bold;text-decoration: underline;">Skip</p></a></div>
            <form id="register-form" method="post">
              <div class="form-group-material">
                <input id="register-hostname" type="text" name="hostname" required class="input-material">
                <label for="register-hostname" class="label-material">Hostname/Server-name</label>
              </div>
              <div class="form-group-material">
                <input id="register-ftp-username" type="text" name="ftp_username" required class="input-material">
                <label for="register-ftp-username" class="label-material">Ftp username</label>
              </div>
              <div class="form-group-material">
                <input id="register-ftp-password" type="password" name="ftp_password" required class="input-material">
                <label for="register-ftp-password" class="label-material">Ftp password</label>
              </div>
              <div class="form-group-material">
                <input id="register-db-name" type="text" name="db_name" required class="input-material">
                <label for="register-db-name" class="label-material">Database Name</label>
              </div>
              <div class="form-group-material">
                <input id="register-db-id" type="text" name="db_id" required class="input-material">
                <label for="register-db-id" class="label-material">Database user id</label>
              </div>
              <div class="form-group-material">
                <input id="register-db-password" type="password" name="db_password" required class="input-material">
                <label for="register-db-password" class="label-material">Database Password</label>
              </div>
              <div class="form-group-material">
                <input id="register-db-tablename" type="text" name="db_tablename" required class="input-material">
                <label for="register-db-tablename" class="label-material">Database Tablename</label>
              </div>
              <div class="form-group-material">
                <input id="register-domain" type="text" name="domain-name" required class="input-material">
                <label for="register-domain" class="label-material">Hosted Domain name</label>
              </div>
              <div class="terms-conditions d-flex justify-content-center">
                <input id="license" type="checkbox" class="form-control-custom" required>
                <label for="license">Agree the terms and policy</label>
              </div>
            </form><div id="errormsg" style="display: none;"><p id="msg" style="color: red;">Error occured while updating details...</p></div><br>
            <button id="login" type="button" class="btn btn-primary" onclick="submitftp_details();" >Update</button><br><br>
            <small>Already have an account? </small><a href="login.html" class="signup">Login</a><br><a href="index.html" class="signup">Visit Homepage!</a>
          </div>
          <div class="copyrights text-center">
            <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
          </div>
        </div>
        <div class="modal2"><!-- Place at bottom of page --></div>
      </div>
    </div>
    <!-- Javascript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script type="text/javascript">
      $body = $("body");

      $(document).on({
          ajaxStart: function() { $body.addClass("loading"); },
           ajaxStop: function() { $body.removeClass("loading"); }    
      });
    </script>
  </body>
</html>