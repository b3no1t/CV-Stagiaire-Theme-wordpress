<?php

/**
 * @package WordPress
 * @subpackage Timberland
 * @since Timberland 2.2.0
 *
 * Ce fichier configure les fonctionnalités du thème WordPress à l'aide de Timber pour la création de templates.
 * Il crée des pages d'options personnalisées pour gérer le contenu du CV (onglet 'Mon CV' dans l'admin).
 * Il inclut la validation des informations requises pour le CV.
 * Il configure l'optimisation des images et la prise en charge responsive.
 * Il enregistre les tailles d'images personnalisées et les configurations de blocs.
 *
 * Structure du fichier
 * Initialiser la configuration du thème
 * Créer des pages d'administration
 * Valider le contenu
 * Optimiser les performances
 * Ajouter des fonctionnalités personnalisées
 *
 */

// Include Composer's autoloader for managing PHP dependencies
require_once dirname(__DIR__) . '/vendor/autoload.php';

Timber\Timber::init();
Timber::$dirname    = array('views', 'blocks'); // les dossiers de vue
Timber::$autoescape = false; // cela supprime les <p> dans tinymce

class Timberland extends Timber\Site
{
     /**
     * Constructeur de la classe Timberland
     *
     * Cette fonction initialise toutes les actions et filtres WordPress nécessaires
     * au bon fonctionnement du thème.
     *
     * @return void
     */
    public function __construct()
    {
        // Enregistre les styles et scripts du thème
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        // Configure les fonctionnalités supportées par le thème
        add_action('after_setup_theme', array($this, 'theme_supports'));
        // Ajoute des variables au contexte Timber
        add_filter('timber/context', array($this, 'add_to_context'));
        // Personnalise l'environnement Twig
        add_filter('timber/twig', array($this, 'add_to_twig'));
        // Ajoute une catégorie de blocs personnalisés
        add_action('block_categories_all', array($this, 'block_categories_all'));
        // Enregistre les blocs ACF personnalisés
        add_action('acf/init', array($this, 'acf_register_blocks'));
        // Charge les assets dans l'éditeur de blocs
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_assets'));
        // Appelle le constructeur parent
        parent::__construct();
    }



    public function add_to_context($context)
    {
        $context['site']    = $this;
        $context['menu']    = Timber::get_menu();
        $context['primary_menu'] = Timber::get_menu('primary_menu');
        $context['footer']  = Timber::get_menu('footer');

        // Require block functions files
        foreach (glob(__DIR__ . '/blocks/*/functions.php') as $file) {
            require_once $file;
        }

        // Récupération des options ACF
        // get_fields('option') récupère TOUS les champs des pages d'options
        $context['theme_options'] = get_fields('option');

        // Récupération spécifique par groupe (optionnel)
        $context['personal_info'] = get_field('personal_info', 'option');
        $context['skills'] = get_field('skills_categories', 'option');
        $context['experiences'] = get_field('experiences', 'option');

        return $context;
    }

    public function add_to_twig($twig)
    {
        return $twig;
    }

    public function theme_supports()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        add_theme_support('menus');
        add_theme_support('post-thumbnails');// image de presentation
        add_theme_support('title-tag');
        add_theme_support('editor-styles');

        add_action('after_setup_theme', function () {
            register_nav_menus([
                'primary_menu' => 'primary_menu',
                'footer' => 'Footer'
            ]);
        });
    }

/**
    * Désactive les styles et scripts WordPress par défaut superflus
    * Configure l'environnement de développement (production/développement)
    * Charge les ressources (CSS, JS) via un manifeste Vite
    * Gère différemment le chargement des scripts en admin et sur le front
    * Charge les scripts de développement localement si nécessaire
 */
    public function enqueue_assets()
    {
        // ! Désactive les styles et scripts WordPress par défaut qui ne sont pas nécessaires
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_script('jquery');
        wp_dequeue_style('global-styles');

        $vite_env = 'production';

        // ! Vérifie s'il existe un fichier de configuration pour surcharger l'environnement
        if (file_exists(get_template_directory() . '/../config.json')) {
            $config   = json_decode(file_get_contents(get_template_directory() . '/../config.json'), true);
            $vite_env = $config['vite']['environment'] ?? 'production';
        }

         // ! Définit les chemins vers les ressources du thème
        $dist_uri  = get_template_directory_uri() . '/assets/dist';
        $dist_path = get_template_directory() . '/assets/dist';
        $manifest  = null;

        // ! Charge le manifeste Vite s'il existe
        if (file_exists($dist_path . '/.vite/manifest.json')) {
            $manifest = json_decode(file_get_contents($dist_path . '/.vite/manifest.json'), true);
        }


        // ! Gère l'inclusion des assets en production ou dans l'administration
        if (is_array($manifest)) {
            if ($vite_env === 'production' || is_admin()) {
                // Chemin du fichier JavaScript principal
                $js_file = 'theme/assets/main.js';
                // Charge le CSS associé
                wp_enqueue_style('main', $dist_uri . '/' . $manifest[$js_file]['css'][0]);
                // Détermine la stratégie de chargement du script
                $strategy = is_admin() ? 'async' : 'defer';
                $in_footer = is_admin() ? false : true;
                // Charge le script principal
                wp_enqueue_script(
                    'main',
                    $dist_uri . '/' . $manifest[$js_file]['file'],
                    array(),
                    '',
                    array(
                        'strategy'  => $strategy,
                        'in_footer' => $in_footer,
                    )
                );
                // Charge les polices Google
                wp_enqueue_style('prefix-editor-font', '//fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap');
                // Charge les styles de l'éditeur
                $editor_css_file = 'theme/assets/styles/editor-style.css';
                add_editor_style($dist_uri . '/' . $manifest[$editor_css_file]['file']);
            }
        }
        // En environnement de développement, charge les scripts Vite directement
        if ($vite_env === 'development') {
            function vite_head_module_hook()
            {
                echo '<script type="module" crossorigin src="http://localhost:3000/@vite/client"></script>';
                echo '<script type="module" crossorigin src="http://localhost:3000/theme/assets/main.js"></script>';
            }
            add_action('wp_head', 'vite_head_module_hook');
        }
    }

    public function block_categories_all($categories)
    {
        return array_merge(
            array(
                array(
                    'slug'  => 'custom',
                    'title' => __('Custom'),
                ),
            ),
            $categories
        );
    }

    public function acf_register_blocks()
    {
        $blocks = array();

        foreach (new DirectoryIterator(__DIR__ . '/blocks') as $dir) {
            if ($dir->isDot()) {
                continue;
            }

            if (file_exists($dir->getPathname() . '/block.json')) {
                $blocks[] = $dir->getPathname();
            }
        }

        asort($blocks);

        foreach ($blocks as $block) {
            register_block_type($block);
        }
    }
}

new Timberland();

/**
 * Utilise le filtre timmy/sizes pour personnaliser les tailles d'images
 * Crée une taille d'image personnalisée appelée 'medium-custom'
 * Redimensionne les images à 650 pixels de large
 * Génère un srcset pour les écrans haute résolution
 * Définit un comportement responsive basé sur la largeur de l'écran
 * Limite l'utilisation de cette taille aux pages d'options
*/
add_filter( 'timmy/sizes', function( $sizes ) {
    return array(
        'medium-custom' => array(
            'resize' => array( 650 ),
            'srcset' => array( 2 ),
            'sizes' => '(min-width: 992px) 33.333vw, 100vw',
            'name' => 'Width 1/4 fix',
            'post_types' => array( 'option', 'option' ),
        ),
    );
} );

function acf_block_render_callback($block, $content)
{
    $context           = Timber::context();
    $context['post']   = Timber::get_post();
    $context['block']  = $block;
    $context['fields'] = get_fields();
    $block_name        = explode('/', $block['name'])[1];
    $template          = 'blocks/' . $block_name . '/index.twig';

    Timber::render($template, $context);
}

/**
 * * Créer des pages d'options ACF pour la configuration du CV
 * * Ajoute des pages d'administration personnalisées pour gérer le contenu du CV
 */
function cv_theme_acf_options_pages() {
    // Vérification qu'ACF est actif
    if (function_exists('acf_add_options_page')) {

        // Page principale des options
        acf_add_options_page(array(
            'page_title' => 'Configuration du CV',
            'menu_title' => 'Mon CV',
            'menu_slug'  => 'cv-options',
            'capability' => 'edit_posts',
            'icon_url'   => 'dashicons-id-alt',
            'position'   => 2,
        ));

        // Sous-pages pour organiser les options
        acf_add_options_sub_page(array(
            'page_title'  => 'Informations personnelles',
            'menu_title'  => 'Infos personnelles',
            'parent_slug' => 'cv-options',
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Compétences',
            'menu_title'  => 'Compétences',
            'parent_slug' => 'cv-options',
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Expériences',
            'menu_title'  => 'Expériences',
            'parent_slug' => 'cv-options',
        ));

        // ... (other subpages)

    }
}
add_action('acf/init', 'cv_theme_acf_options_pages');

/**
 * Validation des data du CV
 * Vérifie si les data essentielles sont completes
 */
function validate_cv_data() {
    $errors = array();

    // Validation des informations essentielles
    if (!get_field('profile_photo', 'option')) {
        $errors[] = 'Photo de profil manquante';
    }

    if (!get_field('about_text', 'option')) {
        $errors[] = 'Texte de présentation manquant';
    }

    // Validation des compétences
    $skills = get_field('skills_categories', 'option');
    if (!$skills || empty($skills)) {
        $errors[] = 'Aucune compétence définie';
    }

    return $errors;
}

//
/**
 * ! Hook pour afficher une notif  dans l'admin
 * * Afficher les erreurs de validation dans l'interface d'administration
 * * Affiche des avertissements si la configuration du CV est incomplète
 */
function display_cv_validation_errors() {
    $errors = validate_cv_data();
    if (!empty($errors)) {
        echo '<div class="notice notice-warning"><p>';
        echo '<strong>Configuration du CV incomplète :</strong><br>';
        echo implode('<br>', $errors);
        echo '</p></div>';
    }
}
add_action('admin_notices', 'display_cv_validation_errors');


/**

/**
 * Lazy loading pour les images
 */
function add_lazy_loading($content) {
    // Ajouter loading="lazy" à toutes les images
    $content = str_replace('<img', '<img loading="lazy"', $content);
    return $content;
}
add_filter('the_content', 'add_lazy_loading');


/**
 * Optimisation des images
 */
function add_responsive_images_support() {
    // Support des images responsive
    add_theme_support('responsive-embeds');

    // Tailles d'images personnalisées
    add_image_size('project-thumb', 400, 300, true);
    add_image_size('hero-bg', 1920, 1080, true);
    add_image_size('profile-photo', 300, 300, true);
}
add_action('after_setup_theme', 'add_responsive_images_support');

// Remove ACF block wrapper div
/**
 *  * Supprimer la balise ACF Block Wrapper Div
 *  * Empêche l'encapsulation inutile des blocs internes
 */
function acf_should_wrap_innerblocks($wrap, $name)
{
    return false;
}

add_filter('acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2);
