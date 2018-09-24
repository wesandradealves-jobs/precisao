<aside class="sidebar -interna">
    <h2 class="title">Contato<br/>e Localização</h2>
    <!-- <p><strong>Nosso Endereço</strong><br/><br/></p>
    <?php echo $endereco; ?>
    <p><?php echo "<br/>Telefone: ".$telefone; ?></p>
    <p><strong><br/><br/>Contato</strong><br/><br/></p>
    <p><?php echo "<a href='mailto:".$email."'>".$email."</a>"; ?></p> -->
    <?php 
        if(count($meusEnderecos)) :

        $tplAddress = "<ul class='footer-multiple-addresses'>";

        foreach ($meusEnderecos as $object) :

            //if($object->o_telefone&&$object->o_email&&$object->o_endereco) :

            $tplAddress .= "<li><div>".(($object->o_telefone) ? '<p><strong>Telefone:</strong><br/>'.$object->o_telefone.'</p>' : '').(($object->o_email) ? '<p><strong>E-mail:</strong><br/>'.$object->o_email.'</p>' : '').(($object->o_endereco) ? '<p><strong>Endereço:</strong><br/>'.$object->o_endereco.'</p>' : '')."</div> <hr/></li>";

            //endif;

        endforeach; 

        $tplAddress .= "</ul>";

        echo $tplAddress;

        endif;    
    ?>
</aside>