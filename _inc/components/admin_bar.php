      <div class="admin-bar">
        <div class="container">
          <div>
              <p class="profile-picture">
                <span>Olá, <?php echo ($_SESSION['login']) ? $_SESSION['login'] : 'Usuário'; ?>.</span>
              </p>
              <ul class="admin-shortcuts">
                <li> 
                  <a target="_blank" href="<?php echo $default_url; ?>login.php" title="Ver minha conta">Ver minha conta</a>
                </li>
                <li>
                  <a href="_inc/logout.php?action=home" title="Sair">Sair</a>
                </li>
              </ul>
          </div>
        </div>
      </div>