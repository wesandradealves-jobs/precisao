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
            $stmt = $conn->prepare("INSERT redes_sociais (`nome`, `url`) VALUES (?, ?)");
            $nome = $_POST['nome'];
            $url = $_POST['url'];

            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("ss", $nome, $url);
                $stmt->execute();
                $stmt->close();
            } else {
                die($conn->error);
            }
            
            header("Location: redes-sociais.php?euid=".$uid); 
        endif;           
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT `nome`, `url` FROM `redes_sociais` WHERE `redes_sociais`.`id` = '".$id."'");
        if($stmt){
            $stmt->execute();
            $stmt->bind_result($nome, $url);
            while($stmt->fetch()) {
                $nome = $nome;
                $url = $url;
            }
            $stmt->close();
        }

        if(isset($_POST['update'])) :
            $nome = $_POST['nome'];
            $url = $_POST['url'];

            $stmt = $conn->prepare("UPDATE redes_sociais SET `nome` = ?, `url` = ? WHERE `redes_sociais`.`id` = '".$id."'");

            if(isset($stmt) && $stmt !== FALSE) {
                $stmt->bind_param("ss", $nome, $url);
                $stmt->execute();
                $stmt->close();
            } else {
                die($conn->error);
            }
            
            header("Location: rede-social.php?id=".$id."&euid=".$uid);  
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
                    <div class="col-xs-12">
                        <h4 class="page-title">Redes Sociais > <?php echo (!empty($_GET['id'])) ? 'Editar Redes Sociais > '.$nome : 'Adicionar Rede Social'; ?></h4>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST">
                                <div class="form-group">
                                    <label class="col-md-12">Rede Social</label>
                                    <div class="col-md-12">
                                        <input name="nome" type="text" value="<?php echo (isset($nome)) ? $nome : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">URL</label>
                                    <div class="col-md-12">
                                        <input name="url" type="url" value="<?php echo (isset($url)) ? $url : ''; ?>" class="form-control form-control-line"> 
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