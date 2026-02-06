<?php
$host = 'localhost';
$dbname = 'forum_donne'; // Nom de ta base
$user = 'root';
$pass = ''; // Vide par défaut sur WAMP/XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Cette ligne est CRUCIAL : elle affiche les erreurs s'il y en a
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>