<?php $servername = "localhost";
$username = "massebtk";
$password = "azerty";
$dbname = "twitter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
<?php
$current_user_id = $_SESSION['username'];
$all_iduname = $conn->query("SELECT id, username FROM user WHERE username = '$current_user_id'");

while ($aff_iduname = $all_iduname->fetch_assoc()) {
?>
    <?php
    $id = $aff_id_uname['id'];
    $uname = $aff_id_uname['username'];
}?>