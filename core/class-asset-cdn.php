<?php
namespace AdvancedAIO_WP\Core;

class Asset_CDN {
    private $cdn_url = 'https://cdn.hamnatech.com/aio-wp/';
    private $local_assets = [];
    
    public function __construct() {
        $this->local_assets = [
            'css' => glob(ADVANCED_AIO_WP_DIR . 'public/css/*.css'),
            'js' => glob(ADVANCED_AIO_WP_DIR . 'public/js/*.js')
        ];
        
        add_filter('script_loader_src', [$this, 'rewrite_asset_url'], 10, 2);
        add_filter('style_loader_src', [$this, 'rewrite_asset_url'], 10, 2);
    }
    
    public function rewrite_asset_url($src, $handle) {
        if (strpos($src, ADVANCED_AIO_WP_URL) !== false) {
            $file = basename(parse_url($src, PHP_URL_PATH));
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            
            if (in_array($ext, ['css', 'js'])) {
                return $this->cdn_url . $ext . '/' . $file;
            }
        }
        return $src;
    }
    
    public function sync_to_cdn() {
        foreach ($this->local_assets as $type => $files) {
            foreach ($files as $file) {
                $this->upload_to_cdn($file, $type);
            }
        }
    }
    
    private function upload_to_cdn($file_path, $asset_type) {
        // Implementation using WP_Filesystem
    }
}
