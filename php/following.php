<?php
session_start();
include('../config/connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $user_id = intval($_GET['id']); 
} else {
  die("ID utilisateur invalide.");
}

$sql = "SELECT user.firstname, user.lastname, user.username FROM user JOIN follow ON user.id = follow.id_user_follow WHERE id_user_followed = ?";
$requete = $db->prepare($sql);
$requete->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Following</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-96 border border-blue-300">
        <h4 class="text-xl font-semibold mb-4 text-blue-600">Following :</h4>
        <ul class="space-y-2">
            <?php while ($a = $requete->fetch()) { ?>
                <li class="p-2 bg-blue-200 rounded-md text-blue-800 font-medium">
                    <?php echo htmlspecialchars($a["username"]); ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html> page following