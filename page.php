<?php 
    include('_inc/head.php'); 
    if($slug == "sucesso") :
        $fetchContato = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'contato' LIMIT 1");
        if($fetchContato && $fetchContato->num_rows) : 
            while ($row = $fetchContato->fetch_object()) :
                $contatoBanner = $row->image; 
            endwhile;
        endif;
    endif;
?> 
  <?php include('_inc/header.php'); ?>     
      <main>
        <section class="banner -internal" style="background-image: url(<?php echo $default_url.((!$pgImage) ? ($slug == 'sucesso' && isset($contatoBanner)) ? "profile/uploads/".$contatoBanner : "assets/imgs/default-banner.jpg" : (($the_mother_page->num_rows && $pgPaginaMaeBanner) ? "profile/uploads/".$pgPaginaMaeBanner : "profile/uploads/".$pgImage)); ?>)">
          <div class="container">
            <h2>
              <?php 
                switch ($slug) {
                    case '404':
                        echo "<span>ERRO 404 - PÁGINA NÃO ENCONTRADA</span>";
                    break;
                    case 'sucesso':
                        echo "<span>Sucesso</span>";
                    break;
                    default:
                        echo ($pgPaginaMaeTitulo) ? "<span>".$pgPaginaMaeTitulo.":</span> ".$pgTitulo  : "<span>".$pgTitulo."</span>";
                        # code...
                    break;
                }
              ?>
            </h2>
            <?php include('_inc/components/breadcrumb.php'); ?>
          </div>
        </section>
        <section class="internal-content">
          <div class="container">
            <?php if($slug == 'contato'||$slug == 'trabalhe-conosco'||$slug == 'sucesso'||$slug == '404'): ?>
                <?php include('_inc/sidebar-interna.php'); ?>   
                <div class="internal-content-fill">
                    <h2 class="title">
                        <?php 
                            switch ($slug) {
                                case '404':
                                    echo "OOps! Encontramos um erro.";
                                break;
                                case 'sucesso':
                                    echo "Parabéns";
                                break;
                                default:
                                    echo ($pgPaginaMaeTitulo) ? "<span>".$pgPaginaMaeTitulo.":</span> ".$pgTitulo  : "<span>".$pgTitulo."</span>";
                                    # code...
                                break;
                            }
                        ?>
                    </h2>
                    <?php if($slug == 'contato') : ?>
                        <form class="contact-form -contato" action="<?php echo $default_url; ?>phpmailer/send.php" method="POST">
                            <p>PARA SUGESTÕES, CRÍTICAS, ELOGIOS OU RECLAMAÇÕES, PREENCHA O FORMULÁRIO ABAIXO:</p>
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
                    <?php elseif($slug == 'sucesso') : ?>
                        <p>Sua mensagem foi enviada com sucesso!<br/>Em breve responderemos seu contato.</p>
                    <?php elseif($slug == '404') : ?>
                        <p>Encontramos um erro ao processar sua página. Desculpe-nos o transtorno.</p>
                    <?php else : ?>
                        <form class="contact-form -trabalhe-conosco" action="<?php echo $default_url; ?>phpmailer/send.php" method="POST">
                            <p>PARA SE CADASTRAR, PREENCHA O FORMULÁRIO ABAIXO:</p>
                            <div class="form-row">
                                <div class="form-group">
                                    <span>
                                        <input onkeypress="mascara(this,soLetras)" required="required" type="text" name="nome" placeholder="Nome" />
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
                                        <input class="cep" id="cep" required="required" type="text" name="cep" placeholder="CEP" />
                                    </span>
                                    <span>
                                        <input readonly id="rua" required="required" type="text" name="rua" placeholder="Rua" />
                                    </span>
                                    <span>
                                        <input required="required" type="number" name="numero" placeholder="Número" />
                                    </span>
                                </div>
                                <div class="form-group">
                                    <span>
                                        <input readonly id="bairro" required="required" type="text" name="bairro" placeholder="Bairro" />
                                    </span>
                                    <span>
                                        <input readonly id="cidade" required="required" type="text" name="cidade" placeholder="Cidade" />
                                    </span>
                                    <span>
                                        <input readonly required="required" type="text" name="uf" id="uf" class="uf" maxlength="2" size="2" max="2" placeholder="UF" />
                                    </span>
                                </div>
                                <div class="form-group form-group-full">
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
                                <div class="form-group form-group-full">
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
                                <div class="form-group form-group-full">
                                    <span>
                                        <textarea name="mensagem" placeholder="Mensagem"></textarea>
                                    </span>
                                </div>
                                <div class="form-group-full">
                                    <input type="submit" name="trabalhe-conosco" value="Enviar" class="btn -red" />
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                    <!--  -->
                    <div id="googleMap"></div>
                </div>
            <?php else : ?>
                <div class="internal-content-fill">
                    <?php 
                        echo htmlspecialchars_decode($pgConteudo);

                        $query=mysqli_query($conn,"select count(id) from `$slug`");
                        
                        if(mysqli_query($conn,"select count(id) from `$slug`")) : $row = mysqli_fetch_row($query);

                        $rows = $row[0];
                        
                        $page_rows = 6;
                        
                        $last = ceil($rows/$page_rows);
                        
                        if($last < 1){
                            $last = 1;
                        }
                        
                        $pagenum = 1;
                        
                        if(isset($_GET['pn'])){
                            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
                        }
                        
                        if ($pagenum < 1) { 
                            $pagenum = 1; 
                        } 
                        else if ($pagenum > $last) { 
                            $pagenum = $last; 
                        }
                        
                        $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
                        
                        $nquery=mysqli_query($conn,"SELECT * FROM `$slug` $limit");
                        
                        $paginationCtrls = '';
                        
                        if($last != 1){
                        
                        if ($pagenum > 1) {
                                $previous = $pagenum - 1;
                            $paginationCtrls .= '<a href="'.$default_url.'archive/'.$slug.'/'.$previous.'" class="btn -red">Anterior</a> &nbsp; &nbsp; ';
                        
                            for($i = $pagenum-4; $i < $pagenum; $i++){
                            if($i > 0){
                                    $paginationCtrls .= '<a href="'.$default_url.'archive/'.$slug.'/'.$i.'" class="btn -red">'.$i.'</a> &nbsp; ';
                            }
                            }
                            }
                        
                        $paginationCtrls .= ''.$pagenum.' &nbsp; ';
                        
                        for($i = $pagenum+1; $i <= $last; $i++){
                            $paginationCtrls .= '<a href="'.$default_url.'archive/'.$slug.'/'.$i.'" class="btn -red">'.$i.'</a> &nbsp; ';
                            if($i >= $pagenum+4){
                            break;
                            }
                        }
                        
                            if ($pagenum != $last) {
                                $next = $pagenum + 1;
                                $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$default_url.'archive/'.$slug.'/'.$next.'" class="btn -red">Próxima</a> ';
                            }
                        } 

                        echo '<ul class="listing -'.$slug.'">';
                            while($crawler = mysqli_fetch_array($nquery)) : 
                            $repeatTPL = '<li>';
                                if($slug == "artigos") :
                                    $repeatTPL .= '<div style="background-image:url('.$default_url.'profile/uploads/'.$crawler['url'].')"></div>';
                                    $repeatTPL .= '<div>';
                                    $repeatTPL .= '<h2 class="title">'.$crawler['titulo'].'</h2>';
                                    $repeatTPL .= '<div class="content-holder">'.substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200).((strlen(substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200)) >= 200) ? '...' : '')."</div>";
                                    // '.$default_url.$row->slug.'/'.$rowID.'  single.php?post='.$slug.'&id='.$crawler['id'].'
                                    $repeatTPL .= '<a class="btn -red" href="'.$default_url.$slug.'/'.$crawler['id'].'" title="'.$crawler['titulo'].'">Continue lendo</a>';
                                    $repeatTPL .= '</div>';
                                else : 
                                    $repeatTPL .= '<h2 class="title">'.$crawler['titulo'].'</h2>';
                                    $repeatTPL .= '<div>';
                                    $repeatTPL .= '<div style="background-image:url('.$default_url.'profile/uploads/'.$crawler['url'].')"><a class="btn -red" href="'.$default_url.$slug.'/'.$crawler['id'].'" title="'.$crawler['titulo'].'">Continue lendo</a></div>';
                                    $repeatTPL .= '<div class="content-holder">'.substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200).((strlen(substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200)) >= 200) ? '...' : '')."</div>";
                                    $repeatTPL .= '</div>';
                                endif; 
                            $repeatTPL .= '</li>';
                            echo $repeatTPL;    
                            endwhile;
                        echo '</ul>';
                        echo $paginationCtrls;   
        
                        endif;  
                        // mysqli_close($conn);
                    ?>   
                </div>
                <?php include('_inc/sidebar.php'); ?>            
            <?php endif; ?>
          </div>
        </section>
      </main>
<?php include('_inc/footer.php'); ?>