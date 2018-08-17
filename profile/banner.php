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

    if(!isset($_GET['id'])){
        if(isset($_POST['update'])) :
            $stmt = $conn->prepare("INSERT banner (`image`, `url`, `html`, `widget`, `widget_name`) VALUES (?, ?, ?, ?, ?)");
            $url = $_POST['url'];
            $html = htmlspecialchars($_POST['html']);
            $widget = (isset($_REQUEST['widget'])) ? 1 : 0;
            $widget_name = isset($_POST['widget_name']) ? $_POST['widget_name'] : '';

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

            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("sssss", $file, $url, $html, $widget, $widget_name);
                $stmt->execute();
                $stmt->close();
            } else {
                die($conn->error);
            }
            
            header("Location: banners.php?euid=".$uid); 
        endif;           
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT `image`, `url`, `html`, `widget`, `widget_name` FROM `banner` WHERE `banner`.`id` = '".$id."'");
        if($stmt){
            $stmt->execute();
            $stmt->bind_result($image, $url, $html, $widget, $widget_name);
            while($stmt->fetch()) {
                $image = $image;
                $url = $url;
                $widget = $widget;
                $widget_name = $widget_name;
                $html = htmlspecialchars($html);
            }
            $stmt->close();
        }

        if(isset($_POST['update'])) :
            $url = $_POST['url'];
            $old_file = $_POST['old_file'];
            $html = htmlspecialchars($_POST['html']);
            $widget = (isset($_REQUEST['widget'])) ? 1 : 0;
            $widget_name = isset($_POST['widget_name']) ? $_POST['widget_name'] : '';

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
            $boolFile = ($file) ? $file : $old_file;

            $stmt = $conn->prepare("UPDATE banner SET `image` = ?, `url` = ?, `html` = ?, `widget` = ?, `widget_name` = ? WHERE `banner`.`id` = '".$id."'");

            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("sssss", $boolFile, $url, $html, $widget, $widget_name);
                $stmt->execute();
                $stmt->close();
                (($old_file != $file) && $file) ? unlink('../profile/uploads/'.$old_file) : '';
            } else {
                die($conn->error);
            }
            
            header("Location: banner.php?id=".$id."&euid=".$uid);  
        endif;
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
                    <div class="col-xs-12">
                        <h4 class="page-title">Banners > <?php echo (!empty($_GET['id'])) ? 'Editar Banner > Banner #'.$id : 'Adicionar Banner'; ?></h4>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-12">URL</label>
                                    <div class="col-md-12">
                                        <input name="url" type="text" value="<?php echo (isset($url)) ? $url : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Thumbnail</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file" class="form-control form-control-line" />
                                        <?php if(isset($image) && $image!=='') : ?>
                                            <input type="hidden" name="old_file" value="<?php echo $image; ?>" /> 
                                            <p><small>Arquivo atual: <a class="<?php echo (substr($image, -3) == 'png' || substr($image, -3) == 'jpg' || substr($image, -3) == 'gif' || substr($image, -3) == 'bmp') ? 'lightbox' : ''; ?>" target="_blank" href="uploads/<?php echo (isset($image)) ? $image : ''; ?>"><?php echo (isset($image)) ? $image : ''; ?></a> <a href="<?php echo "../_inc/delete.php?source=banner-thumbnail&id=".$id."&uid=".$uid."&file=".$image; ?>" title="Deletar arquivo atual"><small>(Remover arquivo atual)</small></a></small></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if($widget == 0) : ?>
                                <div class="form-group">
                                    <label class="col-md-12">Custom HTML</label>
                                    <div class="col-md-12">
                                        <textarea rows="10" class="form-control form-control-line" name="html"><?php echo (isset($html)) ? htmlspecialchars_decode($html) : ''; ?></textarea>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="col-md-12">Tem Widget?</label>
                                    <div class="col-md-12">
                                        <input name="widget" type="checkbox" <?php echo (isset($widget) && $widget == 1) ? 'checked' : ''; ?> class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <?php if(isset($widget) && $widget == 1) : ?>
                                <div class="form-group">
                                    <label class="col-md-12">Selecione um Widget</label>
                                    <div class="col-md-12">
                                        <select name="widget_name">
                                            <?php 
                                                $dir = '../_inc/components/';
                                                if ($handle = opendir($dir)) {

                                                    while (false !== ($entry = readdir($handle))) {
                                                
                                                        if ($entry != "." && $entry != "..") {
                                                
                                                            echo "<option ".(( substr($entry, 0, -4) == $widget_name ) ? 'selected' : '')." value='".substr($entry, 0, -4)."'>".substr($entry, 0, -4)."</option>";
                                                        }
                                                    }
                                                
                                                    closedir($handle);
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php endif; ?>
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