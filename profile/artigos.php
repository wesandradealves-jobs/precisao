<?php
    require_once('../_inc/db.php');
    session_start();
    require_once('../_inc/expire.php');
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
                        <h4 class="page-title">Artigos</h4> 
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- table -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title table-header">(+ <a href="<?php echo "artigo.php?euid=".$uid; ?>" title="Adicionar Novo">Adicionar novo Artigo</a>)</h3>
                            <?php 
                                if ($result = $conn->query("SELECT * FROM artigos ORDER BY id DESC")) :
                                    if ($result->num_rows > 0) :
                            ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr>
                                            <th>#</th>
                                            <th>TITULO</th>
                                            <th>THUMBNAIL</th>
                                            <th>TEXTO</th>
                                            <th>-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop de usuarios aqui -->
                                        <?php while ($row = $result->fetch_object()) : ?>
                                        <tr>
                                            <td><?php echo $row->id; ?></td>
                                            <td class="txt-oflo"><?php echo $row->titulo; ?></td>
                                            <td class="txt-oflo">
                                                <a class="<?php echo (substr($row->url, -3) == 'png' || substr($row->url, -3) == 'jpg' || substr($row->url, -3) == 'gif' || substr($row->url, -3) == 'bmp') ? 'lightbox' : ''; ?>" target="_blank" href="uploads/<?php echo (isset($row->url)) ? $row->url : ''; ?>"><?php echo $row->url; ?></a>
                                            </td>
                                            <!-- <td class="txt-oflo"><a target="_blank" href="uploads/<?php echo $row->url; ?>"><?php echo $row->url; ?></a></td> -->
                                            <td class="txt-oflo"><?php echo ($row->text) ? substr($row->text, 0, 40).( ( strlen($row->text) >= 40 ) ? '(...)' : '' ) : '' ?></td>
                                            <td><a class="action" href="<?php echo "artigo.php?euid=".$uid."&id=".$row->id; ?>">Editar</a> | <a class="action" href="<?php echo "../_inc/delete.php?source=artigo&file=".$row->url."&uid=".$uid."&id=".$row->id; ?>">Deletar</a></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                                endif; 
                                endif; 
                                $conn->close();
                                unset($conn);
                            ?>
                        </div>
                    </div>
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