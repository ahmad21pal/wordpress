<?php
/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author        Konstantin Obenland
 * @package        The Bootstrap
 * @since        1.0 - 05.02.2012
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <?php tha_head_top(); ?>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title><?php wp_title('&laquo;', true, 'right'); ?></title>

    <?php tha_head_bottom(); ?>
    <!--        hi-->
    <?php wp_head(); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/global.css">
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.js"></script>
    <!--        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.min.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#slideshow').cycle({
                fx:'scrollHorz',
                fit:1,
                speed:'slow',
                timeout:3000,
                pager:'#pagination',
                auto:'true',
                slideResize:false,
                containerResize:false,
                slideExpr:'.slide',
                width:null,
                pagerAnchorBuilder:function (idx, slide) {
                    // return selector string for existing anchor
                    return '#pagination li:eq(' + idx + ')';
                }
            });
        });

        //$(function () {
        //    $('#slideshow').cycle({
        //        slideExpr: '.slide',
        //        slideResize: 0
        //    });
        //});
    </script>

</head>

<body <?php body_class(); ?>>

<header>
    <div class="navbar navbar-static-top">
        <div class="navbar-inner">
            <div class="container">
                <h1 class="logo">
                   <a href="<?php echo home_url('/'); ?>"></a>
                </h1>
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <ul class="nav nav-collapse in collapse">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Sample page1</a></li>
                    <li><a href="#">Sample page2</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!--<div class="container mainBannerContainer">
    <div class="mainBanner">
        <ul id="slideshow">
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/dummy.gif" alt="banner"></li>
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlbBanner.jpg" alt="banner" class="slide">
            </li>
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlbBanner.jpg" alt="banner" class="slide">
            </li>
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlbBanner.jpg" alt="banner" class="slide">
            </li>
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlbBanner.jpg" alt="banner" class="slide">
            </li>
            <li><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlbBanner.jpg" alt="banner" class="slide">
            </li>
        </ul>


    </div>

    <div class="sliderNav clearfix">
        <div class="title">
            Featured <br/>Clients
        </div>
        <ul class="clearfix" id="pagination">
            <li><span></span>

                <div><a href="#"><img src="<?php /*echo get_template_directory_uri(); */?>/img/mlb_academy.png"
                                      alt="MLB Academy"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php /*echo get_template_directory_uri(); */?>/img/match.png"
                                      alt="Match"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php /*echo get_template_directory_uri(); */?>/img/makemytrip.png"
                                      alt="Make my trip"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php /*echo get_template_directory_uri(); */?>/img/vmware.png" alt="Vmware"></a>
                </div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php /*echo get_template_directory_uri(); */?>/img/buhler.png" alt="Buhler"></a>
                </div>
            </li>
        </ul>

    </div>
</div>-->