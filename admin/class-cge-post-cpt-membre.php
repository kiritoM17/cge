<?php

class CGE_CPT_MEMBRE
{
    const POSTTYPE = 'cge_membre';

    const TAXONOMY_EVENT_TYPE = 'cge_membre_type';

    public $rewriteSlug = 'cge_membre';
    public $rewriteSlugSingular = 'cge_membre';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cge_membre',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['cge_membre_type'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_cge_membre_type',
        '_cge_membre_organisme',
        '_cge_membre_url'
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

    private $taxonomy_cge_membre_type_args = [];

    private $taxonomyCgeMembreTypeLabels = [];

    public $taxonomy_cge_membre_type_slug = 'cge_membre_type';
    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct()
    {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('CGE Membre', 'cge');
        $this->singular_form_label_lowercase = __('CGE Membre', 'cge');
        $this->plural_form_label = __('CGE Membres', 'cge');
        $this->plural_form_label_lowercase = __('CGE Membres', 'cge');
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
            'menu_name' => __('CGE Membre', 'cge'),
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

        $this->taxonomyCgeMembreTypeLabels = [
            'menu_name' => __('Type', 'cge'),
            'name' => sprintf(__('%s Type', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Type', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Type', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Type', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Type', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Type:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Type', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Type', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Type', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Type Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Type Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init()
    {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_cge_membre_type_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_cge_membre_type_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyCgeMembreTypeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        //register_taxonomy(self::TAXONOMY_EVENT_TYPE, self::POSTTYPE, $this->taxonomy_cge_membre_type_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('MembreTypeMetaBox', __('Editing Membre Type Informations', 'cge'), [$this, 'membreTypeInformationMetaBox'], self::POSTTYPE); //, 'side', 'high'
        add_meta_box('MembreMetaBox', __('Editing Membre organismes Informations', 'cge'), [$this, 'membreInformationMetaBox'], self::POSTTYPE);
    }

    public function membreTypeInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/membre/type.php')) {
            include_once CGE_ADMIN_METABOX . '/membre/type.php';
        }
    }

    public function membreInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/membre/information.php')) {
            include_once CGE_ADMIN_METABOX . '/membre/information.php';
        }
    }

    /**
     * @param $post_id
     */
    public function save_meta($post_id)
    {
        $e_torisme_form = get_post($post_id);
        if ($e_torisme_form->post_type == self::POSTTYPE) {
            $data = (isset($_POST['Membre']) && !empty($_POST['Membre'])) ? $_POST['Membre'] : [];
            if (isset($data['FeaturedImage'])) {
                if (empty($data['FeaturedImage'])) {
                    delete_post_meta($post_id, '_thumbnail_id');
                } else {
                    update_post_meta($post_id, '_thumbnail_id', $data['FeaturedImage']);
                }
                unset($data['FeaturedImage']);
            }
            unset($data['Membre']);
            foreach (self::$valid_form_metabox_keys as $value) {
                update_post_meta($post_id, $this->meta_prefix . $value, (isset($data[$value]) && !empty($data[$value])) ? $data[$value] : null);
            }
        }
    }
}
