<?php
namespace vtech_project_list\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class project_list extends Widget_Base {

    public function get_name() {
        return 'project_list';
    }

    public function get_title() {
        return __('project list', 'vtech-core');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['vtech_widget'];
    }

    protected function register_controls() {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'vtech-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'project-style1',
            [
                'label' => __('Project Style', 'vtech-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'vtech-core'),
                    'style2' => __('Style 2', 'vtech-core'),
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'vtech-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => __('Categories', 'vtech-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_project_categories(),
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'vtech-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'vtech-core'),
                    'title' => __('Title', 'vtech-core'),
                    'rand' => __('Random', 'vtech-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'vtech-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('Descending', 'vtech-core'),
                    'ASC' => __('Ascending', 'vtech-core'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'vtech-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'vtech-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-info h6' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'vtech-core'),
                'selector' => '{{WRAPPER}} .card-info h6',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => __('Card Box Shadow', 'vtech-core'),
                'selector' => '{{WRAPPER}} .card-project',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type' => 'project',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
        );

        if (!empty($settings['categories'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'project_category',
                    'field' => 'term_id',
                    'terms' => $settings['categories'],
                ]
            ];
        }

        $projects = new \WP_Query($args);

        if($settings['project-style1'] === 'style1') {
            ?>
            <section class="box-section box-project-detail">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <?php 
                    if($projects->have_posts()) :
                        while($projects->have_posts()) : $projects->the_post();
                            $project_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $project_title = get_the_title();
                    ?>
                    <div class="col-lg-4">
                        <div class="card-project card-project-5">
                            <div class="card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($project_image); ?>" alt="<?php echo esc_attr($project_title); ?>" />
                                </a>
                            </div>
                            <div class="card-info">
                                <div class="card-info-left">
                                    <a href="<?php the_permalink(); ?>">
                                        <h6><?php echo esc_html($project_title); ?></h6>
                                    </a>
                                </div>
                                <div class="card-info-right">
                                    <a href="<?php the_permalink(); ?>">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.875 8.5C16.875 9.20312 16.2891 9.78906 15.625 9.78906H10V15.4141C10 16.0781 9.41406 16.625 8.75 16.625C8.04688 16.625 7.5 16.0781 7.5 15.4141V9.78906H1.875C1.17188 9.78906 0.625 9.20312 0.625 8.5C0.625 7.83594 1.17188 7.28906 1.875 7.28906H7.5V1.66406C7.5 0.960938 8.04688 0.375 8.75 0.375C9.41406 0.375 10 0.960938 10 1.66406V7.28906H15.625C16.2891 7.25 16.875 7.83594 16.875 8.5Z" fill="" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>
            <?php
        } else {
            ?>
            <section class="position-relative overflow-hidden box-projects-home2">
            <div class="container" data-aos="fade-up">
                <div class="row align-items-end">
                    <div class="col-lg-7 mb-30">
                        <div class="banner-small-title-black">Projects</div>
                        <h2 class="heading-ag-3xl dark-950">
                            Market Entry Strategy Develop<br class="d-none d-lg-block" />
                            for Global Expansion
                        </h2>
                    </div>
                    <div class="col-lg-5 mb-30">
                        <p class="mb-20 paragraph-rubik-r">Lorem Ipsum disponibles, pero la mayoría sufrió alteraciones en alguna manera, ya sea porque se le agregó humor</p>
                        <a href="#" class="btn btn-primary-square-border">
                            Browse all project
                            <img src="assets/imgs/template/icons/plus-black.svg" alt="Vatech" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-5" data-aos="fade-up">
                <div class="box-list-projects">
                <?php 
                    if($projects->have_posts()) :
                        $count = 0;
                        while($projects->have_posts()) : $projects->the_post();
                            $project_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $project_title = get_the_title();
                            $mt_class = ($count % 2 == 1) ? ' mt-5' : '';
                ?>
                    <div class="item-project<?php echo $mt_class; ?>">
                        <div class="card-project-9">
                            <div class="card-image">
                                <img src="<?php echo esc_url($project_image); ?>" alt="<?php echo esc_attr($project_title); ?>" />
                            </div>
                            <div class="card-info">
                                <a href="<?php the_permalink(); ?>" class="heading-lg"><?php echo esc_html($project_title); ?></a>
                            </div>
                        </div>
                    </div>
                <?php
                            $count++;
                        endwhile;
                        wp_reset_postdata();
                    endif;
                ?>
                </div>
            </div>
        </section>
            <?php
        }
    }

    private function get_project_categories() {
        $categories = get_terms('project_category', array('hide_empty' => false));
        $options = array();
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }
}

$widgets_manager->register(new project_list());