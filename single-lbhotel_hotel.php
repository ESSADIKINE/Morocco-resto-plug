<?php
/**
 * Template for displaying single Le Bon Hotel posts.
 *
 * Copy this file into your active theme to override the default single view for
 * the `lbhotel_hotel` custom post type provided by the Le Bon Hotel plugin.
 *
 * @package LeBonHotel
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="hotel-container">
    <?php
    while ( have_posts() ) :
        the_post();

        $hotel_id   = get_the_ID();
        $city       = get_post_meta( $hotel_id, 'lbhotel_city', true );
        $region     = get_post_meta( $hotel_id, 'lbhotel_region', true );
        $postal     = get_post_meta( $hotel_id, 'lbhotel_postal_code', true );
        $country    = get_post_meta( $hotel_id, 'lbhotel_country', true );
        $star_rating = (int) get_post_meta( $hotel_id, 'lbhotel_star_rating', true );
        $rooms_total = get_post_meta( $hotel_id, 'lbhotel_rooms_total', true );
        $checkin     = get_post_meta( $hotel_id, 'lbhotel_checkin_time', true );
        $checkout    = get_post_meta( $hotel_id, 'lbhotel_checkout_time', true );
        $avg_price   = get_post_meta( $hotel_id, 'lbhotel_avg_price_per_night', true );
        $gallery_ids = get_post_meta( $hotel_id, 'lbhotel_gallery_images', true );
        $booking_url = get_post_meta( $hotel_id, 'lbhotel_booking_url', true );

        if ( ! is_array( $gallery_ids ) ) {
            $gallery_ids = array_filter( array_map( 'absint', (array) $gallery_ids ) );
        }

        $star_rating = max( 0, min( 5, $star_rating ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'hotel-single' ); ?>>
            <header class="hotel-header">
                <h1 class="hotel-title"><?php the_title(); ?></h1>

                <?php if ( $star_rating > 0 ) : ?>
                    <div class="hotel-star-rating" aria-label="<?php echo esc_attr( sprintf( _n( '%d star', '%d stars', $star_rating, 'lbhotel' ), $star_rating ) ); ?>">
                        <?php
                        echo str_repeat( '<span class="hotel-star" aria-hidden="true">&#9733;</span>', $star_rating );
                        ?>
                    </div>
                <?php endif; ?>
            </header>

            <section class="hotel-meta">
                <ul class="hotel-meta-list">
                    <?php if ( $city || $region || $postal || $country ) : ?>
                        <li class="hotel-meta-item hotel-meta-location">
                            <strong><?php esc_html_e( 'Location:', 'lbhotel' ); ?></strong>
                            <span>
                                <?php
                                $location_parts = array_filter( array( $city, $region, $postal, $country ) );
                                echo esc_html( implode( ', ', $location_parts ) );
                                ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <?php if ( $rooms_total ) : ?>
                        <li class="hotel-meta-item hotel-meta-rooms">
                            <strong><?php esc_html_e( 'Rooms Available:', 'lbhotel' ); ?></strong>
                            <span><?php echo esc_html( number_format_i18n( (int) $rooms_total ) ); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ( $checkin ) : ?>
                        <li class="hotel-meta-item hotel-meta-checkin">
                            <strong><?php esc_html_e( 'Check-in:', 'lbhotel' ); ?></strong>
                            <span><?php echo esc_html( $checkin ); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ( $checkout ) : ?>
                        <li class="hotel-meta-item hotel-meta-checkout">
                            <strong><?php esc_html_e( 'Check-out:', 'lbhotel' ); ?></strong>
                            <span><?php echo esc_html( $checkout ); ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ( '' !== $avg_price && null !== $avg_price ) :
                        $price_display = is_numeric( $avg_price ) ? number_format_i18n( (float) $avg_price, 2 ) : sanitize_text_field( $avg_price );
                        ?>
                        <li class="hotel-meta-item hotel-meta-price">
                            <strong><?php esc_html_e( 'Average Price per Night:', 'lbhotel' ); ?></strong>
                            <span><?php echo esc_html( $price_display ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </section>

            <div class="hotel-content entry-content">
                <?php the_content(); ?>
            </div>

            <?php if ( ! empty( $gallery_ids ) ) : ?>
                <section class="hotel-gallery" aria-label="<?php esc_attr_e( 'Hotel gallery', 'lbhotel' ); ?>">
                    <div class="hotel-gallery-grid">
                        <?php
                        foreach ( $gallery_ids as $attachment_id ) {
                            $image_html = wp_get_attachment_image( $attachment_id, 'large', false, array( 'class' => 'hotel-gallery-image' ) );

                            if ( $image_html ) {
                                echo '<figure class="hotel-gallery-item">' . $image_html . '</figure>';
                            }
                        }
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ( $booking_url ) : ?>
                <div class="hotel-booking">
                    <a class="hotel-booking-button" href="<?php echo esc_url( $booking_url ); ?>" target="_blank" rel="noopener">
                        <?php esc_html_e( 'Book Now', 'lbhotel' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();
