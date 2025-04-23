<?php
/**
 * Form Handler for Mundo das Baterias Contact Form
 * Improved version with better security and validation
 */

// Initialize variables for status messages
$status = '';
$statusClass = '';

// Check if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set recipient email address
    $para = "mundodasbateriasitabira@gmail.com";
    
    // Validate and sanitize form data
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $mensagemTexto = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
    
    // Validate required fields
    $errors = [];
    
    if (empty($nome)) {
        $errors[] = "O campo nome é obrigatório.";
    }
    
    if (empty($email)) {
        $errors[] = "O campo e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Por favor, informe um e-mail válido.";
    }
    
    if (empty($mensagemTexto)) {
        $errors[] = "O campo mensagem é obrigatório.";
    }
    
    // If no errors, proceed with sending email
    if (empty($errors)) {
        // Set email subject
        $assunto = "Mensagem Enviada pelo Site - Mundo das Baterias";
        
        // Build HTML message
        $mensagem = "<html><body>";
        $mensagem .= "<h2>Nova mensagem do site Mundo das Baterias</h2>";
        $mensagem .= "<p><strong>Nome: </strong>" . htmlspecialchars($nome) . "</p>";
        $mensagem .= "<p><strong>Email: </strong>" . htmlspecialchars($email) . "</p>";
        $mensagem .= "<p><strong>Mensagem: </strong><br>" . nl2br(htmlspecialchars($mensagemTexto)) . "</p>";
        $mensagem .= "<p><small>Mensagem enviada em: " . date('d/m/Y H:i:s') . "</small></p>";
        $mensagem .= "</body></html>";
        
        // Email headers
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: Mundo das Baterias <no-reply@mundodasbaterias.com.br>\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        
        // Attempt to send email
        $enviado = mail($para, $assunto, $mensagem, $headers);
        
        if ($enviado) {
            // Redirect with success parameter
            header("Location: contato.html?enviado=1");
            exit;
        } else {
            // Set error message if mail function fails
            $status = "Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente mais tarde.";
            $statusClass = "alert-danger";
        }
    } else {
        // Join error messages
        $status = "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
        $statusClass = "alert-danger";
    }
} else {
    // Redirect to contact page if accessed directly
    header("Location: contato.html");
    exit;
}

// If we reach here, there was an error. Display the contact form with error messages.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contato - Mundo Das Baterias</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Erro ao Enviar Mensagem</h2>
                        
                        <?php if (!empty($status)): ?>
                        <div class="alert <?php echo $statusClass; ?>" role="alert">
                            <?php echo $status; ?>
                        </div>
                        <?php endif; ?>
                        
                        <p class="text-center">Ocorreu um problema ao processar sua solicitação.</p>
                        <div class="text-center mt-4">
                            <a href="contato.html" class="btn btn-primary">Voltar para o formulário de contato</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

