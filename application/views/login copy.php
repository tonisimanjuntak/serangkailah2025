<!DOCTYPE html>
<html lang="en">
<head>
  <title>SERANGKAILAH | LOGIN</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" type="image/png" href="<?php echo base_url('images/tutwurihandayani.png') ?>"/>


  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>vendor/bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>vendor/animate/animate.css">
  
  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>vendor/css-hamburgers/hamburgers.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>vendor/select2/select2.min.css">

  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>css/util.css">
  <link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/login/')) ?>css/main.css">



  <style>
    
    body, html {
      height: 100%;
    background-image: url("images/bgserangkailah.jpg");
    -webkit-background-size: cover; /* For WebKit */
    -moz-background-size: cover;    /* Mozilla */
    -o-background-size: cover;      /* Opera */
    background-size: cover;         /* Generic */
    }

    #background {
          
      }


    @media (min-width:320px)  { 

      #c2{
          margin-left:auto;
          margin-right:0;
          margin-top: 0;
        height: 100%;
        width: 80%;
      }​

    }

    @media (min-width:961px)  { 

        #c2{
          margin-left:auto;
          margin-right:0;
          margin-top: 0;
        height: 100%;
        width: 30%;
      }​

    }

    .full-height {
      height: 100%;
    }

  </style>
</head>
<body>
  
  
      <div class="bg-white p-5 full-height" id="c2">
          
          <form class="" action="<?php echo(site_url('Login/cek_login')) ?>" method="post" id="form">


            <div class="text-center">
              <img src="<?php echo(base_url('images/tutwurihandayani.png')) ?>" alt="IMG" style="width: 30%;">              
            </div>

            <h3 class="text-center mb-4">Selamat Datang</h3>

            <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
              <input class="input100" type="text" name="username" id="username" placeholder="Username">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>

            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input class="input100" type="password" name="password" id="password" placeholder="Password">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>
            
            <div class="form-group row">
              <label for="" class="col-md-4 col-form-label text-right mt-2">Tahun</label>
              <div class="col-md-8">
                <div class="wrap-input100 validate-input" data-validate = "Tahun is required">
                  <input class="input100" type="number" name="tahunanggaran" id="tahunanggaran" value="<?php echo(date('Y')) ?>" min="2025" max="2100">
                  <span class="focus-input100"></span>
                </div>
              </div>
            </div>


            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lclr9wfAAAAACKIegQtyaCFgj9WrTApK5CPUB1Q"></div>
            </div>

            <div class="form-group text-sm-center">
              <?php
                $pesan = $this->session->flashdata("pesan");
                if (!empty($pesan)) {
                    echo $pesan;
                }
                ?>
            </div>
            
            <div class="container-login100-form-btn">
              <button class="login100-form-btn" type="submit">
                Login
              </button>
            </div>
  <!-- 
            <div class="text-center p-t-12">
              <span class="txt1">
                Lupa
              </span>
              <a class="txt2" href="#">
                Username / Password?
              </a>
            </div>

            <div class="text-center p-t-20">
              <a class="txt2" href="#">
                Register Anggota
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
              </a>
            </div>
   -->
            
          </form>

      </div>
  <script src="<?php echo(base_url('assets/login/')) ?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="<?php echo(base_url('assets/login/')) ?>vendor/bootstrap/js/popper.js"></script>
  <script src="<?php echo(base_url('assets/login/')) ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="<?php echo(base_url('assets/login/')) ?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="<?php echo(base_url('assets/login/')) ?>vendor/tilt/tilt.jquery.min.js"></script>

  <script src='https://www.google.com/recaptcha/api.js'></script>

  <script >
    $('.js-tilt').tilt({
      scale: 1.1
    })
  </script>
<!--===============================================================================================-->
  <script src="<?php echo(base_url('assets/login/')) ?>js/main.js"></script>

</body>
</html>