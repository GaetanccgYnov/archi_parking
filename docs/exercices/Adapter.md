## 🐴 Exercice : Intégrer un cheval dans le parking (Adaptateur)

Problème un cheval se présente à l'entrée du Parking. 
Il s'agit d'un Cheval utiliser dans une application de gestion de centre équestre (Third-party). Le directeur est formel pas de discrimination, il doit pouvoir se reposer chez nous ! 
Vous devez trouver un moyen d'utiliser ce Cheval dans votre Parking. 
Et pour cela utiliser le design pattern [[Adapter]]. 

Comme les chevaux peuvent avoir différents poids, il a été décidé les choses suivante : 
- Un cheval de moins de 250 kg occupe une place. 
- Au delà un cheval de plus de 250 Kg en prend deux.  

**Le problème :** 
Le parking gère des véhicules dotés d’une `size`.  
Le `Cheval.php`, lui, ne possède qu’un `poids`.

🎯 **Objectif :** 
Créez un adaptateur pour rendre le cheval compatible avec notre système de parking.

**Code de base :**
```php
class Cheval
{
    private int $poids;

    public function __construct(int $poids)
    {
        $this->poids = $poids;
    }

    public function getPoids(): int
    {
        return $this->poids;
    }
}
```

### 🧠 **Design Pattern attendu**
- **Adaptateur**

### ✅ **Critères de validation**
- Le cheval peut se garer si une place est disponible pour sa taille
- Il est traité comme un véhicule classique par le parking

