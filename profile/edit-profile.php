<?php
    require_once('../_inc/db.php');
    session_start();
        if(!$_SESSION['login']){
        header("Location: ../login.php");
    } else {
        $uid = $_SESSION['uid'];
    }
    $euid = isset($_GET['euid']);

    // Pegar dados

    $stmt = $conn->prepare("SELECT `login`, `senha` FROM `usuarios` WHERE id = $euid");

    if($stmt){
        $stmt->execute();
        $stmt->bind_result($login, $senha);
        while($stmt->fetch()) {
            $alogin = $login;
            $asenha = $senha;
        }
        $stmt->close();
    }
    // $conn->close();    

    // Update

    if($euid){
        if(isset($_POST['update'])){
            if(is_numeric($_POST['id'])){
                $id = $_POST['id'];
                $login = htmlentities($_POST['login'], ENT_QUOTES);
                $senha = md5(htmlentities($_POST['senha'], ENT_QUOTES));

                if($login && $senha){
                    $stmt = $conn->prepare("UPDATE usuarios SET `senha` = ?, `login` = ? WHERE `usuarios`.`id` = $euid");

                    if(isset($stmt) && $stmt !== FALSE) {
                        $stmt->bind_param("ss", $senha, $login);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        die($conn->error);
                    }
                    
                    if(($id = $euid && $senha != $asenha) && $stmt){
                        header("Location: ../_inc/logout.php?action=update");
                    } else {
                        unset($_SESSION['updateSucess']);
                        $_SESSION['updateSucess'] = "Atualizado com sucesso!";
                        
                        echo $_SESSION['updateSucess'];
                        
                        header("Location: edit-profile.php?euid=".$euid);
                    }
                    // $conn->close();
                }
            }
        }
    }
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
                <ul class="nav" id="side-menu">
                    <li style="padding: 70px 0 0;">
                        <!-- <a href="index.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a> -->
                    </li>
                    <!-- <li>
                        <a href="profile.html" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
                    </li>
                    <li>
                        <a href="basic-table.html" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i>Basic Table</a>
                    </li>
                    <li>
                        <a href="fontawesome.html" class="waves-effect"><i class="fa fa-font fa-fw" aria-hidden="true"></i>Icons</a>
                    </li>
                    <li>
                        <a href="map-google.html" class="waves-effect"><i class="fa fa-globe fa-fw" aria-hidden="true"></i>Google Map</a>
                    </li>
                    <li>
                        <a href="blank.html" class="waves-effect"><i class="fa fa-columns fa-fw" aria-hidden="true"></i>Blank Page</a>
                    </li>
                    <li>
                        <a href="404.html" class="waves-effect"><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>Error 404</a>
                    </li> -->
                </ul>
                <div class="center p-20">
                    <a href="../_inc/logout.php" target="_blank" class="btn btn-danger btn-block waves-effect waves-light" title="Sair">Sair</a>
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
                        <h4 class="page-title">Minha Conta</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a> -->
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Minha Conta</li>
                        </ol>
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
                                    <label class="col-md-12">Login</label>
                                    <div class="col-md-12">
                                        <input name="login" <?php echo ($uid == $euid) ? 'disabled' : '' ?> type="text" value="<?php echo $alogin; ?>" placeholder="<?php echo $alogin; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Senha</label>
                                    <div class="col-md-12">
                                        <input name="senha" type="password" value="<?php echo $asenha; ?>" class="form-control form-control-line"> </div>
                                </div>
                                
                                <input type="hidden" value="<?php echo $euid; ?>" name="id" />
                                <?php if($uid == $euid) : ?>
                                    <input type="hidden" value="<?php echo $alogin; ?>" name="login" />
                                <?php endif; ?>
                                <!-- <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="123 456 7890" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Message</label>
                                    <div class="col-md-12">
                                        <textarea rows="5" class="form-control form-control-line"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Select Country</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line">
                                            <option>London</option>
                                            <option>India</option>
                                            <option>Usa</option>
                                            <option>Canada</option>
                                            <option>Thailand</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" name="update" class="btn btn-success" value="Atualizar perfil" />
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
