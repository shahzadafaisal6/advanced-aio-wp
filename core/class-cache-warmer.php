<?php
namespace AdvancedAIO_WP\Core;

class Cache_Warmer {
    public function warm_cache($urls) {
        $multi_handle = curl_multi_init();
        $handles = [];
        
        foreach ($urls as $url) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_NOSIGNAL => 1
            ]);
            curl_multi_add_handle($multi_handle, $ch);
            $handles[] = $ch;
        }
        
        do {
            curl_multi_exec($multi_handle, $running);
            curl_multi_select($multi_handle);
        } while ($running > 0);
        
        foreach ($handles as $ch) {
            curl_multi_remove_handle($multi_handle, $ch);
            curl_close($ch);
        }
        
        curl_multi_close($multi_handle);
    }
}
