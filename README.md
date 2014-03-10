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
* implémenter la partie javascript pour navigation horizontale
* mettre en place un système de cache afin de ne pas solliciter les chargements d'images pour tester les tailles
* debugguer le troncage de flux
* trouver un système ou un arrangement pour mettre les fonctions necessaires au thème dans le coeur de Leed (dans l'immédiat il a été recopié le fichier modifié Functions.class.php dans le repertoire mag du thème. 
* mettre en grisé automatiquement les billet ou articles qui auront été lus 

Pour que le thème fonctionne il faut donc faire une sauvegarde du fichier Functions.class.php qui est à la racine de votre Leed et le remplacer par celui du thème.  
