<?php
/**
 * @package WordPress
 * @subpackage Timberland
 * @since Timberland 2.2.0
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

// Méthode Timber - Simple et élégante
$projects = Timber::get_posts([
    'post_type' => 'project',           // On spécifie le type de contenu custom
    'category_name' => 'Projects',       // Nom de la catégorie (slug ou nom)
    'posts_per_page' => -1,             // -1 = tous les posts, sinon limite numérique
    'post_status' => 'publish'          // Seulement les posts publiés
]);

$context['projects'] = $projects;



// Récupération les related projects (3 projets aléatoires dans les mêmes catégories)
// composant à créer pour gérer ça ?
// https://timber.github.io/docs/v2/guides/related-posts/
$context['related_projects'] = Timber::get_posts([
    'post_type' => 'project',
    'posts_per_page' => 3,
    'post__not_in' => [$timber_post->ID],
    'tax_query' => [
        [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => wp_get_post_terms( $timber_post->ID, 'category', ['fields' => 'ids'] ),
        ],
    ],
]);
if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
