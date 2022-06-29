<?php


function newcity_colby_news_favicon()
{
    ?>
        <link rel="icon" href="/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png"><!-- 180×180 -->
        <link rel="manifest" href="/manifest.webmanifest">
    <?php
}

add_action('wp_head', 'newcity_colby_news_favicon');