# Mise en place d'un Médiator

Une entité s‘inscrivant comme chaperon des communications, afin de limiter les interconnections entre objets et coordonner les interactions de ses clients. On évite ainsi les appels explicites. 

## Métaphore 
On peut illustrer la théorie du médiateur par une tour de contrôle d’aéroport. Les avions ne sont pas en communication entre eux, mais avec la tour.  Ainsi, les informations sont centralisées, et le centre de contrôle peut coordonner les différents atterrissages et décollages.

## Cas d'utilisations
- Un chat
- Une UI dont les boutons ont des effets sur de multiples endroit.

## Classes composant le pattern : 
Classes abstraites : 
- **Médiateur :**  définit l’interface du médiateur pour les objets Élément.
- **Élément**  est la classe abstraite des éléments qui introduit leurs attributs, associations et méthodes communes.

Classes concrètes 
- **MédiateurConcret**  implante la coordination entre les éléments et gère les associations avec les éléments.

- **ÉlémentConcret1**, **ÉlémentConcret2** ... classes concrètes des éléments qui communiquent avec le médiateur au lieu de communiquer avec les autres éléments.

Les éléments envoient des messages au médiateur et en reçoivent. 
Le médiateur implante la collaboration et la coordination entre les éléments.

## Quid du Parking : une file d’attente intelligente

Pour l'instant c'est la classe Parking qui gère tout avec pour principe "premier arrivé premier servi". Mais on va faire évoluer tout cela. Comme le parking est trop souvent pleins on a décidé de créer une file d'attente intelligente et d'ouvrir deux nouveaux parking. Cette file d'attente intelligente nommé de manière inattendu `ParkingMediator` devra : 
- Faire du Load Balancing et envoyer les voitures systèmatiquement au parking le plus vide 
- Gérrer les priorités et les problématiques de places aménagées pour le handicap 
- Gérer les priorités place avec borne de recharge pour véhicules électriques. 
- Envoyé quand il le faut les voitures dans la file d'attente associée.
- Gérer les timeout (si une voiture attend trop longtemps, elle abandonne)
- Bonus : gérer les reservations faites à distance par Internet.
- Bonus : gérer les fermetures temporaires (maintenance)
- Bonus : changer les règles la nuit. 

## Implémentation sans Mediator 
```php
class Road {
  private $parking;
  
  public function __construct(Parking $parking) {
     $this->parking = $parking;
  }

  public function vehicleArrives() {
     $vehicle = new Vehicle();
     $vehicle->tryToPark($this->parking);
  }

}
```

Devient : 
```php
class Road {
    private $parking1;
    private $parking2;
    private $parking3;

    public function __construct(Parking $parking1, Parking $parking2, Parking $parking3) {
        $this->parking1 = $parking1;
        $this->parking2 = $parking2;
        $this->parking3 = $parking3;
    }

    public function vehicleArrives() {
        $vehicle = new Vehicle();
        
        // Load balancing
        // Trouver le parking avec le plus de places disponibles
        $parking = $this->findBestParking();
        if (!$parking) echo "Tous les parkings sont pleins.\n";

        // Priorités
        // si handicape, envoyer vers les places adaptées
        if ($vehicle->isHandicapped()) {
            $parking = $this->findParkingWithHandicapSpot($parking);
        }

        // Priorités
        //Véhicules électriques avec borne de recharge
        if ($vehicle->isElectric()) {
            $parking = $this->findParkingWithChargingStation($parking);
        }

        // Check s'il y a une file d'attente
        //la voiture attend si aucun parking n'est disponible
        if (!$parking->tryToPark($vehicle)) {
            $this->addToQueue($vehicle);
            echo "Le véhicule a été ajouté à la file d'attente.\n";
        }

        // Gérer les timeouts
        //si une voiture attend trop longtemps, elle abandonne
        if ($this->hasTimedOut($vehicle)) {
            echo "Le véhicule a abandonné après avoir attendu trop longtemps.\n";
        }
        echo "Le véhicule a été garé avec succès dans le parking.\n";
    }

    // Trouver le parking avec le plus de places libres
    private function findBestParking() {
        $parkings = [
	        $this->parking1, 
	        $this->parking2, 
	        $this->parking3
	    ];
        // Trier les parkings par places disponibles
        usort($parkings, function ($a, $b) {
            return $a->getLeftPlaces() - $b->getLeftPlaces();         
        });
        // Retourne le parking avec le plus de places 
        return $parkings[0]; 
    }

    // Trouver un parking avec des places adaptées pour personnes handicapées
    private function findParkingWithHandicapSpot(Parking $parking) {
        foreach ($parking->getPlaces() as $place) {
            if ($place->isHandicappedAccessible() && $place->isAvailable()) {
                return $parking;
            }
        }
        echo "Aucune place adaptée pour les handicapés disponible.\n";
        return $parking; // Renvoyer le même parking s'il n'y a pas de place adaptée
    }

    // Trouver un parking avec des bornes de recharge pour véhicules électriques
    private function findParkingWithChargingStation(Parking $parking) {
        foreach ($parking->getPlaces() as $place) {
            if ($place->hasChargingStation() && $place->isAvailable()) {
                return $parking;
            }
        }
        echo "Aucune borne de recharge disponible.\n";
        return $parking; // Renvoyer le même parking s'il n'y a pas de borne
    }

    // Ajouter un véhicule à la file d'attente
    private function addToQueue(Vehicle $vehicle) {
        // Logique pour ajouter un véhicule à la file d'attente
    }

    // Vérifier si un véhicule a dépassé le timeout d'attente
    private function hasTimedOut(Vehicle $vehicle): bool {
        // Logique pour vérifier si le véhicule a trop attendu dans la file
        return false; // Exemple de valeur de retour
    }
}
```

## Avec un design pattern de Médiator 

Le but du médiateur est de centraliser la logique complexe de coordination et de décision, tout en réduisant les dépendances entre les différentes classes.

Dans le cas de notre parking, le médiateur pourrait gérer la coordination entre les différents parkings, véhicules, et les priorités sans que ces objets aient besoin de se connaître directement.

 **Classes abstraites :**
```php
interface ParkingMediator {
    public function vehicleArrives(Vehicle $vehicle): bool;
    public function findBestParking(): Parking;
    public function manageQueue(Vehicle $vehicle): void;
}
```

```php
class ConcreteParkingMediator implements ParkingMediator {
    private $parkings = [];
    private $queue = [];
    
    public function __construct(Parking $parking1, Parking $parking2, Parking $parking3) {
        $this->parkings[] = $parking1;
        $this->parkings[] = $parking2;
        $this->parkings[] = $parking3;
    }
    
    public function vehicleArrives(Vehicle $vehicle): bool {
        // Load balancing: Trouver le parking le plus vide
        $parking = $this->findBestParking();
        
        // Vérifier les priorités
        if ($vehicle->isHandicapped()) {
            $parking = $this->findParkingWithHandicapSpot($parking);
        }
        
        if ($vehicle->isElectric()) {
            $parking = $this->findParkingWithChargingStation($parking);
        }
        
        // Tentative de stationner la voiture
        if (!$parking->tryToPark($vehicle)) {
            $this->manageQueue($vehicle);
            return false;
        }
        
        echo "Le véhicule a été garé dans le parking.\n";
        return true;
    }

    public function findBestParking(): Parking {
        //...
    }

    public function manageQueue(Vehicle $vehicle): void {
        //...
    }

    // Recherche d'un parking avec une place handicapée
    private function findParkingWithHandicapSpot(Parking $parking): Parking {
        //...
    }

    // Recherche d'un parking avec une borne de recharge pour véhicule électrique
    private function findParkingWithChargingStation(Parking $parking): Parking {
        //...
    }
}
```

**Et la class Road redevient :**
```php
class Road {
    private $mediator;

    public function __construct(ParkingMediator $mediator) {
        $this->mediator = $mediator;
    }

    public function vehicleArrives() {
        $vehicle = new Vehicle();
        return $this->mediator->vehicleArrives($vehicle);
    }
}
```


## Et si on ajoute des files d'attentes ? 
```php
class VehicleQueue {
    private $queue = [];
    private $timeout;
    
    public function __construct($timeout) {
        $this->timeout = $timeout; // Timeout en secondes
    }

    // Ajoute un véhicule à la file d'attente
    public function addToQueue(Vehicle $vehicle) {
        $this->queue[] = [
            'vehicle' => $vehicle,
            'timestamp' => time() // L'heure d'arrivée du véhicule
        ];
    }

    // Retire le véhicule de la file d'attente (si il a trouvé une place)
    public function removeFromQueue(Vehicle $vehicle) {
        foreach ($this->queue as $index => $entry) {
            if ($entry['vehicle'] === $vehicle) {
                unset($this->queue[$index]);
                break;
            }
        }
    }

    // Vérifie si un véhicule a dépassé son temps d'attente et le retire si nécessaire
    public function checkTimeouts() {
        foreach ($this->queue as $index => $entry) {
            if (time() - $entry['timestamp'] > $this->timeout) {
                // Retirer le véhicule du parking et de la file d'attente
                $this->removeFromQueue($entry['vehicle']);
                echo "Véhicule " . $entry['vehicle']->getId() . " abandonné après trop de temps d'attente.\n";
            }
        }
    }

    // Donne la prochaine voiture à envoyer au parking
    public function getNextVehicle() {
        return $this->queue[0] ?? null; // Retourne le premier véhicule en file d'attente
    }

    // Compte le nombre de véhicules dans la file
    public function getQueueSize() {
        return count($this->queue);
    }
}
```
