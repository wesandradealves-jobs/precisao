<ul class="breadcrumbs">
    <li><a href="./" title="Home">Home</a></li>
    <?php if(isset($sessao_titulo)) : ?>
        <li><a href="./<?php echo $sessao_titulo; ?>"><?php echo $sessao_titulo; ?></a></li>
    <?php else : ?>
        <?php if(isset($slug) && $slug == "sucesso") : ?>
            <li><a href="page.php?slug=contato" title="Contato">Contato</a></li>
        <?php else : ?>
            <li><a title="<?php echo $pgTitulo; ?>"><?php echo $pgTitulo; ?></a></li>
        <?php endif ?>
    <?php endif; ?>
    <?php if(isset($single_post_titulo)) : ?>
        <li><a><?php echo $single_post_titulo; ?></a></li>
    <?php endif; ?>
    <?php if($slug == "sucesso") : ?>
        <li><a title="Sucesso">Sucesso</a></li>
    <?php endif; ?>
</ul>