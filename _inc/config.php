<?php
    session_start();

    $basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

    $config = $conn->prepare("SELECT `logo`, `favico`, `titulo` FROM `smtp` LIMIT 1");
    $contato = $conn->prepare("SELECT `telefone`, `email`, `endereco`, `maps` FROM `contatos` ORDER BY id");
    $banner = $conn->prepare("SELECT * FROM `banner` ORDER BY id ASC");
    $portfolio_comercial = $conn->prepare("SELECT `text`, `url`, `label` FROM `portfolio_comercial` ORDER BY id");
    $servicos = $conn->prepare("SELECT `id`, `titulo`, `url`, `text` FROM `servicos` ORDER BY id ASC LIMIT 3");
    $artigos = $conn->prepare("SELECT * FROM `artigos` ORDER BY id DESC LIMIT 1");
    $redes_sociais = $conn->prepare("SELECT * FROM `redes_sociais` ORDER BY id ASC");

    $fetchServicosPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'servicos' LIMIT 1");
    $fetchArtigosPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'artigos' LIMIT 1");
    $fetchEmpresaPage = $conn->query("SELECT * FROM `paginas` WHERE `slug` = 'a-empresa' LIMIT 1");

    $slug = (isset($_GET['slug'])) ? $_GET['slug'] : '';
    $type = (isset($_GET['type '])) ? $_GET['type '] : '';

    if($config){
        $config->execute();
        $config->bind_result($logo, $favico, $ctitulo);
        while($config->fetch()) {
            $logo = $logo;
            $favico = $favico;
            $ctitulo = $ctitulo;
        }
    } if($contato){
        $contato->execute();
        $contato->bind_result($telefone, $email, $endereco, $MAPS);
        while($contato->fetch()) {
            $telefone = strip_tags($telefone);
            $email = strip_tags($email);
            $endereco = strip_tags($endereco);
            $MAPS = strip_tags($MAPS);
        }
    } if($portfolio_comercial){
        $portfolio_comercial->execute();
        $portfolio_comercial->bind_result($ptxt, $purl, $plabel);
        while($portfolio_comercial->fetch()) {
            $ptxt = $ptxt;
            $purl = $purl;
            $plabel = $plabel;
        }
    }  

    if($fetchServicosCotacao = $conn->query("SELECT * FROM `servicos` ORDER BY id ASC")) :
        if($fetchServicosCotacao->num_rows) :
            $servicos_para_cotacao = '<option value="">Orçamento Desejado</option>'; 
            while ($row = $fetchServicosCotacao->fetch_object()) :
                $servicos_para_cotacao .= '<option value="'.$row->titulo.'">'.$row->titulo.'</option>';
            endwhile;
        endif; 
    endif;  

    if($seo = $conn->query("SELECT * FROM paginas ORDER BY id ASC")) :
        if ($seo->num_rows > 0) :
            while ($row = $seo->fetch_object()) :
                if($row->slug == $basename || ($row->slug == "home" && (!$basename||$basename == "index"))){
                    $headers = $row->headers;
                    $slug = $row->slug;
                    $pgTitulo = $row->titulo;
                } else if($basename == "login"){
                    $slug = $basename;
                    $pgTitulo = "Login";
                    $headers = '<meta name="keywords" content="login, precisao, servicos, gerais" />';
                    $headers .= '<meta property="og:description" content="Login Page" />';
                } else if($basename == "page"){
                    
                    $the_page = $conn->prepare("SELECT `titulo`, `conteudo`, `slug`, `image`, `pagina_mae`, `headers` FROM `paginas` WHERE `slug` = '$slug' LIMIT 1");
                    
                    if($the_page){
                        $the_page->execute();
                        $the_page->store_result();
                        $the_page->bind_result($pgTitulo, $pgConteudo, $pgSlug, $pgImage, $pgPaginaMaeSlug, $headers);
                        while($the_page->fetch()) {
                            $pgTitulo = $pgTitulo;
                            $pgImage = $pgImage;
                            $pgSlug = $pgSlug;
                            $pgConteudo = $pgConteudo;
                            $headers = $headers;
                            $pgPaginaMaeSlug = $pgPaginaMaeSlug;
                        }
                        $the_mother_page = $conn->prepare("SELECT `titulo`, `image` FROM `paginas` WHERE `slug` = '$pgPaginaMaeSlug' LIMIT 1");
                        
                        if($the_mother_page){
                            if($the_mother_page){
                                $the_mother_page->execute();
                                $the_mother_page->bind_result($pgPaginaMaeTitulo, $pgPaginaMaeBanner);
                                while($the_mother_page->fetch()) {
                                    $pgPaginaMaeBanner = $pgPaginaMaeBanner;
                                    $pgPaginaMaeTitulo = $pgPaginaMaeTitulo;
                                }
                            }                              
                        }
                    } 
                    // if($slug == "" || !isset($slug)) {
                    //     header("Location: ./page.php?slug=404");
                    // } 
                } else if($basename == "single"){
                    $post_slug = $_GET['post_slug'];
                    $post = $_GET['post'];
                    $single = $conn->prepare("SELECT * FROM `$post` WHERE `slug` = '$post_slug' ORDER BY id");
                    if($single){
                        $single->execute();
                        $single->store_result();
                        $single->bind_result($single_post_id, $single_post_titulo, $single_post_url, $single_post_text, $headers, $slug);
                        while($single->fetch()) {
                            $single_post_titulo = $single_post_titulo;
                            $single_post_url = $single_post_url;
                            $single_post_text = $single_post_text;
                            $single_post_id = $single_post_id;
                            $headers = $headers;
                            $slug = $slug;
                        }
                        $sessao = $conn->prepare("SELECT `titulo`, `slug`, `image` FROM `paginas` WHERE `slug` = '$post' ORDER BY id");
                        if($sessao){
                            $sessao->execute();
                            $sessao->store_result();
                            $sessao->bind_result($sessao_titulo, $sessao_slug, $sessao_image);
                            while($sessao->fetch()) {
                                $sessao_titulo = $sessao_titulo;
                                $sessao_slug = $sessao_slug;
                                $sessao_image = $sessao_image;
                            }
                        }
                        $pgTitulo = $sessao_titulo." - ".$single_post_titulo;
                    } 
                    // if( (!isset($_GET['id']) || !isset($_GET['post'])) || ($_GET['id'] == "" || $_GET['post'] == "") ) {
                    //     header("Location: ./page.php?slug=404");
                    // }
                }
            endwhile;
        endif; 
    endif;    

    if(isset($_SESSION['login']) && $basename == 'login'){
        header("Location: profile/index.php");
    } else if($basename == "single"){

        if(isset($_GET['post'])) :
            $tmp_screenshot = $single_post_url; 
        endif; 

        $description = substr( strip_tags(htmlspecialchars_decode($single_post_text)), 0, 300 )."...";
    } else if($basename == "page"){

        preg_match( '@src="([^"]+)"@' , htmlspecialchars_decode($pgConteudo), $match );
        $screenshot = array_pop($match);

        // requires php5
        define('UPLOAD_DIR', 'profile/tmp/');
        $img = $screenshot;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $tmp_screenshot = UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($tmp_screenshot, $data);
        // print $success ? $default_url.$tmp_screenshot : 'Unable to save the file.';

        $description = substr( strip_tags(htmlspecialchars_decode($pgConteudo)), 0, 300 )."...";
    } else if($basename != "page" && $basename != "single"){
        $description = 'Com sede em São Paulo e Filiais no Rio de Janeiro e Santa Catarina, o Grupo Precisão está no mercado, cuja meta principal é a satisfação de seus clientes e a qualidade nos serviços prestados. O Grupo Precisão tem como escopo a escolha de profissionais capacitados que atendam às necessidades específicas do contratante, oferecendo segurança, qualidade e consciência no cumprimento de seus deveres.';
    }

    $ga = 'UA-124184563-1';

    error_reporting(0);

    foreach (explode("/", $telefone) as $key => $value) {

        $meusEnderecos[$key]->o_telefone = $value;

    } 

    foreach (explode("/", $email) as $key => $value) {

        $meusEnderecos[$key]->o_email = $value;

    } 

    foreach (explode("/", $endereco) as $key => $value) {

        $meusEnderecos[$key]->o_endereco = $value;

    }
?>