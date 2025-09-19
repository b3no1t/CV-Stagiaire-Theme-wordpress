<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package WordPress
 * @subpackage Timberland
 * @since Timberland 2.2.0
 */

$context   = Timber::context();


// ! Récupération des articles (pour le blog éventuel)
// $context['posts'] = Timber::get_posts();
// $context['posts']   = new Timber\PostQuery();


// query toutes les pages options
// Récupération des options ACF
// get_fields('option') récupère TOUS les champs des pages d'options
$context['theme_options'] = get_fields('option');
// Récupération spécifique par groupe (optionnel)
$context['personal_info'] = get_field('personal_info', 'option');
$context['skills']        = get_field('skills_categories', 'option');
$context['experiences']   = get_field('experiences', 'option');
$context['competences']   = get_field('competences', 'option');


// Méthode Timber - Simple et élégante
$projects = Timber::get_posts([
    'post_type' => 'project',           // On spécifie le type de contenu custom
    'category_name' => 'Projects',       // Nom de la catégorie (slug ou nom)
    'posts_per_page' => -1,             // -1 = tous les posts, sinon limite numérique
    'post_status' => 'publish'          // Seulement les posts publiés
]);

$context['projects'] = $projects;

// La date en cours
$timestamp = time();
$datetime_object = current_datetime();
$formatted_date = $datetime_object->format('Ymd');
$formatted_date = wp_date('Ymd');



$templates = array( 'index.twig' );

if ( is_home() ) {
	array_unshift( $templates, 'front-page.twig', 'home.twig' );
}

Timber::render( $templates, $context );
