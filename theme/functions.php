<?php

/**
 * @package WordPress
 * @subpackage Timberland
 * @since Timberland 2.2.0
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

Timber\Timber::init();
Timber::$dirname    = array('views', 'blocks');
Timber::$autoescape = false; // cela supprime les <p> dans l'editeur

class Timberland extends Timber\Site
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('after_setup_theme', array($this, 'theme_supports'));
        add_filter('timber/context', array($this, 'add_to_context'));
        add_filter('timber/twig', array($this, 'add_to_twig'));
        add_action('block_categories_all', array($this, 'block_categories_all'));
        add_action('acf/init', array($this, 'acf_register_blocks'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_assets'));

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
        add_theme_support('post-thumbnails');// image a la une
        add_theme_support('title-tag');
        add_theme_support('editor-styles');

        add_action('after_setup_theme', function () {
            register_nav_menus([
                'primary_menu' => 'primary_menu',
                'footer' => 'Footer'
            ]);
        });
    }


    public function enqueue_assets()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_script('jquery');
        wp_dequeue_style('global-styles');

        $vite_env = 'production';

        if (file_exists(get_template_directory() . '/../config.json')) {
            $config   = json_decode(file_get_contents(get_template_directory() . '/../config.json'), true);
            $vite_env = $config['vite']['environment'] ?? 'production';
        }

        $dist_uri  = get_template_directory_uri() . '/assets/dist';
        $dist_path = get_template_directory() . '/assets/dist';
        $manifest  = null;

        if (file_exists($dist_path . '/.vite/manifest.json')) {
            $manifest = json_decode(file_get_contents($dist_path . '/.vite/manifest.json'), true);
        }

        if (is_array($manifest)) {
            if ($vite_env === 'production' || is_admin()) {
                $js_file = 'theme/assets/main.js';
                wp_enqueue_style('main', $dist_uri . '/' . $manifest[$js_file]['css'][0]);
                $strategy = is_admin() ? 'async' : 'defer';
                $in_footer = is_admin() ? false : true;
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

                wp_enqueue_style('prefix-editor-font', '//fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap');

                $editor_css_file = 'theme/assets/styles/editor-style.css';
                add_editor_style($dist_uri . '/' . $manifest[$editor_css_file]['file']);
            }
        }

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
    }
}
add_action('acf/init', 'cv_theme_acf_options_pages');

/**
 * Fonctions utilitaires pour valider les données ACF
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

// Hook pour afficher les erreurs dans l'admin
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
function acf_should_wrap_innerblocks($wrap, $name)
{
    return false;
}

add_filter('acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2);
