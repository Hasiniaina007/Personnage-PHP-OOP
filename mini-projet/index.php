<?php
 //index
class Personnage
{
    private $id;
    private $degats;
    private $nom;

       const  MOI_MEME= 1;     
       const  PERSONNAGE_TUE= 2;     
       const  PERSONNAGE_FRAPPE= 3;     
   
    public function __construct(array $donnee)
    {
           $this->hydrate($donnee);    
    }  
      
    public function frapper(Personnage $perso)
    {
           if ($perso->id() ==$this->id)
           {
               return self::MOI_MEME;
               
           }
           return $perso->recevoirDegats();
    }
    public function hydrate(array $donnee)
    {
        foreach($donnee as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    public function recevoirDegats()
    {
       $this -> degats += 5;
       /**
        * si le persionnage à 100 degats de plus , alors le personnage à ete tué (PERSONNAGE::TUE)
        */
       if ($this-> degats >=100)
       {
           return self::PERSONNAGE_TUE;
       }
    }
    /**
     * GETTERS
     */
     public function degats()
     {
         return $this->degats;
     }
     public function id()
     {
         return $this->id;
     }
     public function nom()
     {
         return $this->nom;
     }
     public function setDegats($degats)
       {
           $degats =(int) $degats;
           if ($degats >= 0 && $degats <=100)
           {
               $this->degats = $degats;
           }
       }
       public function setId($id)
       {
           $id = (int) $id;
           if ($id > 0)
           {
               $this->id= $id;
           }
       }
       public function setNom($nom)
       {
           if (is_string($nom))
           {
           $this->nom=$nom;
           }
       }
}
//index
 ?>