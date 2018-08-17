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

    if ($result = $conn->query("SELECT * FROM contatos ORDER BY id")) {
        if ($result->num_rows > 0) {
            // Atualizo se tiver
            $stmt = $conn->prepare("SELECT `telefone`, `email`, `endereco`, `maps` FROM `contatos` ORDER BY id");
            if($stmt){
                $stmt->execute();
                $stmt->bind_result($telefone, $email, $endereco, $maps);
                while($stmt->fetch()) {
                    $telefone = $telefone;
                    $email = $email;
                    $endereco = $endereco;
                    $maps = $maps;
                }
                $stmt->close();
            }

            if(isset($_POST['update'])):
                $telefone = $_POST['telefone'];
                $endereco = $_POST['endereco'];
                $email = $_POST['email'];
                $maps = $_POST['maps'];
                
                $stmt = $conn->prepare("UPDATE contatos SET `telefone` = ?, `email` = ?, `endereco` = ?, `maps` = ?");

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("ssss", $telefone, $email, $endereco, $maps);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: contato.php?euid=".$uid); 
            endif;
        } else {
            // Adiciono se nao tiver
            if(isset($_POST['update'])) :
                $stmt = $conn->prepare("INSERT contatos (`telefone`, `email`, `endereco`, `maps`) VALUES (?, ?, ?, ?)");
                $telefone = $_POST['telefone'];
                $email = $_POST['email'];
                $endereco = $_POST['endereco'];
                $maps = $_POST['maps'];

                if(isset($stmt) && $stmt !== FALSE) {
                    $stmt->bind_param("ssss", $telefone, $email, $endereco, $maps);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die($conn->error);
                }
                
                header("Location: contato.php?euid=".$uid); 
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
                        <h4 class="page-title">Contato</h4> 
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" action="" method="POST">
                                <div class="form-group">
                                    <label class="col-md-12">Telefone</label>
                                    <div class="col-md-12">
                                        <input name="telefone" type="text" value="<?php echo (isset($telefone)) ? $telefone : ''; ?>" class="form-control form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
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