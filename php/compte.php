<?php
include('../config/connectmysqli.php');
session_start();

$sess_uname = $_SESSION['username'];

$compte = $conn->query("SELECT * FROM user WHERE username = '$sess_uname'");
while($aff_compte = $compte->fetch_assoc()){
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="outputs.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Mes infos</title>
</head>
<body>    

    <div class="bg-[#00378a] h-screen flex justify-center items-center">
    <div class="bg-white p-5 border rounded-lg shadow-lg">
        <p>Prenom:  <?php echo $_SESSION['firstname']; ?></p>
        <p>Nom:  <?php echo $_SESSION['lastname']; ?></p>
        <p>Date de naissance:  <?php echo $_SESSION['birthdate']; ?></p>
        <p>Ville:  <?php echo $_SESSION['city']; ?></p>
        <p>Pays:  <?php echo $_SESSION['country']; ?></p>
        <p>Genre:  <?php echo $_SESSION['genre']; ?></p>
        <p>Email:  <?php echo $_SESSION['email']; ?></p>
        <p>Mot de passe:  <?php echo $_SESSION['password']; ?></p>
        <p>Phone:  <?php echo $_SESSION['phone']; ?></p>
        <p>Username:  <?php echo $_SESSION['username']; ?></p>
        <p>Display name:  <?php echo $_SESSION['display_name']; ?></p><br>

    <div class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
        <a href="edit-profile.php">Modifier profil</a><br>
    </div>
    <br>
    <div class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
        <a href="menu.php">retour au menu</a>
    </div>
    
<?php }?>
</body>
</html>