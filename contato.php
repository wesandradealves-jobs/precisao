<?php include('_inc/sidebar-interna.php'); ?>   
<div class="internal-content-fill">
    <h2 class="title"><?php echo str_replace('-', ' ', $slug); ?></h2>
    <form class="contact-form -contato" action="phpmailer/send.php" method="POST">
        <p>PARA SUGESTÕES, CRÍTICAS, ELOGIOS OU RECLAMAÇÕES, PREENCHA O FORMULÁRIO ABAIXO</p>
        <div class="form-row">
            <div class="form-group">
                <span>
                    <input onkeypress="mascara(this,soLetras)" required="required" type="text" name="nome" placeholder="Nome" />
                </span>
                <span>
                    <input required="required" type="text" name="email" placeholder="E-mail" />
                </span>
                <span>
                    <input type="text" name="empresa" placeholder="Empresa" />
                </span>
                <span>
                    <div class="custom-select">
                        <select name="assunto">
                            <option value="" selected="">Assunto</option>
                            <option value="Dúvidas">Dúvidas</option>
                            <option value="Sugestões">Sugestões</option>
                            <option value="Elogios">Elogios</option>
                            <option value="Reclamações">Reclamações</option>
                        </select>
                    </div>
                </span>                
                <span>
                    <input class="celular" required="required" type="text" name="celular" placeholder="Celular" />
                </span>
                <span>
                    <input class="telefone" required="required" type="text" name="telefone" placeholder="Telefone" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <textarea name="mensagem" placeholder="Mensagem"></textarea>
                </span>
            </div>
            <div class="form-group-full">
                <input type="submit" name="contato" value="Enviar" class="btn -red" />
            </div>
        </div>
    </form>
    <!--  -->
    <div id="googleMap"></div>
</div>