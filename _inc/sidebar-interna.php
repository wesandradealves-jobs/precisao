<aside class="sidebar -interna">
    <h2 class="title">Contato<br/>e Localização</h2>
    <p><strong>Nosso Endereço</strong><br/><br/></p>
    <?php echo $endereco; ?>
    <p><?php echo "<br/>Telefone: ".strip_tags($telefone); ?></p>
    <p><strong><br/><br/>Contato</strong><br/><br/></p>
    <p><?php echo "<a href='mailto:".$email."'>".$email."</a>"; ?></p>
</aside>