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
            $stmt = $conn->prepare("SELECT `smtp_user`, `smtp_host`, `smtp_password`, `smtp_port`, `contact_form`, `cotacao_form`, `logo`, `favico`, `titulo` FROM `smtp` ORDER BY id");
            if($stmt){
                $stmt->execute();
                $stmt->bind_result($smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form, $logo, $favico, $titulo);
                while($stmt->fetch()) {
                    $smtp_user = $smtp_user;
                    $smtp_host = $smtp_host;
                    $smtp_password = $smtp_password;
                    $smtp_port = $smtp_port;
                    $contact_form = $contact_form;
                    $cotacao_form = $cotacao_form;
                    $logo = $logo;
                    $favico = $favico;
                    $titulo = $titulo;
                }
                $stmt->close();
            }

            if(isset($_POST['update'])):
                $smtp_user = $_POST['smtp_user'];
                $smtp_password = $_POST['smtp_password'];
                $smtp_host = $_POST['smtp_host'];
                $smtp_port = $_POST['smtp_port'];
                $contact_form = $_POST['contact_form'];
                $cotacao_form = $_POST['cotacao_form'];
                $logo = $_POST['logo'];
                $favico = $_POST['favico'];
                $titulo = $_POST['titulo'];

                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                if($_FILES["file"]["tmp_name"]) {
                    if($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPEG" || $imageFileType == "png" || $imageFileType == "gif" || $imageFileType == "bmp") {
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
                $boolFile = ($file) ? $file : $logo;

                // 

                $target_file_favico = $target_dir . basename($_FILES["file_favico"]["name"]);
                $imageFileTypeFavico = pathinfo($target_file_favico, PATHINFO_EXTENSION);

                if($_FILES["file_favico"]["tmp_name"]) {
                    if($imageFileTypeFavico == "jpg" || $imageFileTypeFavico == "png" || $imageFileTypeFavico == "gif" || $imageFileTypeFavico == "bmp") {
                        if (move_uploaded_file($_FILES["file_favico"]["tmp_name"], $target_file_favico)) {
                            $files = date("dmYhis") . basename($_FILES["file_favico"]["name"]);
                        } else {
                            echo "Error Uploading File";
                            exit;
                        }
                    } else {
                        echo "File Not Supported";
                        exit;
                    }
                }

                $file_favico = basename($_FILES["file_favico"]["name"]);
                $boolFileFavico = ($file_favico) ? $file_favico : $favico;

                // 

                $stmt = $conn->prepare("UPDATE smtp SET `smtp_user` = ?, `smtp_host` = ?, `smtp_password` = ?, `smtp_port` = ?, `contact_form` = ?, `cotacao_form` = ?, `logo` = ?, `favico` = ?, `titulo` = ?");

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("sssssssss", $smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form, $boolFile, $boolFileFavico, $titulo);
                    $stmt->execute();
                    $stmt->close();
                    (($logo != $file) && $file) ? unlink('../profile/uploads/'.$logo) : '';
                    (($favico != $file_favico) && $file_favico) ? unlink('../profile/uploads/'.$favico) : '';
                } else {
                    die($conn->error);
                }
                
                header("Location: config_gerais.php?euid=".$uid); 
            endif;
        } else {
            // Adiciono se nao tiver
            if(isset($_POST['update'])) :
                $stmt = $conn->prepare("INSERT smtp (`smtp_user`, `smtp_host`, `smtp_password`, `smtp_port`, `contact_form`, `cotacao_form`, `logo`, `favico`, `titulo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $smtp_user = $_POST['smtp_user'];
                $smtp_host = $_POST['smtp_host'];
                $smtp_password = $_POST['smtp_password'];
                $smtp_port = $_POST['smtp_port'];
                $contact_form = $_POST['contact_form'];
                $cotacao_form = $_POST['cotacao_form'];
                $titulo = $_POST['titulo'];

                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                if($_FILES["file"]["tmp_name"]) {
                    if($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPEG" || $imageFileType == "png" || $imageFileType == "gif" || $imageFileType == "bmp") {
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

                $file = "'".basename($_FILES["file"]["name"])."'";

                // 

                $target_file_favico = $target_dir . basename($_FILES["file_favico"]["name"]);
                $imageFileTypeFavico = pathinfo($target_file_favico, PATHINFO_EXTENSION);

                if($_FILES["file_favico"]["tmp_name"]) {
                    if($imageFileTypeFavico == "jpg" || $imageFileTypeFavico == "png" || $imageFileTypeFavico == "gif" || $imageFileTypeFavico == "bmp") {
                        if (move_uploaded_file($_FILES["file_favico"]["tmp_name"], $target_file_favico)) {
                            $files = date("dmYhis") . basename($_FILES["file_favico"]["name"]);
                        } else {
                            echo "Error Uploading File";
                            exit;
                        }
                    } else {
                        echo "File Not Supported";
                        exit;
                    }
                }

                $file_favico = "'".basename($_FILES["file_favico"]["name"])."'";

                // 

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("sssssssss", $smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form, $file, $file_favico, $titulo);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: config_gerais.php?euid=".$uid); 
            endif;           
        }
    }
?>
    <?php include('_inc/header.php'); ?>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include('_inc/user_header.php'); ?>
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
                        <h4 class="page-title">Configurações Gerais</h4> 
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data">
                                <!-- <div class="form-group">
                                    <label class="col-md-12">SMTP HOST</label>
                                    <div class="col-md-12">
                                        <input <?php echo ($_SESSION['login']!='admin') ? 'readonly' : ''; ?> name="smtp_host" type="text" value="<?php echo (isset($smtp_host)) ? $smtp_host : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">SMTP User</label>
                                    <div class="col-md-12">
                                        <input <?php echo ($_SESSION['login']!='admin') ? 'readonly' : ''; ?> name="smtp_user" type="text" value="<?php echo (isset($smtp_user)) ? $smtp_user : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-12">SMTP Password</label>
                                    <div class="col-md-12">
                                        <input <?php echo ($_SESSION['login']!='admin') ? 'readonly' : ''; ?> name="smtp_password" type="password" placeholder="<?php echo (isset($smtp_password)) ? $smtp_password : ''; ?>" value="<?php echo (isset($smtp_password)) ? $smtp_password : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label class="col-md-12">SMTP PORT</label>
                                    <div class="col-md-12">
                                        <input <?php echo ($_SESSION['login']!='admin') ? 'readonly' : ''; ?> name="smtp_port" type="text" value="<?php echo (isset($smtp_port)) ? $smtp_port : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>    -->
                                <div class="form-group">
                                    <label class="col-md-12">Título do seu Website</label>
                                    <div class="col-md-12">
                                        <input name="titulo" type="text" value="<?php echo (isset($titulo)) ? $titulo : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Logo</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file" class="form-control form-control-line" />
                                        <p><small>Arquivo atual: <a target="_blank" href="uploads/<?php echo (isset($logo)) ? $logo : ''; ?>"><?php echo (isset($logo)) ? $logo : ''; ?></a></small></p>
                                        <input type="hidden" name="logo" value="<?php echo (isset($logo)) ? $logo : ''; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Favico</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file_favico" class="form-control form-control-line" />
                                        <p><small>Arquivo atual: <a target="_blank" href="uploads/<?php echo (isset($favico)) ? $favico : ''; ?>"><?php echo (isset($favico)) ? $favico : ''; ?></a></small></p>
                                        <input type="hidden" name="favico" value="<?php echo (isset($favico)) ? $favico : ''; ?>" />
                                    </div>
                                </div>
                                <!-- <div class="form-group">
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
                                </div>              -->
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
    <?php include('_inc/footer.php'); ?>