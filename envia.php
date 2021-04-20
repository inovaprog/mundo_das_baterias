<?php
  //1 – Definimos Para quem vai ser enviado o email
  $para = "mundodasbateriasitabira@gmail.com";
  //2 - resgatar o nome digitado no formulário e  grava na variavel $nome
  $nome = $_POST['nome'];
  // 3 - resgatar o assunto digitado no formulário e  grava na variavel //$email
  $assunto = $_POST['email'];
   //4 – Agora definimos a  mensagem que vai ser enviado no e-mail
  $mensagem = "<strong>Nome:  </strong>".$nome;
  $mensagem .= "<br>  <strong>Email: </strong>".$_POST['email'];
  $mensagem .= "<br>  <strong>Mensagem: </strong>".$_POST['mensagem'];

  $assunto = "Mensagem Enviada pelo Site";
 
//5 – agora inserimos as codificações corretas e  tudo mais.
  $headers =  "Content-Type:text/html; charset=UTF-8\n";
  $headers .= "From:  dominio.com.br<contato@bateriasitabira.com.br>\n"; //Vai ser //mostrado que  o email partiu deste email e seguido do nome
  $headers .= "X-Sender:  <contato@bateriasitabira.com.br>\n"; //email do servidor //que enviou
  $headers .= "X-Mailer: PHP  v".phpversion()."\n";
  $headers .= "X-IP:  ".$_SERVER['REMOTE_ADDR']."\n";
  $headers .= "Return-Path:  <contato@bateriasitabira.com.br>\n"; //caso a msg //seja respondida vai para  este email.
  $headers .= "MIME-Version: 1.0\n";
 
mail($para, $assunto, $mensagem, $headers);  //função que faz o envio do email.
   header("location:contato.html");
  ?>

