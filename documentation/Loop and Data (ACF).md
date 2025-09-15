# Loop and Data (ACF/Twig)

**Timber 2** : Framework PHP moderne pour WordPress utilisant Twig, version majeure apportant une architecture PSR-4, une meilleure séparation des responsabilités et des performances optimisées. Contrairement à Timber 1.x, la version 2 introduit des classes dédiées et une structure orientée objet plus rigoureuse.

**Custom Post Type (CPT)** : Type de contenu personnalisé dans WordPress, permettant de créer des structures de données spécifiques (ex: "Produits", "Témoignages")

**Contrôleur** : Dans l'architecture MVC, fichier PHP gérant la logique métier et préparant les données pour les templates.

**Context** : En Timber, tableau associatif contenant toutes les données disponibles dans le template Twig

---

## Workaround

### 1 - ACF

- create a Custom Post Type
- create a Custom Fields (the content of the C.P.T)

### 2 - PHP

- create a Query to get data from C.P.T

### 3 - Twig

- Create loop to retrieve data from the query
