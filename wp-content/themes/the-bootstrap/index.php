<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author        Konstantin Obenland
 * @package        The Bootstrap
 * @since        1.0.0 - 05.02.2012
 */

get_header(); ?>
<?php $projects = $wpdb->get_results("select * from  custom_products ", ARRAY_A);



?>
<div class="container mainBannerContainer">
    <div class="mainBanner">
        <ul id="slideshow">
            <?php foreach ($projects as $project) ?>

            <li><img src="<?php echo content_url() . "" . $project['image'];?>" alt="banner" class="slide"></li>
            <?php ?>
            <li><img src="<?php echo get_template_directory_uri(); ?>/img/mlbBanner.jpg" alt="banner" class="slide">
                <!--            </li>-->
                <!--            <li><img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/mlbBanner.jpg" alt="banner" class="slide">-->
                <!--            </li>-->
                <!--            <li><img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/mlbBanner.jpg" alt="banner" class="slide">-->
                <!--            </li>-->
                <!--            <li><img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/mlbBanner.jpg" alt="banner" class="slide">-->
                <!--            </li>-->
                <!--            <li><img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/mlbBanner.jpg" alt="banner" class="slide">-->
                <!--            </li>-->
        </ul>


    </div>

    <div class="sliderNav clearfix">
        <div class="title">
            Featured <br/>Clients
        </div>
        <ul class="clearfix" id="pagination">
            <li><span></span>

                <div><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/mlb_academy.png"
                                      alt="MLB Academy"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/match.png"
                                      alt="Match"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/makemytrip.png"
                                      alt="Make my trip"></a></div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/vmware.png" alt="Vmware"></a>
                </div>
            </li>
            <li><span></span>

                <div><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/buhler.png" alt="Buhler"></a>
                </div>
            </li>
        </ul>

    </div>
</div>

<div class="container hrLine sliderBtmBrdr"></div>

<div class="container">
    <section id="primary">
        <?php tha_content_before(); ?>
        <div id="content" role="main">
            <!--		--><?php //tha_content_top();
//
//		if ( have_posts() ) {
//			while ( have_posts() ) {
//				the_post();
//				get_template_part( '/partials/content', get_post_format() );
//			}
//			the_bootstrap_content_nav( 'nav-below' );
//		}
//		else {
//			get_template_part( '/partials/content', 'not-found' );
//		}
//
//		tha_content_bottom(); ?>

            <div class="row aboutCompany">

                <div class="span6 rightDivider">

                    <h2 class="greenHeading">We are <span>WEBONISERS</span></h2>

                    <div class="webonisers">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/global_offices.png"
                             alt="Global offices">

                    </div>
                    <div class="infoBox clearfix">

                        <a href="#" class="learnAbout">Learn about our <br/>
                            culture of innovation.</a></div>

                </div>
                <div class="divider"><img src="<?php echo get_template_directory_uri(); ?>/img/vr_line.png" alt="">
                </div>
                <div class="span6 startUpsWrapper">

                    <h2 class="greenHeading">We love <span>START-UPs</span></h2>

                    <div class="webonisers startUps">

                        <img src="<?php echo get_template_directory_uri(); ?>/img/startups.png" alt="Startups">
                    </div>
                    <div class="infoBox clearfix">

                        <a href="#" class="learnAbout technologyPartner">Make Webonise Labs your <br/>
                            start-up technology partner.</a></div>

                </div>
            </div>

            <div class="hrLine">


            </div>

            <div class="row blocks">

                <?php
                $gallery = $wpdb->get_results("select * from  wp_ngg_gallery where name='expert-areas'", ARRAY_A);
                $query = "select * from  wp_ngg_pictures where galleryid='" . $gallery[0]['gid'] . "'";
                $images = $wpdb->get_results($query, ARRAY_A);
                ?>

                <!--                --><?php //dynamic_sidebar('experts');?>
                <?php foreach ($images as $image) { ?>
                <div class="span4">
                    <img src="<?php echo "/" . $gallery[0]['path'] . "/" . $image['filename']; ?>" alt="Mobile experts">
                    <label><?php echo $image['description']?></label>
                </div>
                <?php } ?>
                <!--                <div class="span4">-->
                <!--                    <img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/design_studio.png" alt="Design studio">-->
                <!--                </div>-->
                <!--                <div class="span4">-->
                <!--                    <img src="-->
                <?php //echo get_template_directory_uri(); ?><!--/img/agile_development.png"-->
                <!--                         alt="Agile development">-->
                <!--                </div>-->
            </div>

        </div>
        <!-- #content -->
        <?php tha_content_after(); ?>
    </section>
    <!-- #primary -->
</div>
<?php

function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

dynamic_sidebar('recentblog');

?>
<div class="blogWrapper">
    <!--    --><?php //dynamic_sidebar('recentblog')?>
    <?php
    $post_id;
    $args = array(
        'numberposts' => 3,
        'offset' => 0,
        'category' => 0,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'post',
        'post_status' => 'publish',
        'suppress_filters' => true);
    $recent_posts = wp_get_recent_posts($args);
    foreach ($recent_posts as $post) {
        //        echo $post['post_title'];
        $post_id = $post['ID'];
        break;
    }


//    echo $post_id;
    $args = array(
        'numberposts' => 1,
        'order' => 'ASC',
        'post_mime_type' => 'image',
        'post_parent' => $post_id,
        'post_status' => null,
        'post_type' => 'attachment'
    );

    $attachment = get_the_post_thumbnail($post_id, 'large');

//    print_r($attachments);


    $image_id = kd_mfi_get_featured_image_id('right-side-image1', 'post');
//    echo $image_id;
    $top_image = kd_mfi_get_featured_image_url('right-side-image1', 'post', 'full', $post_id);
    $left_image = kd_mfi_get_featured_image_url('right-side-image2', 'post', 'full', $post_id);
    $right_image = kd_mfi_get_featured_image_url('right-side-image3', 'post', 'full', $post_id);
    ?>



    <div class="blogText"></div>

    <div class="container clearfix">
        <div class="row">
            <div class="span8 contentBlock clearfix">

                <!--                <img src="--><?php //echo $attachment; ?><!--" alt="blog">-->
                <?php echo $attachment; ?>

                <div class="content">


                    <h2 class="heading"><?php  echo $post['post_title'];?>,</h2>
                    <?php if (str_word_count($post['post_content'],0) > 30) { ?>

                    <p><?php echo limit_text($post['post_content'],30);?></p>

                    <a href="#" class="boldLink">Read More...</a>

                    <?php } else { ?>

                    <p><?php echo $post['post_content'];?></p>

                    <?php } ?>

                </div>

            </div>
            <div class="span4 infoBlock">
                <a href="#" class="googleSearch"><img src="<?php echo $top_image; ?>" alt="Google's voice search"></a>

                <div class="clearfix">
                    <a href="#" class="appStore"><img src="<?php echo $left_image ?>" alt="App store"></a>
                    <a href="#" class="appStore android"><img src="<?php echo $right_image; ?>" alt="Android"></a>
                </div>
            </div>

        </div>
    </div>
    <!---->
</div>

<?php
//get_sidebar();
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/index.php */