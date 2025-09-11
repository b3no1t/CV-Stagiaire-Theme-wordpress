# Custom Post Type

## 📚 Lexique Technique Détaillé

**Custom Post Type (CPT)**: Extension native de WordPress permettant de créer des types de contenu personnalisés au-delà des articles et pages par défaut. Ils offrent une structure de données spécialisée pour organiser différents types d'informations (portfolios, témoignages, produits, événements).
**Post Type** : Dans WordPress, classification fondamentale du contenu qui détermine la structure, les fonctionnalités et l'affichage des éléments. WordPress inclut par défaut les types "post" (article), "page", "attachment" (média), "revision" et "nav_menu_item".
**register_post_type()** : Fonction WordPress core qui enregistre un nouveau type de contenu personnalisé dans le système. Cette fonction configure tous les paramètres de comportement, d'affichage et de fonctionnalité du CPT.
**Métadonnées (Meta)**: Informations supplémentaires associées à un post, stockées dans la table *wp_postmeta*. Elles permettent d'enrichir les contenus avec des données structurées spécifiques au type de contenu.
**Slug** : Identifiant URL-friendly utilisé pour référencer le post type dans les permaliens et les requêtes. Il doit être unique et respecter les conventions de nommage WordPress.
**Capability** : Système de permissions WordPress qui détermine les actions autorisées pour chaque rôle utilisateur sur un type de contenu spécifique.
**Supports** : Ensemble de fonctionnalités WordPress qu'un post type peut utiliser (éditeur, image à la une, extrait, commentaires, révisions).

---

## 🎯 Compréhension Conceptuelle : L'Analogie du Classeur de Bureau

Imaginez WordPress comme un système de classement de bureau traditionnel.
Par défaut, vous disposez de deux types de classeurs : un pour les articles (actualités, blog) et un pour les pages (informations statiques).

Un *Custom Post Type* équivaut à créer un nouveau type de classeur spécialisé.
Si vous gérez une agence, vous pourriez avoir besoin d'un classeur dédié aux projets, un autre pour les témoignages clients, et un troisième pour les membres de l'équipe.
Chaque classeur a ses propres caractéristiques : format des fiches, informations à collecter, organisation interne.
Cette spécialisation permet une organisation logique et efficace, où chaque **type de contenu dispose de sa propre structure**, ses propres champs et ses propres règles d'affichage.

[Documentation Officielle](https://developer.wordpress.org/themes/template-files-section/custom-post-type-template-files/)
[Enregistrer un CPT](https://developer.wordpress.org/reference/functions/register_post_type/)
