Mag
===

Mag est un thème pour le logiciel de lecture de flux RSS <a href="https://github.com/ldleman/Leed">Leed</a>.

Actuellement en chantier, il s'agit d'un thème inspiré du feu Google Flux ou Google Current. 
L'idée est de proposer une navigation dans ses flux à la façon d'un magazine. 

A partir de Leed une fois le thème installé et choisi, un lien "Affichage mode Magazine" apparait attention il est en 
haut de la page d'accueil pour l'instant c'est plus un raccourci pour tester. 

Partant de là, vous devrez alors choisir un Dossier, puis un Flux pour arriver jusqu'au billet ou article. 
Il s'agit dans ce thème uniquement de lecture façon magazine pas de possibilité d'agir.  

La liste de TODO est longue :

* implémenter la partie javascript pour navigation horizontale (Billet precedent ou suivant, Flux precedent ou suivant)
* mettre en place un système de cache afin de ne pas solliciter les chargements d'images pour tester les tailles
* debugguer le troncage de flux (les fonctions mises dans le plugin renvoient des messages d'erreur avec certains flux)
* [<a="https://github.com/fran6t/MagFonctions">fait voir plugin MagFonctions</a>] sortir les fonctions du coeur de Leed pour les mettre dans un Plugin
* mettre en grisé automatiquement les billet ou articles qui auront été lus 

Pour que le thème fonctionne il faut impérativement installer le plugin MagFontions qui posséde des fonctions 
de traitement PHP difficiles à placer dans un thème.
