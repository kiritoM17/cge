<?php

class CGE_Cpt_Formation
{
    const POSTTYPE = 'cpt_formation';

    const TAXONOMY_TYPE = 'formation_type';
    const TAXONOMY_ECOLE = 'formation_ecole';
    const TAXONOMY_CO_ACC = 'formation_co_accrediteurs';

    const TAXONOMY_DOMAIN = 'formations_domaines';
    const TAXONOMY_THEME = 'formations_themes';
    const TAXONOMY_CAT = 'formations_category';

    public $rewriteSlug = 'cpt_formation';
    public $rewriteSlugSingular = 'cpt_formation';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_formation',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['formation_type', 'formation_ecole', 'formation_co_accrediteurs', 'formations_domaines', 'formations_themes', 'formations_category'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        'id',
        'ecole_id',
        'ecole_acronyme',
        'ecole_nom',
        'co_accrediteurs',
        'langues_enseignements',
        'partenaires',
        'description_lieu_formation',
        'duree_formation_mois',
        'website',
        'directeur_responsable_ms_msc_badge_cqc',
        'responsable_academique',
        'voix_admission',
        'niveau_entree'
    ];

    /**
     * @var string
     */
    protected $meta_prefix = '_formation_';

    /**
     * @var string
     */
    public $singular_form_label;

    /**
     * @var string
     */
    public $plural_form_label;

    /**
     * Static Singleton Holder
     * @var self
     */
    protected static $instance;

    /**
     * Get (and instantiate, if necessary) the instance of the class
     *
     * @return self
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private $taxonomy_type_args = [];
    private $taxonomy_ecole_args = [];
    private $taxonomy_co_acc_args = [];

    private $taxonomy_domaines_args = [];
    private $taxonomy_themes_args = [];
    private $taxonomy_category_args = [];

    private $taxonomyTypeLabels = [];
    private $taxonomyEcoleLabels = [];
    private $taxonomyCoAccLabels = [];

    private $taxonomyDomainesLabels = [];
    private $taxonomyThemesLabels = [];
    private $taxonomyCategoryLabels = [];

    public $taxonomy_type_slug = 'formation_type';
    public $taxonomy_ecole_slug = 'formation_ecole';
    public $taxonomy_co_acc_slug = 'formation_co_accrediteurs';

    public $taxonomy_domaine_slug = 'formations_domaines';
    public $taxonomy_themes_slug = 'formations_themes';
    public $taxonomy_category_slug = 'category';
    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct()
    {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Formation', 'cge');
        $this->singular_form_label_lowercase = __('Formation', 'cge');
        $this->plural_form_label = __('Formations', 'cge');
        $this->plural_form_label_lowercase = __('Formations', 'cge');
        $this->post_type_args['rewrite']['slug'] = $this->rewriteSlug;
        $this->post_type_args['show_in_nav_menus'] = true;
        $this->post_type_args['public'] = true;
        $this->post_type_args['show_in_rest'] = false;
        /**
         * Provides an opportunity to modify the labels used for the form post type.
         *
         * @param array $args Array of arguments for register_post_type labels
         */
        $this->post_type_args['labels'] = [
            'menu_name' => __('CGE  Formation', 'cge'),
            'name' => $this->plural_form_label,
            'singular_name' => $this->singular_form_label,
            'singular_name_lowercase' => $this->singular_form_label_lowercase,
            'plural_name_lowercase' => $this->plural_form_label_lowercase,
            'add_new' => sprintf(__('Add New %s', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s', 'cge'), $this->singular_form_label),
            'new_item' => sprintf(__('New %s', 'cge'), $this->singular_form_label),
            'view_item' => sprintf(__('View %s', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s', 'cge'), $this->plural_form_label),
            'not_found' => sprintf(__('No %s found', 'cge'), strtolower($this->plural_form_label)),
            'not_found_in_trash' => sprintf(__('No %s found in Trash', 'cge'), strtolower($this->plural_form_label)),
            'item_published' => sprintf(__('%s published.', 'cge'), $this->singular_form_label),
            'item_published_privately' => sprintf(__('%s published privately.', 'cge'), $this->singular_form_label),
            'item_reverted_to_draft' => sprintf(__('%s reverted to draft.', 'cge'), $this->singular_form_label),
            'item_scheduled' => sprintf(__('%s scheduled.', 'cge'), $this->singular_form_label),
            'item_updated' => sprintf(__('%s updated.', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyTypeLabels = [
            'menu_name' => __('Type Formation', 'cge'),
            'name' => sprintf(__('%s Type Formation', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Type Formation', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Type Formation', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Type Formation', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Type Formation', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Type Formation:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Type Formation', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Type Formation', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Type Formation', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Type Formation Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Type Formation Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyEcoleLabels = [
            'menu_name' => __('Ecole', 'cge'),
            'name' => sprintf(__('%s Ecole', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Ecole', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Ecole', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Ecole', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Ecole', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Ecole:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Ecole', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Ecole', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Ecole', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Ecole Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Ecole Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyCoAccLabels = [
            'menu_name' => __('Co accréditeurs', 'cge'),
            'name' => sprintf(__('%s Co accréditeurs', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Co accréditeurs', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Co accréditeurs:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Co accréditeurs', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Co accréditeurs Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Co accréditeurs Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyDomainesLabels = [
            'menu_name' => __('Formation domaines', 'cge'),
            'name' => sprintf(__('%s Formation domaines', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Formation domaines', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Formation domaines', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Formation domaines', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Formation domaines', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Formation domaines:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Formation domaines', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Formation domaines', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Formation domaines', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Formation domaines Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Formation domaines Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyThemesLabels = [
            'menu_name' => __('Formation thèmes', 'cge'),
            'name' => sprintf(__('%s Formation thèmes', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Formation thèmes', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Formation thèmes', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Formation thèmes', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Formation thèmes', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Formation thèmes:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Formation thèmes', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Formation thèmes', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Formation thèmes', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Formation thèmes Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Formation thèmes Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];

        $this->taxonomyCategoryLabels = [
            'menu_name' => __('Categories', 'cge'),
            'name' => sprintf(__('%s Categories', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Categories', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Categories', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Categories', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Categories', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Categories:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Categories', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Categories', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Categories', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Categories Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Categories Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init()
    {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_category_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_category_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyCategoryLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_CAT, self::POSTTYPE, $this->taxonomy_category_args);

        $this->taxonomy_co_acc_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_co_acc_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyCoAccLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_CO_ACC, self::POSTTYPE, $this->taxonomy_co_acc_args);

        $this->taxonomy_domaines_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_domaine_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyDomainesLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_DOMAIN, self::POSTTYPE, $this->taxonomy_domaines_args);

        $this->taxonomy_themes_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_themes_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyThemesLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_THEME, self::POSTTYPE, $this->taxonomy_themes_args);

        $this->taxonomy_type_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_type_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyTypeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_TYPE, self::POSTTYPE, $this->taxonomy_type_args);

        $this->taxonomy_ecole_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_ecole_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyEcoleLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_ECOLE, self::POSTTYPE, $this->taxonomy_ecole_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('FormationCoAutorMetaBox', __('Editing Co accréditeursrediteurs', 'cge'), [$this, 'formationCoAuthorInformationMetaBox'], self::POSTTYPE);
        add_meta_box('FormationMetaBox', __('Editing Formation Informations', 'cge'), [$this, 'formationInformationMetaBox'], self::POSTTYPE);
    }

    public function formationInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/formation/information.php')) {
            include_once CGE_ADMIN_METABOX . '/formation/information.php';
        }
    }

    public function formationCoAuthorInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/formation/co-author-information.php')) {
            include_once CGE_ADMIN_METABOX . '/formation/co-author-information.php';
        }
    }

    public function find_formation()
    {
        $type = $_POST['type_formation'];
        $ecole = $_POST['ecole_formation'];
        $co_accrediteurs = $_POST['co_accrediteurs'];
        $formations_domaines = $_POST['formations_domaines'];
        $formations_themes = $_POST['formations_themes'];
        $mots = $_POST['mots'];


        $tax_query = array();
        $date_query = array();

        if ($type != "") {
            $tax_query[] = array(
                'taxonomy' => 'formation_type',
                'field' => 'slug',
                'terms' => $type, // Where term_id of Term 1 is "1".
                'include_children' => false
            );
        }

        if ($ecole != '' && $co_accrediteurs != '') {
            $tax_ecole['relation'] = 'OR';
            $tax_ecole[] = array(
                'taxonomy' => 'formation_ecole',
                'field' => 'slug',
                'terms' => $ecole, // Where term_id of Term 1 is "1".
                'include_children' => false
            );
            $tax_ecole[] = array(
                'taxonomy' => 'formation_co_accrediteurs',
                'field' => 'slug',
                'operator' => 'IN',
                'terms' => $co_accrediteurs, // Where term_id of Term 1 is "1".
                'include_children' => false
            );

            $tax_query[] = $tax_ecole;
        } else if ($ecole != '') {
            $tax_query[] = array(
                'taxonomy' => 'formation_ecole',
                'field' => 'slug',
                'terms' => $ecole, // Where term_id of Term 1 is "1".
                'include_children' => false
            );
        }


        if ($formations_domaines != "") {
            $tax_query[] = array(
                'taxonomy' => 'formations_domaines',
                'field' => 'slug',
                'terms' => $formations_domaines, // Where term_id of Term 1 is "1".
                'include_children' => false
            );
        }


        if ($formations_themes != "") {
            $tax_query[] = array(
                'taxonomy' => 'formations_themes',
                'field' => 'slug',
                'terms' => $formations_themes, // Where term_id of Term 1 is "1".
                'include_children' => false
            );
        }
        if ($type != '' && $ecole != '' && $formations_domaines != '' && $formations_themes != '') {
            $tax_query['relation'] = 'AND';
        }

        $args = array(
            'post_type' => 'cpt_formation',
            'posts_per_page' => -1
        );

        if (count($tax_query) >= 1) {
            $args['tax_query'] = $tax_query;
        }

        if (count($date_query) >= 1) {
            $args['date_query'] = $date_query;
        }
        $args['s'] = $mots;

        $args['order'] = 'DESC';
        $query = new WP_Query($args);
        //die(var_dump($query));
        $response = [];
        foreach ($query->posts as $post)
            $response[] = [
                'post' => $post,
                'post_meta' => get_post_custom($post->ID),
                'formation_type' => get_the_terms($post->ID, 'formation_type'),
                '_formation_co_accrediteurs' => get_post_meta($post->ID, "_formation_co_accrediteurs")[0]
            ];
        wp_send_json($response);
    }
}
