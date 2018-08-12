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
    
    if(!empty($_GET['id'])){
        if($result = $conn->query("SELECT * FROM paginas ORDER BY id")){ 
            if($result->num_rows > 0){
                $stmt = $conn->prepare("SELECT `titulo`, `conteudo`, `headers`, `slug`, `anchor`, `pagina_mae`, `subpagina`, `showmenu`, `image`, `resumo` FROM `paginas` WHERE `paginas`.`id` = '".$_GET['id']."'");
                
                if($stmt){
                    $stmt->execute();
                    $stmt->bind_result($titulo, $conteudo, $headers, $slug, $anchor, $pagina_mae, $subpagina, $showmenu, $image, $resumo);
                    while($stmt->fetch()) {
                        $titulo = $titulo;
                        $conteudo = $conteudo;
                        $headers = htmlspecialchars($headers);
                        $slug = $slug;
                        $anchor = $anchor;
                        $subpagina = $subpagina;
                        $showmenu = $showmenu;
                        $pagina_mae = $pagina_mae;
                        $image = $image;
                        $resumo = $resumo;
                    }
                    $stmt->close();
                }

                if(isset($_POST['update'])):
                    $titulo = $_POST['titulo'];
                    $conteudo = $_POST['conteudo'];
                    $slug = ( $_POST['slug'] != to_permalink(removeSpecialChars($titulo)) ? to_permalink(removeSpecialChars($titulo)) : $_POST['slug']);
                    $headers = htmlspecialchars($_POST['headers']);
                    $anchor = (isset($_REQUEST['anchor'])) ? 1 : 0;
                    $subpagina = (isset($_REQUEST['subpagina'])) ? 1 : 0;
                    $showmenu = (isset($_REQUEST['showmenu'])) ? 1 : 0;
                    $pagina_mae = $_POST['pagina_mae'];
                    $resumo = $_POST['resumo'];
                    $image = $image;

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
                    $boolFile = ($file) ? $file : $image;

                    $stmt = $conn->prepare("UPDATE paginas SET `titulo` = ?, `conteudo` = ?, `slug` = ?, `headers` = ?, `anchor` = ?, `pagina_mae` = ?, `subpagina` = ?, `showmenu` = ?, `image` = ?, `resumo` = ? WHERE `paginas`.`id` = '".$_GET['id']."'");

                    if(isset($stmt) && $stmt !== FALSE) {
                        $stmt->bind_param("ssssssssss", $titulo, $conteudo, $slug, $headers, $anchor, $pagina_mae, $subpagina, $showmenu, $boolFile, $resumo);
                        $stmt->execute();
                        $stmt->close();
                        (($image != $file) && $file) ? unlink('../profile/uploads/'.$image) : '';
                    } else {
                        die($conn->error);
                    }
                    
                    header("Location: pagina.php?id=".$_GET['id']."&euid=".$uid); 
                endif;
            } else {  
                // Adiciono se nao tiver
                if(isset($_POST['update'])) :
                    $stmt = $conn->prepare("INSERT paginas (`titulo`, `conteudo`, `headers`, `slug`, `anchor`, `pagina_mae`, `subpagina`, `showmenu`, `image`, `resumo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $titulo = $_POST['titulo'];
                    $conteudo = $_POST['conteudo'];
                    $slug = to_permalink(removeSpecialChars($titulo));
                    $headers = htmlspecialchars($_POST['headers']);
                    $anchor = (isset($_REQUEST['anchor'])) ? 1 : 0;
                    $subpagina = (isset($_REQUEST['subpagina'])) ? 1 : 0;
                    $showmenu = (isset($_REQUEST['showmenu'])) ? 1 : 0;
                    $pagina_mae = $_POST['pagina_mae'];
                    $resumo = $_POST['resumo'];

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
                        $stmt->bind_param("ssssssssss", $titulo, $conteudo, $headers, $slug, $anchor, $pagina_mae, $subpagina, $showmenu, $file, $resumo);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        die($conn->error);
                    }
                    
                    header("Location: paginas.php?euid=".$uid); 
                endif; 
            }
        }
    } else {
        if(isset($_POST['update'])) :
            $stmt = $conn->prepare("INSERT paginas (`titulo`, `conteudo`, `headers`, `slug`, `anchor`, `pagina_mae`, `subpagina`, `showmenu`, `image`, `resumo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $titulo = $_POST['titulo'];
            $conteudo = $_POST['conteudo'];
            $slug = to_permalink(removeSpecialChars($titulo));
            $headers = htmlspecialchars($_POST['headers']);
            $anchor = (isset($_REQUEST['anchor'])) ? 1 : 0;
            $subpagina = (isset($_REQUEST['subpagina'])) ? 1 : 0;
            $showmenu = (isset($_REQUEST['showmenu'])) ? 1 : 0;
            $pagina_mae = $_POST['pagina_mae'];
            $resumo = $_POST['resumo'];

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
                $stmt->bind_param("ssssssssss", $titulo, $conteudo, $headers, $slug, $anchor, $pagina_mae, $subpagina, $showmenu, $file, $resumo);
                $stmt->execute();
                $stmt->close();
            } else {
                die($conn->error);
            }
            
            header("Location: paginas.php?euid=".$uid); 
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4 class="page-title">Páginas > <?php echo (!empty($_GET['id'])) ? 'Editar Página > '.$titulo : 'Adicionar Nova Página'; ?></h4> 
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-12">Título</label>
                                    <div class="col-md-12">
                                        <input name="titulo" type="text" value="<?php echo (isset($titulo)) ? $titulo : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Conteudo</label>
                                    <div class="col-md-12">
                                        <textarea name="conteudo" rows="10" class="froala-editor form-control form-control-line"><?php echo (isset($conteudo)) ? $conteudo : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Resumo</label>
                                    <div class="col-md-12">
                                        <textarea name="resumo" rows="10" class="froala-editor form-control form-control-line"><?php echo (isset($resumo)) ? $resumo : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Headers/SEO</label>
                                    <div class="col-md-12">
                                    <textarea rows="10" class="form-control form-control-line" name="headers"><?php echo (isset($headers)) ? htmlspecialchars_decode($headers) : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Imagem Header</label>
                                    <div class="col-md-12">
                                        <input type="file" name="file" class="form-control form-control-line" />
                                        <?php if(isset($image) && $image!=='') : ?>
                                            <input type="hidden" name="image" value="<?php echo (isset($image) && $image!=='') ? $image : ''; ?>">
                                            <p><small>Arquivo atual: <a class="<?php echo (substr($image, -3) == 'png' || substr($image, -3) == 'jpg' || substr($image, -3) == 'gif' || substr($image, -3) == 'bmp') ? 'lightbox' : ''; ?>" target="_blank" href="uploads/<?php echo (isset($image)) ? $image : ''; ?>"><?php echo (isset($image)) ? $image : ''; ?></a> <a href="<?php echo "../_inc/delete.php?source=pagina-thumbnail&id=".((isset($_GET['id']) ? $_GET['id'] : ''))."&uid=".$uid."&file=".$image; ?>" title="Deletar arquivo atual"><small>(Remover arquivo atual)</small></a></small></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if(isset($slug)) : ?>
                                <div class="form-group">
                                    <label class="col-md-12">Slug</label>
                                    <div class="col-md-12">
                                        <input name="slug" readonly type="text" value="<?php echo (isset($slug)) ? $slug : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="col-md-12">Página Mãe</label>
                                    <div class="col-md-12">
                                        <select name="pagina_mae">
                                            <option value="">Nenhuma</option>
                                            <?php 
                                            $stmt = $conn->prepare("SELECT `titulo`, `slug` FROM `paginas` ORDER BY id");
                                            
                                            if($stmt){
                                                $stmt->execute();
                                                $stmt->bind_result($titulos, $slugs);
                                                while($stmt->fetch()) {
                                                    $titulos = $titulos;
                                                    $slugs = $slugs;
                                                    
                                                    echo '<option '.(($pagina_mae == $slugs) ? 'selected' : '').' value="'.$slugs.'">'.$titulos.'</option>';
                                                }
                                                $stmt->close();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Inserir como submenu</label>
                                    <div class="col-md-12">
                                        <input name="subpagina" type="checkbox" <?php echo (isset($subpagina) && $subpagina == 1) ? 'checked' : ''; ?> class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Mostrar no menu</label>
                                    <div class="col-md-12">
                                        <input name="showmenu" type="checkbox" <?php echo (isset($showmenu) && $showmenu == 1) ? 'checked' : ''; ?> class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Âncora</label>
                                    <div class="col-md-12">
                                        <input name="anchor" type="checkbox" <?php echo (isset($anchor) && $anchor == 1) ? 'checked' : ''; ?> class="form-control form-control-line"> 
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