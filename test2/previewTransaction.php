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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
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
          .container .row .col button#refreshbtn {
            border-radius: 50%;
            position: fixed;
            float: right;
            margin-top: 20px;
            right: 20px;
            font-weight: bolder; 
            opacity:0.6;
            width: 60px;
            height: 60px;
            font-size: 20px;
            z-index: 3;
          }
          .container .row .col button#refreshbtn:hover {
            opacity: 1;
          }

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
        
        function update_details() 
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
        // document.write(data1);
          if(data1.includes("ok")){
            
           document.getElementById('success-msg').style.display =  "block";
          }
          else{
            
            document.getElementById("error-msg").style.display = "block";
          }

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert("some error"+errorThrown+" textStatus: "+textStatus);
  },
      complete: function(){

      }
    });
  }; 
          
  function check(){
    $.ajax({
      url: 'verify.php',
      data: "",
      dataType: "text",
      success: function(data){
        if(data==="true"){
          displayData();
          
        }
        else{
          document.getElementById('db_error').style.display = "block";
          document.getElementById('data-disp').style.display = "none";
        }

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert("some error"+errorThrown);
  },
      complete: function(){
       
      }
    });
  }
  
 
    </script>
    <script type="text/javascript">
      function clear(){
        $.ajax({
          url: 'compute/clearJson.php',
          complete: function(){
            // displayData();
          }
        });
      }
      function displayData(){
        var url_data = "compute/getTransactions.php";
        $('#putData').empty();
        $.ajax({
          url: url_data,
          data: "",
          type: 'POST',
          dataType: 'text',
          success: function(data){
            // var data1 = JSON.parse(data);
            // document.write(data);

            if(data==="No data"){
              document.getElementById('No-freq').style.display = "block";
              document.getElementById('data-disp').style.display = "none";
              document.getElementById('db_error').style.display = "none";
            }
            else{
              
              document.getElementById('No-freq').style.display = "none";
              document.getElementById('data-disp').style.display = "block";
              document.getElementById('db_error').style.display = "none";
            var tr =[];
            var json = $.parseJSON(data);
            // document.write(typeof json);
            $(json).each(function(i,val){
              

                // document.write("key:"+k+" Confidence:"+v['Confidence']+" Lift:"+v['Lift']);
                  // tr.push('<tr>');
                  // tr.push("<td>" + k + "</td>");
                  // tr.push("<td>" + v['Confidence'] + "</td>");
                  // tr.push("<td>" + v['Lift'] + "</td>");
                  // tr.push('</tr>');      
                  g.row.add([val]).draw(false);
            
              // $('#putData').append($(tr.join('')));
            // document.write(data);
            });
          }
          }
        });
      }




        </script>
        <script id="source" language="javascript" type="text/javascript">
    
  
 function displayAndCompute(){
    check();
    
  }
</script>
  </head>
  <body onload="displayAndCompute();">
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="img/custom-avatar-1.png" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo $_SESSION['username'] ?></h2><span>(Client)</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="dashboard.php" class="brand-small text-center"> <strong>D</strong><strong class="text-primary">A</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="dashboard.php"> <i class="icon-home"></i>Home    </a></li>
            
            <li><a href="viewFrequent.php"> <i class="fa fa-bar-chart"></i>Visualize Frequent Itemsets </a></li>
            <li><a href="displayFrequentItemset.php"> <i class="icon-grid"></i>Display Frequent Itemsets </a></li>
            <li><a href="association_rules.php"> <i class="icon-grid"></i>Generate Association Rules</a></li>
            <li class="active"><a href="previewTransaction.php"> <i class="icon-grid"></i>Preview Transactions</a></li>
            <li style="cursor: pointer;"><a data-toggle="modal" data-target="#myModal"> <i class="icon-check"></i>Update Hosting Details </a></li>
            <li><a href="logout.php"> <i class="icon-interface-windows"></i>Logout   </a></li>
            
          </ul>
        </div>
        
      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header" >
        <nav class="navbar" style="z-index: 1005">
          <div class="container-fluid" >
            <div class="navbar-holder d-flex align-items-center justify-content-between" >
              <div class="navbar-header" ><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="dashboard.php" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>Dynamic Data </span><strong class="text-primary">Analyser</strong></div></a></div>
              
            </div>
          </div>
        </nav>
      </header>
      <!-- Counts Section -->
      
      <!-- Header Section-->
      <!-- Modal-->
      <div>
                  <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 id="exampleModalLabel" class="modal-title">FTP Information</h5>
                          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                          <p>Update following details if required!</p>
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
            </form><center><div id="error-msg" style="display: none;"><p id="msg" style="color: red;">Error occured while updating details...</p></div></center><br><center><div id="success-msg" style="display: none;"><p id="msg" style="color: green;">Successfully updated your details!</p></div></center><br>
                        </div>
                        <div class="modal-footer">
                          <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                          <button type="button" class="btn btn-primary" onclick="update_details();">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
      <!-- Main Content area -->

        <div class="container">
          <div class="row">
          <div class="col">
            <button type="button" id="refreshbtn" onclick="check();" class="btn btn-primary">&#8635;</button>
            
            </div>
          </div>
          <div class="row" id="data-disp" style="display: none;">
            <div class="col">
              <div class="card" style="position: relative;top: 20px;">
                <div class="card-header">
                  <h5>Transaction Preview</h5>
                </div>
                <div class="card-body">
                <div class="table-responsive" style="margin-right: 2px;margin-left: 2px;">
                <table class="table table-striped " data-toggle="table" id="data-table">
                  <thead>
                    <tr>
                      <th >Itemsets</th>
                    </tr>
                  </thead>
                  <tbody id="putData">
                    
                  </tbody>
                </table>
              </div> 
              </div> 
              </div>
              </div>
            </div>
            <div class="row" id="db_error" style="display: none;">
            <div class="col">
              <div class="card" style="position: relative;top: 20px;">
                <div class="card-header">
                  <h5 style="color: red;">ERROR</h5>
                </div>
                <div class="card-body">
                  <p class="text-center">Please update your Database Details first!</p>
                </div>
              </div>
              </div>
            </div>
            <div class="row" id="No-freq" style="display: none;">
            <div class="col">
              <div class="card" style="position: relative;top: 20px;">
                  <div class="card-header">
                    <h5 style="color: orange;text-align: center;">Association Rules</h5>
                  </div>
                  <div class="card-body">
                    <p class="text-center" style="font-weight: bold;color: black;">No Association rules generated for provided dataset!</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal2"><!-- Place at bottom of page --></div>
          </div>
       

      <!-- end main -->
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Developed for <a href="https://bootstrapious.com" class="external">Final Year Project</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
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
    <script src="js/charts-home.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script type="text/javascript">
      $body = $("body");
      var g;
      $(document).on({
          ajaxStart: function() { $body.addClass("loading"); },
           ajaxStop: function() { $body.removeClass("loading"); }    
      });
      $(document).ready(function() {
      var m = $('#data-table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

    } );
      g = m;
} );
    </script>
    <!-- Datatable dependencies --><!-- 
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  </body>
</html>