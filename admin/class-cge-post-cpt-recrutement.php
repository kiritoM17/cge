<?php

class CGE_Cpt_Recrutement
{
    const POSTTYPE = 'cpt_recrutement';
    const TAXONOMY = 'cpt_recrutement_cat';

    public $rewriteSlug = 'cpt_recrutement';
    public $rewriteSlugSingular = 'cpt_recrutement';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_recrutement',
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
        'id_emploi',
        'demandeur_emplois',
        'poste_propose_emplois',
        'lieu_emplois',
        'document_emplois',
        'date_debut_emplois',
        'date_depot_emplois',
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

    private $taxonomy_args = [];

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     */
    protected function __construct() {
        $this->post_type = self::POSTTYPE;
        $this->singular_form_label = __('Recrutement', 'cge');
        $this->singular_form_label_lowercase = __('Recrutement', 'cge');
        $this->plural_form_label = __('Recrutements', 'cge');
        $this->plural_form_label_lowercase = __('Recrutements', 'cge');
        $this->post_type_args['rewrite']['slug'] = $this->rewriteSlug;
        $this->post_type_args['show_in_nav_menus'] = true;
        $this->post_type_args['public'] = true;
        $this->post_type_args['show_in_rest'] = false;
        $this->post_type_args['labels'] = [
            'menu_name' => __('Recrutement', 'cge'),
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
        flush_rewrite_rules();
    }

    /**
     * @function initialize postype metabox structure
     */
    public function add_meta_boxes()
    {
        add_meta_box('cptRecrutementMetaBox', __('Editing Recrutement Informations', 'cge'), [$this, 'cptRecrutementInformationMetaBox'], self::POSTTYPE);
    }

    public function cptRecrutementInformationMetaBox()
    {
        if (file_exists(CGE_ADMIN_METABOX . '/cpt_recrutement/information.php')) {
            include_once CGE_ADMIN_METABOX . '/cpt_recrutement/information.php';
        }
    }
}