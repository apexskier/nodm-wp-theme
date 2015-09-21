<?php

namespace Roots\Sage\AnchorLinks;

use DOMDocument;

function generate_anchors($content){
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
    libxml_use_internal_errors(false);

    $count = 0;
    $elements = $dom->getElementsByTagName('h3');
    if ($elements) {
        foreach ($elements as $element) {
            $str = $element->textContent . $count;
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
            $clean = strtolower(trim($clean, '-'));
            $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
            $count++;

            $element->setAttribute('id', $clean);
        }
    }

    return $dom->saveHTML();
}

add_filter('the_content', __NAMESPACE__ . '\\generate_anchors', 20);
