      <?php if($basename != 'login') : if(isset($_SESSION['login'])) : include('_inc/components/admin_bar.php'); endif; ?>   
      <header class="header">
          <?php if($email||$telefone) : ?>
          <div id="topo">
            <div class="container">
              <p class="phone">Telefone: <?php echo $telefone; ?> | E-mail: <a href="mailto:<?php echo $email; ?>" title="<?php echo $email; ?>"><?php echo $email; ?></a></p>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($result = $conn->query("SELECT * FROM paginas ORDER BY id ASC")) : if ($result->num_rows > 0) : ?>
          <nav class="navigation -mobile">
            <ul>
              <?php include('_inc/nav.php'); ?>
            </ul>
            <div class="contact">
              <?php if($email) : ?>
              <p>
                <?php echo $email; ?>
              </p>
              <?php endif; ?>
              <?php include('_inc/components/social_networks.php'); ?>
            </div>
            <ul class="shortcuts">
              <li>
                <a href="./">
                  <i class="fas fa-home"></i>
                  <!-- Início -->
                </a>
              </li>
              <li>
                <a href="./page.php?slug=contato">
                  <i class="fas fa-envelope"></i>
                  <!-- Contato -->
                </a>
              </li>
              <li>
                  <button onclick="_mobileNavigation(this)" type="button" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                      <span class="tcon-menu__lines" aria-hidden="true"></span>
                      <span class="tcon-visuallyhidden">toggle menu</span>
                  </button>  
              </li>
            </ul>
          </nav>
          <?php endif; endif; ?>
          <div id="header">
            <div class="container">
              <?php if($logo) : ?>
              <h1 class="logo">
                <a href="<?php echo $default_url; ?>" title="<?php echo $ctitulo; ?>"><img height="90" src="profile/uploads/<?php echo $logo; ?>" alt="<?php echo $ctitulo; ?>" /></a>
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