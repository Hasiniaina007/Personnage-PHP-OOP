<?php
//enregiste l'autro load
    function chargerClasse($classeName)

    {//ça c'est inconnue
       //require $classeName;
        require('index.php');
        require('database.php');
    }
spl_autoload_register('chargerClasse');
session_start();
    if (isset($_GET["deconnexion"]))
    {
        session_destroy();
        header('Location:ifront.php');
        exit();
    }
    if(isset($_SESSION['perso']))
    {
        $perso = $_SESSION['perso'];
    }

$db=new PDO ('mysql:host=localhost;dbname=gameone','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$manager = new  personnagesManager($db);

//si on a voilu cree un personnage 
if (isset($_POST['creer']) && isset($_POST['nom']))
{
    //on cree un nouveau perso
    $perso=new Personnage(array(
        'nom'=>$_POST['nom']
                                ));
        if (!$perso->nomValide())
            {
                $message="Le nom est invalide";
                unset ($perso);
            }
            # code...
            elseif ($manager->exists($perso->nom())) 
            {
                $message="Le nom du perso est deja prise ";
                unset ($perso);
            }
            else
            {
                $manager->add($perso); 
            } 
    }
    //si on a voulu utiliser le personnnage 
elseif (isset($_POST['utiliser']) && isset($_POST['nom']))
{
        //verifier si le nom existe 
        if ($manager->exists($_POST['nom']))
            {
              $perso = $manager->get($_POST['nom']);  
            }
            else
            {
                $message='ce personnage n\'existe pas ';
            }
}
        elseif (isset($_GET['frapper'])) // dans le cas ou on clique pour frapper
        {
            if(!isset($perso))
                {
                    $message =" merci de cree un personnage ou un  identifiant";
                }   
            else
            {
                if (!$manager->exists((int) $_GET['frapper']))
                {
                    $message="Le perso que vous voulez frapper n'existe pas";
                }
                else
                {
                    $persoAFrapper=$manager->get((int) $_GET['frapper']);
                    $retour=$pero->frapper($persoAFrapper);// On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
                    switch($retour)
                    {
                        case Personnage::MOI_MEME :
                            $message ="Pourquoi voulez vous frapper tout seul?";
                            break;
                        case Personnage::PERSONNAGE_TUE:
                            $message="Le personnage à ete frapper";

                            $manager->update($perso);
                            $manager->update($persoAFrapper);

                            break;

                        case Personnage::PERSONNAGE_FRAPPE:
                            $message="Vous avez tuer ce personnage";

                            $manager->utdate($perso);                       
                            $manager->delete($persoAFrapper);

                            break;
                    }
                }
            }
        }
        
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny-Game</title>
</head>
<body>
    <p>Personnages crées : <?php echo $manager->count(); ?></p>
    <?php //si on des messages à afficher
    if (isset($message))
        {
        echo '<p>'.$message.'</p>';//sioui on affiche ici
        }
        if (isset($perso))
        {
    ?>
    <p><a href="?deconnexion=1">Deconnexion</a></p>
    <fieldset>
        <legend>Mes informations :</legend>
        <p>
            Nom : <?php echo htmlspecialchars($perso->nom()); ?> <br />
            Degats : <?php echo $pero->degats(); ?>
        </p>
    </fieldset>
    <fieldset>
        <legend>Qui Frappe ?</legend>
        <p>
            <?php 
            $persos = $manager->getList($perso->nom());
                if (empty($persos))
                {
                    echo 'Personne à frapper';
                }
                else
                {
                    foreach ($pero as $unPerso)
                    echo '<a href="?frapper="',$unPerso->id(),'">',   
                    htmlspecialchars($unPerso->nom()),'</a> (degats : ', $unPerso->degats(), ')<br />';
                }
                ?>
        </p>
    </fieldset>
    <?php
     }
    else
    {
    ?>
    <form action="" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" maxlenght="50">

        <input type="submit" name="creer" value="Creer ce personnage">

        <input type="submit" name="utiliser" value="Utiliser ce personnage">
    </form>
    <?php
    }
    ?>
</body>
</html>
<?php
//economiser des requette sql
if (isset($perso))
    {
            $_SESSION["perso"]=$pero;
    }