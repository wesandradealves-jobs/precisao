<form action="phpmailer/send.php" method="POST" class="cotacao-form">
    <div class="cotacao-header">
      <h2 class="title">Faça sua cotação online agora!</h2>
      <p class="text">Profissionais capacitados que atendem às necessidades específicas</p>
    </div>
    <div class="cotacao-content">
      <span>
        <input required="required" name="nome" type="text" placeholder="Nome" />
      </span>
      <span>
        <input name="email" type="email" placeholder="E-mail" />
      </span>
      <span>
        <input required="required" name="telefone" type="tel" placeholder="Telefone" />
      </span>                                  
      <span>
        <span class="custom-select">
          <select required="required" name="orcamento_tipo" id="orcamento_tipo">
            <?php 
              echo $servicos_para_cotacao;
            ?>
          </select>
        </span>
      </span>     
      <span>
        <input type="submit" name="orcamento" class="btn -red" />
      </span>     
    </div>
  </form>
