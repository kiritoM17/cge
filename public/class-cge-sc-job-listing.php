<?php

class CGE_SC_Job_Listing
{
    protected static $instance;
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function init()
    {
        add_shortcode('cge_job_listing', [$this, 'job_listing']);
    }

    public function job_listing($atts)
    {
        if (isset($atts['id']) && !empty($atts['id'])) {
        } else {
        }
    }
}
