# Annexe - Check List Clean Code 

Voici un résumé des principales idées du livre « [Clean Code: A Handbook of Agile Software Craftsmanship](https://www.decitre.fr/livres/clean-code-9780132350884.html) » de Robert C. Martin (Uncle Bob).

>[!info] **Robert Cecil Martin** - Uncle Bob
>Familièrement connu sous le nom Uncle Bob est un ingénieur logiciel et auteur américain né le 5 décembre 1952 co-auteur du Manifeste Agile. Il  est à l'origine du site web _Clean Coders_, et du livre éponyme.

# En quelques lignes 
Du code est propre (_clean_) si il peut : 
- Être compris facilement - par chaque personne de l'équipe. 
- Peut être lu et amélioré par un·e développeur·se autre que la personne qui l'a écrit. 

# Objectif
- Compréhensibilité 
- Lisibilité, 
- Facilité à changer 
- Extensibilité 
- La maintenabilité

## Règles générales

- [ ] Suivez des conventions reconnues
- [ ] KISS Keep it simple stupid
- [ ] Règle du boy scout : laissez le camp plus propre que l'état dans lequel vous l'avez trouvé.
- [ ] Lors de résolution d'un problème, toujours chercher et trouver **la cause racine**.
- [ ] Suivez le principe de moindre surprise (le programme se comporter comme l’utilisateur ou le développeur s’y attend naturellement, "Le meilleur comportement est celui qui surprend le moins").
- [ ] DRY
 
## Règles de design

- [ ] Gardez les données configurables (par exemple les constantes) à hauts niveaux. (Elles devraient être faciles à changer).
- [ ] Préférez le polymorphisme aux `if`/`else` ou `switch`/`case`.
- [ ] Évitez la sur-configurabilité et tout ce qui n'a pas prouvé sa nécessité.
- [ ] Utilisez l'injection de dépendances.
- [ ] Suivez la loi de Déméter (une classe ne devrait connaître que ses dépendances directes).

>[!info] Zoom sur la loi de Déméter
> **Un objet ne doit parler qu’à ses amis proches, pas aux étrangers.**
> **Mauvais exemple (viole la loi de Déméter)**   
> `$vehicle->getEngine()->start();`
   Ici, `car` connaît `engine`, mais il utilise `engine` directement.  
   Ça veut dire qu’il sait trop de choses sur la structure interne de `car`, ce qui crée une forte dépendance.
   >
   **Bon exemple (respecte la loi de Déméter)**
   `$vehicle->startEngine();`
   Ici, `car` masque l'existence de son `engine`.  
   C’est `car` qui s’occupe de démarrer son moteur. Le reste du code n’a pas besoin de savoir qu’il existe un `engine`.
   > 
   **Pourquoi faire ?**
   Moins de dépendances / Moins fragile / Meilleure encapsulation
## Astuces pour la compréhensibilité

- [ ] Soyez cohérent. Si vous faites quelque chose d'une certaine manière, toutes les choses similaires devraient être faites de la même manière.
- [ ] Utilisez des noms de variables explicites.
- [ ] Encapsulez les conditions limites : elles sont compliquées à suivre. Il vaut mieux les isoler à un endroit.
- [ ] Préférez des  value objects_ spécifiques plutôt que des types primitifs
- [ ] Évitez les dépendances logiques : n'écrivez pas de méthodes qui dépendent d'autre chose dans la même classe.
- [ ] Évitez les conditions négatives.

## Règles de nommages

- [ ] Choisissez **des noms descriptifs et sans ambiguïté**.
- [ ] Faites **des distinctions qui ont du sens**.
- [ ] Utilisez **des noms prononçables**.
- [ ] Utilisez **des noms cherchables**.
- [ ] Remplacez les nombres magiques par **des constantes bien nommées**.
- [ ] Évitez d'ajouter des préfixes ou des informations sur les types.

## Règles relatives aux fonctions

- [ ] **Courtes**.
- [ ] **Ne fait qu'une chose** et la fait bien.
- [ ] Utilisez **des noms descriptifs**.
- [ ] Préférez les avec **le moins d'arguments possibles**, idéalement pas plus de 3.
- [ ] **Sans effet de bord**.
- [ ] N'utilisez pas de flag : écrivez plutôt plusieurs méthodes sans ce type d'argument.

## Règles relatives aux commentaires

- [ ] Essayez d'écrire [**du code expressif** ne nécessitant pas de commentaire](https://damien.pobel.fr/post/juste-dose-commentaires-dans-le-code/). Si c'est impossible, prenez le temps d'écrire un bon commentaire.
- [ ] Ne soyez pas redondant (par exemple : `i++; // increment i`).
- [ ] N'ajoutez pas de bruit évident.
- [ ] N'utilisez pas les commentaires de fermeture de bloc (par exemple : `} // end of function`).
- [ ] **Ne commentez pas de code**. Supprimez ce code.
- [ ] Utilisez des commentaires **pour expliquer l'intention**.
- [ ] Utilisez des commentaires **pour avertir des conséquences**.

## Structure du code source

- [ ] **Séparez les concepts verticalement**.
- [ ] **Le code lié** devrait apparaître **dense verticalement**.
- [ ] Déclarez les **variables à proximité de leurs usages**.
- [ ] **Les fonctions dépendantes les unes des autres** devraient être **à proximité**.
- [ ] **Les fonctions similaires** devraient être **à proximité les unes des autres**.
- [ ] Placez les fonctions dans **la direction descendante**.
- [ ] Gardez les **lignes courtes**.
- [ ] N'alignez rien horizontalement.
- [ ] Utilisez des **espaces pour associer des choses liées** et dissocier des choses liées faiblement.
- [ ] **Ne cassez pas l'indentation**.

## Objets et structures de données

- [ ] Cachez les structures internes.
- [ ] Devraient être **petits**.
- [ ] **Ne font qu'une chose**.
- [ ] **Possèdent un petit nombre de variables d'instance**. Si votre classe a trop de variables d'instance, il est probable que votre objet fasse plus qu'une chose.
- [ ] Une classe de base ne devrait rien connaître de ses classes dérivées.
- [ ] **Il vaut mieux avoir plusieurs fonctions** que de passer du code à une fonction pour qu'elle choisisse un comportement.
- [ ] **Préférez des méthodes non statiques**.

## Tests
- [ ] **Un concept** par test.
- [ ] **Rapides**.
- [ ] **Indépendants**.
- [ ] **Répétables**.
- [ ] **Auto validants**.
- [ ] **Utiles**.
- [ ] **Lisibles**.
- [ ] **Faciles à lancer**.
- [ ] Utilisez un outil de génération de couverture de code

## Indicateurs d'un code pas terrible (_Code smells_)

- [ ] **Rigidité** : le logiciel est difficile à faire évoluer. Une petite modification peut causer une cascade de changements.
- [ ] **Fragilité** : le logiciel dysfonctionne en plusieurs endroits en réponse à un unique changement.
- [ ] **Immobilité** : vous ne pouvez pas réutiliser une partie du code dans d'autres projets car cette opération est risquée ou nécessite un grand effort.
- [ ] Complexité inutile
- [ ] **Répétition inutile**.
- [ ] **Opacité** : le code est difficile à comprendre.

## Gestion des erreurs

- [ ] **Ne mélangez pas** la gestion des erreurs et le code.
- [ ] Utilisez des **Exceptions** au lieu de renvoyer des codes d'erreurs.
- [ ] **Ne retournez pas `null`**, n'utilisez pas `null` non plus
- [ ] Lancer des exceptions **avec du contexte**.

# Source 
- https://damien.pobel.fr/post/clean-code/