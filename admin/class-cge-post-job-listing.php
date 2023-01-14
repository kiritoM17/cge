<?php

class CGE_Job_Listing
{
    const POSTTYPE = 'job_listing';
    const TAXONOMY_REGION = 'job_listing_region';
    const TAXONOMY_TYPE = 'job_listing_type';
    const TAXONOMY_AMENITY = 'job_listing_amenity';

    public $rewriteSlug = 'job_listing';
    public $rewriteSlugSingular = 'job_listing';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'job_listing',
            'with_front' => false
        ],
        'show_ui' => true,
        //'show_in_menu' => 'edit.php?post_type=cpt_formation',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['job_listing_region', 'job_listing_type', 'job_listing_amenity'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-store',
    ];

    /**
     * @var string
     */
    public $singular_form_label;

    /**
     * @var string[]
     */
    public static $valid_form_metabox_keys = [
        '_ecole_id',
        '_ecole_logo',
        '_ecole_acronyme',
        '_ecole_nom',
        '_ecole_type_formation',
        '_ecole_statut',
        '_ecole_annee_creation',

        '_job_location',
        '_job_hours',
        '_company_website',


        'geolocation_formatted_address',
        'geolocation_city',
        'geolocation_state_short',
        'geolocation_state_long',
        'geolocation_country_long',

        '_ecole_type_structure',
        '_ecole_ministere_tutelle_1',
        '_ecole_organisme_rattachement',
        '_ecole_habilitation_delivrer_doctorat',
        '_ecole_prepa_integree',
        '_ecole_type_habilitation',

        '_ecole_centres_documentation_horaires',
        '_ecole_centres_documentation_responsable_civilite',
        '_ecole_centres_documentation_responsable_nom',
        '_ecole_centres_documentation_responsable_prenom',
        '_ecole_centres_documentation_responsable_telephone',
        '_ecole_centres_documentation_responsable_email',

        '_ecole_dg_civilite',
        '_ecole_dg_nom',
        '_ecole_dg_prenom',

        '_ecole_de_civilite',
        '_ecole_de_nom',
        '_ecole_de_prenom',

        '_ecole_resp_formation',

        '_ecole_associations',

        '_ecole_accords_internationaux_'

    ];

    /**
     * @var string
     */
    protected $meta_prefix = '';

    

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

    private $taxonomy_region_args = [];
    private $taxonomy_type_args = [];
    private $taxonomy_amenity_args = [];

    private $taxonomyRegionLabels = [];
    private $taxonomyTypeLabels = [];
    private $taxonomyAmenityLabels = [];

    public $taxonomy_region_slug = 'flux_cge_region';
    public $taxonomy_type_slug = 'flux_cge_type';
    public $taxonomy_amenty_slug = 'flux_cge_amenety';

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct() {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('CGE', 'cge');
        $this->singular_form_label_lowercase = __('CGE', 'cge');
        $this->plural_form_label = __('CGE', 'cge');
        $this->plural_form_label_lowercase = __('CGE', 'cge');
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
            'menu_name' => __('CGE', 'cge'),
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
        $this->taxonomyAmenityLabels = [
            'menu_name' => __('CGE Amenity', 'cge'),
            'name' => sprintf(__('%s CGE Amenity', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s CGE Amenity', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s CGE Amenity', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s CGE Amenity', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s CGE Amenity', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s CGE Amenity:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s CGE Amenity', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s CGE Amenity', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s CGE Amenity', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s CGE Amenity Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s CGE Amenity Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyTypeLabels = [
            'menu_name' => __('CGE TYPE', 'cge'),
            'name' => sprintf(__('%s CGE TYPE', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s CGE TYPE', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s CGE TYPE', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s CGE TYPE', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s CGE TYPE', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s CGE TYPE:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s CGE TYPE', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s CGE TYPE', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s CGE TYPE', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s CGE TYPE Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s CGE TYPE Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
        $this->taxonomyRegionLabels = [
            'menu_name' => __('CGE REGION', 'cge'),
            'name' => sprintf(__('%s CGE REGION', 'cge'), $this->singular_form_label),
            'singular_name' => sprintf(__('%s CGE REGION', 'cge'), $this->singular_form_label),
            'search_items' => sprintf(__('Search %s CGE REGION', 'cge'), $this->singular_form_label),
            'all_items' => sprintf(__('All %s CGE REGION', 'cge'), $this->singular_form_label),
            'parent_item' => sprintf(__('Parent %s CGE REGION', 'cge'), $this->singular_form_label),
            'parent_item_colon' => sprintf(__('Parent %s CGE REGION:', 'cge'), $this->singular_form_label),
            'edit_item' => sprintf(__('Edit %s CGE REGION', 'cge'), $this->singular_form_label),
            'update_item' => sprintf(__('Update %s CGE REGION', 'cge'), $this->singular_form_label),
            'add_new_item' => sprintf(__('Add New %s CGE REGION', 'cge'), $this->singular_form_label),
            'new_item_name' => sprintf(__('New %s CGE REGION Name', 'cge'), $this->singular_form_label),
            'item_link' => sprintf(__('%s CGE REGION Link', 'cge'), $this->singular_form_label),
            'item_link_description' => sprintf(__('A link to a particular %s category.', 'cge'), $this->singular_form_label),
        ];
    }

    public function init() {
        register_post_type(self::POSTTYPE, $this->post_type_args);

        $this->taxonomy_region_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_region_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyRegionLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_REGION, self::POSTTYPE, $this->taxonomy_region_args);

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

        $this->taxonomy_amenity_args = [
            'hierarchical' => true,
            'update_count_callback' => '',
            'rewrite' => [
                'slug' => $this->rewriteSlug . '/' . $this->taxonomy_amenty_slug,
                'with_front' => false,
                'hierarchical' => true,
            ],
            'public' => true,
            'show_ui' => true,
            'labels' => $this->taxonomyAmenityLabels,
            'capability_type' => 'post',
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menu' => true,
        ];
        register_taxonomy(self::TAXONOMY_AMENITY, self::POSTTYPE, $this->taxonomy_amenity_args);

        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('JobListingInformationMetaBox', __('Editing Ecole Informations', 'cge'), [$this, 'jobListingInformationMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationContactMetaBox', __('Editing Ecole Informations Contact', 'cge'), [$this, 'jobListingInformationContactMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationDocumentationMetaBox', __('Editing Ecole Informations Documentation Responsable', 'cge'), [$this, 'jobListingInformationDocumentationMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationDgMetaBox', __('Editing Ecole Informations Directeur Généraux', 'cge'), [$this, 'jobListingInformationDgMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationDeMetaBox', __('Editing Ecole Informations Directeur d\'Etude', 'cge'), [$this, 'jobListingInformationDeMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationFormationMetaBox', __('Editing Ecole Informations Formation', 'cge'), [$this, 'jobListingInformationFormationMetaBox'], self::POSTTYPE);

        add_meta_box('JobListingInformationAssocationMetaBox', __('Editing Ecole Informations Associtation', 'cge'), [$this, 'jobListingInformationAssocationMetaBox'], self::POSTTYPE);
        add_meta_box('JobListingInformationAccordsMetaBox', __('Editing Ecole InformationsAccords', 'cge'), [$this, 'jobListingInformationAccordsMetaBox'], self::POSTTYPE);
    }

    public function jobListingInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information.php';
    }

    public function jobListingInformationContactMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-contact.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-contact.php';
    }

    public function jobListingInformationDocumentationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-documentation.php')) 
            include_once CGE_ADMIN_METABOX . '/job_listing/information-documentation.php';
    }

    public function jobListingInformationDgMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-dg.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-dg.php';
    }

    public function jobListingInformationDeMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-de.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-de.php';
    }
    
    public function jobListingInformationFormationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-formation.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-formation.php';
    }

    public function jobListingInformationAssocationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-association.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-association.php';
    }

    public function jobListingInformationAccordsMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/job_listing/information-accords.php'))
            include_once CGE_ADMIN_METABOX . '/job_listing/information-accords.php';
    }
}