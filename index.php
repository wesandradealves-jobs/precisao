<?php include('_inc/head.php'); ?> 
  <?php include('_inc/header.php'); ?>     
      <main class="scroll-view">
        <?php if($banner) : ?>
          <section id="home" class="webdoor">
            <div class="owl-carousel owl-theme -webdoor">
              <?php
                $banner->execute();
                $banner->bind_result($bannerID, $image, $url, $html, $widget, $widget_name);
                while($banner->fetch()) :
                    $bannerID = $bannerID;
                    $image = $image;
                    $url = $url;
                    $html = $html;

                    $bannerTPL = '<div style="background-image:url(profile/uploads/'.$image.')" id="post_banner_'.$bannerID.'" class="item">';
                      $bannerTPL .= '<div class="container">';
                        $bannerTPL .= '<div>';
                          if($widget){
                            if($widget_name) :
                              ob_start();
                              include '_inc/widgets/'.$widget_name.'.php';
                              $bannerTPL .= ob_get_clean();
                            endif;
                          } else if(!$widget){
                            if($html) :
                              $bannerTPL .= html_entity_decode($html);
                            endif;
                          }
                        $bannerTPL .= '</div>';
                      $bannerTPL .= '</div>';
                    $bannerTPL .= '</div>';

                    echo $bannerTPL;
                endwhile;
              ?>
            </div>
          </section>
        <?php endif; ?>
        <?php include('_inc/components/portfolio_comercial.php'); ?>
        <?php if($fetchServicosPage && $fetchServicosPage->num_rows) : while ($row = $fetchServicosPage->fetch_object()) :  ?>
          <section id="servicos" class="servicos">
            <div class="container">
              <div class="section-header">
                <h2 class="title">
                  <span><?php echo $row->titulo; ?></span>
                </h2>
                <p><?php echo strip_tags(htmlspecialchars_decode($row->resumo)); ?></p>
              </div>
              <?php if($servicos) : ?>
              <ul class="servicos-list">
                <?php 
                    $servicos->execute();
                    $servicos->bind_result($SID, $stitulo, $surl, $stext);
                    while($servicos->fetch()) {
                        $SID = $SID;
                        $stitulo = $stitulo;
                        $surl = $surl;
                        $stext = $stext;
                        $sSlug = to_permalink($stitulo);

                        $servicosTPL = '<li>';
                          $servicosTPL .= '<div style="background-image:url(profile/uploads/'.$surl.')" id="post_servico_'.$SID.'" class="thumbnail -hover">';
                            $servicosTPL .= '<div>';
                              $servicosTPL .= '<div>';
                                $servicosTPL .= '<h3 class="title">'.$stitulo.'</h3>';
                                $servicosTPL .= '<a href="single.php?post=servicos&id='.$SID.'" title="Saiba Mais +" class="btn -red">Saiba Mais +</a>';
                              $servicosTPL .= '</div>';
                            $servicosTPL .= '</div>';
                          $servicosTPL .= '</div>';
                        $servicosTPL .= '</li>';

                        echo $servicosTPL;
                    }
                ?>
              </ul>
              <?php endif; ?>
            </div>
          </section>
        <?php endwhile; endif; ?>
        <?php if($fetchArtigosPage && $fetchArtigosPage->num_rows) : while ($row = $fetchArtigosPage->fetch_object()) :  ?>
          <section id="artigos" class="artigos">
            <div class="container">
              <div class="section-header">
                <h2 class="title">
                  <span><?php echo $row->titulo; ?></span>
                </h2>
                <p><?php echo strip_tags(htmlspecialchars_decode($row->resumo)); ?></p>
              </div>
              <?php if($artigos) : ?>
              <div class="artigos-section-content">
                <?php 
                    $artigos->execute();
                    $artigos->bind_result($AID, $atitulo, $aurl, $atext, $headers);
                    while($artigos->fetch()) {
                        $AID = $AID;
                        $atitulo = $atitulo;
                        $aurl = $aurl;
                        $atext = $atext;
                        $aSlug = to_permalink($atitulo);

                        $artigosTPL = '<div>';
                          $artigosTPL .= '<div class="thumbnail" id="post_artigo_'.$AID.'" style="background-image:url(profile/uploads/'.$aurl.')"><div></div></div>';
                        $artigosTPL .= '</div>';

                        $artigosTPL .= '<div>';
                          $artigosTPL .= '<h3 class="title">'.$atitulo.'</h3>';
                          $artigosTPL .= '<p>'.substr(strip_tags(htmlspecialchars_decode($atext)), 0, 200).((strlen(substr(strip_tags(htmlspecialchars_decode($atext)), 0, 200)) >= 200) ? '...' : '').'</p>';
                          $artigosTPL .= '<a href="single.php?post=artigos&id='.$AID.'" class="btn -red" title="'.$atitulo.'">Saiba Mais +</a>';
                        $artigosTPL .= '</div>';

                        echo $artigosTPL;
                    }
                ?>
              </div>
              <?php endif; ?>
            </div>
          </section>
        <?php endwhile; endif; ?>
        <?php if($fetchEmpresaPage && $fetchEmpresaPage->num_rows) :  while ($row = $fetchEmpresaPage->fetch_object()) : ?>
          <section id="a-empresa" class="empresa">
            <div class="container">
              <div>
                <div class="section-header">
                  <h2 class="title">
                    <span><?php echo $row->titulo; ?></span>
                  </h2>
                </div>
                <p><?php echo strip_tags(htmlspecialchars_decode($row->resumo)); ?></p>
              </div>
            </div>
          </section>
        <?php  endwhile; endif; ?>
        <section id="contato" class="contato">
          <div class="container">
            <div class="section-header">
              <h2 class="title"><span>Contato</span></h2>
            </div>
            <div class="contato-content">
              <p>
                <?php echo $telefone; ?><br/>
                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                <br/><br/>
                <small><?php echo $endereco; ?></small>
              </p>
            </div>
          </div>
          <div id="googleMap"></div>
        </section>
      </main>
<?php include('_inc/footer.php'); ?>