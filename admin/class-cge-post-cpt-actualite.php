<?php

class CGE_Cpt_Actualite
{
    const POSTTYPE = 'cpt_actualite';

    const TAXONOMY_CAT = 'actualite_category';
    const TAXONOMY_TAG = 'actualite_post_tag';

    public $rewriteCatSlug = 'actualite_category';
    public $rewriteTagSlug = 'actualite_post_tag';

    private $taxonomy_cat_args = [];
    private $taxonomy_tag_args = [];

    private $taxonomyCatLabels = [];
    private $taxonomyTagLabels = [];

    public $rewriteSlugSingular = 'cpt_actualite';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_actualite',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['actualite_category', 'actualite_post_tag'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_custom_post_type_onomies_relationship',
    ];

    /**
     * @var string
     */
    protected $meta_prefix = '';

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



    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct()
    {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Actualité', 'cge');
        $this->singular_form_label_lowercase = __('Actualité', 'cge');
        $this->plural_form_label = __('Actualités', 'cge');
        $this->plural_form_label_lowercase = __('Actualités', 'cge');
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
            'menu_name' => __('CGE Actualité', 'cge'),
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

        $this->taxonomyCatLabels = [
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

        $this->taxonomyTagLabels = [
            'menu_name' => __('Tags', 'cge'),
            'name' => sprintf(__('%s Tags', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Tags', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Tags', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Tags', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Tags', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Tags:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Tags', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Tags', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Tags', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Tags Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Tags Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init()
    {
        register_post_type(self::POSTTYPE, $this->post_type_args);


        $this->taxonomy_cat_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->rewriteCatSlug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyCatLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_CAT, self::POSTTYPE, $this->taxonomy_cat_args);

        $this->taxonomy_tag_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->rewriteTagSlug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyTagLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_TAG, self::POSTTYPE, $this->taxonomy_tag_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        //add_meta_box('cptActualiteMetaBox', __('Editing Actualité Informations', 'cge'), [$this, 'cptActualiteInformationMetaBox'], self::POSTTYPE);
    }

    public function cptActualiteInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/cpt_actualite/information.php')) {
            include_once CGE_ADMIN_METABOX . '/cpt_actualite/information.php';
        }
    }
}
