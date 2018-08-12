              <?php while ($row = $result->fetch_object()) : ?>
                <?php if($row->showmenu && !$row->subpagina) : ?>
                  <li>
                    <a href="<?php echo ($row->anchor) ? '#'.$row->slug : $row->slug.".php"; ?>" title="<?php echo $row->titulo; ?>"><?php echo $row->titulo; ?></a>
                    <?php 
                        if($fetchSubmenu = $conn->query("SELECT * FROM `paginas` WHERE `pagina_mae` = '$row->slug' AND `subpagina` = 1 ORDER BY id ASC")) :
                            if($fetchSubmenu->num_rows) : 
                              $submenuTpl = '<ul class="submenu">';
                                while ($row = $fetchSubmenu->fetch_object()) :
                                  $submenuTpl .= '<li><a href="'.(($row->anchor) ? '#'.$row->slug : $row->slug).'" title="'.$row->titulo.'" target="'.(($row->anchor) ? '_self' : '_blank').'">'.$row->titulo.'</a></li>';
                                endwhile;
                              $submenuTpl .= '</ul>';
                              echo $submenuTpl;
                            endif; 
                        endif;                         
                    ?>
                  </li>
                <?php endif; ?>
              <?php endwhile; ?>       