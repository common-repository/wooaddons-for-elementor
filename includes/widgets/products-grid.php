<?php


class wooaddons_Product_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Blank widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'woopg_widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Blank widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'WA Products Card', 'wooaddons-for-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Blank widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'fas fa-credit-card';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Blank widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'productwoo' ];
	}

	/**
	 * Register Blank widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_content_controls();
		$this->register_style_controls();

	}

	/**
	 * Register Blank widget content ontrols.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	function register_content_controls() {

		$this->start_controls_section(
            'woopg_query',
            [
                'label' => esc_html__( 'Products Query', 'wooaddons-for-elementor' ),
            ]
        );

            $this->add_control(
                'woopg_products_filter',
                [
                    'label' => esc_html__( 'Filter By', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'recent',
                    'options' => [
                        'recent' => esc_html__( 'Recent Products', 'wooaddons-for-elementor' ),
                        'featured' => esc_html__( 'Featured Products', 'wooaddons-for-elementor' ),
                        'best_selling' => esc_html__( 'Best Selling Products', 'wooaddons-for-elementor' ),
                        'sale' => esc_html__( 'Sale Products', 'wooaddons-for-elementor' ),
                        'top_rated' => esc_html__( 'Top Rated Products', 'wooaddons-for-elementor' ),
                        'random_order' => esc_html__( 'Random Products', 'wooaddons-for-elementor' ),
                        'show_byid' => esc_html__( 'Show By Id', 'wooaddons-for-elementor' ),
                        'show_byid_manually' => esc_html__( 'Add ID Manually', 'wooaddons-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'woopg_product_id',
                [
                    'label' => __( 'Select Product', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => wooaddons_product_name( ),
                    'condition' => [
                        'woopg_products_filter' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'woopg_product_ids_manually',
                [
                    'label' => __( 'Product IDs', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'woopg_products_filter' => 'show_byid_manually',
                    ]
                ]
            );

            $this->add_control(
              'woopg_products_count',
                [
                    'label'   => __( 'Product Limit', 'wooaddons-for-elementor' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'default' => 3,
                    'step'    => 1,
                ]
            );

            $this->add_control(
                'woopg_grid_categories',
                [
                    'label' => esc_html__( 'Product Categories', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => wooaddons_taxonomy_list(),
                    'condition' => [
                        'woopg_products_filter!' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'woopg_custom_order',
                [
                    'label' => esc_html__( 'Custom order', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => esc_html__( 'Orderby', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'          => esc_html__('None','wooaddons-for-elementor'),
                        'ID'            => esc_html__('ID','wooaddons-for-elementor'),
                        'date'          => esc_html__('Date','wooaddons-for-elementor'),
                        'name'          => esc_html__('Name','wooaddons-for-elementor'),
                        'title'         => esc_html__('Title','wooaddons-for-elementor'),
                        'comment_count' => esc_html__('Comment count','wooaddons-for-elementor'),
                        'rand'          => esc_html__('Random','wooaddons-for-elementor'),
                    ],
                    'condition' => [
                        'woopg_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => esc_html__( 'order', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => esc_html__('Descending','wooaddons-for-elementor'),
                        'ASC'   => esc_html__('Ascending','wooaddons-for-elementor'),
                    ],
                    'condition' => [
                        'woopg_custom_order' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();
        // Product Content
        $this->start_controls_section(
            'woopg_layout',
            [
                'label' => esc_html__( 'Grid Layout', 'wooaddons-for-elementor' ),
            ]
        );
         $this->add_control(
                'woopg_product_style',
                [
                    'label'   => __( 'Grid Style', 'wooaddons-for-elementor' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'wooaddons-for-elementor' ),
                        '2'  => __( 'Style Two', 'wooaddons-for-elementor' ),
                        '3'  => __( 'Style Three', 'wooaddons-for-elementor' ),
                    ]
                ]
            );
            $this->add_control(
              'woopg_rownumber',
                [
                    'label'   => __( 'Show Products Per Row', 'wooaddons-for-elementor' ),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '12'   => __( '1', 'wooaddons-for-elementor' ),
                        '6'  => __( '2', 'wooaddons-for-elementor' ),
                        '4'  => __( '3', 'wooaddons-for-elementor' ),
                        '3'  => __( '4', 'wooaddons-for-elementor' ),
                        '2'  => __( '6', 'wooaddons-for-elementor' ),
                    ]
                ]
            );
        $this->end_controls_section();
        // Product Content
        $this->start_controls_section(
            'woopg_content',
            [
                'label' => esc_html__( 'Content Settings', 'wooaddons-for-elementor' ),
            ]
        );
           

            $this->add_control(
                'woopg_product_img_show',
                [
                    'label'     => __( 'Show Products image', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'woopg_show_title',
                [
                    'label'     => __( 'Show Product Title', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );
            $this->add_control(
              'woopg_crop_title',
                [
                    'label'   => __( 'Crop Title By Word', 'wooaddons-for-elementor' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'step'    => 1,
                    'default' => 5,
                    'condition' => [
                        'woopg_show_title' => 'yes',
                    ]

                ]
            );
            $this->add_control(
			'woopg_title_tag',
			[
				'label' => __( 'Title HTML Tag', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
				'condition' => [
                        'woopg_show_title' => 'yes',
                    ]

			]
		);
            $this->add_control(
                'woopg_desc_show',
                [
                    'label'     => __( 'Show Product Description', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );
             $this->add_control(
              'woopg_crop_desc',
                [
                    'label'   => __( 'Crop Description By Word', 'wooaddons-for-elementor' ),
                    'type'    => \Elementor\Controls_Manager::NUMBER,
                    'step'    => 1,
                    'default' => 15,
                    'condition' => [
                        'woopg_desc_show' => 'yes',
                    ]
                                    ]
            );

            $this->add_control(
                'woopg_price_show',
                [
                    'label'     => __( 'Show Product Price', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );

            $this->add_control(
                'woopg_cart_btn',
                [
                    'label'     => __( 'Show button', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );
            
            $this->add_responsive_control(
			'woopg_content_align',
			[
				'label' => __( 'Alignment', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wooaddons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wooaddons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wooaddons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					
				],
				'default' => 'left',
				'classes' => 'flex-{{VALUE}}',
				'selectors' => [
					'{{WRAPPER}} .wae-card-text.woopg-card-text' => 'text-align: {{VALUE}};',
				],
			]
		);


        $this->end_controls_section();
		
		$this->start_controls_section(
			'woopg_meta_section',
			[
				'label' => __( 'Products Meta', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'default' => 'no',
			]
		);
		$this->add_control(
                'woopg_badge_show',
                [
                    'label'     => __( 'Show Badge', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );
		$this->add_control(
                'woopg_category_show',
                [
                    'label'     => __( 'Show Category', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    
                ]
            );

            $this->add_control(
                'woopg_ratting_show',
                [
                    'label'     => __( 'Show Ratting', 'wooaddons-for-elementor' ),
                    'type'      => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'no',
                    
                ]
            );

        $this->end_controls_section();
		
		
		$this->start_controls_section(
			'woopg_card_button',
			[
				'label' => __( 'Cart Button', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
                        'woopg_cart_btn' => 'yes',
                    ]

			]
		);
		$this->add_control(
                'woopg_btn_type',
                [
                    'label' => esc_html__( 'Button type', 'wooaddons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'cart',
                    'options' => [
                        'cart'  => esc_html__('Add to card button','wooaddons-for-elementor'),
                        'view'   => esc_html__('View details','wooaddons-for-elementor'),
                    ],
                    
                ]
            );

		
		$this->add_control(
			'woopg_card_text',
			[
				'label'       => __( 'Button Text', 'wooaddons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __( 'View details', 'wooaddons-for-elementor' ),
				'default'     => __( 'View details', 'wooaddons-for-elementor' ),
				'condition' => [
                        'woopg_btn_type' => 'view',
                    ]
			]
		);
		
		
		$this->end_controls_section();
		
	}

	/**
	 * Register Blank widget style ontrols.
	 *
	 * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_style_controls() {

		$this->start_controls_section(
			'woopg_style',
			[
				'label' => __( 'Layout style', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'woopg_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'woopg_bg_color',
                'label' => esc_html__( 'Background', 'wooaddons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                
                'selector' => '{{WRAPPER}} .woopg-card',
            ]
        );
        
        $this->add_control(
            'woopg_border_radius',
            [
                'label' => __( 'Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'woopg_content_border',
                'selector' => '{{WRAPPER}} .woopg-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'woopg_content_shadow',
                'selector' => '{{WRAPPER}} .woopg-card',
            ]
        );
        $this->end_controls_section();
		$this->start_controls_section(
			'woopg_img_style',
			[
				'label' => __( 'Image style', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
            'image_width_set',
            [
                'label' => __( 'Width', 'wooaddons-for-elementor' ),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'desktop_default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    
                ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-img figure img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    
                ],
            ]
        );

		$this->add_control(
			'woopg_img_auto_height',
			[
				'label' => __( 'Image auto height', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wooaddons-for-elementor' ),
				'label_off' => __( 'Off', 'wooaddons-for-elementor' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'woopg_img_height',
			[
				'label' => __( 'Image Height', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					]
				],
				'condition' => [
                    'woopg_img_auto_height!' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .woopg-card-img figure img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'woopg_imgbg_height',
			[
				'label' => __( 'Image div Height', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					]
				],
				'condition' => [
                    'woopg_img_auto_height!' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .woopg-card-img figure' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'woopg_img_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-img, {{WRAPPER}} .woopg-card-img figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_img_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'woopg_img_border_radius',
            [
                'label' => __( 'Border Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'woopg_img_bgcolor',
                'label' => esc_html__( 'Background', 'wooaddons-for-elementor' ),
                //'types' => [ 'classic', 'gradient' ],
                
                'selector' => '{{WRAPPER}} .woopg-card-img, {{WRAPPER}} .woopg-card-img figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'woopg_img_border',
                'selector' => '{{WRAPPER}} .woopg-card-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
			'woopg_desc_style',
			[
				'label' => __( 'Product Title', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'woopg_title_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card .wae-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_title_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card .wae-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_title_color',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-card .wae-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_title_bgcolor',
            [
                'label' => __( 'Background Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-card .wae-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'woopg_descb_radius',
            [
                'label' => __( 'Border Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card .wae-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'woopg_title_typography',
                'label' => __( 'Typography', 'wooaddons-for-elementor' ),
                'selector' => '{{WRAPPER}} .woopg-card .wae-ptitle',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
            ]
        );
        $this->end_controls_section();
       
        $this->start_controls_section(
			'woopg_description_style',
			[
				'label' => __( 'Description', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
            'woopg_description_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_description_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_description_color',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_description_bgcolor',
            [
                'label' => __( 'Background Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'woopg_description_radius',
            [
                'label' => __( 'Border Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'woopg_description_typography',
                'label' => __( 'Typography', 'wooaddons-for-elementor' ),
                'selector' => '{{WRAPPER}} .woopg-card-text p',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

		$this->end_controls_section();       
        $this->start_controls_section(
			'woopg_meta_style',
			[
				'label' => __( 'Products Meta', 'wooaddons-for-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'woopg_meta_badge',
			[
				'label' => __( 'Products Badge', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_responsive_control(
            'woopg_meta_badge_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wooaddons-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_meta_badge_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wooaddons-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_meta_badge_color',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wooaddons-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_meta_badge_bgcolor',
            [
                'label' => __( 'Background Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wooaddons-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'woopg_meta_badge_typography',
                'label' => __( 'Typography', 'wooaddons-for-elementor' ),
                'selector' => '{{WRAPPER}} .wooaddons-badge',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'woopg_badge_border',
                'selector' => '{{WRAPPER}} .wooaddons-badge',
            ]
        );

        $this->add_control(
            'woopg_badge_border_radius',
            [
                'label' => __( 'Border Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wooaddons-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'woopg_meta_cat',
			[
				'label' => __( 'Category style', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_responsive_control(
            'woopg_meta_cat_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text .wae-category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_control(
            'woopg_meta_cat_color',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-card-text .wae-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'woopg_meta_cat_typography',
                'label' => __( 'Typography', 'wooaddons-for-elementor' ),
                'selector' => '{{WRAPPER}} .woopg-card-text .wae-category a',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
            ]
        );
        $this->add_control(
			'woopg_meta_star',
			[
				'label' => __( 'Rating Style', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'woopg_meta_star_color',
            [
                'label' => __( 'Rating star Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-product-rating .wd-product-ratting i' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'woopg_meta_starfill_color',
            [
                'label' => __( 'Rating star Fill Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-product-rating .wd-product-ratting .wd-product-user-ratting i' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'woopg_btn_style',
            [
                'label' => __( 'Button', 'wooaddons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'woopg_btn_padding',
            [
                'label' => __( 'Padding', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'woopg_btn_margin',
            [
                'label' => __( 'Margin', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'woopg_btn_typography',
                'selector' => '{{WRAPPER}} .woopg-cart-btn a.button',
                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'woopg_btn_border',
                'selector' => '{{WRAPPER}} .woopg-cart-btn a.button',
            ]
        );

        $this->add_control(
            'woopg_btn_border_radius',
            [
                'label' => __( 'Border Radius', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'woopg_btn_box_shadow',
                'selector' => '{{WRAPPER}} .woopg-cart-btn a.button',
            ]
        );
        $this->add_control(
			'woopg_button_color',
			[
				'label' => __( 'Button color', 'wooaddons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->start_controls_tabs( 'infobox_btn_tabs' );

        $this->start_controls_tab(
            'woopg_btn_normal_style',
            [
                'label' => __( 'Normal', 'wooaddons-for-elementor' ),
            ]
        );

        $this->add_control(
            'woopg_btn_color',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'woopg_btn_bg_color',
            [
                'label' => __( 'Background Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        

        $this->end_controls_tab();

        $this->start_controls_tab(
            'woopg_btn_hover_style',
            [
                'label' => __( 'Hover', 'wooaddons-for-elementor' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'woopg_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .woopg-cart-btn a.button:hover',
            ]
        );

        $this->add_control(
            'woopg_btn_hcolor',
            [
                'label' => __( 'Text Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button:hover, {{WRAPPER}} .woopg-cart-btn a.button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'woopg_btn_hbg_color',
            [
                'label' => __( 'Background Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button:hover, {{WRAPPER}} .woopg-cart-btn a.button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'woopg_btn_hborder_color',
            [
                'label' => __( 'Border Color', 'wooaddons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'woopg_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .woopg-cart-btn a.button:hover, {{WRAPPER}} .woopg-cart-btn a.button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


	}

	/**
	 * Render Blank widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display(); 
		$woopg_filter = $this->get_settings('woopg_products_filter');
		$woopg_products_count = $this->get_settings('woopg_products_count');
		$woopg_custom_order = $this->get_settings('woopg_custom_order');
		$woopg_grid_categories = $this->get_settings('woopg_grid_categories');
		$orderby = $this->get_settings('orderby');
		$order = $this->get_settings('order');


 // Query Argument
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $woopg_products_count,
        );

        switch( $woopg_filter ){

            case 'sale':
                $args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            break;

            case 'featured':
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
            break;

            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';
            break;

            case 'top_rated': 
                $args['meta_key']   = '_wc_average_rating';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';          
            break;

            case 'random_order':
                $args['orderby']    = 'rand';
            break;

            case 'show_byid':
                $args['post__in'] = $settings['woopg_product_id'];
            break;

            case 'show_byid_manually':
                $args['post__in'] = explode( ',', $settings['woopg_product_ids_manually'] );
            break;

            default: /* Recent */
                $args['orderby']    = 'date';
                $args['order']      = 'desc';
            break;
        }

        // Custom Order
        if( $woopg_custom_order == 'yes' ){
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

if( !( ($woopg_filter == "show_byid") || ($woopg_filter == "show_byid_manually") )){

	$product_cats = str_replace(' ', '', $woopg_grid_categories);
        if ( "0" != $woopg_grid_categories ) {
            if( is_array($product_cats) && count($product_cats) > 0 ){
                $field_name = is_numeric($product_cats[0])?'term_id':'slug';
                $args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => $product_cats,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }

}
        


//grid layout
 $woopg_product_style = $this->get_settings('woopg_product_style');
 $woopg_rownumber = $this->get_settings('woopg_rownumber');
 // grid content
  $woopg_product_img_show = $this->get_settings('woopg_product_img_show');
  $woopg_show_title = $this->get_settings('woopg_show_title');
  $woopg_crop_title = $this->get_settings('woopg_crop_title');
  $woopg_title_tag = $this->get_settings('woopg_title_tag');
  $woopg_desc_show = $this->get_settings('woopg_desc_show');
  $woopg_crop_desc = $this->get_settings('woopg_crop_desc');
  $woopg_price_show = $this->get_settings('woopg_price_show');
  $woopg_cart_btn = $this->get_settings('woopg_cart_btn');
  $woopg_category_show = $this->get_settings('woopg_category_show');
  $woopg_ratting_show = $this->get_settings('woopg_ratting_show');
  $woopg_badge_show = $this->get_settings('woopg_badge_show');
  $woopg_content_align = $this->get_settings('woopg_content_align');
  $woopg_btn_type = $this->get_settings('woopg_btn_type');
  $woopg_card_text = $this->get_settings('woopg_card_text');
   
   if( $woopg_content_align == 'center'){
   		$rating_class = 'flex-center';   
   }elseif($woopg_content_align == 'right'){
   		$rating_class = 'flex-right';   
   }else{
   		$rating_class = 'flex-left';   
   }


$woopg_products = new WP_Query( $args );

if( $woopg_products->have_posts() ):
?>
<div id="woopg-items" class="wae-items style<?php echo esc_attr($woopg_product_style); ?>">
<div class="row">
	<?php while( $woopg_products->have_posts() ): $woopg_products->the_post(); ?>
	<div class="col-lg-<?php echo esc_attr($woopg_rownumber); ?>">
		<div class="wae-shadow wae-card woopg-card mb-4 wae-has-hover">
			<?php  if( $woopg_product_img_show == 'yes'): ?>
			<div class="wae-card-img woopg-card-img wae-imghover">
				<?php 
				if( class_exists('WooCommerce') && $woopg_badge_show == 'yes' ){ 
                    wooaddons_products_badge(); 
                }
                 ?>
				<figure>
					<a href="<?php the_permalink();?>"> 
		                <?php woocommerce_template_loop_product_thumbnail(); ?> 
		            </a>
				</figure>
				<?php if( $woopg_cart_btn == 'yes' && $woopg_product_style == '2' ): ?>
					<div class="woocommerce woopg-cart-btn">
						<?php if($woopg_btn_type == 'cart'): ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php else: ?>
							<a class="button " href="<?php the_permalink(); ?>"><?php echo esc_html($woopg_card_text); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<div class="wae-card-text woopg-card-text">
		<?php if( $woopg_product_style == '3' ): ?>
				<div class="row">
					<div class="col text-left">
						<?php if ( $woopg_category_show == 'yes' ): ?>
						<div class="wae-category">
							<?php wooaddons_product_category();?>
						</div>
			        	<?php endif; ?>
					</div>
					<div class="col text-right">
						<?php if ( $woopg_ratting_show ): ?>
							<?php echo wooaddons_wc_get_rating_html(); ?>
				        <?php endif; ?>
					</div>
				</div>
				
		        
		<?php else: ?>
		        <?php if ( $woopg_category_show == 'yes' ): ?>
					<div class="wae-category">
						<?php wooaddons_product_category();?>
					</div>
		        <?php endif; ?>
		<?php endif; ?>

				<?php if($woopg_show_title == 'yes'): ?>
				<a class="wae-ptitle-link" href="<?php the_permalink(); ?>">
				<?php
		            printf( '<%1$s class="wae-ptitle">%2$s</%1$s>',
		                    tag_escape( $woopg_title_tag ),
		                    wp_trim_words( get_the_title(), $woopg_crop_title ) );
		            ?>
		        </a>
		    <?php endif; ?>
		        <?php if ( $woopg_ratting_show && $woopg_product_style != '3' ): ?>
				<?php echo wooaddons_wc_get_rating_html(); ?>
		        <?php endif; ?>
			<?php if($woopg_desc_show): ?>
				<p><?php echo wp_trim_words( get_the_content(), $woopg_crop_desc, '...' ); ?></p>
			<?php endif; ?>
				<?php if ( $woopg_price_show == 'yes' ): ?>
					<div class="woopg-product-price mb-2">
					<?php
						 woocommerce_template_loop_price(); 
					?>
					</div>

		        <?php endif; ?>
		        <?php if( $woopg_cart_btn == 'yes' && $woopg_product_style != '2' ): ?>
					<div class="woocommerce woopg-cart-btn">
						<?php if($woopg_btn_type == 'cart'): ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php else: ?>
							<a class="button " href="<?php the_permalink(); ?>"><?php echo esc_html($woopg_card_text); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $woopg_ratting_show && $woopg_product_style != '3' ): ?>
				<?php wooaddons_wc_empty_rating_html(); ?>
		        <?php endif; ?>
			</div>
			
		</div>	
	</div>
	<?php 
		endwhile; 
		wp_reset_query(); 
		wp_reset_postdata(); 
	?>
</div>
</div>




<?php
endif;


	}






}

