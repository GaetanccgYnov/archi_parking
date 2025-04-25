# Implémenter une Façade

On vient de recevoir un Dashboard ! 
Il coûte cher mais il est magnifique !
Le voici :

```shell
----
🌙 Moment : Jour || nuit 
🚗 Véhicules en circulation :  
* Motos : __
* Voitures : __
* Camions : __ 
* Total: __
🅿️ Véhicules garés : __ 
💸 Montant de la tirelire : __ €
-----
```
Et voici son code :

```php
//... code du Dashboard
```

On veut l'intégrer dans notre code source, mais comme on ne sait pas 
si on pourra le garder, préparons une façade pour l'intégrer. 

- Ajouter une facade au Dashboard pour pouvoir changer l'affichage.
- Intégrer la nouveau Dashboard via la Façade en question.
- Prendre en option le Dashboard choisi au lancement de la simulation (main)