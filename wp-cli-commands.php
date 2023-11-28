<?php

if (!(defined('WP_CLI') && WP_CLI)) {
    return;
}

class NewsScripts {
    public function convertBlocks($args, $assoc_args) {

        $post = get_post(42813);
        var_dump($post);
        WP_CLI::success("Test Script Successfully Run");
    }
 
  }
  

WP_CLI::add_command('ColbyNews', 'NewsScripts');
