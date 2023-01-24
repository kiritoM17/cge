<?php

class CGE_Cpt_Recrutement
{
    const POSTTYPE = 'cpt_recrutement';
    const TAXONOMY_CAT = 'recrutement_category';

    private $taxonomy_cat_args = [];
    private $taxonomyCatLabels = [];
    public $rewriteCatSlug = 'recrutement_category';

    public $rewriteSlug = 'cpt_recrutement';
    public $rewriteSlugSingular = 'cpt_recrutement';
    protected $post_type_args = [
        'public' => true,
        'rewrite' => [
            'slug' => 'cpt_recrutement',
            'with_front' => false
        ],
        'show_ui' => true,
        //'show_in_menu' => 'edit.php?post_type=job_listing',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
        'taxonomies' => ['recrutement_category'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-megaphone',
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
        $this->singular_form_label = __('Recrutement', 'cge');
        $this->singular_form_label_lowercase = __('Recrutement', 'cge');
        $this->plural_form_label = __('Recrutements', 'cge');
        $this->plural_form_label_lowercase = __('Recrutements', 'cge');
        $this->post_type_args['rewrite']['slug'] = $this->rewriteSlug;
        $this->post_type_args['show_in_nav_menus'] = true;
        $this->post_type_args['public'] = true;
        $this->post_type_args['show_in_rest'] = false;
        $this->post_type_args['labels'] = [
            'menu_name' => __('CGE Recrutement', 'cge'),
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

    public function find_recrutement()
    {
        
        $lieu_emplois = $_POST['lieu_emplois'];
        $demandeur_emplois = $_POST['demandeur_emplois'];
        $poste_propose_emplois = $_POST['poste_propose_emplois'];

        $tax_query = [] ;

        

        if ($lieu_emplois != 0) {
            $tax_query[] = array(
                'key' => 'lieu_emplois',
                'value' => $lieu_emplois,
                'compare' => 'LIKE',
            );
        }
  
        if ($demandeur_emplois != "") {
            $tax_query[] = array(
                'key' => 'demandeur_emplois',
                'value' => $demandeur_emplois,
                'compare' => 'LIKE',
            );
        }

        if ($poste_propose_emplois != "") {
            $tax_query[] = array(
                'key' => 'poste_propose_emplois',
                'value' => $poste_propose_emplois,
                'compare' => 'LIKE',
            );
        }

        if ($lieu_emplois != '' && $demandeur_emplois != '' && $poste_propose_emplois != '' ) {
            $tax_query['relation'] = 'AND';
        }
        
        $args = array(
            'post_type' => 'cpt_recrutement',
            'posts_per_page' => -1,
        );

        if (count($tax_query) >= 1) {
            $args['meta_query'] = array_merge(['relation' => 'AND',],$tax_query);
        }
    
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $response = [];
            foreach ($query->posts as $post)
                $response[] = [
                    'post' => $post,
                    'post_meta' => get_post_custom($post->ID),
                    'post_taxonomies' => get_post_taxonomies($post->ID),
                    'post_permalink' => get_permalink( $post->ID, $leavename = false ),
                ];
            wp_send_json($response);
        } else
            wp_send_json($query->posts);
    }
}
