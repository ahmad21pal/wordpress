<?php
/** footer.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */

				tha_footer_before(); ?>


<footer>
    <div id="footer" class="clearfix">

        <div id="footer-wrapper">

            <div class="container">
                <div class="row">
                    <div class="footerNav">
                <div class="span7">

                    <ul class="footerMenu clearfix">
                        <li><a href="#">CONTACT</a></li>
                        <li><a href="#">CAREERS</a></li>
                        <li><a href="#">BLOG</a></li>
                        <li><a href="#">AGENCIES</a></li>
                        <li><a href="#">START-UPS</a></li>
                    </ul>

                </div>

                <div class="span4 socialMenu clearfix">
                    <div class="connect">Let's Connect</div>
                    <ul class="social-icons clearfix">
                        <li><a href="#" title="Facebook"></a> </li>
                        <li><a href="#" class="twitt" title="Twitter"></a> </li>
                        <li><a href="#" class="in" title="Linkedin"></a> </li>
                    </ul>

                </div>
                    </div>
            </div>


              <div class="row contactInfo">
            <div class="span6 copyright">
                <div class="grid emailSign">
                    <input type="text" class="email" placeholder="get email updates (monthly or so)"><button type="submit" value="" class="emailInput" href="#"> </button>
                </div>
                <div>
                    <div class="footerLogo"></div>
                    <address>
                        <div>World class innovation in development, design and consulting. </div>
                        <div class="row">
                        <div class="span3 addressBlock">
                            <ul class="add addInfo">
                                <li>Raleigh, NC, USA</li>
                                <li>Pune, India  </li>
                                <li>Waterloo, ON, Canada</li>
                            </ul>
                        </div>
                        <div class="span3 contactBlock">
                            <ul class="add">
                                <li><span class="email"></span><a href="mailto:contact@weboniselab.com"> contact@weboniselab.com</a></li>
                                <li><span class="phone"></span>727-210-5206  (USA & Canada)</li>
                                <li><span class="phone"></span>+91 203-024-6161 (India)</li>
                            </ul>

                        </div>
                        </div>
                    </address>
                </div>
            </div><!-- end of .copyright -->

            <div class="span6 twitterBlock">
                <div class="twiiterHeading"><span></span>@webonise</div>
                <div class="clear"></div>
                <div class="grid">
                    <div class="twitterPanel">
                        <div class="tweets"><div class="content_tweets"> </div></div>
                        <script type='text/javascript'>
                            jQuery(".content_tweets").miniTwitter({username: ['webonise'], limit: 1});
                        </script>
                    </div>
                </div>
            </div>

              </div>
            </div>


        </div><!-- end #footer-wrapper -->


    </div><!-- end #footer -->
    <div class="powered">
        <!--            <a href="--><?php //echo esc_url(__('http://themeid.com/responsive-theme/','responsive')); ?><!--" title="--><?php //esc_attr_e('Responsive Theme', 'responsive'); ?><!--">-->
        <!--                    --><?php //printf('Responsive Theme'); ?><!--</a>-->
        <!--            --><?php //esc_attr_e('powered by', 'responsive'); ?><!-- <a href="--><?php //echo esc_url(__('http://wordpress.org/','responsive')); ?><!--" title="--><?php //esc_attr_e('WordPress', 'responsive'); ?><!--">-->
        <!--                    --><?php //printf('WordPress'); ?><!--</a>-->
        © 2013 Webonise, Inc

    </div><!-- end .powered -->
</footer>




				<?php tha_footer_after(); ?>
			</div><!-- #page -->
		</div><!-- .container -->
	<!-- <?php printf( __( '%d queries. %s seconds.', 'the-bootstrap' ), get_num_queries(), timer_stop(0, 3) ); ?> -->








<?php wp_footer(); ?>
	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/the-bootstrap/footer.php */