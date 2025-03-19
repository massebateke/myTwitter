<?php

$servername = "localhost";
$username = "massebtk";
$password = "azerty";
$dbname = "twitter";

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
    echo "<h1>" . htmlspecialchars($row['username']) . "</h1";
}

$current_user_id = "" . $row['username'] . "";



$sql1 = "SELECT user.username, COUNT(follow.id_user_follow) as followers 
         FROM user 
         JOIN follow ON user.id = follow.id_user_follow 
         WHERE user.username LIKE '$current_user_id' 
         GROUP BY user.username";

$sql2 = "SELECT user.username, COUNT(follow.id_user_followed) as following 
         FROM user 
         JOIN follow ON user.id = follow.id_user_followed 
         WHERE user.username LIKE '$current_user_id' 
         GROUP BY user.username";


$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);


$sql3 = "SELECT tweet.content, tweet.creation_date, user.username AS author 
         FROM tweet 
         JOIN user ON tweet.id_user = user.id 
         WHERE user.username = '$current_user_id'
         ORDER BY tweet.creation_date DESC";

$sql4 = "SELECT tweet.content AS tweet_content, author.username AS original_author, retweeter.username AS retweeter, retweet.creation_date AS retweet_date 
         FROM retweet  
         JOIN tweet ON retweet.id_tweet = tweet.id  
         JOIN user AS retweeter ON retweet.id_user = retweeter.id  
         JOIN user AS author ON tweet.id_user = author.id
         WHERE retweeter.username = '$current_user_id'
         ORDER BY retweet.creation_date DESC";


$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);

$sql5 = "SELECT biography 
         FROM user 
         WHERE username = '$current_user_id'";

$result5 = $conn->query($sql5);

$sql6 = "SELECT username 
         FROM user
         WHERE username = '$current_user_id'";

$result6 = $conn->query($sql6);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Profil de <?php echo htmlspecialchars($row['username']) ?></title>
</head>

<body>

<!--Affichage des Followers et Following-->
    <div>
        <?php while ($row = $result1->fetch_assoc()):
            echo $row['followers'] . "<h6> Followers" . "</h6>";
        endwhile; ?>

        <?php while ($row = $result2->fetch_assoc()): ?>
            <div>
                <?php echo $row['following'] . "<h6> Following" . "</h6>"; ?>
            </div>
        <?php endwhile; ?>
    </div>

<!--Affichage de la Biographie-->
    <div class="Bio">
        <?php
        if ($result5->num_rows > 0) {
            $row = $result5->fetch_assoc();
            echo "<h5>" . htmlspecialchars($row['biography']) . "</h5>";
        } else echo "";
        ?>
    </div>


    <div>
        <?php 
        echo "<h4><a href='user_message.php?id=" . substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '=') + 1) . "'>Envoyer un Message</a></h4>";
        ?>
    </div>



    <div>
        <form>
        <?php
        if ($userid != $followerid) {
            if ($isFollowing) {
               echo '<input type="submit" name="unfollow" value="unfollow">';              
            } else {
                echo '<input type="submit" name="follow" value="Follow">';
            }
        }
        ?>
        </form>
    </div>


<!--Affichage des Tweets-->
    </div>
    <div class="Tweets">
        <h3>Tweets</h3>
        <?php
        if ($result3->num_rows > 0) {
            while ($row = $result3->fetch_assoc()) {
                echo "<h4>" . htmlspecialchars($row['author']) . " :</h4>";
                echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                echo "<p>" . $row['creation_date'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Cet Utilisateur n'a pas posté de tweet.</p>";
        }
        ?>
    </div>

<!--Affichage des Retweets-->
    <div class="Retweets">
        <h3>Retweets</h3>
        <?php
        if ($result4->num_rows > 0) {
            while ($row = $result4->fetch_assoc()) {
                echo "<h4>" . htmlspecialchars($row['retweeter']) . " a retweeté :</h4>";
                echo "<h5>" . htmlspecialchars($row['original_author']) . "</h5>" . "<p>" . htmlspecialchars($row['tweet_content']) . "</p>";
                echo "<p>" . $row['retweet_date'] . "</p>";
            }
        } else {
            echo "<p>Aucun retweet.</p>";
        }
        $conn->close(); ?>
    </div>
</body>

</html>