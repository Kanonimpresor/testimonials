<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Templates for plugin displays.
 * Updated for Bootstrap 5.3 + Royal Bus palette.
 */

$TESTIMONIALS_TEMPLATE['menu_header'] = '
<div class="testimonials-section" data-readmore="{LAN=LAN_TESTIMONIALS_18}" data-readless="{LAN=LAN_TESTIMONIALS_19}">
	<div id="testimonials-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

		<!-- Carousel Slides -->
		<div class="carousel-inner">';

$TESTIMONIALS_TEMPLATE['menu_body'] = '
			<div class="carousel-item{TESTIMONIALS_ACTIVE}">
				<div class="testimonial-card">
					<div class="testimonial-quote-icon">
						<i class="fas fa-quote-left"></i>
					</div>
					<blockquote class="testimonial-message">
						<p>{TESTIMONIALS_MESSAGE}</p>
					</blockquote>
					<div class="testimonial-author">
						<span class="testimonial-author-name">{TESTIMONIALS_AUTHOR}</span>
					</div>
				</div>
			</div>';

$TESTIMONIALS_TEMPLATE['menu_footer'] = '
		</div>

		<!-- Carousel Indicators -->
		{TESTIMONIALS_INDICATORS}

		<!-- Carousel Controls -->
		<button class="carousel-control-prev" type="button" data-bs-target="#testimonials-carousel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">{LAN=LAN_TESTIMONIALS_15}</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#testimonials-carousel" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">{LAN=LAN_TESTIMONIALS_16}</span>
		</button>
	</div>
</div>
';
