<?php
include('../config/connectmysqli.php');
session_start();
$current_user_id = $_SESSION['username'];
$all_iduname = $conn->query("SELECT id, username FROM user WHERE username = '$current_user_id'");

while ($aff_iduname = $all_iduname->fetch_assoc()) {
?>
    <?php
    $useid = $aff_iduname['id'];
    $useuname = $aff_id_uname['username'];
    ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Mon Profil</title>
    </head>

    <body class="bg-[#00378a]">
        <div class="container mx-auto mt-10">
            <!-- Bouton Infos -->
            <div class="mb-5 text-right">
                <a href="compte.php" class="px-4 py-2 bg-gray-900 text-white rounded shadow">Mes Infos</a>
            </div>

            <!-- Affichage Username -->
            <div class="bg-white shadow rounded p-6 mb-5">
                <h1 class="text-3xl font-bold text-gray-800">
                    <?php echo "$current_user_id"; ?>
                </h1>
            </div>

            <!-- Followers et Following -->
            <div class="bg-white shadow rounded p-6 mb-5 flex justify-between items-center">
                <div class="text-center">
                    <a href="follow.php?id=<?php echo "" . $useid . "" ?>">
                        <p class="text-2xl font-bold text-gray-700">
                            <?php
                            $sqlcountfollow = $conn->query("SELECT COUNT(id_user_follow) AS follow FROM follow JOIN user where user.username = '$current_user_id' GROUP BY user.username");
                            while ($affcountfollow = $sqlcountfollow->fetch_assoc()) {
                                echo "" . $affcountfollow['follow'] . "";
                            }
                            ?>
                        </p>
                    </a>
                    <p class="text-gray-500">Followers</p>
                </div>

                <div class="text-center">
                <a href="following.php?id=<?php echo "".$useid."" ?>">
                        <?php
                        $sqlcountfollow = $conn->query("SELECT COUNT(id_user_followed) AS following FROM follow JOIN user where user.username = '$current_user_id' GROUP BY user.username");
                        while ($affcountfollow = $sqlcountfollow->fetch_assoc()) {
                            echo "" . $affcountfollow['following'] . "";
                        }
                        ?>
                        </p></a>
                    <p class="text-gray-500">Following</p>
                </div>
            </div>

            <!-- Biographie -->
            <div class="bg-white shadow rounded p-6 mb-5">
                <h2 class="text-xl font-bold text-gray-800">Biographie</h2>
                <p class="text-gray-700 mt-2">
                    <?php
                    $sqlcountfollow = $conn->query("SELECT biography FROM user where user.username = '$current_user_id'");
                    while ($affcountfollow = $sqlcountfollow->fetch_assoc()) {
                        echo "" . $affcountfollow['biography'] . "";
                    }
                    ?>
                </p>
            </div>
            <!-- Tweets -->
            <div class="bg-white shadow rounded p-6 mb-5">
                <h2 class="text-xl font-bold text-gray-800">Tweets</h2>
                <div id="aff_tweet_perso">
                    <!-- Affichage de la TL perso-->
                    <script src="https://cdn.tailwindcss.com"></script>
                    <div id="TL" class="border border-black rounded-lg">
                        <?php
                        $current_user_id = $_SESSION['username'];
                        include('../config/connectmysqli.php');
                        $recup_tweet = $conn->query("SELECT user.username, user.picture, user.id, tweet.content, tweet.creation_date, user.display_name, tweet.media1, tweet.media2, tweet.media3, tweet.media4
                   FROM tweet
                   JOIN user ON tweet.id_user = user.id
                   WHERE user.username = '$current_user_id'
                   ORDER BY tweet.creation_date DESC");

                        while ($aff_tweet = $recup_tweet->fetch_assoc()) {
                        ?>
                            <div>
                                <img class=" w-1/12 rounded-full " src="<?= $aff_tweet['picture'] ?>">
                                <?= "<h4><a href='page_user.php?id=" . $aff_tweet['id'] . "'>@" . $aff_tweet['display_name'] . "</a></h4>"; ?>
                                <div class="flex flex-col items-center">
                                    <p class="flex"><?= $aff_tweet['content'] ?></p>
                                    <img class="max-w-96" src="<?= $aff_tweet['media1'] ?>">
                                    <img class="max-w-96" src="<?= $aff_tweet['media2'] ?>">
                                    <img class="max-w-96" src="<?= $aff_tweet['media3'] ?>">
                                    <img class="max-w-96" src="<?= $aff_tweet['media4'] ?>">
                                </div>
                                <h6><?= $aff_tweet['creation_date'] ?></h6>
                                <br><br><br>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>



            <!-- Retweets -->
            <div class="bg-white shadow rounded p-6 mb-5">
                <h2 class="text-xl font-bold text-gray-800">Retweets</h2>
                <?php
                include('../config/connectmysqli.php');
                $recup_rtweet = $conn->query("SELECT tweet.content AS tweet_content, retweeter.username AS retweeter, retweet.creation_date AS retweet_date, tweet.media1, tweet.media2, tweet.media3, tweet.media4
                   FROM retweet
                   JOIN tweet ON retweet.id_user = tweet.id
                   JOIN user AS retweeter ON retweet.id_user = retweeter.id  
                   JOIN user AS author ON tweet.id_user = author.id
                   WHERE retweeter.username = '$current_user_id'
                   ORDER BY tweet.creation_date DESC");

                while ($aff_rtweet = $recup_rtweet->fetch_assoc()) {
                ?>
                    <div>
                        <img class=" w-1/12 rounded-full " src="<?= $aff_rtweet['picture'] ?>">
                        <?= "<h4><a href='page_user.php?id=" . $aff_rtweet['id'] . "'>@" . $aff_rtweet['display_name'] . "</a></h4>"; ?>
                        <div class="flex flex-col items-center">
                            <p class="flex"><?= $aff_rtweet['tweet_content'] ?></p>
                            <img class="max-w-96" src="<?= $aff_rtweet['media1'] ?>">
                            <img class="max-w-96" src="<?= $aff_rtweet['media2'] ?>">
                            <img class="max-w-96" src="<?= $aff_rtweet['media3'] ?>">
                            <img class="max-w-96" src="<?= $aff_rtweet['media4'] ?>">
                        </div>
                        <h6><?= $aff_rtweet['retweet_date'] ?></h6>
                        <br><br><br>
                    </div>
            </div>
        <?php } ?>



        <!-- Création de Tweets -->
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold text-gray-800">Créer un Tweet</h2>
            <form action="perso.php" method="POST" enctype="multipart/form-data" class="mt-4">
                <textarea name="tweet" rows="3" placeholder="Tweet ?" class="w-full p-3 border rounded mb-4"></textarea>
                <input type="file" name="upload" class="mb-4">
                <button type="submit" class="px-4 py-2 bg-[#00378a] text-white rounded shadow hover:bg-[#00378a]">Poster</button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="menu.php" class="px-4 py-2 bg-gray-900 text-white rounded shadow hover:bg-gray-700">Retour au menu</a>
        </div>
        </div>
    </body>

    </html>
<?php } ?>