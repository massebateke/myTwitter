<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css"> 
    <title>Page d'inscription</title>
</head>
<body>
<section class="flex justify-between items-center w-full h-full bg-[#00378a]">
    <div class=" w-2/2 flex justify-center items-center">
        <form class="bg-white p-5 border-1 rounded-lg" method="POST" action="index.php">
            <button class="bg-[#00378a] text-white py-6 px-8 rounded-lg">
                <p>T<p>
            </button>

                <h1 class="font-bold text-2*1">Connexion</h1>
        
                <p class="text-md">Bienvenue sur twitter, Inscriver-vous.</p>
<br>


                <div class="flex flex-col">
                    <label class="text-md mb-1 font-bold">Nom</label>
                    <input type="text" name="lastname" class="border-2 p-3 round-md text-sm">
                </div>

                <div class="flex flex-col mt-4">
                    <label class="text-md mb-1 font-bold">Prenom</label>
                    <input type="text" name="firstname" class="border-2 p-3 round-md text-sm">
                </div>


                <div class="flex flex-col">
                    <label class="text-md mb-1 font-bold">Date de naissance</label>
                    <input type="date" name="birthdate" class="border-2 p-3 round-md text-sm">
                </div>
                <br>

                <label for="genre_label">Genre</label><br>
            
                   <select name="genre" id="genre">
                    <option value="homme" class="">Homme</option>
                    <option value="femme" class="">Femme</option>
                    <option value="autre" class="">Autre</option>
                   </select>
        
                <div class="border-b-2 my-10"></div>


                <div class="flex flex-col mt-2">
                    <label class="text-md mb-1 font-bold">Email</label>
                    <input type="email" name="email" class="border-2 p-3 round-md text-sm">
                </div>

                <div class="flex flex-col mt-4">
                    <label class="text-md mb-1 font-bold">Mot de passe</label>
                    <input type="password" name="password" class="border-2 p-3 round-md text-sm">
                </div>

                <div class="flex flex-col mt-4">
                        <label class="text-md mb-1 font-bold">Username</label>
                        <input type="text" name="username" class="border-2 p-3 round-md text-sm">
                </div>
                <div class="flex flex-col mt-4">
                        <label class="text-md mb-1 font-bold">Display_name</label>
                        <input type="text" name="display_name" class="border-2 p-3 round-md text-sm">
                </div>

                <button class="w-full bg-[#00378a] text-white mt-7 text-sm rounded-md p-3">
                    <input type="text" hidden name="inscription" value="S'inscrire">
                    <input type="submit" value="S'inscrire">
            
                </button>
            
                <p>vous avez deja un comptes ?<br><br> <a class="w-full bg-[#00378a] text-white mt-7 text-sm rounded-md p-3" href="Login.php">connectez-vous</a><p>
    
        </form>
    </div>
</section>
<?php include('../config/connect.php');
if(isset($_POST["inscription"])){

if(!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["birthdate"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["genre"]) && !empty($_POST["display_name"])){
    $lastname= htmlspecialchars($_POST["lastname"]);
    $firstname= htmlspecialchars($_POST["firstname"]);
    $birthdate=htmlspecialchars($_POST["birthdate"]);
    $email= htmlspecialchars($_POST["email"]);
    $username= htmlspecialchars($_POST["username"]);
    $genre=htmlspecialchars($_POST["genre"]);
    $display_name=htmlspecialchars($_POST["display_name"]);
}
else {
  echo "Tout les champs doivent etre complétés";
}

$password = hash("ripemd160", $_POST["password"]);

$sql="INSERT INTO user(firstname,lastname,birthdate,email,password,username,genre,display_name)
      values (:firstname,:lastname,:birthdate,:email,:password,:username,:genre,:display_name)";

    $execution = $db->prepare($sql);

    $execution->bindParam(':firstname', $firstname);
    $execution->bindParam(':lastname', $lastname);
    $execution->bindParam(':birthdate', $birthdate);
    $execution->bindParam(':email', $email);
    $execution->bindParam(':password', $password);
    $execution->bindParam(':username', $username);
    $execution->bindParam(':genre', $genre);
    $execution->bindParam(':display_name', $display_name);


    if($execution->execute()){
    session_start();
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['genre'] = $genre;
    $_SESSION['email'] = $email;
    $_SESSION['display_name'] = $display_name;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    header("Location: menu.php");
    exit();
    } 

   
}

?>
</body>
</html>
        
