# plugin wordpress - version de base

NE FONCTIONNE PAS CORRECTEMENT
les medias ne se chargent pas correctement en mode grille - problème probable de choix des hook pour les chargements de fonctions

Ce plugin a été créé sur la base d'un plugin de Chris Knowles
 * voir http://premium.wpmudev.org/blog/create-presentations-in-wordpress-with-flowtime/
Ce plugin contient un color picker créé par Braad Martin ( https://github.com/BraadMartin )
==========
## pour générer des présentations produit satisfaisantes


==========
## changelog

V1.0

* In the settings page a checkbox may be used by a developer to display the contents of some arrays at the bottom of the setting page. 
* A settings page for the admin users lets her set some options for the plugin

V0-9
* yet another split among more files ! 
* uses either the templates in plugins /template directory or the theme's /template directory

V0-8 
* tests de pages d'options en cours

V0-7
* séparation du contenu en plusieurs fichiers
* internalisation OK (mais pas encore de fichier POT)
* style modifié
* templates modifiés
* dans le fichier principal du plugin, simplement ajout en ligne 93 de 'editor' dans les éléments supportés
	par la page. Comme ça, je peux créer un ordre d'affichage des produits dans le template archive.
	
V0-6 
Ergonomie de l'éditeur d'écran 
	-> titre = "le titre de cet écran"
	-> présentation dans laquelle s'insère l'écran et n° d'ordre de l'écran au dessus du contenu
	-> éditeur du contenu couleur azure pour se souvenir qu'on est dans un écran
Ergonomie de l'éditeur de présentations (pages produits)
	-> titre = "Le nom de ce produit"
	-> Baseline et résumé juste en dessous du titre
	-> éditeur du contenu couleur azure pour se souvenir qu'on est dans une page produit
	-> partie SEO du plugin de Yoast tout en bas de l'écran

V0-5
Le plugin fonctionne sur les sites CB et PP (et VP)
l'archive et la single présentation sont lisibles et fonctionnement correctement. 
C'est une version de travail à laquelle de nombreuses améliorations doivent être encore apportées

V0-4
Problème du reste du site blanc réglé. 
On peut créer des écrans correspondant à une page produit en brouillon seulement
Les sites s’affichent normalement
Si des templates single-presentation.php et archive-presentation.php sont placés dans un répertoire ald-presentation-template du thème utilisé, ce modèle est utilisé prioritairement. 
Il est possible de régler directement les paramètres de Yoast SEO en allant sur les pages de réglage des plugins. Voir https://docs.google.com/a/parcours-performance.com/document/d/1WU1odMO_bcHK9yA1TdummlGGoUqMXp1jK79Vd712-YE/edit#heading=h.ldjr897mle73


 V0-3 
 ATTENTION !!!! 
 Ne fonctionne pas correctement. Lorsqu'il est activé, le reste du site ne s'affiche pas correctement
 (page blanche) !!!
 Sinon, les améliorations sont : 
 Menu amélioré dans l'interface wordpress
 2 taxonomies spécifiques créées
 
 
 V0-2
 insérer une metabox pour la base line dans le custom post ‘présentation’ 
 générer une page de synthèse des présentations avec leur image, leur titre, leur extrait et leur baseline.
 
 V0-1
 crée une page de synthèse des présentations qui reprendrait déjà le titre et le résumé
 fonctionne bien : donne l'extrait s'il existe, un bout du contenu raccourci sinon

 V0 
 La version adaptée à mon cas du plugin original
 Permet de visualiser en une seule page les différents écrans. 
