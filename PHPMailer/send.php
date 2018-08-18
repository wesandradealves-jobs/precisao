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

require_once("PHPMailerAutoload.php");

if($_POST['orcamento']){
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $orcamento_tipo = $_POST['orcamento_tipo'];
    $enviarPara = "orcamentos@precisaoservicos.com.br";
    //
    $assunto = 'Cotação - '.$orcamento_tipo;
    $message = $nome;
    $message .= '<br/>'.$email;
    $message .= '<br/>'.$telefone;
    $message .= '<br/>'.$orcamento_tipo;
} else if($_POST['trabalhe-conosco']){
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $nascimento = $_POST['nascimento'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $trabalhando = $_POST['trabalhando'];
    $horario = $_POST['horario'];
    $disponibilidade = $_REQUEST['disponibilidade'];
    $mensagem = $_POST['mensagem'];
    $enviarPara = "curriculos@precisaoservicos.com.br";
    //
    $assunto = 'Trabalhe Conosco';
    $message = $nome;
    $message .= '<br/>'.$email;
    $message .= '<br/>'.$rg;
    $message .= '<br/>'.$cpf;
    $message .= '<br/>'.$nascimento;
    $message .= '<br/>'.$sexo;
    $message .= '<br/>'.$email;
    $message .= '<br/>'.$telefone;
    $message .= '<br/>'.$celular;
    $message .= '<br/>'.$cep;
    $message .= '<br/>'.$cidade;
    $message .= '<br/>'.$uf;
    $message .= '<br/>'.$bairro;
    $message .= '<br/>'.$rua;
    $message .= '<br/>'.$numero;
    $message .= '<br/>'.$trabalhando;
    $message .= '<br/>'.$horario;
    $message .= '<br/>'.$disponibilidade;
    $message .= '<br/>'.$mensagem;
} else {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $empresa = $_POST['empresa'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $tipo_mensagem = $_POST['tipo_mensagem'];
    $mensagem = $_POST['mensagem'];
    $enviarPara = "contatos@precisaoservicos.com.br";
    //
    $assunto = 'Contato - '.$tipo_mensagem;
    $message = $nome;
    $message .= '<br/>'.$email;
    $message .= '<br/>'.$empresa;
    $message .= '<br/>'.$telefone;
    $message .= '<br/>'.$celular;
    $message .= '<br/>'.$tipo_mensagem;
    $message .= '<br/>'.$mensagem;
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
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "wesandradealves@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "Wes@03122530";
$mail->AddBCC('luiz.sd@gmail.com', 'Luiz SD');
//Set who the message is to be sent from
$mail->setFrom('no-reply@precisaoservicos.com.br', 'NoReply - Precisão Serviços');
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
    header("Location: http://precisaoservicos.com.br/");
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
    $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);
    return $result;
}
?>