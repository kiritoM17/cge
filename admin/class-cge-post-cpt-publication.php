<?php

class CGE_Cpt_Publication
{
    const POSTTYPE = 'cpt_publication';

    const TAXONOMY_SOURCE = 'sources';
    const TAXONOMY_TYPE = 'document_type';
    const TAXONOMY_TYPE_SPE = 'type_document_spe';
    const TAXONOMY_DATE = 'document_annee_publication';


    public $category_source_slug = 'sources';
    public $category_document_type_slug = 'document_type';
    public $category_document_spe_slug = 'type_document_spe';
    public $category_document_annee_slug = 'document_annee_publication';

    public $rewriteSlug = 'cpt_publication';
    public $rewriteSlugSingular = 'cpt_publication';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_publication',
            'with_front' => false
        ],
        'show_ui' => true,
        // 'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['sources', 'document_type', 'type_document_spe', 'document_annee_publication'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-write-blog',
    ];

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_cge_publication_url',
        '_cge_publication_date',
        '_cge_publication_id',
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

    private $taxonomy_sources_args = [];
    private $taxonomy_document_type_args = [];
    private $taxonomy_document_spe_args = [];
    private $taxonomy_document_annee_args = [];

    private $taxonomySourcesLabels = [];
    private $taxonomyDocumentTypeLabels = [];
    private $taxonomyDocumentSpeLabels = [];
    private $taxonomyDocumentAnneeLabels = [];

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct() {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Publication', 'cge');
        $this->singular_form_label_lowercase = __('Publication', 'cge');
        $this->plural_form_label = __('Publications', 'cge');
        $this->plural_form_label_lowercase = __('Publications', 'cge');
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
            'menu_name' => __('Publications', 'cge'),
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

        $this->taxonomySourcesLabels = [
            'menu_name' => __('Publication Source', 'cge'),
            'name' => sprintf(__('%s Publication Source', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Publication Source', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Publication Source', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Publication Source', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Publication Source', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Publication Source:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Publication Source', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Publication Source', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Publication Source', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Publication Source Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Publication Source Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyDocumentTypeLabels = [
            'menu_name' => __('Publication Type', 'cge'),
            'name' => sprintf(__('%s Publication Type', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Publication Type', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Publication Type', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Publication Type', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Publication Type', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Publication Type:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Publication Type', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Publication Type', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Publication Type', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Publication Type Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Publication Type Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyDocumentSpeLabels = [
            'menu_name' => __('Publication Type SPE', 'cge'),
            'name' => sprintf(__('%s Publication Type SPE', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Publication Type SPE', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Publication Type SPE:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Publication Type SPE', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Publication Type SPE Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Publication Type SPE Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyDocumentAnneeLabels = [
            'menu_name' => __('Publication Document Année', 'cge'),
            'name' => sprintf(__('%s Publication Document Année', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s Publication Document Année', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s Publication Document Année', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s Publication Document Année', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s Publication Document Année', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s Publication Document Année:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s Publication Document Année', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s Publication Document Année', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s Publication Document Année', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s Publication Document Année Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s Publication Document Année Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init() {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_document_annee_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->category_document_annee_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyDocumentAnneeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_DATE, self::POSTTYPE, $this->taxonomy_document_annee_args);

        $this->taxonomy_document_spe_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->category_document_spe_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyDocumentSpeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_TYPE_SPE, self::POSTTYPE, $this->taxonomy_document_spe_args);

        $this->taxonomy_sources_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->category_source_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomySourcesLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_SOURCE, self::POSTTYPE, $this->taxonomy_sources_args);

        $this->taxonomyDocumentTypeLabels = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->category_document_type_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyDocumentTypeLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_TYPE, self::POSTTYPE, $this->taxonomyDocumentTypeLabels);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('cptPublicationMetaBox', __('Editing Publication Informations', 'cge'), [$this, 'cptPublicationInformationMetaBox'], self::POSTTYPE);
    }

    public function cptPublicationInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/cpt_publication/information.php')) {
            include_once CGE_ADMIN_METABOX . '/cpt_publication/information.php';
        }
    }

    function find_publication(){

        $type_document = $_POST['type_document'];
        $type_document_spe = $_POST['type_document_spe'];
        $annee = $_POST['annee'];
        $source = $_POST['source'];
        $mots = $_POST['mots'];
        $tax_query = array();

        if ($type_document != "") {
            $tax_query[] = array(
                'taxonomy' => 'document_type',
                'field' => 'slug',
                'terms' => $type_document, 
                'include_children' => false
            );
        }

        if ($type_document_spe != "") {
            $tax_query[] = array(
                'taxonomy' => 'type_document_spe',
                'field' => 'slug',
                'terms' => $type_document_spe, 
                'include_children' => false
            );
        }

        if ($annee != "") {
            $tax_query[] = array(
                'taxonomy' => 'document_annee_publication',
                'field' => 'slug',
                'terms' => $annee,
                'include_children' => false
            );
        }

        if ($source != "") {
            $tax_query[] = array(
                'taxonomy' => 'sources',
                'field' => 'slug',
                'terms' => $source,
                'include_children' => false
            );
        }

        if ($type_document != '' && $annee != '' && $source != '' && $type_document_spe != '') {
            $tax_query['relation'] = 'AND';
        }

        $args = array(
            'post_type' => 'cpt_publication',
            'posts_per_page' => -1
        );

        if (count($tax_query) >= 1) {
            $args['tax_query'] = array_merge(['relation' => 'AND',],$tax_query);;
        }

        $args['s'] = $mots;

        $args['order'] = 'DESC';

        $query = new WP_Query($args);

        if ($query->have_posts()){
            $response = [];
            foreach ($query->posts as $post){
                $response[] = [
                    'post' => $post,
                    'post_meta' => get_post_custom($post->ID),
                    'post_taxonomies' => get_post_taxonomies($post->ID),
                    'post_permalink' => get_permalink( $post->ID, $leavename = false ),
                ];
            }
            wp_send_json($response);
        } else 
            wp_send_json($query->posts);
    }
}
