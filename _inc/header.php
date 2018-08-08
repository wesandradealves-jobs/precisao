      <?php if($basename != 'login') : if(isset($_SESSION['login'])) : include('_inc/admin-bar.php'); endif; ?>   
      <header class="header">
          <div id="topo">
            <div class="container">
              <p class="phone">Telefone: <a href="tel:+551126744000">(055XX11) 2674 - 4000</a> | E-mail: <a href="mailto:precisao@precisaoservicos.com.br" title="precisao@precisaoservicos.com.br">precisao@precisaoservicos.com.br</a></p>
            </div>
          </div>
          <nav class="navigation -mobile">
            <ul>
              <li><a href="#home" title="Home">Home</a></li>
              <li><a href="#servicos" title="Serviços">Serviços</a></li>
              <li><a href="#artigos" title="Artigos">Artigos</a></li>
              <li><a href="#empresa" title="Empresa">Empresa</a></li>
              <li><a href="javascript:void(0)" title="Terceirize">Terceirize</a></li>
              <li><a href="javascript:void(0)" title="Meio Ambiente">Meio Ambiente</a></li>
              <li><a href="javascript:void(0)" title="Trabalhe Conosco">Trabalhe Conosco</a></li>
              <li><a href="#contato" title="Contato">Contato</a></li>
            </ul>
          </nav>
          <div id="header">
            <div class="container">
              <h1 class="logo">
                <a href="index.html" title="PRECISÃO SERVIÇOS GERAIS"><img src="assets/imgs/logo.png" alt="PRECISÃO SERVIÇOS GERAIS" /></a>
              </h1>
              <nav class="navigation">
                <ul>
                  <li><a href="#home" title="Home">Home</a></li>
                  <li><a href="#servicos" title="Serviços">Serviços</a></li>
                  <li><a href="#artigos" title="Artigos">Artigos</a></li>
                  <li><a href="#empresa" title="Empresa">Empresa</a></li>
                  <li><a href="javascript:void(0)" title="Terceirize">Terceirize</a></li>
                  <li><a href="javascript:void(0)" title="Meio Ambiente">Meio Ambiente</a></li>
                  <li><a href="javascript:void(0)" title="Trabalhe Conosco">Trabalhe Conosco</a></li>
                  <li><a href="#contato" title="Contato">Contato</a></li>
                  <li>
                      <button onclick="_mobileNavigation(this)" type="button" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                          <span class="tcon-menu__lines" aria-hidden="true"></span>
                          <span class="tcon-visuallyhidden">toggle menu</span>
                      </button>  
                  </li>                     
                </ul>
              </nav>
            </div>
          </div>
      </header>
      <?php endif; ?>