<?php include('_inc/head.php'); ?> 
  <?php include('_inc/header.php'); ?>     
      <main>
        <section class="banner -internal" style="background-image: url(<?php echo (!$pgImage) ? "assets/imgs/default-banner.jpg" : (($the_mother_page->num_rows && $pgPaginaMaeBanner) ? "profile/uploads/".$pgPaginaMaeBanner : "profile/uploads/".$pgImage); ?>)">
          <div class="container">
            <h2>
              <?php 
               echo (($pgPaginaMaeTitulo) ? "<span>".$pgPaginaMaeTitulo.":</span> ".$pgTitulo : "<span>".$pgTitulo."</span>");
              ?>
            </h2>
            <?php include('_inc/components/breadcrumb.php'); ?>
          </div>
        </section>
        <section class="internal-content">
          <div class="container">
            <?php if($slug == 'contato'||$slug == 'trabalhe-conosco'): ?>
                <?php include($slug.".php"); ?>
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
                            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?slug='.$slug.'&pn='.$previous.'" class="btn -red">Anterior</a> &nbsp; &nbsp; ';
                        
                            for($i = $pagenum-4; $i < $pagenum; $i++){
                            if($i > 0){
                                    $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?slug='.$slug.'&pn='.$i.'" class="btn -red">'.$i.'</a> &nbsp; ';
                            }
                            }
                            }
                        
                        $paginationCtrls .= ''.$pagenum.' &nbsp; ';
                        
                        for($i = $pagenum+1; $i <= $last; $i++){
                            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?slug='.$slug.'&pn='.$i.'" class="btn -red">'.$i.'</a> &nbsp; ';
                            if($i >= $pagenum+4){
                            break;
                            }
                        }
                        
                            if ($pagenum != $last) {
                                $next = $pagenum + 1;
                                $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?slug='.$slug.'&pn='.$next.'" class="btn -red">Próxima</a> ';
                            }
                        } 

                        echo '<ul class="listing -'.$slug.'">';
                            while($crawler = mysqli_fetch_array($nquery)) : 
                            $repeatTPL = '<li>';
                                if($slug == "artigos") :
                                    $repeatTPL .= '<div style="background-image:url(profile/uploads/'.$crawler['url'].')"></div>';
                                    $repeatTPL .= '<div>';
                                    $repeatTPL .= '<h2 class="title">'.$crawler['titulo'].'</h2>';
                                    $repeatTPL .= '<div class="content-holder">'.substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200).((strlen(substr(strip_tags(htmlspecialchars_decode($crawler['text'])), 0, 200)) >= 200) ? '...' : '')."</div>";
                                    $repeatTPL .= '<a class="btn -red" href="single.php?post='.$slug.'&id='.$crawler['id'].'" title="'.$crawler['titulo'].'">Continue lendo</a>';
                                    $repeatTPL .= '</div>';
                                else : 
                                    $repeatTPL .= '<h2 class="title">'.$crawler['titulo'].'</h2>';
                                    $repeatTPL .= '<div>';
                                    $repeatTPL .= '<div style="background-image:url(profile/uploads/'.$crawler['url'].')"><a class="btn -red" href="single.php?post='.$slug.'&id='.$crawler['id'].'" title="'.$crawler['titulo'].'">Continue lendo</a></div>';
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