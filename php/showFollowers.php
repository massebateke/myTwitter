<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Followers</title>
</head>
<body>
    <?php include 'config/connect.php';?>

    <label for="titre">Followers et Following</label>
        <form method="get">
            <input type="search" name="MonCompte" placeholder="recherche compte...">
            <input type="submit" value="valide">
        </form>

    <?php if(isset($_GET['MonCompte']) and !empty($_GET['MonCompte'])){
        $query = htmlspecialchars_decode($_GET['MonCompte']);
        $sql = "SELECT user.username, COUNT(follow.id_user_followed) FROM user JOIN follow ON user.id = follow.id_user_followed where user.username like '@%$query%' group by user.username";    
        $requete = $db->query($sql);
        $sql2 = "SELECT user.username, COUNT(follow.id_user_follow) FROM user JOIN follow ON user.id = follow.id_user_follow where user.username like '@%$query%' group by user.username;";    
        $requete2 = $db->query($sql2);}
    ?>
    <table id ="colonne">
        
    <thead>
            <tr>
                <th scope="col">username:</th>
                <th scope="col">Abonnement:</th>
            </tr>
    </thead>
    <?php while($a = $requete->fetch()) { ?>
    <tbody>
    <tr>
        <td><?php echo $a["username"]?></td>
        <td><?php //echo $a["id_user_followed)"]?></td>
    </tr>
    </tbody>
    <?php } ?>
    </table>


    
</body>
</html>