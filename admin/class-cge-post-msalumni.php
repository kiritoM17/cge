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
        'menu_icon' => 'dashicons-welcome-learn-more',
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
        $this->singular_form_label = __('Étudiant', 'cge');
        $this->singular_form_label_lowercase = __('Étudiant', 'cge');
        $this->plural_form_label = __('Étudiants', 'cge');
        $this->plural_form_label_lowercase = __('Étudiants', 'cge');
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
            'menu_name' => __('Étudiants  Alumni', 'cge'),
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

        $annee = (int)$_POST['annee'];
        $nom = $_POST['nom'];
        $intitule = $_POST['intitule'];
        $ecole = $_POST['ecole'];
        $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;

        $tax_query = [];
        if ($annee > 0) {
            $tax_query[] = array(
                'key' => 'annee_obtention',
                'value' => $annee,
                'compare' => '=',
            );
        }

        if ($nom != "") {
            $tax_query[] = array(
                'key' => 'nom',
                'value' => $nom,
                'compare' => 'LIKE',
            );
        }

        if ($intitule != "") {
            $tax_query[] = array(
                'key' => 'formation',
                'value' => $intitule,
                'compare' => 'LIKE',
            );
        }

        if ($ecole != "") {
            $tax_query[] = array(
                'key' => 'ecole',
                'value' => $ecole,
                'compare' => 'LIKE',
            );
        }

        if ($annee > 0 && $ecole != '' && $nom != '' && $intitule != '' && $ecole != '') {
            $tax_query['relation'] = 'AND';
        }

        $args = array(
            'post_type' => 'msalumni',
            'posts_per_page' => 50,
            'paged' => $paged
        );


        if (count($tax_query) >= 1) {
            $args['meta_query'] = array_merge(['relation' => 'AND',], $tax_query);
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $response = [];
            foreach ($query->posts as $post)
                $response[] = [
                    'post' => $post,
                    'post_meta' => get_post_custom($post->ID),
                    'post_taxonomies' => get_post_taxonomies($post->ID),
                ];
            wp_send_json(['response' => $response, 'total' => $query->found_posts, 'total_page'=>$query->max_num_pages]);
        } else
            wp_send_json(['response' => $query->posts, 'total' => $query->found_posts, 'total_page'=>$query->max_num_pages]);
    }
}
