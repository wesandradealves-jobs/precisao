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
                        <h4 class="page-title">Páginas</h4> 
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
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title table-header">(+ <a href="<?php echo "pagina.php?euid=".$uid; ?>" title="Adicionar Nova Página">Adicionar nova Página</a>)</h3>
                            <?php 
                                if ($result = $conn->query("SELECT * FROM paginas ORDER BY id DESC")) :
                                    if ($result->num_rows > 0) :
                            ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-header">
                                        <tr>
                                            <th>#</th>
                                            <th>TITULO</th>
                                            <th>RESUMO</th>
                                            <th>CONTEÚDO</th>
                                            <th>IMAGEM HEADER</th>
                                            <th>SEO/HEADERS</th>
                                            <th>SLUG</th>
                                            <th>PÁGINA MÃE</th>
                                            <th>SCROLL</th>
                                            <th>SUBPÁGINA</th>
                                            <th>MENU</th>
                                            <th>-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop de usuarios aqui -->
                                        <?php while ($row = $result->fetch_object()) : ?>
                                        <tr>
                                            <td><?php echo $row->id; ?></td>
                                            <td class="txt-oflo"><?php echo $row->titulo; ?></td>
                                            <td class="txt-oflo"><?php echo substr(strip_tags($row->resumo), 0, 20).((strlen(substr(strip_tags($row->resumo), 0, 20)) >= 20) ? '...' : ''); ?></td>
                                            <td class="txt-oflo"><?php echo substr(strip_tags($row->conteudo), 0, 20).((strlen(substr(strip_tags($row->conteudo), 0, 20)) >= 20) ? '...' : ''); ?></td>
                                            <td class="txt-oflo">
                                                <a class="<?php echo (substr($row->image, -3) == 'png' || substr($row->image, -3) == 'jpg' || substr($row->image, -3) == 'gif' || substr($row->image, -3) == 'bmp') ? 'lightbox' : ''; ?>" target="_blank" href="uploads/<?php echo (isset($row->image)) ? $row->image : ''; ?>"><?php echo $row->image; ?></a>
                                            </td>  
                                            <td class="txt-oflo"><code><?php echo $row->headers; ?></code></td>
                                            <td class="txt-oflo"><?php echo $row->slug; ?></td>
                                            <td class="txt-oflo"><?php echo $row->pagina_mae; ?></td>
                                            <td class="txt-oflo"><?php echo ($row->anchor) ? 'Sim' : 'Não'; ?></td>
                                            <td class="txt-oflo"><?php echo ($row->subpagina) ? 'Sim' : 'Não'; ?></td>
                                            <td class="txt-oflo"><?php echo ($row->showmenu) ? 'Sim' : 'Não'; ?></td>
                                    <td><a class="action" href="<?php echo "pagina.php?euid=".$uid."&id=".$row->id; ?>">Editar</a> <?php if($row->slug != "home") : ?> | <a class="action" href="<?php echo "../_inc/delete.php?source=pagina&uid=".$uid."&id=".$row->id; ?>">Deletar</a> <?php endif; ?></td>
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