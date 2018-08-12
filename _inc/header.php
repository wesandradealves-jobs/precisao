      <?php if($basename != 'login') : if(isset($_SESSION['login'])) : include('_inc/admin-bar.php'); endif; ?>   
      <header class="header">
          <?php if($email||$telefone) : ?>
          <div id="topo">
            <div class="container">
              <p class="phone">Telefone: <?php echo $telefone; ?> | E-mail: <a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo $email; ?></a></p>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($result = $conn->query("SELECT * FROM paginas ORDER BY id DESC")) : if ($result->num_rows > 0) : ?>
          <nav class="navigation -mobile">
            <ul>
              <?php include('_inc/nav.php'); ?>
            </ul>
          </nav>
          <?php endif; endif; ?>
          <div id="header">
            <div class="container">
              <?php if($logo) : ?>
              <h1 class="logo">
                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" title="PRECISÃO SERVIÇOS GERAIS"><img src="profile/uploads/<?php echo $logo; ?>" alt="PRECISÃO SERVIÇOS GERAIS" /></a>
              </h1>
              <?php endif; ?>
              <?php if ($result = $conn->query("SELECT * FROM paginas ORDER BY id ASC")) : if ($result->num_rows > 0) : ?>
              <nav class="navigation">
                <ul>
                  <?php include('_inc/nav.php'); ?>
                  <li>
                      <button onclick="_mobileNavigation(this)" type="button" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                          <span class="tcon-menu__lines" aria-hidden="true"></span>
                          <span class="tcon-visuallyhidden">toggle menu</span>
                      </button>  
                  </li>                     
                </ul>
              </nav>
              <?php endif; endif; ?>
            </div>
          </div>
      </header>
      <?php endif; ?>