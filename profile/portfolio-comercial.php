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

    if ($result = $conn->query("SELECT * FROM portfolio_comercial ORDER BY id")) {
        if ($result->num_rows > 0) {
            // Atualizo se tiver
            $stmt = $conn->prepare("SELECT `label`, `url`, `text` FROM `portfolio_comercial` ORDER BY id");
            if($stmt){
                $stmt->execute();
                $stmt->bind_result($label, $url, $text);
                while($stmt->fetch()) {
                    $label = $label;
                    $url = $url;
                    $text = $text;
                }
                $stmt->close();
            }

            if(isset($_POST['update'])):
                $label = $_POST['label'];
                $text = $_POST['text'];
                $url = $_POST['url'];
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                if($_FILES["file"]["tmp_name"]) {
                    if($imageFileType == "bmp" || $imageFileType == "gif" || $imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPEG" || $imageFileType == "png" || $imageFileType == "txt" || $imageFileType == "doc" || $imageFileType == "pdf" || $imageFileType == "rtf") {
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
                $boolFile = ($file) ? $file : $url;

                $stmt = $conn->prepare("UPDATE portfolio_comercial SET `label` = ?, `url` = ?, `text` = ?");

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("sss", $label, $boolFile, $text);
                    $stmt->execute();
                    $stmt->close();
                    (($url != $file) && $file) ? unlink('../profile/uploads/'.$url) : '';
                } else {
                    die($conn->error);
                }
                
                header("Location: portfolio-comercial.php?euid=".$uid); 
            endif;
        } else {
            // Adiciono se nao tiver
            if(isset($_POST['update'])) :
                $stmt = $conn->prepare("INSERT portfolio_comercial (`label`, `url`, `text`) VALUES (?, ?, ?)");
                $label = $_POST['label'];
                $text = $_POST['text'];

                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

                if($_FILES["file"]["tmp_name"]) {
                    if($imageFileType == "bmp" || $imageFileType == "gif" || $imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "JPEG" || $imageFileType == "png" || $imageFileType == "txt" || $imageFileType == "doc" || $imageFileType == "pdf" || $imageFileType == "rtf") {
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

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("sss", $label, $file, $text);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: portfolio-comercial.php?euid=".$uid); 
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
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-12">Label do botão</label>
                                    <div class="col-md-12">
                                        <input name="label" type="text" value="<?php echo (isset($label)) ? $label : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Suba o portfolio</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file" class="form-control form-control-line" />
                                        <?php if($url!=='') : ?>
                                            <p><small>Arquivo atual: <a class="<?php echo (substr($url, -3) == 'png' || substr($url, -3) == 'jpg' || substr($url, -3) == 'gif' || substr($url, -3) == 'bmp') ? 'lightbox' : ''; ?>" target="_blank" href="uploads/<?php echo (isset($url)) ? $url : ''; ?>"><?php echo (isset($url)) ? $url : ''; ?></a> <a href="<?php echo "../_inc/delete.php?source=portfolio-comercial&uid=".$uid."&file=".$url; ?>" title="Deletar arquivo atual"><small>(Remover arquivo atual)</small></a></small></p>
                                        <?php endif; ?>
                                        <input type="hidden" name="url" value="<?php echo (isset($url)) ? $url : ''; ?>" />                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Texto</label>
                                    <div class="col-md-12">
                                        <textarea name="text" rows="5" class="froala-editor form-control form-control-line"><?php echo (isset($text)) ? $text : '';; ?></textarea>
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
    <?php include('_inc/footer.php'); ?>