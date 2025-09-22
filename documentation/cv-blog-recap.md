# Thème WordPress pour un C.V de Développeur, extensible avec Timber et ACF. Mise à l'échelle possible pour un éventuel blog de développeur.

> Stack: WordPress, Composer, Timber (Twig), ACF, Tailwind CSS, WAMP

## 1. Introduction au Développement d'un Portfolio WordPress Moderne

- Vue d'ensemble de la structure du thème et de son organisation
- Comprendre le système de templates WordPress + Timber (Twig)
- Structure des fichiers et composants importants

## 2. Intégration Advanced Custom Fields (ACF)

- Comprendre les fichiers ACF **JSON** (`acf-json/acf-export-2025-09-08.json`, `group_68b847e93c1e6.json`, etc.)
- Explorer la structure des champs personnalisés :
  - Catégories de compétences
  - Outils et technologies de projet
  - Champs pour la chronologie des expériences

## 3. Développement Frontend avec CSS et Tailwind

- Variables CSS et **thématisation** (`theme/assets/styles/theme.css`)
- Systèmes typographiques (`theme/assets/styles/base/typography.css`)
- Principes de design responsive avec tailwindcss
- Utilisation des utilitaires Tailwind pour la mise en page et le style

## 4. Templates Twig pour WordPress

- Hiérarchie des templates dans le thème
- Aperçu des templates principaux :
  - `index.twig` - La page d'accueil/mise en page du CV
  - `single-project.twig` - Page de présentation de projet
  - Organisation des partiels et des sections

## 5. Création d'un CV/Portfolio de Développeur

- Création de la section "À propos de moi" (`sections/about.twig`)
- Construction de la chronologie de formation (`sections/education.twig`)
- Présentation des expériences avec une timeline visuelle (`sections/experience.twig`)
- Affichage des compétences avec représentations visuelles (`sections/skills.twig`)

## 6. Développement de Présentation de Projets

- Comprendre la structure de données des projets
- Créer des pages de projets attrayantes (`single-project.twig`)
- Afficher les technologies et outils utilisés dans les projets

## 7. Validation des Données et Contrôle Qualité

- Implémentation de la validation des données (`validate_cv_data()` dans `functions.php`)
- S'assurer que toutes les informations de profil requises sont présentes

## 8. Thématisation et Personnalisation

- Personnalisation des couleurs, typographie et espacement
- Création de variations de thème (mode clair/sombre)
- Personnalisation du thème pour des portfolios individuels

## 9. Optimisation des Performances

- Organisation et optimisation CSS
- Gestion et optimisation des images
- Considérations responsive

## 10. Projet Final : Portfolio Personnel de Développeur

- Construire votre propre CV/portfolio basé sur le thème
- Personnaliser le thème pour mettre en valeur votre style personnel
- Ajouter vos projets, compétences et expériences

Cette structure de cours suit l'organisation du thème et aiderait les développeurs juniors à comprendre à la fois les modèles de développement WordPress et comment créer un site web de portfolio de développeur efficace.

Le thème un système de portfolio bien structuré avec des sections pour afficher les compétences, l'expérience, la formation et les projets, avec un accent mis sur un design épuré et une bonne organisation des informations du développeur.

> **note:** Un CV de developper est différent d'un blog de developper.
> Un CV est plus statique et centré sur les informations personnelles et professionnelles, tandis qu'un blog est dynamique et centré sur le contenu régulier.
> Un CV / Blog de dév ne dois pas etre obligatoirement *'design'* l'employeur lira le code source afin de connaitre votre agilité à coder et commenter proprement. Mettre l'importance sur votre qualité de code alors que le design, devrait faire ressentir (look n feel) le sérieux et l'organisation de l'information.
> Ce thème est conçu principalement pour un CV, mais il peut être étendu pour inclure des fonctionnalités de blog si nécessaire.

happy coding ! :)
