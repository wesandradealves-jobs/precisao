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
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    
    // Pegar dados e definir acao

    if ($result = $conn->query("SELECT * FROM seo ORDER BY id")) {
        if ($result->num_rows > 0) {
            // Atualizo se tiver
            $stmt = $conn->prepare("SELECT `code` FROM `seo` ORDER BY id");
            if($stmt){
                $stmt->execute();
                $stmt->bind_result($code);
                while($stmt->fetch()) {
                    $code = $code;
                }
                $stmt->close();
            }

            if(isset($_POST['update'])):
                $code = htmlentities($_POST['code'], ENT_QUOTES);

                $stmt = $conn->prepare("UPDATE seo SET `code` = ?");

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("s", $code);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: seo.php?euid=".$uid); 
            endif;
        } else {
            if(isset($_POST['update'])) :
                $stmt = $conn->prepare("INSERT seo (`code`) VALUES (?)");
                $code = htmlentities($_POST['code'], ENT_QUOTES);

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("s", $code);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: seo.php?euid=".$uid); 
            endif;  
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
                <ul class="nav" id="side-menu">
                    <li style="padding: 70px 0 0;">
                        <a href="<?php echo "index.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo "usuarios.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-group fa-fw" aria-hidden="true"></i>Usuários</a>
                    </li>
                    <li>
                        <a href="<?php echo "contato.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>Contato</a>
                    </li>
                    <li>
                        <a href="<?php echo "portfolio-comercial.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-book fa-fw" aria-hidden="true"></i>Portfolio Comercial</a>
                    </li>      
                    <li>
                        <a href="<?php echo "servicos.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>Serviços</a>
                    </li>  
                    <li>
                        <a href="<?php echo "artigos.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-university fa-fw" aria-hidden="true"></i>Artigos</a>
                    </li>         
                    <li>
                        <a href="<?php echo "a-empresa.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-building fa-fw" aria-hidden="true"></i>A Empresa</a>
                    </li> 
                    <li>
                        <a href="<?php echo "seo.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-code fa-fw" aria-hidden="true"></i>SEO</a>
                    </li> 
                </ul>
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
                        <h4 class="page-title">SEO/Metas</h4> 
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
                                    <label class="col-md-12">Insira seu header aqui:</label>
                                    <div class="col-md-12">
                                        <textarea name="code" rows="5" class="form-control form-control-line"><?php echo (isset($code)) ? $code : ''; ?></textarea>
                                    </div>
                                </div>
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
