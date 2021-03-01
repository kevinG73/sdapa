# SDAPA
## Système de gestion des points d'admissibilités en master 1

 ### class 
 contient toutes les classes nécessaires aux fonctionnement de etudiants et inscriptions .

### database
contient le fichier sql pour la base de donnée sdapa

### fonctions
contient les fonctions de recherche du projet

### pages
contient toutes les pages du sites excéptés la page de connexion

### vendor
contient toutes les bibliothèques du projet


### Utilisateurs
````sql
SELECT e.nom_etablissement , d.nom_departement, g.libelle_groupe_utilisateur , u.login_utilisateur , u.mot_passe_utilisateur    FROM utilisateur_sdapa u 
JOIN etablissement e ON e.id_etablissement = u.id_etablissement
JOIN departement d ON d.id_departement = u.id_departement
JOIN groupe_utilisateur g ON g.id_groupe_utilisateur = u.id_groupe_utilisateur
WHERE  u.id_groupe_utilisateur IN (14,19,20)
````