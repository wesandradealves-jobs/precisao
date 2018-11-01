<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */
//Import PHPMailer classes into the global namespace
// require("PHPMailer.php");
// require("SMTP.php");
// require("Exception.php");
// require("OAuth.php");
// atendimento@precisaoservicos.com.br

require_once("PHPMailerAutoload.php");
require_once("../_inc/db.php");

$stmt = $conn->prepare("SELECT `smtp_user`, `smtp_host`, `smtp_password`, `smtp_port`, `contact_form`, `cotacao_form`, `trabalhe_form` FROM `smtp` ORDER BY id");

if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($smtp_user, $smtp_host, $smtp_password, $smtp_port, $contact_form, $cotacao_form, $trabalhe_form);
    while ($stmt->fetch()) {
        $smtp_user     = $smtp_user;
        $smtp_host     = $smtp_host;
        $smtp_password = $smtp_password;
        $smtp_port     = $smtp_port;
        $contact_form  = $contact_form;
        $cotacao_form  = $cotacao_form;
        $trabalhe_form = $trabalhe_form;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        $secret         = '6LcBeGgUAAAAAMU-nI_79ASrPb6wL_QXn69BT3Zx';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData   = json_decode($verifyResponse);
        if($responseData->success){
            if (isset($_POST['orcamento'])) {
                $nome           = $_POST['nome'];
                $telefone       = $_POST['telefone'];
                $email          = $_POST['email'];
                $orcamento_tipo = $_POST['orcamento_tipo'];
                $enviarPara     = ($cotacao_form) ? $cotacao_form : '';
                //
                $assunto        = 'Cotação - ' . $orcamento_tipo;
                $message        = 'Nome: ' . $nome;
                $message .= '<br/>E-mail: ' . $email;
                $message .= '<br/>Telefone: ' . $telefone;
                $message .= '<br/>Orçamento: ' . $orcamento_tipo;
            } elseif (isset($_POST['trabalhe-conosco'])) {
                $nome            = $_POST['nome'];
                $rg              = $_POST['rg'];
                $cpf             = $_POST['cpf'];
                $nascimento      = $_POST['nascimento'];
                $sexo            = $_POST['sexo'];
                $email           = $_POST['email'];
                $telefone        = $_POST['telefone'];
                $celular         = $_POST['celular'];
                $cep             = $_POST['cep'];
                $cidade          = $_POST['cidade'];
                $uf              = $_POST['uf'];
                $bairro          = $_POST['bairro'];
                $rua             = $_POST['rua'];
                $numero          = $_POST['numero'];
                $trabalhando     = $_POST['trabalhando'];
                $disponibilidade = $_REQUEST['disponibilidade'];
                $mensagem        = $_POST['mensagem'];
                $enviarPara      = ($trabalhe_form) ? $trabalhe_form : '';
                
                
                // UPLOAD
                function db($servidor, $usuario, $senha, $dbname)
                {
                    //Criar a conexao
                    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
                    
                    if (!$conn) {
                        die("Falha na conexao: " . mysqli_connect_error());
                    } else {
                        $query  = "SELECT cpf FROM curriculos WHERE cpf = '" . $_POST['cpf'] . "' LIMIT 1";
                        $result = mysqli_query($conn, $query);
                        
                        $target_dir    = dirname(__FILE__) . "/../profile/curriculos/";
                        $target_file   = $target_dir . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]);
                        $uploadOk      = 1;
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        
                        $get_file  = "SELECT curriculo FROM curriculos WHERE cpf = '" . $_POST['cpf'] . "' LIMIT 1";
                        $rget_file = mysqli_query($conn, $get_file);
                        
                        if ($get_info = $conn->query($get_file)):
                            while ($row = $get_info->fetch_row()):
                                $arquivo_atual = $row[0];
                                if ($arquivo_atual != to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"])):
                                    unlink($target_dir . $arquivo_atual);
                                endif;
                            endwhile;
                        endif;
                        
                        if (!$result->num_rows) {
                            $sql = "INSERT INTO curriculos (nome, rg, cpf, nascimento, sexo, email, telefone, celular, cep, rua, numero, bairro, cidade, uf, trabalhando, disponibilidade, mensagem, curriculo, curriculo_url) VALUES ('" . $_POST['nome'] . "', '" . $_POST['rg'] . "', '" . $_POST['cpf'] . "', '" . $_POST['nascimento'] . "', '" . $_POST['sexo'] . "' , '" . $_POST['email'] . "', '" . $_POST['telefone'] . "', '" . $_POST['celular'] . "', '" . $_POST['cep'] . "', '" . $_POST['rua'] . "', '" . $_POST['numero'] . "', '" . $_POST['bairro'] . "', '" . $_POST['cidade'] . "', '" . $_POST['uf'] . "', '" . $_POST['trabalhando'] . "', '" . $_POST['disponibilidade'] . "', '" . $_POST['mensagem'] . "', '" . ((basename($_FILES["file"]["name"])) ? to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) : '-') . "', '" . ((basename($_FILES["file"]["name"])) ? 'https://' . $_SERVER['SERVER_NAME'] . '/profile/curriculos/' . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) : '-') . "')";
                        } else {
                            $sql = "UPDATE curriculos SET nome='" . $_POST['nome'] . "', rg='" . $_POST['rg'] . "', cpf='" . $_POST['cpf'] . "', nascimento='" . $_POST['nascimento'] . "', sexo='" . $_POST['sexo'] . "', email='" . $_POST['email'] . "', telefone='" . $_POST['telefone'] . "', celular='" . $_POST['celular'] . "', cep='" . $_POST['cep'] . "', rua='" . $_POST['rua'] . "', numero='" . $_POST['numero'] . "', bairro='" . $_POST['bairro'] . "', cidade='" . $_POST['cidade'] . "', uf='" . $_POST['uf'] . "', trabalhando='" . $_POST['trabalhando'] . "', disponibilidade='" . $_POST['disponibilidade'] . "', mensagem='" . $_POST['mensagem'] . "', curriculo='" . ((basename($_FILES["file"]["name"])) ? to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) : '-') . "', curriculo_url='" . ((basename($_FILES["file"]["name"])) ? 'https://' . $_SERVER['SERVER_NAME'] . '/profile/curriculos/' . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) : '-') . "' ";

                            echo 'Atualizado com sucesso';
                        }
                        if ($conn->query($sql) === TRUE) {
                            if ($_FILES["file"]["tmp_name"]) {
                                if ($imageFileType == "pdf" || $imageFileType == "docx" || $imageFileType == "doc") {
                                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                                        $files = date("dmYhis") . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]);
                                        print_r(array(
                                            'FILE',
                                            'File Successfully Uploaded'
                                        ));
                                    } else {
                                        print_r(array(
                                            'FILE',
                                            'Error Uploading File'
                                        ));
                                        exit;
                                    }
                                } else {
                                    print_r(array(
                                        'FILE',
                                        'File Not Supported'
                                    ));
                                    exit;
                                }
                            }
                        }
                    }
                }
                
                
                db('localhost', 'root', '', 'demo1380119880');
                
                //
                $assunto = 'Trabalhe Conosco';
                $message = 'Nome: ' . $nome;
                $message .= '<br/>Email: ' . $email;
                $message .= '<br/>RG: ' . $rg;
                $message .= '<br/>CPF: ' . $cpf;
                $message .= '<br/>Nascimento: ' . $nascimento;
                $message .= '<br/>Sexo: ' . $sexo;
                $message .= '<br/>Telefone: ' . $telefone;
                $message .= '<br/>Celular: ' . $celular;
                $message .= '<br/>Endereço: ' . $rua . ', ' . $numero . ' - ' . $bairro . ', ' . $uf . ' - ' . $cidade . ' - ' . $cep;
                $message .= '<br/>Trabalhando: ' . $trabalhando;
                $message .= '<br/>Disponibilidade: ' . $disponibilidade;
                $message .= '<br/>Currículo:<br/><a href="https://' . $_SERVER['SERVER_NAME'] . '/profile/curriculos/' . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) . '">' . to_permalink($_POST['cpf']) . '_' . basename($_FILES["file"]["name"]) . '</a>';
                $message .= '<br/><hr/><br/>' . $mensagem;
            } else {
                $nome          = $_POST['nome'];
                $email         = $_POST['email'];
                $empresa       = $_POST['empresa'];
                $telefone      = $_POST['telefone'];
                $celular       = $_POST['celular'];
                $tipo_mensagem = $_POST['assunto'];
                $mensagem      = $_POST['mensagem'];
                $enviarPara    = ($contact_form) ? $contact_form : '';
                //
                $assunto       = 'Contato - ' . $tipo_mensagem;
                $message       = 'Nome: ' . $nome;
                $message .= '<br/>E-mail: ' . $email;
                $message .= '<br/>Empresa: ' . $empresa;
                $message .= '<br/>Telefone: ' . $telefone;
                $message .= '<br/>Celular: ' . $celular;
                $message .= '<br/>Assunto: ' . $tipo_mensagem;
                $message .= '<br/><hr/><br/>' . $mensagem;
            }
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


// use PHPMailer\PHPMailer\PHPMailer;
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host      = ($smtp_host) ? $smtp_host : '';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port      = ($smtp_port) ? $smtp_port : '';
;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth   = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username   = ($smtp_user) ? $smtp_user : '';
//Password to use for SMTP authentication
$mail->Password   = ($smtp_password) ? $smtp_password : '';
// $mail->AddBCC('luiz.sd@gmail.com', 'Luiz SD');
// $mail->AddBCC('wesandradealves@gmail.com', 'Wesley Andrade');
//Set who the message is to be sent from
$mail->setFrom(($smtp_user) ? $smtp_user : '', 'NoReply - Precisão Serviços');
//Set an alternative reply-to address
$mail->addReplyTo($email, $nome);
//Set who the message is to be sent to
$mail->addAddress($enviarPara, $assunto);
//Set the subject line
$mail->Subject = $assunto;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
$mail->Subject = $assunto;
$mail->Body    = $message;
$mail->CharSet = 'UTF-8';
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    header("Location: ".$default_url."pagina/sucesso");
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path       = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
    $result     = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);
    return $result;
}
?>