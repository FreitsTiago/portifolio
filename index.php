<?php

/**
 * Aqui temos o PHP que é responsavel por enviar os emails.
 */
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Import PHPMailer classes into the global namespace


$msg = '';
//Don't run this unless we're handling a form submission
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');



    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tiago.m.freitas205@gmail.com';
    $mail->Password = 'gmail200415';
    $mail->Port = 587;

    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('tiago.m.freitas205@gmail.com');
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addAddress('tiago.m.freitas204@gmail.com');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Novo email de contato Portifolio';
        //Keep it simple - don't use HTML
        $mail->isHTML(false);
        //Build a simple message body
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$_POST['message']}
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            $msg = 'erro001';
        } else {
            $msg = 'sucesso';
        }
    } else {
        $msg = 'erro002';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176475366-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-176475366-1');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiago Freitas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" type="imagem/ico" href="/content/images/favico.ico" />
    <script src="https://kit.fontawesome.com/f0a4915076.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Scripts dos Dialogs ▼ -->
    <script>
        function cdindispo() {
            $('#erro002').modal('show');
        }

        function msgctt() {
            $('#contato').modal('show');
        }

        function msgenv() {
            var delay = 500;
            setTimeout(function() {
                $('#msgenviada').modal('show');
            }, delay);
        }
        function msgerro() {
            var delay = 500;
            setTimeout(function() {
                $('#erro001').modal('show');
            }, delay);
        }
        $sttmsg = '<?php echo $msg ?>';
        if ($sttmsg == 'sucesso') {
            msgenv();
        }
        if ($sttmsg == 'erro001') {
            msgerro();
        }
        if ($sttmsg == 'erro002') {
            msgerro();
        }
    </script>
</head>

<body>
    <!-- NavBar ▼ -->
    <nav class="navbar navbar-expand-lg navbar-dark corSecundaria">
        <a class="navbar-brand" style="color: #FF3C3C;" href="/">Tiago Freitas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#projetos">Projetos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sobre-min">Sobre min</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#conhecimentos">Conhecimento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#perfil" onclick="msgctt()">Contato</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Perfil ▼ -->
    <section class="jumbotron text-center ftperfil corTerciaria" id="perfil">
        <div class="container">
            <img class="foto-perfil" src="http://tiagofreitas.ga/content/images/minhafoto.jpg" alt="">
            <h1 class="jumbotron-heading">Tiago Freitas</h1>
            <p class="lead ">Programador e Designer Web.</p>
            <p>
                <a onclick="msgctt()" class="btn bt0001 my-2">Contato</a>
            </p>
            <a target="_blank" title="GitHub: FreitsTiago" href="https://github.com/FreitsTiago"><i class="fab fa-github fa-lg icosocial"></i></a>
            <a target="_blank" title="Linkedin: Tiago Freitas" href="https://www.linkedin.com/in/tiago-freitas-a767b5189"><i class="fab fa-linkedin fa-lg icosocial"></i></a>
            <a target="_blank" title="Instagram: Tiago Freitas" href="https://www.instagram.com/draz_of/"><i class="fab fa-instagram fa-lg icosocial"></i></a>
            <a target="_blank" title="GitHub: Tiago Freitas" href="https://t.me/freitstiago"><i class="fab fa-telegram fa-lg icosocial"></i></a><br>
        </div>
    </section>

    <!-- Projetos ▼ -->
    <div class="album py-5 corPrimaria" id="projetos">
        <div class="container">
            <h2 class="jumbotron-heading text-center mb-4 " style="color: #FFFFFF;">Projetos</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 56,25%; width: 100%; display: block;" src="http://tiagofreitas.ga/content/images/seboso.jpg" data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">Esse é um projeto de um blog onde publico coisas sobre um servidor de minecraft.</p>
                            <ul>
                                <li>HTML</li>
                                <li>CSS</li>
                                <li>Javascript</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a target="_blank" href="http://seboso.ga" style="margin-right: 10px;"><button type="button" class="btn btn-sm btn-outline-danger">Ver projeto</button></a>
                                    <a ><button onclick="cdindispo()" type="button" class="btn btn-sm btn-outline-primary">Codigo</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 56,25%; width: 100%; display: block;" src="http://tiagofreitas.ga/content/images/calculadora.jpg" data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">Esse projeto fiz quando estava começando a programar em python. É uma calculadora geometrica bem simples.</p>
                            <ul>
                                <li>Phyton</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a target="_blank" href="http://tiagofreitas.ga/downloads/CalculadorAvan%c3%a7ada.zip" style="margin-right: 10px;"><button type="button" class="btn btn-sm btn-outline-danger">Ver projeto</button></a>
                                    <a target="_blank" href="https://github.com/FreitsTiago/calculadoraavncd"><button type="button" class="btn btn-sm btn-outline-primary">Codigo</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 56,25%; width: 100%; display: block;" src="http://tiagofreitas.ga/content/images/portifolio.jpg" data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">Esse projeto fiz quando estava começando a programar em python. É uma calculadora geometrica bem simples.</p>
                            <ul>
                                <li>HTML</li>
                                <li>CSS</li>
                                <li>JavaScript</li>
                                <li>PHP</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a target="_blank" href="http://tiagofreitas.ga" style="margin-right: 10px;"><button type="button" class="btn btn-sm btn-outline-danger">Ver projeto</button></a>
                                    <a target="_blank" href="https://github.com/FreitsTiago/portifolio"><button type="button" class="btn btn-sm btn-outline-primary">Codigo</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sobre Min ▼ -->
    <section class="espaco20px text-center corTerciaria" id="sobre-min">
        <div class="container">
            <h2 class="textobranco">Sobre min</h2>
            <p class="lead textocinzinha">Me chamo Tiago e trabalho desenvolvendo sites e aplicações web, sou novo no ramo mas busco conhecimento e a cada projeto que faço aprimoro eles. Desde criança eu tinha esse sonho de me tornar um desenvolvedor web e aqui estou eu vivendo meu sonho.</p>
        </div>
    </section>

    <!-- Conhecimento ▼ -->
    <section class="espaco20px text-center corPrimaria" id="conhecimentos">
        <div class="container">
            <h2 class="textobranco">Conhecimento</h2>
            <p class="lead textocinzinha">Abaixo você vê o meu nível de conhecimento em cada área.</p>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">HTML</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraLaranja textopreto" role="progressbar" style="width: 24%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">24%</div>
                </div>
            </div>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">CSS</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraAzul textopreto" role="progressbar" style="width: 49%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">49%</div>
                </div>
            </div>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">Java Script</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraAmarela textopreto" role="progressbar" style="width: 10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">10%</div>
                </div>
            </div>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">Python</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraVerde textopreto" role="progressbar" style="width: 57%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">57%</div>
                </div>
            </div>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">Photoshop</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraAzul textopreto" role="progressbar" style="width: 46%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">46%</div>
                </div>
            </div>
            <div class="barrasprogresso">
                <h4 class="textocinzinha" style="text-align: left;">WordPress</h4>
                <div class="progress barraCinza" style=" margin-bottom: 10px;">
                    <div class="progress-bar barraAzul textopreto" role="progressbar" style="width: 68%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">68%</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer ▼ -->
    <footer class="myfooter text-center corSecundaria">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a class="textocntt">Para entrar em contato <a onclick="msgctt()" class="linkctt">clique aqui!</a></a>
                </div>
                <div class="col-sm-6">
                    <p class="textobranco">© 2020 Copyright Tiago Freitas. Todos os direitos reservados.</p>
                </div>
                <div class="col">
                    <a target="_blank" title="GitHub: FreitsTiago" href="https://github.com/FreitsTiago"><i class="fab fa-github fa-lg icosocial"></i></a>
                    <a target="_blank" title="Linkedin: Tiago Freitas" href="https://www.linkedin.com/in/tiago-freitas-a767b5189"><i class="fab fa-linkedin fa-lg icosocial"></i></a>
                    <a target="_blank" title="Instagram: Tiago Freitas" href="https://www.instagram.com/draz_of/"><i class="fab fa-instagram fa-lg icosocial"></i></a>
                    <a target="_blank" title="GitHub: Tiago Freitas" href="https://t.me/freitstiago"><i class="fab fa-telegram fa-lg icosocial"></i></a><br>
                </div>
            </div>
        </div>
    </footer>

    <!-- Dialogs -->

    <!-- Dialog Contato ▼ -->
    <div class="modal fade" id="contato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content corTerciaria">
                <div class="modal-header">
                    <h5 class="modal-title textobranco" id="exampleModalLabel">Enviar mensagem</h5>
                    <button type="button" class="close btclose" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="name" class="col-form-label textobranco">Nome:</label>
                            <input type="tect" name="name" id="name" class="form-control feiltiago">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label textobranco">Email:</label>
                            <input type="email" name="email" id="email" class="form-control feiltiago">
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-form-label textobranco">Mensagem:</label>
                            <textarea class="form-control feiltiago" name="message" id="message"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                            <input class="btn btn-danger" name="" botao type="submit" value="Enviar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dialog Erro01 ▼ -->
    <div class="modal fade" id="erro001" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content corTerciaria">
                <div class="modal-header">
                    <h5 class="modal-title textobranco" id="exampleModalLabel">Oh não!</h5>
                    <button type="button" class="close btclose" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body textobranco">
                    Algo esta impedindo o envio da sua mensagem. Tente novamente se o problema persistir entre em contato por outra plataforma, e me informe sobre o erro.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dialog Erro02 ▼ -->
    <div class="modal fade" id="erro002" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content corTerciaria">
                <div class="modal-header">
                    <h5 class="modal-title textobranco" id="exampleModalLabel">Oh não!</h5>
                    <button type="button" class="close btclose" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body textobranco">
                    O codigo que você está tentando acessar não está disponível!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dialog MSGEnviada ▼ -->
    <div class="modal fade" id="msgenviada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content corTerciaria">
                <div class="modal-header">
                    <h5 class="modal-title textobranco" id="exampleModalLabel">Sucesso!</h5>
                    <button type="button" class="close btclose" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body textobranco">
                    Sua mensagem foi enviada! Agradeço pela sua mensagem! Entrarei em contato assim que puder!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>