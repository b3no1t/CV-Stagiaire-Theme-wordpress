<?php
/**
 * Template pour la catégorie Projects (par ID)
 * Remplace {ID} par l'ID réel de ta catégorie
 * Exemple: category-5.php
 */

$context       = Timber::context();
$timber_post   = Timber::get_post();

// Les posts sont automatiquement récupérés par WordPress
// $context['posts'] = new Timber\PostQuery();
// $context['category'] = get_queried_object();

$args = Timber::get_posts( [
    'post_type' => array( 'project' ),
] );
$context['posts'] = new Timber\Archives( $args );

$context['posts'] = Timber::get_posts( [ 'post_type' => 'project' ]);

$context['page_slug'] = get_post_field('post_name', get_queried_object_id());

// Pagination native deprecated v2
// todo find the way to do paginations
// $context['pagination'] = Timber::get_pagination();

Timber::render('category-projects.twig', $context);
