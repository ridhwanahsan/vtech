<?php
namespace vtech_blog_post\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class vtech_blog_post extends Widget_Base {

	public function get_name() {
		return 'post_list';
	}

	public function get_title() {
		return __( 'Post List', 'elementor-hello-world' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'vtech_widget' ];
	}

	public function get_script_depends() {
		return [ 'elementor-hello-world' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	protected function register_content_controls() {
		// Layout Section
		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__('Layout', 'textdomain'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'card_style',
			[
				'label' => esc_html__('Card Style', 'textdomain'),
				'type' => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => esc_html__('Style 1 (Consultant)', 'textdomain'),
					'style2' => esc_html__('Style 2 (Team)', 'textdomain'),
					
				],
			]
		);

		$this->end_controls_section();

		// Blog Post Section  
		$this->start_controls_section(
			'blog_post_section',
			[
				'label' => esc_html__( 'Blog Post', 'textdomain' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_limit',
			[
				'label' => esc_html__('Post Limit', 'textdomain'),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'post_include',
			[
				'label' => esc_html__('Post Include', 'textdomain'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => post_cat(),
			]
		);

		$this->add_control(
			'post_exclude',
			[
				'label' => esc_html__('Post Exclude', 'textdomain'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => post_cat(),
			]
		);

		$this->add_control(
			'post_title_include',
			[
				'label' => esc_html__('Post Title Include', 'textdomain'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => get_all_post(),
			]
		);

		$this->add_control(
			'post_title_exclude',
			[
				'label' => esc_html__('Post Title Exclude', 'textdomain'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => get_all_post(),
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => esc_html__('Order', 'textdomain'),
				'type' => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'asc' => esc_html__('ASC', 'textdomain'),
					'desc' => esc_html__('DESC', 'textdomain'),
				],
			]
		);

		$this->add_control(
			'post_orderby',
			[
				'label' => esc_html__('Order By', 'textdomain'),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'ID' => esc_html__('Post ID', 'textdomain'),
					'author' => esc_html__('Post Author', 'textdomain'),
					'title' => esc_html__('Title', 'textdomain'),
					'date' => esc_html__('Date', 'textdomain'),
					'modified' => esc_html__('Last Modified Date', 'textdomain'),
					'parent' => esc_html__('Parent Id', 'textdomain'),
					'rand' => esc_html__('Random', 'textdomain'),
					'comment_count' => esc_html__('Comment Count', 'textdomain'),
					'menu_order' => esc_html__('Menu Order', 'textdomain'),
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Style', 'textdomain'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Title Color', 'textdomain'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .link-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__('Title Typography', 'textdomain'),
				'selector' => '{{WRAPPER}} .link-title',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__('Meta Color', 'textdomain'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .card-meta span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'label' => esc_html__('Meta Typography', 'textdomain'),
				'selector' => '{{WRAPPER}} .card-meta span',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $settings['post_limit'],
			'orderby' => $settings['post_orderby'],
			'order' => $settings['post_order'],
			'post__in' => $settings['post_title_include'],
			'post__not_in' => $settings['post_title_exclude'],
		);

		if (!empty($settings['post_include']) && !empty($settings['post_exclude'])) {
			$args['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $settings['post_include'],
					'operator' => 'IN',
				),
				array(
					'taxonomy' => 'category', 
					'field' => 'slug',
					'terms' => $settings['post_exclude'],
					'operator' => 'NOT IN',
				),
			);
		} elseif (!empty($settings['post_include']) || !empty($settings['post_exclude'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $settings['post_exclude'] ? $settings['post_exclude'] : $settings['post_include'],
					'operator' => $settings['post_exclude'] ? 'NOT IN' : 'IN',
				),
			);
		}

		$query = new \WP_Query($args);

		if ($settings['card_style'] === 'style1') {
			?>
			<div class="row position-relative m-0 p-0" data-aos="fade-up">
				<?php 
				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						?>
						<div class="col-lg-4" data-aos="fade-up" data-aos-duration="500">
							<div class="card-blog">
								<div class="card-image">
									<a href="<?php the_permalink(); ?>">
										<img class="wow img-custom-anim-top" src="<?php echo get_the_post_thumbnail_url() ?: 'assets/images/blog/blog1.jpg'; ?>" alt="<?php the_title_attribute(); ?>" />
									</a>
									<span class="card-date"><?php echo get_the_date('d M'); ?></span>
								</div>
								<div class="card-info">
									<div class="card-meta">
										<?php
										$categories = get_the_category(get_the_ID());
										if (!empty($categories)) :
											?>
											<span class="comment"><?php echo esc_html($categories[0]->name); ?></span>
										<?php endif; ?>
										<span class="by-user"><?php echo get_the_author(); ?></span>
									</div>
									<div class="card-title">
										<a href="<?php the_permalink(); ?>" class="link-title"><?php the_title(); ?></a>
										<a href="<?php the_permalink(); ?>" class="link-readmore">
											<?php echo esc_html__('Read More', 'textdomain'); ?>
											<svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M10 10C10 9.47 10.4581 8.67857 10.9219 8.01429C11.5181 7.15714 12.2306 6.40929 13.0475 5.83857C13.66 5.41071 14.4025 5 15 5M15 5C14.4025 5 13.6594 4.58929 13.0475 4.16143C12.2306 3.59 11.5181 2.84214 10.9219 1.98643C10.4581 1.32143 10 0.528572 10 3.7749e-07M15 5L2.18557e-07 5" stroke="" stroke-width="1.5" />
											</svg>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
			<?php
		} else {
			?>
			
			<div class="row position-relative m-0 p-0" data-aos="fade-up">
				<?php
				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						?>
						<div class="col-lg-4">
							<div class="card-blog card-blog-2">
								<div class="card-image">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo get_the_post_thumbnail_url() ?: 'assets/images/blog/blog1.jpg'; ?>" alt="<?php the_title_attribute(); ?>" />
									</a>
									<span class="card-date"><?php echo get_the_date('d M y'); ?></span>
								</div>
								<div class="card-info">
									<div class="card-meta">
										<?php
										$categories = get_the_category(get_the_ID());
										if (!empty($categories)) :
											?>
											<span class="comment"><?php echo esc_html($categories[0]->name); ?></span>
										<?php endif; ?>
										<span class="by-user"><?php echo get_the_author(); ?></span>
									</div>
									<div class="card-title">
										<a href="<?php the_permalink(); ?>" class="link-title"><?php the_title(); ?></a>
										<a href="<?php the_permalink(); ?>" class="link-readmore">
											<?php echo esc_html__('Read More', 'textdomain'); ?>
											<svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M10 10C10 9.47 10.4581 8.67857 10.9219 8.01429C11.5181 7.15714 12.2306 6.40929 13.0475 5.83857C13.66 5.41071 14.4025 5 15 5M15 5C14.4025 5 13.6594 4.58929 13.0475 4.16143C12.2306 3.59 11.5181 2.84214 10.9219 1.98643C10.4581 1.32143 10 0.528572 10 3.7749e-07M15 5L2.18557e-07 5" stroke="" stroke-width="1.5" />
											</svg>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
			<?php
		}
	}
}

$widgets_manager->register(new vtech_blog_post());