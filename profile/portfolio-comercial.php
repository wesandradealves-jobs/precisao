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
    
    // Pegar dados

    $stmt = $conn->prepare("SELECT `text`, `url`, `label` FROM `portfolio_comercial`");

    if($stmt){
        $stmt->execute();
        $stmt->bind_result($text, $url, $label);
        while($stmt->fetch()) {
            $atext = $text;
            $aurl = $url;
            $alabel = $label;
        }
        $stmt->close();
    }
    // $conn->close();    

    // Update

    if(isset($_POST['update'])){
        $text = htmlentities($_POST['text'], ENT_QUOTES);
        $url = htmlentities($_POST['url'], ENT_QUOTES);
        $label = htmlentities($_POST['label'], ENT_QUOTES);

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if($_FILES["file"]["tmp_name"]) {
            if($imageFileType != "rtf" || $imageFileType != "txt" || $imageFileType != "doc"  || $imageFileType != "pdf") {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $files = date("dmYhis") . basename($_FILES["file"]["name"]);
                } else {
                    echo "Error Uploading File";
                    exit;
                }
            } else {
                echo "File Not Supported";
                exit;
            }
        }

        $file = basename($_FILES["file"]["name"]);

        $stmt = $conn->prepare("UPDATE portfolio_comercial SET `text` = ?, `url` = ?, `label` = ?");

        $boolFile = ($file) ? $file : $url;

        if(isset($stmt) && $stmt !== FALSE) {
            $stmt->bind_param("sss", $text, $boolFile, $label);
            if($boolFile != $aurl){
                unlink('uploads/'.$aurl);
            }
            $stmt->execute();
            $stmt->close();
        } else {
            die($conn->error);
        }
        
        $_SESSION['acessedUid'] = $euid;
        header("Location: portfolio-comercial.php?euid=".$_SESSION['acessedUid']);
        // $conn->close();
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
                        <a class="acesse" href="http://localhost/precisao/" title="Acesse seu site" target="_blank">Acesse seu site</a>
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
                    <!-- <li>
                        <a href="profile.html" class="waves-effect"><i class="fa fa-group fa-fw" aria-hidden="true"></i>Profile</a>
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
                        <h4 class="page-title">Portfolio Comercial</h4> 
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
                            <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-12">Label do botão</label>
                                    <div class="col-md-12">
                                        <input name="label" type="text" value="<?php echo $alabel; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">URL</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file" class="form-control form-control-line" />
                                        <p><small>Arquivo atual: <?php echo $aurl; ?></small></p>
                                        <input type="hidden" name="url" value="<?php echo $aurl; ?>" />
                                        <?php if($aurl) : ?>
                                            <p><a href="<?php echo "../_inc/delete.php?uid=".$uid."&file=".$aurl; ?>" title="Deletar arquivo atual">*Remover arquivo atual</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Texto</label>
                                    <div class="col-md-12">
                                        <textarea name="text" rows="5" class="form-control form-control-line"><?php echo utf8_decode($atext); ?></textarea>
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
