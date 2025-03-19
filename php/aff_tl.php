  <!-- Affichage de la TL-->
  <script src="https://cdn.tailwindcss.com"></script>
  <div id="TL" class="border border-black rounded-lg">
    <?php
    include('../config/connectmysqli.php');
    $recup_tweet = $conn->query("SELECT user.picture, user.id, tweet.content, tweet.creation_date, user.display_name, tweet.media1, tweet.media2, tweet.media3, tweet.media4
                   FROM tweet
                   JOIN user ON tweet.id_user = user.id
                   ORDER BY tweet.creation_date DESC");
    while($aff_tweet = $recup_tweet->fetch_assoc()){
    ?>
    <div>
      <img class=" w-1/12 rounded-full " src="<?= $aff_tweet['picture'] ?>">
      <?= "<h4><a href='page_user.php?id=".$aff_tweet['id']."'>@".$aff_tweet['display_name']."</a></h4>"; ?> 
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