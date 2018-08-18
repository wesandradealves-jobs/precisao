<?php include('_inc/sidebar-interna.php'); ?>   
<div class="internal-content-fill">
    <h2 class="title"><?php echo str_replace('-', ' ', $slug); ?></h2>
    <form class="contact-form -trabalhe-conosco" action="phpmailer/send.php" method="POST">
        <p>PARA SUGESTÕES, CRÍTICAS, ELOGIOS OU RECLAMAÇÕES, PREENCHA O FORMULÁRIO ABAIXO</p>
        <div class="form-row">
            <div class="form-group">
                <span>
                    <input required="required" type="text" name="nome" placeholder="Nome" />
                </span>
                <span>
                    <input required="required" class="rg" required="required" type="text" name="rg" placeholder="RG" />
                </span>
                <span>
                    <input required="required" class="cpf" required="required" type="text" name="cpf" placeholder="CPF" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <input required="required" type="date" class="data" name="nascimento" placeholder="Data de Nascimento" />
                </span>
                <span>
                    <div class="custom-select">
                        <select name="sexo">
                            <option selected value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                </span>  
                <span>
                    <input required="required" required="required" type="email" name="email" placeholder="E-mail" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <input class="telefone" type="tel" name="telefone" placeholder="Telefone" />
                </span>
                <span>
                    <input required="required" class="celular" type="tel" name="celular" placeholder="Celular" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <input required="required" type="text" name="rua" placeholder="Rua" />
                </span>
                <span>
                    <input required="required" type="number" name="numero" placeholder="Número" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <input required="required" type="text" name="bairro" placeholder="Bairro" />
                </span>
                <span>
                    <input required="required" type="text" name="cidade" placeholder="Cidade" />
                </span>
                <span>
                    <input required="required" type="text" name="uf" max-length="2" placeholder="UF" />
                </span>
            </div>
            <div class="form-group">
                <span>
                    <p>Está Trabalhando?</p> 
                    <p>
                        <label>Sim</label>
                        <input type="radio" name="trabalhando" id="sim" value="Sim" />
                    </p>
                    <p>
                        <label>Não</label>
                        <input type="radio" name="trabalhando" id="nao" value="Não" />
                    </p>
                </span>
            </div>
            <div class="form-group">
                <span>
                    <p>Disponível Sábado, Domingos e Feriados?</p> 
                    <p>
                        <label>Sim</label>
                        <input type="radio" name="disponibilidade" id="sim" value="Sim" />
                    </p>
                    <p>
                        <label>Não</label>
                        <input type="radio" name="disponibilidade" id="nao" value="Não" />
                    </p>
                </span>
            </div>
            <div class="form-group">
                <span>
                    <textarea name="mensagem" placeholder="Mensagem"></textarea>
                </span>
            </div>
            <div class="form-group-full">
                <input type="submit" name="trabalhe-conosco" value="Enviar" class="btn -red" />
            </div>
        </div>
    </form>
    <!--  -->
    <div id="googleMap"></div>
</div>