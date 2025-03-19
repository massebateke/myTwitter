<?php
session_start()
?>
<?php
include('../config/connect.php');

if (isset($_GET['q']) and !empty($_GET['q'])) {

  $query = htmlspecialchars_decode($_GET['q']);
  $sql = "SELECT user.username, hashtag.name FROM user JOIN hashtag ON user.id = hashtag.id WHERE user.username OR hashtag.name LIKE '%$query%'";
  $requete = $db->query($sql);
}
?>

<?php
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="output.css">-->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <title>Menu</title>
</head>

<body class="text-gray-800 dark:text-gray-200">
  <!-- Conteneur principal -->
  <div class="flex flex-col lg:flex-row h-screen">
    <!-- Menu latéral -->
    <aside class="w-full lg:w-1/5  text-white p-6 flex flex-col items-center shadow-lg">
      <h1 class="text-2xl font-bold mb-10">Twitter</h1>
      <nav class="space-y-4 w-full">
        <a href="perso.php" class="block bg-[#00378a] py-3 px-4 rounded-lg text-center hover:bg-blue-600 transition">
          Mon compte
        </a>
        <a href="../php/notifications.php" class="block bg-[#00378a] py-3 px-4 rounded-lg text-center hover:bg-blue-600 transition">
          Notifications
        </a>
        <a href="deconnexion.php" class="block bg-[#00378a] py-3 px-4 rounded-lg text-center hover:bg-red-600 transition">
          Déconnexion
        </a>
      </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8 space-y-10">
      <!-- Section : Créer un post -->
      <section class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Créer un post</h2>
        <form method="POST" action="" class="space-y-4">
          <textarea name="tweet" placeholder="Exprimez-vous..." class="w-full h-32 p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
          <input type="file" name="media" accept="image/*,video/*" class="block text-gray-700">
          <button type="submit" name="send2" class="bg-[#00378a] text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
            Publier
          </button>
        </form>
      </section>

      <!-- Section : Liste des tweets -->
      <section id="aff_tweet" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Derniers Tweets</h2>
        <!-- Les tweets seront chargés dynamiquement ici -->
         
        <?php
            include('../config/connectmysqli.php');
            if (isset($_POST['send2'])) {
              if (!empty($_POST['tweet']) && !empty($_POST['media'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $media1 = htmlspecialchars("http://localhost:8000/uploads/" . $_POST['media'] . "");
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content, media1)  VALUES ($id_user, '$tweet', '$media1')");
              } elseif (!empty($_POST['media']) && empty($_POST['tweet'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $media1 = htmlspecialchars("http://localhost:8000/uploads/" . $_POST['media'] . "");
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content, media1)  VALUES ($id_user, '$tweet', '$media1')");
              } elseif (!empty($_POST['tweet']) && empty($_POST['media'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $media1 = htmlspecialchars("http://localhost:8000/uploads/" . $_POST['media'] . "");
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content)  VALUES ($id_user, '$tweet')");
              }
            } else echo "";
            ?>
      </section>
    </main>

    <!-- Barre de recherche -->
    <aside class="w-full lg:w-1/5 bg-gray-100 dark:bg-gray-800 p-6 shadow-lg">
      <h2 class="text-2xl font-semibold mb-6">Recherche</h2>
      <form method="GET" action="" class="space-y-4">
        <input type="search" name="s" placeholder="Rechercher un utilisateur" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        <button type="submit" name="send" class="bg-[#00378a] text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
          Rechercher
        </button>
      </form>

      <!-- Résultats de recherche -->
      <div class="mt-6">
        <h3 class="text-lg font-semibold">Utilisateurs trouvés :</h3>
        <div class="mt-4 space-y-3">
          <?php
           include('../config/connectmysqli.php');
           $all = $conn->query("SELECT * FROM user ORDER BY username ASC");
           if (isset($_GET['s']) and !empty($_GET['s'])) {
             $search = htmlspecialchars($_GET['s']);
             $all = $conn->query("SELECT username, display_name, id FROM user WHERE username LIKE '%" . $search . "%' OR username LIKE '%" . $search . "%'");
           }
           ?>
           <h1>Users : </h1>
           <?php
           if ($all->num_rows > 0) {
             while ($affi_uname = $all->fetch_assoc()) {
           ?>
               <?= "<h2><a href='page_user.php?id=" . $affi_uname['id'] . "'>" . $affi_uname['username'] . "</a></h2>"; ?>
               <?= "<h2><a href='page_user.php?id=" . $affi_uname['id'] . "'>" . $affi_uname['display_name'] . "</a></h2>"; ?>
             <?php
             }
           } else {
             ?>
             <p>Aucun utilisateur trouvé</p>
           <?php
           }
           ?>
        </div>
      </div>
    </aside>
  </div>

  <script>
    function MyFunctionFav() {
      const svgElementfav = document.getElementById("svgElementfav");
      if (svgElementfav.getAttribute("fill") === "#e3e3e3") {
        svgElementfav.setAttribute("fill", "#FF0000");
      } else {
        svgElementfav.setAttribute("fill", "#e3e3e3");
      }
    }

    function MyFunctionRepost() {
      const svgElementrepost = document.getElementById("svgElementrepost");
      if (svgElementrepost.getAttribute("fill") === "#e3e3e3") {
        svgElementrepost.setAttribute("fill", "#008000");
      } else {
        svgElementrepost.setAttribute("fill", "#e3e3e3");
      }
    }
    
    setInterval('load_tweet()', 500);
    function load_tweet(){
      $('#aff_tweet').load('aff_tl.php');
    }

  </script>
</body>

</html>









































































<!--
      <!-- Affichage et Création des tweets
      <!--<div id="tl_crea" class=" h-fit w-3/5 ">
        <div id="TL" class="h-2/3 flex flex-col items-center">
          <!-- Création de Tweets
          <div class="w-full h-1/5 h-1/3 flex flex-col items-center mb-10">
            <?php
            include('../config/connectmysqli.php');
            if (isset($_POST['send2'])) {
              if (!empty($_POST['tweet']) && !empty($_POST['media'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $media1 = htmlspecialchars("http://localhost:8000/uploads/" . $_POST['media'] . "");
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content, media1)  VALUES ($id_user, '$tweet', '$media1')");
              } elseif (!empty($_POST['media']) && empty($_POST['tweet'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $media1 = htmlspecialchars("http://localhost:8000/uploads/" . $_POST['media'] . "");
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content, media1)  VALUES ($id_user, '$tweet', '$media1')");
              } elseif (!empty($_POST['tweet']) && empty($_POST['media'])) {
                $id_user = $_SESSION['id'];
                $tweet = nl2br(htmlspecialchars($_POST['tweet']));
                $inser_tweet = $conn->query("INSERT INTO tweet (id_user, content)  VALUES ($id_user, '$tweet')");
              }
            } else echo "";
            ?>
            <form method="POST" action="">
              <div class="flex justify-center">
                <textarea name="tweet" placeholder="Créer un post" id="txt_area" class="w-1/2 mt-10 border border-black rounded-lg"></textarea>
              </div>
              <input type="file" name="media" accept="image/*,video/*" multiple="4">
              <input type="submit" name="send2">
            </form>
          </div>

          <div id="aff_tweet">

          </div>

        </div>
      </div>
      <!--Barre de recherche
      <div id="Recherche" class="h-96 w-1/5 overflow-x-auto flex items-center justify-evenly flex-col mt-10">
        <form method="GET" action="">
          <input type="search" name="s" placeholder="Chercher" class="border-solid border border-white rounded-md">
          <input type="submit" name="send">
        </form>
        <!--Chercher et afficher les usernames
        <?php
        include('../config/connectmysqli.php');
        $all = $conn->query("SELECT * FROM user ORDER BY username ASC");
        if (isset($_GET['s']) and !empty($_GET['s'])) {
          $search = htmlspecialchars($_GET['s']);
          $all = $conn->query("SELECT username, display_name, id FROM user WHERE username LIKE '%" . $search . "%' OR username LIKE '%" . $search . "%'");
        }
        ?>
        <h1>Users : </h1>
        <?php
        if ($all->num_rows > 0) {
          while ($affi_uname = $all->fetch_assoc()) {
        ?>
            <?= "<h2><a href='page_user.php?id=" . $affi_uname['id'] . "'>" . $affi_uname['username'] . "</a></h2>"; ?>
            <?= "<h2><a href='page_user.php?id=" . $affi_uname['id'] . "'>" . $affi_uname['display_name'] . "</a></h2>"; ?>
          <?php
          }
        } else {
          ?>
          <p>Aucun utilisateur trouvé</p>
        <?php
        }
        ?>
      </div>
    </div>
  </div>-->




  <script>
    setInterval('load_tweet()', 500);
    function load_tweet(){
      $('#aff_tweet').load('aff_tl.php');
    }

  </script>
</body>

</html>