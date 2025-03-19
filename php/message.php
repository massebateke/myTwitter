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
$current_user_username = $_SESSION['id'];



$sql1 = "SELECT user.id, display_name
         FROM user
         WHERE id <> $current_user_username";


$aff_users = $conn->query($sql1);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
</head>
<body>

<div>
<?php
while ($row = $aff_users->fetch_assoc()): ?>
    <div>
        <?php echo "<a href='user_message.php?id=".$row['id']."'>".$row['display_name']."</a>";?>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>