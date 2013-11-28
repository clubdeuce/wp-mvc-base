<?php
namespace WPMVCB\Testing
{
	require_once( WPMVCB_SRC_DIR . '/models/class-base-model-cpt.php' );

	/**
	 * The tests for Base_Model_CPT
	 *
	 * @since WPMVCBase 0.1
	 * @internal
	 */

	class testBaseModelCpt extends WPMVCB_Test_Case
	{
		private $_factory;
		private $_cpt;
		private $_post;

		public function setUp()
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

		/**
		 * @covers Base_Model_CPT::_init_labels
		 */
		public function testInitLabels()
		{
			$expected =  array(
				'name' => 'Books',
				'singular_name' => 'Book',
				'menu_name' => 'Books',
				'parent_item_colon' => 'Parent Book',
				'all_items' => 'All Books',
				'view_item' => 'View Book',
				'add_new_item' => 'Add New Book',
				'add_new' => 'New Book',
				'edit_item' => 'Edit Book',
				'update_item' => 'Update Book',
				'search_items' => 'Search Books',
				'not_found' => 'No books found',
				'not_found_in_trash' => 'No books found in Trash'
			);

			$this->assertClassHasAttribute( '_labels', '\Base_Model_CPT' );
			$this->assertTrue( method_exists( $this->_cpt, '_init_labels' ) );
			$this->reflectionMethodInvokeArgs( $this->_cpt, '_init_labels', 'footxtdomain' );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_cpt, '_labels' ) );
		}

		/**
		 * @covers Base_Model_CPT::get_slug
		 */
		public function testMethodGetSlug()
		{
			$this->assertClassHasAttribute( '_slug', '\Base_Model_CPT' );
			$this->assertTrue( method_exists( $this->_cpt, 'get_slug' ) );
			$this->assertEquals( 'fooslug', $this->_cpt->get_slug() );
		}

		/**
		 * @covers Base_Model_CPT::set_metakey
		 */
		public function testMethodSetMetakey()
		{
			$this->assertClassHasAttribute( '_metakey', '\Base_Model_CPT' );
			$this->assertTrue( method_exists( $this->_cpt, 'set_metakey' ) );
			$this->_cpt->set_metakey( '_foo_metakey' );

			$this->assertEquals(
				'_foo_metakey',
				$this->getReflectionPropertyValue( $this->_cpt, '_metakey' )
			);

		}

		/**
		 * @covers Base_Model_CPT::get_metakey
		 */
		public function testMethodGetMetakey()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_metakey' ) );
			$this->setReflectionPropertyValue( $this->_cpt, '_metakey', '_foo_metakey' );
			$this->assertEquals( '_foo_metakey', $this->_cpt->get_metakey() );
		}

		/**
		 * @covers Base_Model_CPT::get_metakey
		 * @depends testMethodGetMetakey
		 */
		public function testMethodGetMetakeyEmpty()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'Metakey is not set for fooslug' );
			$this->_cpt->get_metakey();
		}

		/**
		 * @covers Base_Model_CPT::set_args
		 */
		public function testMethodSetArgs()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'set_args' ) );
			$this->_cpt->set_args( array( 'foo' => 'bar' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->getReflectionPropertyValue( $this->_cpt, '_args' ) );
		}

		/**
		 * @covers Base_Model_CPT::set_args
		 * @depends testMethodSetArgs
		 */
		public function testMethodSetArgsNonArray()
		{
			$this->setExpectedException( 'PHPUnit_Framework_Error', 'set_args expects an array' );
			$this->_cpt->set_args( 'foo' );
		}

		/**
		 * @covers Base_Model_CPT::get_args
		 */
		public function testMethodGetArgs()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_args' ) );
			$this->setReflectionPropertyValue( $this->_cpt, '_args', array( 'foo' => 'bar' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->_cpt->get_args( array( 'foo' => 'bar' ) ) );
		}

		/**
		 * Test the return of default arguments
		 *
		 * @covers Base_Model_CPT::get_args
		 */
		public function testMethodGetArgsDefaults()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_args' ) );
			
			$expected = array(
				'description'         	=> 'Books',
				'labels'              	=> array(
								                'name' => 'Books',
												'singular_name' => 'Book',
												'menu_name' => 'Books',
												'parent_item_colon' => 'Parent Book',
												'all_items' => 'All Books',
												'view_item' => 'View Book',
												'add_new_item' => 'Add New Book',
												'add_new' => 'New Book',
												'edit_item' => 'Edit Book',
												'update_item' => 'Update Book',
												'search_items' => 'Search Books',
												'not_found' => 'No books found',
												'not_found_in_trash' => 'No books found in Trash'
											),
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
				'rewrite' 			  	=> array( 'slug' => 'fooslug' ),
			);
			
			$this->assertSame( $expected, $this->_cpt->get_args() );
		}
	}
} //namespace
