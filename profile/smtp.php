<?php
    require_once('../_inc/db.php');
    session_start();
    require_once('../_inc/expire.php');
    if(!$_SESSION['login']){
        header("Location: ../login.php");
    } else {
        $uid = $_SESSION['uid'];
    }
    $euid = $_GET['euid'];
    
    // Pegar dados e definir acao

    if ($result = $conn->query("SELECT * FROM smtp ORDER BY id")) {
        if ($result->num_rows > 0) {
            // Atualizo se tiver
            $stmt = $conn->prepare("SELECT `smtp_user`, `smtp_host`, `smtp_password`, `smtp_port`, `contact_form`, `cotacao_form` FROM `smtp` ORDER BY id");
            if($stmt){
                $stmt->execute();
                $stmt->bind_result($smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form);
                while($stmt->fetch()) {
                    $smtp_user = $smtp_user;
                    $smtp_host = $smtp_host;
                    $smtp_password = $smtp_password;
                    $smtp_port = $smtp_port;
                    $contact_form = $contact_form;
                    $cotacao_form = $cotacao_form;
                }
                $stmt->close();
            }

            if(isset($_POST['update'])):
                $smtp_user = htmlentities($_POST['smtp_user'], ENT_QUOTES);
                $smtp_password = htmlentities($_POST['smtp_password'], ENT_QUOTES);
                $smtp_host = htmlentities($_POST['smtp_host'], ENT_QUOTES);
                $smtp_port = htmlentities($_POST['smtp_port'], ENT_QUOTES);
                $contact_form = htmlentities($_POST['contact_form'], ENT_QUOTES);
                $cotacao_form = htmlentities($_POST['cotacao_form'], ENT_QUOTES);
                
                $stmt = $conn->prepare("UPDATE smtp SET `smtp_user` = ?, `smtp_host` = ?, `smtp_password` = ?, `smtp_port` = ?, `contact_form` = ?, `cotacao_form` = ?");

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("ssssss", $smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: smtp.php?euid=".$uid); 
            endif;
        } else {
            // Adiciono se nao tiver
            if(isset($_POST['update'])) :
                $stmt = $conn->prepare("INSERT smtp (`smtp_user`, `smtp_host`, `smtp_password`, `smtp_port`, `contact_form`, `cotacao_form`) VALUES (?, ?, ?, ?, ?, ?)");
                $smtp_user = htmlentities($_POST['smtp_user'], ENT_QUOTES);
                $smtp_host = htmlentities($_POST['smtp_host'], ENT_QUOTES);
                $smtp_password = htmlentities($_POST['smtp_password'], ENT_QUOTES);
                $smtp_port = htmlentities($_POST['smtp_port'], ENT_QUOTES);
                $contact_form = htmlentities($_POST['contact_form'], ENT_QUOTES);
                $cotacao_form = htmlentities($_POST['cotacao_form'], ENT_QUOTES);
                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("ssssss", $smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: smtp.php?euid=".$uid); 
            endif;           
        }
    }

    // // Update

    // if(isset($_POST['update'])){
    //     $telefone = htmlentities($_POST['telefone'], ENT_QUOTES);
    //     $email = htmlentities($_POST['email'], ENT_QUOTES);
    //     $endereco = htmlentities($_POST['endereco'], ENT_QUOTES);

    //     $stmt = $conn->prepare("UPDATE contato SET `telefone` = ?, `email` = ?, `endereco` = ?");

    //     if(isset($stmt) && $stmt !== FALSE) {
    //         $stmt->bind_param("sss", $telefone, $email, $endereco);
    //         $stmt->execute();
    //         $stmt->close();
    //     } else {
    //         die($conn->error);
    //     }
        
    //     $_SESSION['acessedUid'] = $euid;
    //     header("Location: contato.php?euid=".$_SESSION['acessedUid']);
    //     // $conn->close();
    // }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/admin-logo-dark.png">
    <title>Precisao Servicos Gerais - Dashboard - Ola, <?php echo $_SESSION['login']; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="<?php echo "index.php?euid=".$uid; ?>">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="plugins/images/admin-logo.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="plugins/images/admin-logo-dark.png" alt="home" class="light-logo" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="plugins/images/admin-text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="plugins/images/admin-text-dark.png" alt="home" class="light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li> -->
                    <li>
                        <a class="profile-pic" href="<?php echo "edit-profile.php?euid=".$uid; ?>"> <img src="https://pixinvent.com/materialize-material-design-admin-template/images/avatar/avatar-7.png" alt="user-img" width="36" class="img-circle">Seja bem vindo(a), <b class="hidden-xs"><?php echo $_SESSION['login']; ?></b></a>
                        <a class="acesse" href="http://precisaoservicos.com.br/hmg" title="Acesse seu site" target="_blank">Acesse seu site</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
                </div>
                <?php include('_inc/nav.php'); ?>
                <div class="center p-20">
                    <a href="../_inc/logout.php"  class="btn btn-danger btn-block waves-effect waves-light" title="Sair">Sair</a>
                </div>
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">SMTP/E-MAIL Settings</h4> 
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <!-- <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white">User Name</h4>
                                        <h5 class="text-white">info@myadmin.com</h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple"><i class="ti-facebook"></i></p>
                                    <h1>258</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue"><i class="ti-twitter"></i></p>
                                    <h1>125</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger"><i class="ti-dribbble"></i></p>
                                    <h1>556</h1> </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST">
                                <div class="form-group">
                                    <label class="col-md-12">SMTP HOST</label>
                                    <div class="col-md-12">
                                        <input name="smtp_host" type="text" value="<?php echo (isset($smtp_host)) ? $smtp_host : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">SMTP User</label>
                                    <div class="col-md-12">
                                        <input name="smtp_user" type="text" value="<?php echo (isset($smtp_user)) ? $smtp_user : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-12">SMTP Password</label>
                                    <div class="col-md-12">
                                        <input name="smtp_password" type="password" placeholder="<?php echo (isset($smtp_password)) ? $smtp_password : ''; ?>" value="<?php echo (isset($smtp_password)) ? $smtp_password : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label class="col-md-12">SMTP PORT</label>
                                    <div class="col-md-12">
                                        <input name="smtp_port" type="text" value="<?php echo (isset($smtp_port)) ? $smtp_port : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>     
                                <div class="form-group">
                                    <label class="col-md-12">Email para contato</label>
                                    <div class="col-md-12">
                                        <input name="contact_form" type="email" value="<?php echo (isset($contact_form)) ? $contact_form : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-12">Email para receber a cotação</label>
                                    <div class="col-md-12">
                                        <input name="cotacao_form" type="email" value="<?php echo (isset($cotacao_form)) ? $cotacao_form : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>             
                                <!-- <div class="form-group">
                                    <label class="col-md-12">E-mail</label>
                                    <div class="col-md-12">
                                        <input name="email" type="text" value="<?php echo (isset($email)) ? $email : ''; ?>" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Endereço</label>
                                    <div class="col-md-12">
                                        <textarea name="endereco" rows="5" class="form-control form-control-line froala-editor"><?php echo (isset($endereco)) ? $endereco : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Google Maps Coordenadas</label>
                                    <div class="col-md-12">
                                        <input name="maps" type="text" value="<?php echo (isset($maps)) ? $maps : ''; ?>" class="form-control form-control-line">
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" name="update" class="btn btn-success" value="Salvar" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo date('Y'); ?> &copy; Precisao Servicos Gerais </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

    <script>
        $(document).ready(function() {
            $('.froala-editor').summernote();
        });    
    </script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>
