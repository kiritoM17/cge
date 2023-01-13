<?php

class CGE_Cpt_Formation
{
    const POSTTYPE = 'cpt_formation';
    const TAXONOMY = 'cpt_formation_cat';

    public $rewriteSlug = 'cpt_formation';
    public $rewriteSlugSingular = 'cpt_formation';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_formation',
            'with_front' => false
        ],
        'show_ui' => true,
        //'show_in_menu' => 'admin.php?page=cge-admin-menu',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['cpt_formation_cat'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-store',
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
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private $taxonomy_args = [];

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct() {
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
            'menu_name' => __('Formation', 'cge'),
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
    }

    public function init() {
        register_post_type(self::POSTTYPE, $this->post_type_args);
        // register_taxonomy(self::TAXONOMY, self::POSTTYPE, $this->taxonomy_args);

        // $this->taxonomyLabels = [
        //     'menu_name' => __('Categories', 'cge'),
        //     'name' => sprintf(__('%s Category', 'cge'), $this->singular_form_label),
        //     'singular_name' => sprintf(__('%s Category', 'cge'), $this->singular_form_label),
        //     'search_items' => sprintf(__('Search %s Categories', 'cge'), $this->singular_form_label),
        //     'all_items' => sprintf(__('All %s Categories', 'cge'), $this->singular_form_label),
        //     'parent_item' => sprintf(__('Parent %s Category', 'cge'), $this->singular_form_label),
        //     'parent_item_colon' => sprintf(__('Parent %s Category:', 'cge'), $this->singular_form_label),
        //     'edit_item' => sprintf(__('Edit %s Category', 'cge'), $this->singular_form_label),
        //     'update_item' => sprintf(__('Update %s Category', 'cge'), $this->singular_form_label),
        //     'add_new_item' => sprintf(__('Add New %s Category', 'cge'), $this->singular_form_label),
        //     'new_item_name' => sprintf(__('New %s Category Name', 'cge'), $this->singular_form_label),
        //     'item_link' => sprintf(__('%s Category Link', 'cge'), $this->singular_form_label),
        //     'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        // ];

        // $this->taxonomy_args = [
        //     'hierarchical' => true,
        //     'update_count_callback' => '',
        //     'rewrite' => [
        //         'slug' => $this->rewriteSlug . '/' . $this->category_slug,
        //         'with_front' => false,
        //         'hierarchical' => true,
        //     ],
        //     'public' => true,
        //     'show_ui' => true,
        //     'labels' => $this->taxonomyLabels,
        //     'capability_type' => 'post',
        //     'public' => true,
        //     'show_ui' => true,
        //     'show_in_nav_menu' => true,
        // ];
        // register_taxonomy(self::TAXONOMYCAT, self::POSTTYPE, $this->taxonomy_args);
        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('FormationCoAutorMetaBox', __('Editing Formation Co Accrediteurs', 'cge'), [$this, 'formationCoAuthorInformationMetaBox'], self::POSTTYPE);
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
}