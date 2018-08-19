              <?php while ($row = $result->fetch_object()) : ?>
                <?php if($row->showmenu && !$row->subpagina) : ?>
                  <li>
                    <a href="<?php echo ($row->anchor) ? '#'.$row->slug : "page.php?slug=".$row->slug; ?>" title="<?php echo $row->titulo; ?>"><?php echo $row->titulo; ?></a>
                    <?php 
                        if($row->slug != 'servicos') {
                          if($fetchSubmenu = $conn->query("SELECT * FROM `paginas` WHERE `pagina_mae` = '$row->slug' AND `subpagina` = 1 ORDER BY id ASC")) :
                              if($fetchSubmenu->num_rows) : 
                                $submenuTpl = '<ul class="submenu">';
                                  while ($row = $fetchSubmenu->fetch_object()) :
                                    $submenuTpl .= '<li><a href="'.(($row->anchor) ? '#'.$row->slug : "page.php?slug=".$row->slug).'" title="'.$row->titulo.'" target="'.(($row->anchor) ? '_self' : '_blank').'">'.$row->titulo.'</a></li>';
                                  endwhile;
                                $submenuTpl .= '</ul>';
                                echo $submenuTpl;
                              endif; 
                          endif;                         
                        } else {
                          if($fetchSubmenu = $conn->prepare("SELECT * FROM `$row->slug` ORDER BY id ASC")) :
                            if($fetchSubmenu) :
                              $fetchSubmenu->execute();
                              $fetchSubmenu->bind_result($rowID, $rowTITULO, $rowURL, $rowTEXT, $rowHEADERS);
                              $submenuTpl = '<ul class="submenu">';
                              while($fetchSubmenu->fetch()) :
                                  $rowID = $rowID;
                                  $rowTITULO = $rowTITULO;
                                  $rowURL = $rowURL;
                                  $rowTEXT = $rowTEXT;
                                  $submenuTpl .= '<li><a href="single.php?post='.$row->slug.'&id='.$rowID.'" title="'.$rowTITULO.'">'.$rowTITULO.'</a></li>';
                              endwhile;
                              $submenuTpl .= '</ul>';
                              echo $submenuTpl;
                            endif; 
                          endif;       
                        }
                    ?>
                  </li>
                <?php endif; ?>
              <?php endwhile; ?>       