<?php
require 'forum_donne.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    
    $stmt = $pdo->prepare("INSERT INTO participants (email, statut) VALUES (?, 'Email capture') 
                           ON DUPLICATE KEY UPDATE statut = 'Email capture'");
    $stmt->execute([$email]);
    
    // On redirige vers la suite
    header("Location: details.php?user=" . urlencode($email));
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concours O'TACOS - Lycée Gabriel Fauré</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>CONCOURS O'TACOS</h1>
        <h2 style="color:var(--neon-blue); font-size: 1.2rem;">SPÉCIAL LYCÉE GABRIEL FAURÉ</h2>
        
        <p>Tentez de gagner <strong>1 AN DE TACOS GRATUITS</strong> !</p>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Entrez votre Email pour participer" required>
            <button type="submit">JE PARTICIPE !</button>
        </form>
        
        <p class="legal-text">Tirage au sort le 12/04/2026. Partenariat O'Tacos Annecy x BDE.</p>
    </div>
</body>
</html>