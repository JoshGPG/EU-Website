<?php if (!is_front_page()) : ?>
    </div>
</main>
<?php endif; ?>

<footer class="site-footer">
    <div class="footer-columns">
        <div class="footer-col">
            <h3>About Us</h3>
            <p>Empowering communities through education, athletics, and mentorship. We are committed to developing young leaders on and off the field.</p>
        </div>

        <div class="footer-col">
            <h3>Get Involved</h3>
            <ul>
                <li><a href="#">Donate</a></li>
                <li><a href="#">Volunteer</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Sponsor Us</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Our Team</h3>
            <ul>
                <li><a href="<?php echo esc_url(site_url('/board-of-directors/')); ?>">Board of Directors</a></li>
                <li><a href="#">Staff</a></li>
                <li><a href="<?php echo esc_url(site_url('/coaches/')); ?>">Coaches</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Connect</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="mailto:info@enduranceunited.org">info@enduranceunited.org</a></li>
                <li><a href="tel:+16128503937">(612) 850-3937</a></li>
                <li><a href="https://www.facebook.com/EnduranceUntd/" target="_blank" rel="noopener">Facebook</a></li>
                <li><a href="https://www.instagram.com/enduranceunited/" target="_blank" rel="noopener">Instagram</a></li>
                <li><a href="https://www.youtube.com/channel/UCsrv65x0Vzscsh3vRJk_PUA" target="_blank" rel="noopener">YouTube</a></li>
            </ul>
            <p class="footer-address">713 Minnehaha Ave. East, Suite 216<br>Saint Paul, MN 55106, USA</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
