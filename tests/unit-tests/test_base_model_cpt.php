<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/base_model_cpt.php' );
	
	/**
	 * The test controller for Base_Model_CPT
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */
	 
	class Test_Base_Model_CPT extends WPMVCB_Test_Case
	{
		private $_factory;
		private $_cpt;
		private $_post;
		
		public function SetUp()
		{
			$this->_factory = new \WP_UnitTest_Factory;
			$this->_cpt = new \Base_Model_CPT( 'fooslug', 'Book', 'Books', 'http://my-super-cool-site.com', 'footxtdomain' );
			
			$this->_post = get_post(
				$this->_factory->post->create_object(
					array(
						'post_type' => 'fooslug',
						'post_title' => 'Test CPT'
					)
				)
			);
		}
		
		protected function init_args()
		{

			$this->_cpt->set_args ( 
				array(
					'description'         	=> __( 'Books', 'my-super-cool-text-domain' ),
					'labels'              	=> $labels,
					'supports'            	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
					'hierarchical'        	=> false,
					'public'              	=> true,
					'show_ui'             	=> true,
					'show_in_menu'        	=> true,
					'show_in_nav_menus'   	=> true,
					'show_in_admin_bar'   	=> true,
					'menu_icon'           	=> null,
					'can_export'          	=> true,
					'has_archive'         	=> true,
					'exclude_from_search' 	=> false,
					'publicly_queryable'  	=> true,
					'rewrite' 			  	=> array( 'slug' => 'books' ),
					//this is supported in 3.6
					'statuses'				=> array(
						'draft' => array(
							'label'                     => _x( 'New', 'book', 'my-super-cool-text-domain' ),
							'public'                    => true,
							'exclude_from_search'       => false,
							'show_in_admin_all_list'    => true,
							'show_in_admin_status_list' => true,
							'label_count'               => _n_noop( 'New <span class="count">(%s)</span>', 'New <span class="count">(%s)</span>', 'my-super-cool-text-domain' )
						)
					)
				)
			);
		}
		
		public function testMethodGetSlug()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_slug' ) );
			$this->assertEquals( 'fooslug', $this->_cpt->get_slug() );
		}
		
		public function testMethodSetMetakey()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'set_metakey' ) );
			$this->_cpt->set_metakey( '_foo_metakey' );
			
			$this->assertEquals(
				'_foo_metakey',
				$this->getReflectionPropertyValue( $this->_cpt, '_metakey' )
			);
			
		}
		
		public function testMethodGetMetakeyExists()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_metakey' ) );
		}
		
		public function testMethodGetMetakey()
		{
			$this->setReflectionPropertyValue( $this->_cpt, '_metakey', '_foo_metakey' );
			$this->assertEquals( '_foo_metakey', $this->_cpt->get_metakey() );
		}
		
		public function testMethodGetMetakeyEmpty()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'Metakey is not set for fooslug' );
			$this->_cpt->get_metakey();
		}
		
		public function testMethodGetPostUpdatedMessages()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_post_updated_messages' ) );
			
			$messages = array(
				0 => null, // Unused. Messages start at index 1.
				1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink( $this->_post->ID) ) ),
				2 => __('Custom field updated.', 'your_text_domain'),
				3 => __('Custom field deleted.', 'your_text_domain'),
				4 => __('Book updated.', 'your_text_domain'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('Book published. <a href="%s">View book</a>', 'your_text_domain'), esc_url( get_permalink($this->_post->ID) ) ),
				7 => __('Book saved.', 'your_text_domain'),
				8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) ),
				9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'your_text_domain'),
				  // translators: Publish box date format, see http://php.net/date
				  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $this->_post->post_date ) ), esc_url( get_permalink( $this->_post->ID ) ) ),
				10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $this->_post->ID) ) ) )
			);
			
			$this->assertEquals( 
				$messages,
				$this->_cpt->get_post_updated_messages( $this->_post )
			);
		}
		
		public function testMethodSetArgsExists()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'set_args' ) );
		}
		
		/**
		 * @depends testMethodSetArgsExists
		 */
		public function testMethodSetArgs()
		{
			$this->_cpt->set_args( array( 'foo' => 'bar' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->getReflectionPropertyValue( $this->_cpt, '_args' ) );
		}
		
		/**
		 * @depends testMethodSetArgsExists
		 */
		public function testMethodSetArgsNonArray()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'set_args expects an array' );
			$this->_cpt->set_args( 'foo' );
		}
		
		public function testMethodGetArgsExists()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_args' ) );
		}
		
		/**
		 * @depends testMethodGetArgsExists
		 */
		public function testMethodGetArgs()
		{
			$this->setReflectionPropertyValue( $this->_cpt, '_args', array( 'foo' => 'bar' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->_cpt->get_args( array( 'foo' => 'bar' ) ) );
		}
		
		/**
		 * @depends testMethodGetArgsExists
		 */
		public function testMethodGetArgsError()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'Arguments for fooslug post type not set' );
			$this->_cpt->get_args();
		}
		
		public function testMethodRegisterExists()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'register' ) );
		}
		
		/**
		 * @depends testMethodRegisterExists
		 */
		public function testRegister()
		{
			$labels = array(
				'name'                => _x( 'Books', 'Post Type General Name', $txtdomain ),
				'singular_name'       => _x( 'Book', 'Post Type Singular Name', $txtdomain ),
				'menu_name'           => __( 'Books', $txtdomain ),
				'parent_item_colon'   => __( 'Parent Book', $txtdomain ),
				'all_items'           => __( 'All Books', $txtdomain ),
				'view_item'           => __( 'View Book', $txtdomain ),
				'add_new_item'        => __( 'Add New Book', $txtdomain ),
				'add_new'             => __( 'New Book', $txtdomain ),
				'edit_item'           => __( 'Edit Book', $txtdomain ),
				'update_item'         => __( 'Update Book', $txtdomain ),
				'search_items'        => __( 'Search books', $txtdomain ),
				'not_found'           => __( 'No books found', $txtdomain ),
				'not_found_in_trash'  => __( 'No books found in Trash', $txtdomain ),
			);
	
			$args = array(
				'description'         	=> __( 'Books', $txtdomain ),
				'labels'              	=> $labels,
				'supports'            	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'hierarchical'        	=> false,
				'public'              	=> true,
				'show_ui'             	=> true,
				'show_in_menu'        	=> true,
				'show_in_nav_menus'   	=> true,
				'show_in_admin_bar'   	=> true,
				'menu_icon'           	=> null,
				'can_export'          	=> true,
				'has_archive'         	=> true,
				'exclude_from_search' 	=> false,
				'publicly_queryable'  	=> true,
				'rewrite' 			  	=> array( 'slug' => 'books' ),
			);
			
			$this->_cpt->set_args( $args );
			$this->_cpt->register();
			$this->assertTrue( post_type_exists( $this->_cpt->get_slug() ) );
		}
		
		public function testMethodAddShortcode()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'add_shortcode' ) );
			$this->_cpt->add_shortcode( 'fooshortcode', 'foocallback' );
			
			$this->assertEquals(
				array( 'fooshortcode' => 'foocallback' ),
				$this->getReflectionPropertyValue( $this->_cpt, '_shortcodes' )
			);
		}
		
		/**
		 * @depends testMethodAddShortcode
		 */
		public function testMethodGetShortcodes()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_shortcodes' ) );
			$this->setReflectionPropertyValue( $this->_cpt, '_shortcodes', array( 'fooshortcode' => 'foocallback' ) );
			$this->assertEquals( array( 'fooshortcode' => 'foocallback' ), $this->_cpt->get_shortcodes() );
		}
	}
} //namespace
?>
