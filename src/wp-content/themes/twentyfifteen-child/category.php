<?php
/**
 * The template for displaying all posts sharing same category
 */

get_header(); 


$term = get_queried_object(); 
$taxonomy = $term->taxonomy;

$stories = new WP_Query( array(
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
        'post_type'      => array( 'story' ),
        'post_status'    => 'publish',
        'category_name'  => $term->slug
    )
);

$books = new WP_Query( array(
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
        'post_type'      => array( 'book' ),
        'post_status'    => 'publish',
        'category_name'  => $term->slug
    )
);

$reportages = new WP_Query( array(
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => -1,
        'post_type'      => array( 'reportage' ),
        'post_status'    => 'publish',
        'category_name'  => $term->slug
    )
);

?>

<div id="primary" class="content-area featured-content">
    <main id="main" class="site-main container" role="main">

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2 class="category-title"><i class="material-icons">local_offer</i><?php echo $term->name; ?></h2>
            </div>
        </div>

        <!-- Stories -->
        <section id="stories" class="section <?php echo $stories->have_posts() ? 'section-open' : 'section-disabled'; ?>">
            <div class="row section-title">
                <div class="col-sm-12 col-md-12">
                    <h4>
                        <?php echo __( 'Stories', 'twentyfifteen-child' ); ?>&nbsp;<small>(<?php echo $stories->post_count; ?>)</small>
                        <i class="material-icons arrow-down">keyboard_arrow_down</i>
                        <i class="material-icons arrow-right">keyboard_arrow_right</i>
                    </h4>
                    <hr />
                </div>
            </div>

            <div class="row section-content">
                <div class="col-sm-4 col-md-4">
                   <!-- TODO -->
                </div>
            </div>
        </section>

        <!-- Books -->
        <section id="books" class="section <?php echo $books->have_posts() ? 'section-open' : 'section-disabled'; ?>">
            <div class="row section-title">
                <div class="col-sm-12 col-md-12">
                    <h4>
                        <?php echo __( 'Books', 'twentyfifteen-child' ); ?>&nbsp;<small>(<?php echo $books->post_count; ?>)</small>
                        <i class="material-icons arrow-down">keyboard_arrow_down</i>
                        <i class="material-icons arrow-right">keyboard_arrow_right</i>
                    </h4>
                    <hr />
                </div>
            </div>

            <div class="row transitions-enabled fluid masonry js-masonry grid section-content">
                <?php while ( $books->have_posts() ) :
                    // Post
                    $book = get_post( $books->the_post() );
                    // Cover
                    $coverImage = get_field( 'book_cover_image', $book );
                    // Authors
                    $authors = get_field( 'book_authors', $book, false );
                    // Publication date
                    $publicationDate = new DateTime( get_field( 'book_publication_date', $book, false ) );
                    // Tags
                    $tags = wp_get_post_tags( $book->ID );
                    // Categories
                    $categories = get_post_categories( $post );
                ?>

                    <div class="col-sm-4 col-md-4 grid-item">
                        <article class="thumbnail thumbnail-book">
                            <div class="content">
                                <div class="corner">
                                    <a href="#" class="triangle triangle-top-right"></a>
                                    <span class="label"><i class="material-icons">add</i></span>
                                </div>
                                <div class="image clearfix">
                                    <?php if ( $coverImage ): ?>
                                        <img src="<?php echo $coverImage['sizes']['medium_large']; ?>" alt="<?php echo $book->post_title; ?>" />
                                    <?php else: ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/default/book-cover.jpg" alt="<?php echo $book->post_title; ?>" />
                                    <?php endif; ?>
                                </div>
                                <h3 class="title"><?php echo $book->post_title; ?></h3>
                                <h3 class="authors"><?php echo $authors; ?></h3>
                                <a class="see-more-link-area" href="<?php echo get_permalink( $book ); ?>" title="<?php echo __( 'See more', 'twentyfifteen-child' ); ?>"></a>
                            </div>
                            <div class="footer">
                                <?php foreach ( $categories as $index => $category ) : ?>
                                    <a href="<?php echo get_category_link( $category ); ?>" class="category">
                                        <i class="material-icons">local_offer</i><?php echo $category->name; ?>
                                    </a>&nbsp;
                                <?php endforeach; ?>
                                <?php foreach ( $tags as $index => $tag ) : ?>
                                    <a href="<?php echo get_term_link( $tag ); ?>" class="tag">#<?php echo $tag->name; ?></a>&nbsp;
                                <?php endforeach; ?>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
                <div class="col-sm-4 col-md-4">
                    <article class="thumbnail thumbnail-book">
                        <div class="content">
                            <div class="corner">
                                <a href="#" class="triangle triangle-top-right"></a>
                                <span class="label"><i class="material-icons">add</i></span>
                            </div>
                            <a class="image clearfix" href="<?php echo get_permalink( $book ); ?>">
                                <?php //if ( $coverImage ): ?>
                                    <!--<img src="<?php echo $coverImage['sizes']['medium_large']; ?>" alt="<?php echo $book->post_title; ?>" />-->
                                <?php //else: ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/default/book-cover.jpg" alt="<?php echo $book->post_title; ?>" />
                                <?php //endif; ?>
                            </a>
                            <h3 class="title">
                                <a href="<?php echo get_permalink( $book ); ?>">Titre<?php //echo $book->post_title; ?></a>
                            </h3>
                            <h3 class="authors">Auteurs<?php //echo $authors; ?></h3>
                            <a class="see-more-link-area" href="<?php //echo get_permalink( $book ); ?>" title="<?php echo __( 'See more', 'twentyfifteen-child' ); ?>"></a>
                        </div>
                        <!--<div class="footer">
                            <?php foreach ( $categories as $index => $category ) : ?>
                                <a href="<?php echo get_category_link( $category ); ?>" class="category">
                                    <i class="material-icons">local_offer</i><?php echo $category->name; ?>
                                </a>&nbsp;
                            <?php endforeach; ?>
                            <?php foreach ( $tags as $index => $tag ) : ?>
                                <a href="<?php echo get_term_link( $tag ); ?>" class="tag">#<?php echo $tag->name; ?></a>&nbsp;
                            <?php endforeach; ?>
                        </div>-->
                    </article>
                </div>
                <div class="col-sm-4 col-md-4">
                    <article class="thumbnail thumbnail-book">
                        <div class="content">
                            <div class="corner">
                                <a href="#" class="triangle triangle-top-right"></a>
                                <span class="label"><i class="material-icons">add</i></span>
                            </div>
                            <a class="image clearfix" href="<?php echo get_permalink( $book ); ?>">
                                <?php //if ( $coverImage ): ?>
                                    <!--<img src="<?php echo $coverImage['sizes']['medium_large']; ?>" alt="<?php echo $book->post_title; ?>" />-->
                                <?php //else: ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/default/book-cover.jpg" alt="<?php echo $book->post_title; ?>" />
                                <?php //endif; ?>
                            </a>
                            <h3 class="title">
                                <a href="<?php echo get_permalink( $book ); ?>">Titre<?php //echo $book->post_title; ?></a>
                            </h3>
                            <h3 class="authors">Auteurs<?php //echo $authors; ?></h3>
                            <a class="see-more-link-area" href="<?php //echo get_permalink( $book ); ?>" title="<?php echo __( 'See more', 'twentyfifteen-child' ); ?>"></a>
                        </div>
                        <!--<div class="footer">
                            <?php foreach ( $categories as $index => $category ) : ?>
                                <a href="<?php echo get_category_link( $category ); ?>" class="category">
                                    <i class="material-icons">local_offer</i><?php echo $category->name; ?>
                                </a>&nbsp;
                            <?php endforeach; ?>
                            <?php foreach ( $tags as $index => $tag ) : ?>
                                <a href="<?php echo get_term_link( $tag ); ?>" class="tag">#<?php echo $tag->name; ?></a>&nbsp;
                            <?php endforeach; ?>
                        </div>-->
                    </article>
                </div>
                <div class="col-sm-4 col-md-4">
                    <article class="thumbnail thumbnail-book">
                        <div class="content">
                            <div class="corner">
                                <a href="#" class="triangle triangle-top-right"></a>
                                <span class="label"><i class="material-icons">add</i></span>
                            </div>
                            <a class="image clearfix" href="<?php echo get_permalink( $book ); ?>">
                                <?php //if ( $coverImage ): ?>
                                    <!--<img src="<?php echo $coverImage['sizes']['medium_large']; ?>" alt="<?php echo $book->post_title; ?>" />-->
                                <?php //else: ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/default/book-cover.jpg" alt="<?php echo $book->post_title; ?>" />
                                <?php //endif; ?>
                            </a>
                            <h3 class="title">
                                <a href="<?php echo get_permalink( $book ); ?>">Titre<?php //echo $book->post_title; ?></a>
                            </h3>
                            <h3 class="authors">Auteurs<?php //echo $authors; ?></h3>
                            <a class="see-more-link-area" href="<?php //echo get_permalink( $book ); ?>" title="<?php echo __( 'See more', 'twentyfifteen-child' ); ?>"></a>
                        </div>
                        <!--<div class="footer">
                            <?php foreach ( $categories as $index => $category ) : ?>
                                <a href="<?php echo get_category_link( $category ); ?>" class="category">
                                    <i class="material-icons">local_offer</i><?php echo $category->name; ?>
                                </a>&nbsp;
                            <?php endforeach; ?>
                            <?php foreach ( $tags as $index => $tag ) : ?>
                                <a href="<?php echo get_term_link( $tag ); ?>" class="tag">#<?php echo $tag->name; ?></a>&nbsp;
                            <?php endforeach; ?>
                        </div>-->
                    </article>
                </div>
            </div>
        </section>

        <!-- Reportages -->
        <section id="reportages" class="section <?php echo $reportages->have_posts() ? 'section-open' : 'section-disabled'; ?>">
            <div class="row section-title">
                <div class="col-sm-12 col-md-12">
                    <h4>
                        <?php echo __( 'Reportages', 'twentyfifteen-child' ); ?>&nbsp;<small>(<?php echo $reportages->post_count; ?>)</small>
                        <i class="material-icons arrow-down">keyboard_arrow_down</i>
                        <i class="material-icons arrow-right">keyboard_arrow_right</i>
                    </h4>
                    <hr />
                </div>
            </div>

            <div class="row section-content">
                <div class="col-sm-4 col-md-4">
                    <!-- TODO -->
                </div>
            </div>
        </section>
    </main>
</div>

<?php wp_reset_postdata(); ?>
<?php $post = null; ?>

<?php get_footer(); ?>