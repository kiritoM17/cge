<?php

class CGE_Msalumni
{
    const POSTTYPE = 'msalumni';
    const TAXONOMY = 'msalumni_cat';

    public $rewriteSlug = 'msalumni';
    public $rewriteSlugSingular = 'msalumni';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'msalumni',
            'with_front' => false
        ],
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => [],
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
        'nom',
        'prenom',
        'ecole',
        'id_ecole',
        'formation',
        'annee_obtention',
        'id_formation',
    ];

    /**
     * @var string
     */
    protected $meta_prefix = ''; //_msalumni_

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

    private $taxonomy_args = [];

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct()
    {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Diplomé', 'cge');
        $this->singular_form_label_lowercase = __('Diplomé', 'cge');
        $this->plural_form_label = __('Diplomés', 'cge');
        $this->plural_form_label_lowercase = __('Diplomés', 'cge');
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
            'menu_name' => __('Diplomé', 'cge'),
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

    public function init()
    {
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
        add_meta_box('MsalumniMetaBox', __('Editing Msalumni Informations', 'cge'), [$this, 'msalumniInformationMetaBox'], self::POSTTYPE);
    }

    public function msalumniInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/msalumni/information.php')) {
            include_once CGE_ADMIN_METABOX . '/msalumni/information.php';
        }
    }

    public function find_msalumini()
    {
        $annee = $_POST['annee'];
        $nom = $_POST['nom'];
    
        $tax_query = array();
        $date_query = array();
    
    
        if ($nom != "") {
            $tax_query[] = array(
                'key' => 'nom_ms',
                'compare' => 'like',
                'value' => $nom,
            );
        }
        if (count($tax_query) >= 1) {
            $args['meta_query'] = $tax_query;
        }
    
    
        $args = array(
            'post_type' => 'msalumni',
            'posts_per_page' => -1
        );
    
        $today = date('Ymd');
    
        $args['order'] = 'DESC';
    
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $response = [];
            foreach ($query->posts as $post)
                $response[] = [
                    'post' => $post,
                    'post_meta' => get_post_custom($post->ID),
                    // 'formation_type' => get_the_terms($post->ID, 'formation_type'),
                    // '_formation_co_accrediteurs' => get_post_meta($post->ID, "_formation_co_accrediteurs")[0]
                ];
            wp_send_json($response);
        } else
            wp_send_json($query->posts);
    }
    
}
