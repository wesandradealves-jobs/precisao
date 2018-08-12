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

    if(empty($_GET['id'])){
        if(isset($_POST['update'])) :
            $login = to_permalink(removeSpecialChars($_POST['login']));
            
            $senha = md5($_POST['senha']);
            if($login && $senha){ 
                $stmt = $conn->prepare("INSERT usuarios (`senha`, `login`) VALUES (?, ?)");
    
                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("ss", $senha, $login);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: usuarios.php?euid=".$uid);
            }
        endif;           
    } else {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT `login`, `senha`, `lastupdate` FROM `usuarios` WHERE `usuarios`.`id` = '".$id."'");
        if($stmt){
            $stmt->execute();
            $stmt->bind_result($login, $senha, $lastupdate);
            while($stmt->fetch()) {
                $login = $login;
                $senha = $senha;
                $lastupdate = $lastupdate;
            }
            $stmt->close();
        }
        if(isset($_POST['update'])) :
            if(is_numeric($id) && (to_permalink(removeSpecialChars($_POST['login'])) && $_POST['senha'])){
                $login = to_permalink(removeSpecialChars($_POST['login']));
                $senha = ($_POST['senha'] == $senha) ? $senha : md5($_POST['senha']);
                $time = time();
                $lastupdate = date("Y-m-d G:i:s", $time);
                $stmt = $conn->prepare("UPDATE usuarios SET `senha` = ?, `login` = ?, `lastupdate` = ? WHERE `usuarios`.`id` = $id");
                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("sss", $senha, $login, $lastupdate);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                if($id == $euid && ($senha != $_POST['asenha'] || $login != $_POST['alogin'])){
                    header("Location: ../_inc/logout.php");
                } else {
                    header("Location: usuario.php?id=".$id."&euid=".$euid);
                }
            }
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
                    <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Usuários > <?php echo ((isset($id) ? $id : '')) ? 'Editar Conta' : 'Adicionar nova conta'; ?></h4> 
                        <?php if((isset($id) ? $id : '')) : ?><p class="last-update"><b>Última Atualização: <?php echo (isset($lastupdate)) ? $lastupdate : ''; ?> </b><i></i></p> <?php endif; ?>
                    </div>
                    <!-- <div class="col-lg-4 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo "index.php?euid=".$uid; ?>">Dashboard</a></li>
                            <li class="active">Minha Conta</li>
                        </ol>
                    </div> -->
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form role="form" class="form-horizontal form-material usuario" action="" method="POST">
                                <div class="form-group">
                                    <label class="col-md-12">Login</label>
                                    <div class="col-md-12">
                                        <input name="login" <?php echo (($_SESSION['login'] == 'admin' && (isset($id) ? $id : '') == $euid) || ($_SESSION['login'] != 'admin' && (isset($id) ? $id : '') != $euid)) ? 'readonly' : '' ?> type="text" value="<?php echo (isset($login) && (isset($id) ? $id : '')) ? $login : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Senha</label>
                                    <div class="col-md-12">
                                    <input <?php echo (($_SESSION['login'] != 'admin') && ((isset($id) ? $id : '') != $uid)) ? 'readonly' : ''; ?> name="senha" type="password" value="<?php echo (isset($senha) && (isset($id) ? $id : '')) ? $senha : ''; ?>" class="form-control form-control-line"> </div>
                                </div>
                                <?php if($uid == $euid) : ?>
                                    <input type="hidden" value="<?php echo (isset($login) && (isset($id) ? $id : '')) ? $login : ''; ?>" name="alogin" />
                                    <input type="hidden" value="<?php echo (isset($senha) && (isset($id) ? $id : '')) ? $senha : ''; ?>" name="asenha" />
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input <?php echo (($_SESSION['login'] != 'admin') && ((isset($id) ? $id : '') != $uid)) ? 'readonly' : ''; ?> type="submit" name="update" class="btn btn-success" value="Salvar" />
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
    <?php include('_inc/footer.php'); ?>