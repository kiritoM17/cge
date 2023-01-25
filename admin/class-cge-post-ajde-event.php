<?php

class CGE_Ajde_Events
{
    const POSTTYPE = 'ajde_events';

    const TAXONOMY_EVENT_TYPE = 'event_type';
    const TAXONOMY_EVENT_LOCATION = 'event_location';

    public $rewriteSlug = 'ajde_events';
    public $rewriteSlugSingular = 'ajde_events';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'ajde_events',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['event_type', 'event_location'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_cge_event_id',
        'evcal_srow',
        'event_year',
        '_event_month',
        'evcal_erow',

        '_evcal_ec_f1a1_cus',
        '_evcal_ec_f1a1_cusL',

        '_sch_blocks',

        // 'duree_formation_mois',
        // 'website',
        // 'directeur_responsable_ms_msc_badge_cqc',
        // 'responsable_academique',
        // 'voix_admission',
        // 'niveau_entree'
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

    private $taxonomy_event_type_args = [];
    private $taxonomy_event_location_args = [];
    
    private $taxonomyEventTypeLabels = [];
    private $taxonomyEventLocationLabels = [];

    public $taxonomy_event_type_slug = 'event_type';
    public $taxonomy_event_location_slug = 'event_location';
    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct()
    {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Event', 'cge');
        $this->singular_form_label_lowercase = __('Event', 'cge');
        $this->plural_form_label = __('Events', 'cge');
        $this->plural_form_label_lowercase = __('Events', 'cge');
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
            'menu_name' => __('CGE  Event', 'cge'),
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

        $this->taxonomyEventTypeLabels = [
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

        $this->taxonomyEventLocationLabels = [
            'menu_name' => __('Location', 'cge'),
            'name' => sprintf(__('%s Location', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Location', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Location', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Location', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Location', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Location:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Location', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Location', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Location', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Location Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Location Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init()
    {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_event_type_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_event_type_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyEventTypeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_EVENT_TYPE, self::POSTTYPE, $this->taxonomy_event_type_args);

        $this->taxonomy_event_location_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_event_location_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyEventLocationLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_EVENT_LOCATION, self::POSTTYPE, $this->taxonomy_event_location_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('EventMetaBox', __('Editing Event Informations', 'cge'), [$this, 'eventInformationMetaBox'], self::POSTTYPE);
    }

    public function eventInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/event/information.php')) {
            include_once CGE_ADMIN_METABOX . '/event/information.php';
        }
    }
}
