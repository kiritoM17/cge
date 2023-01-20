<?php

class CGE_Cpt_Presse
{
    const POSTTYPE = 'cpt_presse';

    const TAXONOMY_FORMAT = 'document_format_presse';
    const TAXONOMY_YEAR = 'annee_presse';
    const TAXONOMY_TYPE = 'type_document_presse';

    public $rewriteDocumentFormatSlug = 'presse_document_format';
    public $rewriteTypeDocumentSlug = 'presse_type_document';
    public $rewriteAnneeSlug = 'presse_annee';

    private $taxonomy_document_format_args = [];
    private $taxonomy_type_document_args = [];
    private $taxonomy_annee_args = [];

    private $taxonomyDocumentFormatLabels = [];
    private $taxonomyTypeDocumentLabels = [];
    private $taxonomyAnneeLabels = [];

    public $rewriteSlugSingular = 'cpt_presse';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_presse',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => [],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_cge_presse_url',
        '_cge_presse_file_name',
        '_cge_presse_id'
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
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct() {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Presse', 'cge');
        $this->singular_form_label_lowercase = __('Presse', 'cge');
        $this->plural_form_label = __('Presses', 'cge');
        $this->plural_form_label_lowercase = __('Presses', 'cge');
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
            'menu_name' => __('CGE Presse', 'cge'),
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

        $this->taxonomyDocumentFormatLabels = [
            'menu_name' => __('Presse Document Format', 'cge'),
            'name' => sprintf(__('%s Presse Document Format', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Presse Document Format', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Presse Document Format', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Presse Document Format', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Presse Document Format', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Presse Document Format:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Presse Document Format', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Presse Document Format', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Presse Document Format', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Presse Document Format Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Presse Document Format Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyTypeDocumentLabels = [
            'menu_name' => __('Presse Document Type', 'cge'),
            'name' => sprintf(__('%s Presse Document Type', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Presse Document Type', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Presse Document Type', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Presse Document Type', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Presse Document Type', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Presse Document Type:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Presse Document Type', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Presse Document Type', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Presse Document Type', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Presse Document Type Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Presse Document Type Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyAnneeLabels = [
            'menu_name' => __('Presse Année', 'cge'),
            'name' => sprintf(__('%s Presse Année', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Presse Année', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Presse Année', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Presse Année', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Presse Année', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Presse Année:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Presse Année', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Presse Année', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Presse Année', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Presse Année Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Presse Année Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init() {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_type_document_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->rewriteTypeDocumentSlug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyTypeDocumentLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_TYPE, self::POSTTYPE, $this->taxonomy_type_document_args);

        $this->taxonomy_document_format_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->rewriteDocumentFormatSlug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyDocumentFormatLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_FORMAT, self::POSTTYPE, $this->taxonomy_document_format_args);

        $this->taxonomy_annee_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->rewriteAnneeSlug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyAnneeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_YEAR, self::POSTTYPE, $this->taxonomy_annee_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('cptPresseMetaBox', __('Editing Presse Informations', 'cge'), [$this, 'cptPresseInformationMetaBox'], self::POSTTYPE);
    }

    public function cptPresseInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/cpt_presse/information.php')) {
            include_once CGE_ADMIN_METABOX . '/cpt_presse/information.php';
        }
    }

    function find_presse()
    {
        $type_document = $_POST['type_document'];
        $annee = $_POST['annee'];
        $mots = $_POST['mots'];

        $tax_query = array();
        $date_query = array();
        if ($type_document != "") {
            $tax_query[] = array(
                'taxonomy' => 'document_format_presse',
                'field' => 'slug',
                'terms' => $type_document, 
                'include_children' => false
            );
        }


        if ($annee != "") {
            $tax_query[] = array(
                'taxonomy' => 'annee_presse',
                'field' => 'slug',
                'terms' => $annee,
                'include_children' => false
            );
        }


        if ($type_document != '' && $annee != '') {
            $tax_query['relation'] = 'AND';
        }

        $args = array(
            'post_type' => array('cpt_presse', 'revue_de_presse'),
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
        if ($query->have_posts()):
            $response = [];
            foreach ($query->posts as $post){
                $response[] = [
                    'post' => $post,
                    'post_meta' => get_post_custom($post->ID),
                    'post_taxonomies' => get_post_taxonomies($post->ID),
                ];
            }
            wp_send_json($response);
        else:
            wp_send_json($query->posts);
        endif;

    }


}