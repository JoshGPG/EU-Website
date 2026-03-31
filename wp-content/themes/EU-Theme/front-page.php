<?php get_header(); ?>

</div><!-- close .container from header -->
</main><!-- close .site-content from header -->

<!-- Hero Box - Large slider -->
<section class="hero-box">
    <div class="hero-slider">
        <?php
// Build slides array from individual ACF fields (slots 1-4)
$slides = [];
for ($i = 1; $i <= 8; $i++) {
    $title = get_field('slide_title_' . $i);
    if ($title) {
        $slides[] = [
            'title' => $title,
            'subtitle' => get_field('slide_subtitle_' . $i),
            'image' => get_field('slide_image_' . $i),
            'bg_color' => get_field('slide_bg_color_' . $i) ?: '#2c3e50',
        ];
    }
}

if (!empty($slides)):
    foreach ($slides as $idx => $slide):
        $active = ($idx === 0) ? ' active' : '';
        $style = 'background-color: ' . esc_attr($slide['bg_color']) . ';';
        if (!empty($slide['image'])) {
            $style .= ' background-image: url(' . esc_url($slide['image']) . ');';
        }
?>
        <div class="hero-slide<?php echo $active; ?>" style="<?php echo $style; ?>">
            <div class="hero-slide-content">
                <h1>
                    <?php echo esc_html($slide['title']); ?>
                </h1>
                <p>
                    <?php echo esc_html($slide['subtitle']); ?>
                </p>
            </div>
        </div>
        <?php
    endforeach; ?>
        <?php
else: ?>
        <div class="hero-slide active" style="background-color: #2c3e50;">
            <div class="hero-slide-content">
                <h1>Welcome to EnduranceUnited</h1>
                <p>Active. Healthy. Outdoors.</p>
            </div>
        </div>
        <?php
endif; ?>
    </div>
    <?php if (count($slides) > 1): ?>
    <div class="hero-slider-dots">
        <?php for ($i = 0; $i < count($slides); $i++): ?>
        <span class="dot<?php echo ($i === 0) ? ' active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
        <?php
    endfor; ?>
    </div>
    <?php
endif; ?>
</section>

<!-- Programs Showcase Grid -->
<?php
$featured_query = new WP_Query([
    'post_type' => 'eu_program',
    'posts_per_page' => 8,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'meta_query' => [['key' => '_eu_program_featured', 'value' => '1']],
]);

if ($featured_query->have_posts()): ?>
<section class="showcase-grid" style="--card-count: <?php echo $featured_query->post_count; ?>;">
    <?php while ($featured_query->have_posts()):
        $featured_query->the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        $coach = get_post_meta(get_the_ID(), '_eu_program_coach', true);
        $short_desc = get_post_meta(get_the_ID(), '_eu_program_short_desc', true);
        $page_link = get_post_meta(get_the_ID(), '_eu_program_page_link', true) ?: '#';
?>
    <a href="<?php echo esc_url($page_link); ?>" class="showcase-card">
        <div class="showcase-card-img" <?php if ($thumb): ?> style="background-image: url(
            <?php echo esc_url($thumb); ?>);"
            <?php
        endif; ?>>
        </div>
        <div class="showcase-card-body">
            <h3 class="showcase-card-title">
                <?php the_title(); ?>
            </h3>
            <?php if ($coach): ?>
            <p class="showcase-card-coach">Coach:
                <?php echo esc_html($coach); ?>
            </p>
            <?php
        endif; ?>
            <?php if ($short_desc): ?>
            <p class="showcase-card-desc">
                <?php echo esc_html($short_desc); ?>
            </p>
            <?php
        endif; ?>
            <span class="showcase-card-btn">Learn More &rarr;</span>
        </div>
    </a>
    <?php
    endwhile; ?>
</section>
<?php wp_reset_postdata();
endif; ?>

<!-- Two Column Boxes -->
<section class="two-col-boxes">
    <?php
$twocol_defaults = [
    1 => ['title' => 'Latest News', 'text' => 'Stay up to date with the latest program announcements, race results, and community highlights from EnduranceUnited.', 'link_label' => 'Read More', 'link_url' => site_url('/news/'), 'color' => '#2D62A5'],
    2 => ['title' => 'Upcoming Events', 'text' => 'Check out our calendar of races, training camps, and community gatherings happening throughout the season.', 'link_label' => 'View Events', 'link_url' => site_url('/events/'), 'color' => '#245089'],
];
for ($i = 1; $i <= 2; $i++):
    $d = $twocol_defaults[$i];
    $title = get_field('twocol_title_' . $i) ?: $d['title'];
    $text = get_field('twocol_text_' . $i) ?: $d['text'];
    $label = get_field('twocol_link_label_' . $i) ?: $d['link_label'];
    $url = get_field('twocol_link_url_' . $i) ?: $d['link_url'];
    $color = get_field('twocol_color_' . $i) ?: $d['color'];
?>
    <div class="col-box" style="background-color: <?php echo esc_attr($color); ?>;">
        <h2>
            <?php echo esc_html($title); ?>
        </h2>
        <p>
            <?php echo esc_html($text); ?>
        </p>
        <a href="<?php echo esc_url($url); ?>" class="box-link">
            <?php echo esc_html($label); ?> &rarr;
        </a>
    </div>
    <?php
endfor; ?>
</section>

<!-- 2x2 Feature Grid -->
<section class="feature-grid">
    <?php
$feat_defaults = [
    1 => ['label' => 'Upcoming Race', 'title' => 'City of Lakes Loppet', 'text' => 'Check the calendar for the next race and get registered before spots fill up.', 'cta' => 'View Calendar', 'url' => site_url('/events/'), 'color' => '#2D62A5'],
    2 => ['label' => 'Featured Program', 'title' => 'Adult Year-Round Nordic', 'text' => 'Train with experienced coaches year-round. Beginner to advanced skiers welcome.', 'cta' => 'Learn More', 'url' => site_url('/adult-nordic/'), 'color' => '#B9313A'],
    3 => ['label' => 'From the Blog', 'title' => 'Season Recap & What\'s Ahead', 'text' => 'A look back at an incredible season and a preview of what\'s coming next.', 'cta' => 'Read Post', 'url' => site_url('/news/'), 'color' => '#333333'],
    4 => ['label' => 'Support EU', 'title' => 'Make a Donation', 'text' => 'Your donations fund scholarships, equipment, trail access, and youth programs so everyone can get outside.', 'cta' => 'Donate Now', 'url' => '#', 'color' => '#2D62A5'],
];
for ($i = 1; $i <= 4; $i++):
    $d = $feat_defaults[$i];
    $label = get_field('feat_label_' . $i) ?: $d['label'];
    if (!$label)
        continue;
    $title = get_field('feat_title_' . $i) ?: $d['title'];
    $text = get_field('feat_text_' . $i) ?: $d['text'];
    $cta = get_field('feat_cta_' . $i) ?: $d['cta'];
    $url = get_field('feat_url_' . $i) ?: $d['url'];
    $color = get_field('feat_color_' . $i) ?: $d['color'];
?>
    <a href="<?php echo esc_url($url); ?>" class="feature-box"
        style="background-color: <?php echo esc_attr($color); ?>;">
        <span class="feature-label">
            <?php echo esc_html($label); ?>
        </span>
        <h2>
            <?php echo esc_html($title); ?>
        </h2>
        <p>
            <?php echo esc_html($text); ?>
        </p>
        <span class="feature-cta">
            <?php echo esc_html($cta); ?> &rarr;
        </span>
    </a>
    <?php
endfor; ?>
</section>

<!-- Testimonials Slider -->
<?php
$testimonial_query = new WP_Query([
    'post_type' => 'eu_testimonial',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => [['key' => '_eu_testimonial_featured', 'value' => '1']],
]);

if ($testimonial_query->have_posts()): ?>
<section class="testimonials">
    <div class="testimonials-inner">
        <?php $idx = 0;
    while ($testimonial_query->have_posts()):
        $testimonial_query->the_post();
        $author = get_post_meta(get_the_ID(), '_eu_testimonial_author', true);
        $program = get_post_meta(get_the_ID(), '_eu_testimonial_program', true);
        $byline = $author;
        if ($program)
            $byline .= ', ' . $program;
?>
        <div class="testimonial-slide<?php echo ($idx === 0) ? ' active' : ''; ?>">
            <p class="testimonial-quote">&ldquo;
                <?php echo esc_html(wp_strip_all_tags(get_the_content())); ?>&rdquo;
            </p>
            <?php if ($byline): ?>
            <span class="testimonial-author">&mdash;
                <?php echo esc_html($byline); ?>
            </span>
            <?php
        endif; ?>
        </div>
        <?php $idx++;
    endwhile; ?>
    </div>
    <?php if ($testimonial_query->post_count > 1): ?>
    <div class="testimonial-dots">
        <?php for ($i = 0; $i < $testimonial_query->post_count; $i++): ?>
        <span class="dot<?php echo ($i === 0) ? ' active' : ''; ?>" data-tslide="<?php echo $i; ?>"></span>
        <?php
        endfor; ?>
    </div>
    <?php
    endif; ?>
</section>
<?php wp_reset_postdata();
endif; ?>

<script>
    (function () {
        var slides = document.quer                    ectorAll('.hero-slide');
        var dots = document                                l('.her        ider        s .d            ;
                if             des.leng             2) retu                    var                 = 0;
                       al = sli                    
        funct                  ide(index)                           slides[cur                             emove('acti                                    ts[        e            sList                                   
            curre                                                 slides[curren t].class                                      ive');
                                          las                 ('active');
                                           me                      l(function ()  {
                                       ((curr                otal                , 15 000)                                             forEach(functi                                             ddEventLi                                                    n () {
                        g oTo                    nt(this.g                                                            ;
                    c    learInter val                                                       = se        erva           unct            ()                                   go ToSl             cu            1) % tota                                }, 15000);
                }                            );
    })();

    // Testimon                   der
            ction ()                                tSlides = document.        ySelectorA                                 ial-slide');
         var                            umen            electo rAll(                                 ts .dot');
        if (!tSlides.lengt                                       var tCu                                     Tot          t                    h;

                                  oTes                ex) {
                tSli                        t.remove('ac                                     s[t         en                    ove( 'acti                            Curr                
                     es[t                        tive');
                    ts[t            .classList.ad d('ac                    }

                        = setInterval(f                
                     esti        al((    tCu            }, 60                  tDots.forEach(function (dot ) {
                     ddEventListener('click', function () {
                    goToTesti            arse        this    .getAttr;
                clearInterval(tTimer);
                tTimer = setInterval(function () {
                    goToTestimonial((tCurrent + 1) % tTotal);
                }, 6000);
            });
        });
    })();
</script>

<?php get_footer(); ?>