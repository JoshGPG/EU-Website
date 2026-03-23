<?php if (!is_front_page()) : ?>
    </div>
</main>
<?php endif; ?>

<?php
// Retrieve ACF option fields (with fallbacks for when ACF isn't populated yet)
$acf = function_exists('get_field');

$about_text     = $acf ? get_field('footer_about_text', 'option') : '';
$involved_links = $acf ? get_field('footer_get_involved_links', 'option') : [];
$team_links     = $acf ? get_field('footer_our_team_links', 'option') : [];
$email          = $acf ? get_field('office_email', 'option') : '';
$phone          = $acf ? get_field('office_phone', 'option') : '';
$address        = $acf ? get_field('office_address', 'option') : '';
$facebook       = $acf ? get_field('facebook_url', 'option') : '';
$instagram      = $acf ? get_field('instagram_url', 'option') : '';
$youtube        = $acf ? get_field('youtube_url', 'option') : '';

// Fallback defaults (used until the client populates Site Settings)
if (!$about_text) $about_text = 'Empowering communities through education, athletics, and mentorship. We are committed to developing young leaders on and off the field.';
if (!$email)      $email      = 'info@enduranceunited.org';
if (!$phone)      $phone      = '(612) 850-3937';
if (!$address)    $address    = "713 Minnehaha Ave. East, Suite 216\nSaint Paul, MN 55106, USA";
if (!$facebook)   $facebook   = 'https://www.facebook.com/EnduranceUntd/';
if (!$instagram)  $instagram  = 'https://www.instagram.com/enduranceunited/';
if (!$youtube)    $youtube    = 'https://www.youtube.com/channel/UCsrv65x0Vzscsh3vRJk_PUA';
?>

<footer class="site-footer">
    <div class="footer-columns">
        <div class="footer-col">
            <h3>About Us</h3>
            <p><?php echo esc_html($about_text); ?></p>
        </div>

        <div class="footer-col">
            <h3>Get Involved</h3>
            <ul>
                <?php if (!empty($involved_links)) : ?>
                    <?php foreach ($involved_links as $link) : ?>
                        <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><a href="#">Donate</a></li>
                    <li><a href="#">Volunteer</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Sponsor Us</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Our Team</h3>
            <ul>
                <?php if (!empty($team_links)) : ?>
                    <?php foreach ($team_links as $link) : ?>
                        <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><a href="<?php echo esc_url(site_url('/board-of-directors/')); ?>">Board of Directors</a></li>
                    <li><a href="#">Staff</a></li>
                    <li><a href="<?php echo esc_url(site_url('/coaches/')); ?>">Coaches</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Connect</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
                <li><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li>
                <?php if ($facebook) : ?>
                    <li><a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener">Facebook</a></li>
                <?php endif; ?>
                <?php if ($instagram) : ?>
                    <li><a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener">Instagram</a></li>
                <?php endif; ?>
                <?php if ($youtube) : ?>
                    <li><a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener">YouTube</a></li>
                <?php endif; ?>
            </ul>
            <p class="footer-address"><?php echo nl2br(esc_html($address)); ?></p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
