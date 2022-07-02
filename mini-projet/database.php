<?php
 //database
 class personnagesManager
{
    private $db;
        public function __construct($db)
        {
            $this->setDb($db);
        }
        public function add(personnage $perso)
        {
            // Préparation de la requête d'insertion.
            // Assignation des valeurs pour le nom du personnage.
            // Exécution de la requête.
            // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
            $query= $this->db->prepare-('INSERT INTO personnages WHERE nom = :nom');
            $query->bindvalue(':nom', $perso->nom());
            $query->execute();

            $perso->hydrate(array(
                'id'=>$this->db->lastInsertId(),
                'degats'=> 0,
            ));
        }
        public function count()
        {
            // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
             return $this->db->query ('SELECT COUNT(*) FROM personnages')->fetchColumn();
        }
        public function delete(personnage $perso)
        {
            // Exécute une requête de type DELETE.
            $query->db->exec('DELETE FROM personnages WHERE id='.$perso->id());
        }
        public function exists($info)
        {
            // Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
            // On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
            // Sinon c'est qu'on a passé un nom.
            // Exécution d'une requête COUNT() avec une clause WHERE, etretourne un boolean.
            if (is_int($info))
            {
                return (bool) $this->db->query('SELECT COUNT(*) FROM personnages WHERE id= '.$info)->fetchColumn();  
            }
            //verifier si le nom existe ou pas 
            $query=$this->db->prepare('SELECT COUNT(*) FROM personnages WHERE nom= :nom');
            $query->execute(array(':nom'=>$info));
            return (bool) $query->fetchColumn();  
        }   
        public function get($info)
        {
                // Si le paramètre est un entier, on veut récupérer la personnage avec son identifiant.
                // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.          
                // Sinon, on veut récupérer le personnage avec son nom.
                // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
                if (is_int($info))
                    {
                        $query=$this->db->query('SELECT * FROM personnages WHERE id= '.$info);
                        $donnee=$query->fetch(PDO::FETCH_ASSOC);
                        return new Personnage($donnee);
                    }
                    else
                        {
                            $query=$this->prepare('SELECT * FROM personnages WHERE nom=:nom');
                            $query->execute(array(':nom'=>$info));

                            return new Personnage ($query->fetch(PDO::FETCH_ASSOC));
                        }
        }
        public function getList($nom)
        {
            // Retourne la liste des personnages dont le nom n'est pas $nom.
            // Le résultat sera un tableau d'instances de Personnage.
            $persos=array();
            $query=$this->db->prepare('SELECT * FROM personnages WHERE nom <>:nom ORDER BY nom');       
            $query->execute(array(':nom'=>$nom));
            while($donnee =$query->fetch(PDO::FETCH_ASSOC))
                    {
                        $persos[]= new Personnage($donnee);
                    }
            return $persos;

        }        
        
        public function update(personnage $perso)
        {
            //mise a jour du requette
            $query=$this->db->prepare('UPDATE personnages SET degats= :degats WHERE id= :id');
            $query->bindvalue(':degats',$perso->degats() , PDO::PARAM_INT);
            $query->bindvalue(':ic',$perso->id() , PDO::PARAM_INT);
                $query->execute();
        }
        public function setDb(PDO $db)
        {
            $this->db=$db;
        } 
}  
//database     
?>