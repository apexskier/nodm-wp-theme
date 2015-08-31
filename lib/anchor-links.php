<?php

namespace Roots\Sage\AnchorLinks;

use DOMDocument;

function generate_anchors($content){
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);

    $count = 0;
    foreach($dom->getElementsByTagName('h3') as $element) {
        $str = $element->textContent . $count;
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
        $count++;

        $element->setAttribute('id', $clean);
    }

    return $dom->saveHTML();
}

add_filter('the_content', __NAMESPACE__ . '\\generate_anchors', 20);
