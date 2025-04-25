
![parking_complex](images/parking_complex.png)

# Information sur le code de base

##  La route (Road)
La Route délègue au véhicule le fait d’interagir avec le parking
Génère des véhicules et les envoie vers le parking.

**Exercices en lien** :
- ➡️ [Factory](exercices/Factory.md)
- ➡️ [Mediator](exercices/Mediator.md)

## Une classe Parking
- Le parking contient N places (paramétrable).
- Chaque place peut être libre ou occupée.
- Un véhicule ne peut se garer que si une place est libre.
- Contient des Place, gère l’accueil des véhicules.
- Fournit des Places et gère l’argent collecté
- private array $places = []; // Array of Place[]
- private Tirelire $tirelire;

**Exercices en lien**
- ➡️ [Stratégie](exercices/Strategy.md)
- ➡️ [Iterator](exercices/Iterator.md)
- ➡️ [Builder](exercices/Builder.md) 


## Une classe Vehicle
- Le parking accepte des voitures, des motos et des camions.
- Certains véhicules (ex. : camions) occupent plusieurs places.
- $remainingIteration : le temps de parking souhaité (nombre d'itération)
- $size: la taille du véhicule (1 = moto, 2= voiture, 3= camion)

**Exercices en lien** 
- ➡️ [Factory](exercices/Factory.md)
- ➡️ [Adapter](exercices/Adapter.md)
- ➡️ [Decorator](exercices/Decorator.md)
- 💡 Vehicle, Truck, Motorcycle extends Vehicle
- 💡 Template Method
- 💡 Design pattern State

## Place	
Gère son Véhicule et décide s’il part
Peut accepter certains types de véhicules selon leur taille. 
A un prix de base.

## PriceCalculator
Classe à laquelle on delègue le calcul des prix ! 
- ➡️ [Strategy](exercices/Strategy.md)

 
## Clock 
Gère les cycles d'itérations.
Fait juste passer le temps (tick)

**Exercices en lien** 
- ➡️ [Singleton](exercices/Singleton.md)
- ➡️ [Observer](exercices/Observer.md)

## Tirelire	
Stocke l'argent payé par les véhicules quand ils partent.
Elle récolte l’argent quand un véhicule quitte une Place.
Elle n’est pas impactée par le temps qui passe
Elle est impactée par le départ d'un véhicule.
Tirelire est alimentée seulement à la libération d’une Place.

**Exercices en lien** 
- ➡️ [Singleton](exercices/Singleton.md)

## Dashboard
Le dashboard affiche les informations à propos de la simulation: 

**Exercices en lien** 
- ➡️ [Facade](exercices/Facade.md)

## main
Grande boucle qui démarre l'application.

## Bonus : Architecture globale MVC
- 💡 L'architecture est pensée en MVC (+ Front Controller si besoin est).
