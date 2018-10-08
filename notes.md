### 1 / Bases de l'objet
#### Durée : 1h15

Tous les objets, champs et méthodes sont donnés en français dans les instructions.
Dans l'email vous demandez de coder en anglais, j'ai donc choisi de quand même tout coder en anglais.

Sur les classes, à noter que j'aurais pu passer par des variables privée et utiliser des accesseurs dans toutes les classes.  
Je ne l'ai pas fait dans un souci de lisibilité, l'intégralité du code étant dans un seul et même fichier.

Le fichier est fait pour être exécuté en tant que script, n'ayant pas besoin d'interface pour cet exercice.


### 2 / Tickets de caisse
#### Durée : 2h15

Le code livré est un peu rudimentaire, mais pour une application demandant peu de contrôles et peu d'actions, il reste facilement compréhensible.

J'ai utilisé le localStorage pour stocker les informations.  
Le localStorage ne peut contenir que du type string, il a fallu donc parser les éléments.

J'ai utilisé une classe Receipt, assez basique, ainsi qu'une classe ReceiptManager permettant de gérer les actions liées à la classe.

Bien que d'utilité limitée, j'ai intégré jQuery et Momentjs, seulement afin de montrer ma capacité à me servir de librairies externes.

J'ai passé un peu de temps car il a fallu que je réfléchisse à l'UX de l'application que je voulais utiliser.  
Finalement, du one page sous bootstrap me semblait favorable du fait de la simplicité de l'application et de sa mise en place.


 
### 3 / Traitement sur les textes
#### Durée : 0h10

J'ai décidé pour ce cas, de passer me passer d'une interface, non nécessaire pour la réalisation de cette tâche.

Le programme s'exécute en passant le fichier texte en paramètre.  
Par exemple : `php read.php "/home/david/texte/montexte.txt"`


 
### 4 / La chasse au lapin
#### Durée : 0h40

Ce cas manque de détails sur son fonctionnement et ce qu'on en attend.
Il nécessiterait d'avantages d'informations pour pouvoir être développé correctement.  
En effet, beaucoup de questions restent en suspens et l'énoncé n'est pas assez clair.

De fait, la réalisation d'un tel projet est bloquée par son manque de clarté. 

J'ai tout de même mis en place le dessin d'une carte représentant la forêt avec chacun de ses 
éléments dispersés dedans. R étant le lapin, H le trou, et X le chasseur.

Le script s'exécute en ligne de commande `php hunt.php`

