# Ajouter un iterator

On veut récupérer des informations spécifiques sur les parkings pour le dashboard et cela pour chaque parking : 
- Nombre de places handicapées et leur taux d'occupation
- Nombre de places réservées pour les camions

On va donc devoir traverser tous les parkings pour en extraire ces informations et les afficher sur le dashboard.

# Use case : Trois parkings différents : 

Chaque parking a des types de places différents : 
- Places standard 
- Places handicapées 
- Places pour camions

## Implémentation de l'itérateur :

L'itérateur devra parcourir tous les parkings, et pour chaque parking, récupérer le nombre de places handicapées et le nombre de places pour camions.

```php
class Place {     
    private $type; 
    private $occupied;      
   
    public function __construct($type, $occupied = false) {              $this->type = $type;         
        $this->occupied = $occupied;     
    }      
    
    public function getType() { ...    }      
    public function isOccupied() {  ... } 
}  
```

```php
class Parking {     
     private $places = [];      
     
    public function __construct($places) {         
         $this->places = $places;     
    }      
    public function getPlaces() {         
         return $this->places;     
    } 
}  
```

```php
class ParkingIterator implements Iterator {     
private $parkings;     
private $currentParking;     
private $currentPlace;     
private $totalParkings;      

public function __construct($parkings) {         
$this->parkings = $parkings;         
$this->currentParking = 0;         
$this->currentPlace = 0;         
$this->totalParkings = count($parkings);     
}      

public function current() {         
return $this->parkings[$this->currentParking]->getPlaces()[$this->currentPlace];     
}      

public function key() {         
return $this->currentPlace;     
}      

public function next() {         
if ($this->currentPlace < count($this->parkings[$this->currentParking]->getPlaces()) - 1) {
$this->currentPlace++;         
} else {             
$this->currentParking++;             
$this->currentPlace = 0;         
}     
}      

public function valid() {         
     return $this->currentParking < $this->totalParkings;     
}      

public function rewind() {         
    $this->currentParking = 0;         
    $this->currentPlace = 0;     } 
}  

// Méthode pour calculer les infos sur les places handicapées et les camions 
function getParkingStats($parkings) {     
    $handicapCount = 0;     
    $handicapOccupied = 0;     
	$camionCount = 0;     
	$camionOccupied = 0;      

	// Créer un itérateur pour parcourir tous les parkings et leurs places     
	$iterator = new ParkingIterator($parkings);      
	// Parcours des parkings     
	foreach ($iterator as $place) {         
		if ($place->getType() === 'Handicap') {             
			$handicapCount++;             
			if ($place->isOccupied()) {                
				$handicapOccupied++;             
			}         
		} elseif ($place->getType() === 'Camion') {
			$camionCount++;             
			if ($place->isOccupied()) {
				$camionOccupied++;             
			}         
		}     
	}      
	
	// Retourne les stats     
	return [         
		'handicap' => [             
			'total' => $handicapCount,             
			'occupied' => $handicapOccupied,             
			'rate' => $handicapCount > 0 ? ($handicapOccupied / $handicapCount) * 100 : 0
		],
		'camion' => [             
			'total' => $camionCount,             
			'occupied' => $camionOccupied,             
			'rate' => $camionCount > 0 ? ($camionOccupied / $camionCount) * 100 : 0         
		]     
	]; 
}  

// Exemple d'utilisation 
$places = [     new Place('Handicap', true),     new Place('Handicap', false),     new Place('Camion', true),     new Place('Camion', false),     new Place('Standard', true), ];  $parkings = [     new Parking($places),     new Parking($places),     new Parking($places), ];  

// Calcul des stats 
$stats = getParkingStats($parkings);  

// Affichage des stats dans le dashboard 
echo "Places handicapées: {$stats['handicap']['occupied']} / {$stats['handicap']['total']} (Taux d'occupation: {$stats['handicap']['rate']}%)\n"; echo "Places Camion: {$stats['camion']['occupied']} / {$stats['camion']['total']} (Taux d'occupation: {$stats['camion']['rate']}%)\n";`
```
### Explication :

1. **Les classes** :
    
    - `Place` : Représente une place dans le parking, avec son type (handicapé, camion, etc.) et son état (occupée ou non).
        
    - `Parking` : Contient un tableau de `Place`.
        
    - `ParkingIterator` : Itère sur tous les parkings et leurs places.
        
2. **La fonction `getParkingStats`** :
    
    - Cette fonction utilise un itérateur pour parcourir chaque parking et chaque place.
        
    - Elle compte le nombre de places handicapées et de places pour camions, ainsi que le nombre de places occupées dans chaque catégorie.
        
    - Elle calcule également le taux d'occupation des places handicapées et des places pour camions.
        
3. **Le résultat** :
    
    - Tu obtiens le nombre total de places handicapées et pour camions, ainsi que leur taux d'occupation, le tout de manière centralisée et sans avoir à parcourir manuellement chaque parking à chaque fois.
        

### Pourquoi ça a du sens ?

- **Centralisation de la logique** : L'itérateur centralise la logique de parcours des parkings et de comptage des places, ce qui simplifie le code de ton dashboard.
    
- **Extensibilité** : Si tu ajoutes de nouveaux types de places (par exemple, places pour motos, places réservées, etc.), tu n'auras qu'à modifier l'itérateur et les calculs dans `getParkingStats` sans avoir à changer la manière dont tu parcoures les parkings.
    
- **Flexibilité** : Tu pourrais facilement étendre cela pour inclure des règles spécifiques, comme des horaires où certaines places sont réservées à un type de véhicule particulier (par exemple, les places pour camions peuvent être réservées la nuit).
    

### En résumé

L'utilisation d'un itérateur dans ce cas permet de rendre la gestion des parkings et des places beaucoup plus modulable et évolutive, en facilitant le parcours des différents types de places tout en centralisant la logique. C'est un excellent moyen de maintenir un code propre, surtout quand tu as plusieurs parkings avec des types de places variés à gérer.

4o mini