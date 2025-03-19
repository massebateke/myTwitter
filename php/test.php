<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/output.css"> 
    <title>Page de connexion</title>
</head>
<body>
<section class="flex justify-between items-center w-full h-screen bg-[#00378a]">
    <div class=" w-2/2 flex justify-center items-center">
        <form class="bg-white p-5 border-1 rounded-lg" method="POST">
            <button class="bg-[#00378a] text-white py-6 px-8 rounded-lg">
                <p>T<p>
            </button>

            <h1 class="font-bold text-2*1">Connexion</h1>
        
            <p class="text-md">Bienvenue sur twitter, connecter vous.</p>
<br>
            <div class="flex flex-col">
                <label class="text-md mb-1 font-bold">Email ou Username</label>
                <input type="text" name="email" class="border-2 p-3 round-md text-sm" required>
            </div>

            <div class="flex flex-col mt-4">
                <label class="text-md mb-1 font-bold">Mot de passe</label>
                <input type="password" name="password" class="border-2 p-3 round-md text-sm" required>
            </div>

            <button class="w-full bg-[#00378a] text-white mt-7 text-sm rounded-md p-3">
                    <input type="submit" name="connexion" value="Connexion">
                
                </button>


            <div class="border-b-2 my-10">
               <p class="">Ou</p>
            </div> 

            <p>Créer un compte<br><br> <a class="w-full bg-[#00378a] text-white mt-7 text-sm rounded-md p-3" href="index.php">Inscription</a><p>         
        </form>

       </div>
</section>

<?php
include('./config/connect.php');

if(isset($_POST["connexion"])){

    if(!empty($_POST["email"]) && !empty($_POST["password"])){
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
    }
    $requete = "SELECT * FROM user WHERE email = '$email' AND password = '$password' AND is_active = 1 ";//paas sur
    $execution2 = $db->query($requete);
    if($execution2){
        echo "vous etes connecter";
        session_start();
        $users = $execution2->fetch(PDO::FETCH_ASSOC);

        $user = $users[0];
        $_SESSION['test'] = $users;
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['birthdate'] = $user['birthdate'];
        $_SESSION['city'] = $city;
        $_SESSION['country'] = $country;
        $_SESSION['genre'] = $genre;
        $_SESSION['email'] = $email;
        $_SESSION['display_name'] = $display_name;
        $_SESSION['phone'] = $phone;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("Location: menu.php");
        exit();
    }else{
        echo "erreur";
        header("Location: yr.php");
        exit();
    }
}
?>
</body>
</html>