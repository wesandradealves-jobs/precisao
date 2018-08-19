<ul class="nav" id="side-menu">
    <li style="padding: 70px 0 0;">
        <a href="<?php echo "index.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i>Dashboard</a>
    </li>
    <li>
        <a href="<?php echo ($_SESSION['login'] == "admin") ? "usuarios.php?euid=".$uid : "usuario.php?id=".$uid."&euid=".$uid  ?>" class="waves-effect"><i class="fa fa-group fa-fw" aria-hidden="true"></i><?php echo ($_SESSION['login'] == "admin") ? "Usuários" : "Minha Conta"  ?></a>
    </li>
    <li>
        <a href="<?php echo "contato.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>Contato</a>
    </li>
    <li>
        <a href="<?php echo "portfolio-comercial.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-book fa-fw" aria-hidden="true"></i>Portfolio Comercial</a>
    </li> 
    <li>
        <a href="<?php echo "servicos.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>Serviços</a>
    </li>  
    <li>
        <a href="<?php echo "artigos.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-university fa-fw" aria-hidden="true"></i>Artigos</a>
    </li> 
    <!-- <li>
        <a href="<?php echo "a-empresa.php?euid=".$uid; ?>" class="waves-effect"><i class="fa fa-building fa-fw" aria-hidden="true"></i>A Empresa</a>
    </li>  -->
    <li>
        <a href="<?php echo "banners.php?euid=".$uid; ?>" class="waves-effect list-open toggle"><i class="fa fa-file-image-o fa-fw" aria-hidden="true"></i>Banners</a>
    </li>
    <li>
        <a href="<?php echo "paginas.php?euid=".$uid; ?>" class="waves-effect list-open toggle"><i class="fa fa-code fa-fw" aria-hidden="true"></i>Páginas</a>
    </li>
    <li>
        <a href="<?php echo "redes-sociais.php?euid=".$uid; ?>" class="waves-effect list-open toggle"><i class="fa fa-facebook-f fa-fw" aria-hidden="true"></i>Redes Sociais</a>
    </li>
    <li>
        <a href="<?php echo "config_gerais.php?euid=".$uid; ?>" class="waves-effect list-open toggle"><i class="fa fa-cogs fa-fw" aria-hidden="true"></i>Configurações Gerais</a>
    </li>
</ul>