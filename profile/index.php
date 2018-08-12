<?php
    require_once('../_inc/db.php');
    session_start();
    require_once('../_inc/expire.php');

    $usr = $_SESSION['login'];

    if(!$_SESSION['login']){
        header("Location: ../login.php");
    } else {
        $uid = $_SESSION['uid'];
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
                        <h4 class="page-title">Dashboard</h4> 
                    </div>
                        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a>
                            <ol class="breadcrumb">
                                <li><a href="#">Dashboard</a></li>
                            </ol>
                        </div> -->
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- table -->
                <!-- ============================================================== -->
                <div class="row">
                    <?php 
                        if ($result = $conn->query("SELECT * FROM usuarios ORDER BY id DESC LIMIT 5")) :
                            if ($result->num_rows > 0) :
                    ?>
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title table-header">Usuários recentes</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr>
                                            <th>#</th>
                                            <th>ALIAS</th>
                                            <th>INSERIDO EM</th>
                                            <th>Última Atualização</th>
                                            <th>-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop de usuarios aqui -->
                                        <?php while ($row = $result->fetch_object()) : ?>
                                        <tr>
                                            <td><?php echo $row->id; ?></td>
                                            <td class="txt-oflo"><?php echo $row->login.(($row->id == $uid) ? ' (Você)' : ''); ?></td>
                                            <td class="txt-oflo"><?php echo $row->date; ?></td>
                                            <td class="txt-oflo"><?php echo $row->lastupdate; ?></td>
                                            <!-- <td><a target="_blank" class="action" href="<?php echo "usuario.php?id=".$row->id."&euid=".$uid; ?>"><?php echo ($_SESSION['login'] == $row->login && $row->id==$uid) ? 'Editar' : ($_SESSION['login'] == 'admin') ? 'Editar Perfil' : 'Visualizar Pefil'; ?></a></td> -->
                                            <td><a target="_blank" class="action" href="<?php echo "usuario.php?id=".$row->id."&euid=".$uid; ?>"><?php echo ($_SESSION['login'] == $row->login && $row->id==$uid) ? 'Editar' : ($_SESSION['login'] == 'admin') ? 'Editar Perfil' : 'Visualizar Pefil'; ?></a> <?php if($_SESSION['login'] == 'admin' && $row->id!=$uid) : ?> | <a class="action" href="<?php echo "../_inc/delete.php?source=usuarios&uid=".$uid."&id=".$row->id; ?>">Deletar</a><?php endif; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($result->num_rows >= 5) : ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo "usuarios.php?euid=".$uid; ?>">Ver Todos</a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endif; 
                        endif; 
                        $conn->close();
                        unset($conn);
                    ?>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo date('Y'); ?> &copy; Precisao Servicos Gerais </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php include('_inc/footer.php'); ?>