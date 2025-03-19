<?php
$servername = "localhost";
$username = "massebtk";
$password = "azerty";
$dbname = "twitter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
session_start();

// Récupérer l'utilisateur actuel 
$current_user_id = $_SESSION['id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // récupére les données du formulaire
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $biography = $_POST["biography"];
    $city = $_POST["city"];
    $country = $_POST["country"];

    // pour mettre à jour les informations de l'utilisateur dans la bdd
    $sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', biography='$biography', city='$city', country='$country' WHERE id=$current_user_id";

    if ($conn->query($sql) === TRUE) {
        echo "Votre profil a bien été mis à jour !";
    } else {
        echo "Erreur de mise à jour : " . $conn->error;
    }
}

// récupére les informations de l'utilisateur actuel
$sql = "SELECT * FROM user WHERE id=$current_user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Utilisateur non trouvé.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Éditer le Profil</title>
    <link rel="stylesheet" href="outputs.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full h-full bg-[#00378a]">
    <div class=" w-2/2 flex justify-center items-center">
    <div class="bg-white p-5 border-1 rounded-lg">
    <div class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white ">
<a href="menu.php">back Menu</a>
    </div>
    <div class="rounded-md bg-[#00378a] mt-8 px-3 py-2 text-sm font-medium text-white">
    <h2>Éditer le Profil</h2>
    </div>

    <?php 
        $pdp = $conn->query("SELECT picture FROM user WHERE id = $current_user_id");
        while ($aff_pdp = $pdp->fetch_assoc()){
        ?>
        <img src="<?= $aff_pdp['picture'] ?>">

<?php }
$conn->close();?>

        <img src="<?= $aff_pdp['picture'] ?>">
    <form action="edit-profile.php" method="POST">
    <div class = "flex flex-col mt-4">
        <label for="firstname">Prénom:</label>
        <input class = "border-2 p-3 round-md text-sm" type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" required><br>
        <label for="lastname">Nom:</label>
        <input class = "border-2 p-3 round-md text-sm" type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" required><br>
        <label for="username">Nom d'utilisateur:</label>
        <input class = "border-2 p-3 round-md text-sm" type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>
        <label for="email">Email:</label>
        <input class = "border-2 p-3 round-md text-sm" type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <label for="biography">Biographie:</label>
        <textarea class = "border-2 p-3 round-md text-sm" id="biography" name="biography"><?php echo $user['biography']; ?></textarea><br>
        <label for="city">Ville:</label>
        <input class = "border-2 p-3 round-md text-sm" type="text" id="city" name="city" value="<?php echo $user['city']; ?>"><br>
        <label for="country">Pays:</label>
        <input class = "border-2 p-3 round-md text-sm" type="text" id="country" name="country" value="<?php echo $user['country']; ?>"><br>
        <div class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
        <input type="submit" value="Mettre à jour">
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
