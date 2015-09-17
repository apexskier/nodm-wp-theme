<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');

function get_order($a, $b) {
    $a_order = get_post_meta($a->ID, 'course_path', true);
    $b_order = get_post_meta($b->ID, 'course_path', true);
    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

$icons = get_posts(array(
    'post_type' => 'course_icons'
));

$courses = get_posts(array(
    'post_type' => 'course'
));
usort($courses, 'get_order');
?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main" role="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <aside class="sidebar" role="complementary">
          <?php dynamic_sidebar('sidebar-course'); ?>
        </aside><!-- /.sidebar -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <div class="map-container">
        <div id="map"><p>Map Loading...</p></div>
        <div class="container map-controls-container">
            <div class="row">
                <div class="map-controls col-sm-12">
<?php foreach ($courses as $course): ?>
                    <div class="map-control gpx-control" style="background-color: <?php echo get_post_meta($course->ID, 'course_color', true) ?>;">
                        <a data-courseid="<?php echo $course->ID; ?>" class="enabled" href="#"><?php echo $course->post_title; ?></a>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="container map-controls-container">
            <div class="row">
                <div class="map-controls col-sm-12">
<?php foreach ($icons as $icon): ?>
                    <div class="map-control icons-control">
                        <a data-iconsid="<?php echo $icon->ID; ?>" class="enabled" href="#">
                            <?php echo $icon->post_title; ?>
                            <img src="<?php echo get_post_meta($icon->ID, 'course_icons_icon_path', true); ?>" alt="<?php echo $icon->post_title; ?> icon">
                        </a>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
        <div id="elevation_graph"></div>
    </div>
    <div class="container">
      <div class="content row">
<?php foreach ($courses as $course): ?>
        <div class="col-sm-12 col-lg-6">
            <h3>
                <span class="course-title-color" style="background-color: <?php echo get_post_meta($course->ID, 'course_color', true) ?>;"></span> <?php echo $course->post_title; ?>
                <small><a target="_blank" href="<?php echo get_post_meta($course->ID, 'course_path', true); ?>">download gps file</a></small>
            </h3>
            <?php
                $course_content = $course->post_content;
                $course_content = apply_filters('the_content', $course_content);
                $course_content = str_replace(']]>', ']]&gt;', $course_content);
                echo $course_content;
            ?>
        </div>
<?php endforeach; ?>
<?php foreach ($icons as $icon): ?>
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h3>
                <?php echo $icon->post_title; ?>
                <small><a target="_blank" href="<?php echo get_post_meta($icon->ID, 'course_icons_path', true); ?>">download geojson file</a></small>
            </h3>
        </div>
<?php endforeach; ?>
      </div>
    </div>
<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css">
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/dist/scripts/gpx.js"></script>
  <script>
(function ($) {
    var $map = $('#map'),
        elevation_graph = $('#elevation_graph'),
        gpxs = [],
        gpxMap = {};


    function getgraphdata(e) {
        var points = [];
        for (var key in e.target._layers) {
            if (typeof e.target._layers[key].getLatLngs !== 'undefined') {
                points = e.target._layers[key].getLatLngs();
            }
        }
        data = []
        for (var i = 0; i < points.length; i++) {
            data.push({
                x: e.target._info.elevation._points[i][0],
                y: e.target._info.elevation._points[i][1],
                lat: points[i].lat,
                lng: points[i].lng
            });
        }
        gpxs.push({
            data: data,
            color: e.target.options.polyline_options.color,
            name: e.target._popupContent,
            turboThreshold: 0,
            marker: {
                symbol: 'circle'
            }
        });
    }
    function pathMouseOut(e) {
        e.target.setStyle({ weight: 5 });
    }
    function pathMouseOver(e) {
        e.target.setStyle({ weight: 10 });
    }

    var gpxsLoadedPromises = [];
<?php foreach ($courses as $course): ?>
    gpxsLoadedPromises.push(new Promise(function (resolve) {
        var g = new L.GPX("<?php echo get_post_meta($course->ID, 'course_path', true); ?>", {
            async: true,
            polyline_options: {
                color: "<?php echo get_post_meta($course->ID, 'course_color', true); ?>",
                opacity: 1
            },
            marker_options: {
                startIconUrl: false,
                endIconUrl: false,
                shadowUrl: false
            }
        })
        .on('loaded', function(e) {
            getgraphdata(e);
            resolve(e.target.getBounds());
        })
        .on('mouseover', pathMouseOver)
        .on('mouseout', pathMouseOut)
        .bindPopup('<?php echo $course->post_title; ?>');

        gpxMap['course<?php echo $course->ID; ?>'] = g;
        gpxs.push(g);
    }));
<?php endforeach; ?>

    Promise.all(gpxsLoadedPromises).then(function (bounds) {
        map.fitBounds(bounds);
    });

    var detailtiles = new L.tileLayer('http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.opencyclemap.org">OpenCycleMap</a>, &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
    });
    var sattiles = new  L.tileLayer('http://oatile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg', {
        attribution: 'Tiles Courtesy of <a href="http://www.mapquest.com/">MapQuest</a> &mdash; Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency',
        subdomains: '1234'
    });
    var roadtiles = new L.tileLayer('http://openmapsurfer.uni-hd.de/tiles/roadsg/x={x}&y={y}&z={z}', {
        maxZoom: 19,
        attribution: 'Imagery from <a href="http://giscience.uni-hd.de/">GIScience Research Group @ University of Heidelberg</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    var map = L.map('map', {
        center: [48.12490938797694, -123.2966423034668], // sligtly lower than center. nice animation
        zoom: 12,
        layers: [roadtiles].concat(gpxs.reverse()),
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    });

    var circle = new L.CircleMarker([0, 0], {
        radius: 6,
        fillOpacity: 1,
        opacity: 1,
        color: '#fff',
        fillColor: 'green',
        weight: 1
    }).addTo(map);

    var baseMaps = {
        "Simple Road Map": roadtiles,
        "Detailed Road Map": detailtiles,
        "Satellite": sattiles
    };

    $('.gpx-control a').on('click', function(e) {
        e.preventDefault();
        var $this = $(this).toggleClass('enabled disabled');
        var key = 'course' + $this.data('courseid');
        var layer = gpxMap[key];
        if ($this.hasClass('enabled')) {
            map.addLayer(layer);
            map.fitBounds(layer.getBounds());
        } else {
            map.removeLayer(layer);
        }
    });

    var getJsons = [];
    function getPoints(id, layerName, url, icon) {
        return $.getJSON(url, function(data) {
            var sqicon = L.icon({
                iconUrl: icon,
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });
            geojsonLayer = L.geoJson(data, {
                onEachFeature: function(feature, layer) {
                    layer.bindPopup(feature.properties.name);
                },
                pointToLayer: function(feature, latlng) {
                    return L.marker(latlng, {
                        icon: sqicon,
                        title: feature.properties.name
                    });
                }
            });
            gpxMap['icons' + id] = geojsonLayer;
            geojsonLayer.addTo(map);
        });
    }
<?php foreach ($icons as $icon): ?>
    getJsons.push(getPoints(
        <?php echo $icon->ID; ?>,
        '<?php echo $icon->post_title; ?>',
        '<?php echo get_post_meta($icon->ID, 'course_icons_path', true); ?>',
        '<?php echo get_post_meta($icon->ID, 'course_icons_icon_path', true); ?>'
    ));
<?php endforeach; ?>
    $.when.apply($, getJsons).done(function() {
        $('.icons-control a').on('click', function(e) {
            e.preventDefault();
            var $this = $(this).toggleClass('enabled disabled');
            var key = 'icons' + $this.data('iconsid');
            var layer = gpxMap[key];
            if ($this.hasClass('enabled')) {
                map.addLayer(layer);
            } else {
                map.removeLayer(layer);
            }
        });
    });
    L.control.layers(baseMaps).addTo(map);
})(jQuery)
    </script>

    <!-- pre>
<?php
foreach ($courses as $course):
    print_r($course);
    echo "\n";
?>
<?php endforeach; ?>
    </pre -->
  </body>
</html>
