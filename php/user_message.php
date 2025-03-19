<?php
$servername = "localhost";
$username = "massebtk";
$password = "azerty";
$dbname = "twitter";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql_user = "SELECT id, username 
             FROM user 
             WHERE user.id =  " . substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '=') + 1) . "";

$username = $conn->query($sql_user);


if ($username->num_rows > 0) {
    $row = $username->fetch_assoc();
    echo "<h1>".htmlspecialchars($row['username'])."</h1";
}


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $sessid = $_SESSION['id']; 
    if (isset($_POST['send'])) {
        $message = htmlspecialchars($_POST['message']);
        $inser_message = $conn->query("INSERT INTO message (content, id_receiver, id_sender) VALUES ('$message', $getid, $sessid)");
    }
} else {
    echo "Aucun utilisateur trouvé";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="outputs.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title> Message avec <?php echo $row['username']; ?> </title>
</head>

<body class="bg-blue h-screen flex flex-col items-center p-5">

<div class="bg-white shadow-md w-full max-w-3xl p-4 rounded-lg">
        <form method="POST" action="" class="flex flex-col gap-4">
            <textarea name="message" class="border border-gray-300 rounded-lg p-3 resize-none focus:outline-none focus:ring-2 w-full"></textarea>
            <input type="submit" name="send" class="bg-[#00378a] text-white py-2 px-4 rounded">
        </form>
        <div class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
        <a href="menu.php">retour au menu</a>
    </div>

    </div>

        <?php
        $recupe_msg = $conn->query("SELECT content, media, date  FROM message WHERE message.id_sender = $sessid AND message.id_receiver = $getid OR message.id_sender = $getid AND message.id_receiver = $sessid ORDER BY message.date DESC");
        while ($message = $recupe_msg->fetch_assoc()){
            if($message['id_receiver'] = $sessid){
        ?>
        <p id="me"> <?php echo $message['content'];?> </p>
        <p id="me"> <?php echo $message['media'];?> </p>
        <p id="me"> <?php echo $message['date'];?> </p>
        <?php
            }elseif($message['id_receiver'] = $getid){
        ?>
        <p id="you"><?php echo $message['content'];?></p>
        <p id="you"><?php echo $message['media'];?></p>
        <p id="you"><?php echo $message['date'];?></p>
        <?php
        }
        }
        ?>


</body>
</html>