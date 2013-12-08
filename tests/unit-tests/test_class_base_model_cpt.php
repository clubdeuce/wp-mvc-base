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
		protected $factory;
		private $cpt;
		private $post;

		public function setUp()
		{
			$args = array(
				'fooslug',
				'Book',
				'Books',
				'/home/foo/fooplugin.php', 
				'/home/foo/',
				'/home/foo/app/',
				'/home/foo/base/',
				'http://my-super-cool-site.com/',
				'footxtdomain'
			);
			
			$this->_factory = new \WP_UnitTest_Factory;
			$this->_cpt = $this->getMockBuilder( '\Base_Model_CPT' )
			                   ->setConstructorArgs( $args )
			                   ->getMockForAbstractClass();

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
		 * @covers Base_Model_CPT::__construct
		 */
		public function testPropertySlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Model_CPT' );
			$this->assertSame( 'fooslug', $this->getReflectionPropertyValue( $this->_cpt, 'slug' ) );
		}
		
		/**
		 * @covers Base_Model_CPT::__construct
		 */
		public function testPropertySingular()
		{
			$this->assertClassHasAttribute( 'singular', '\Base_Model_CPT' );
			$this->assertSame( 'Book', $this->getReflectionPropertyValue( $this->_cpt, 'singular' ) );
		}
		
		/**
		 * @covers Base_Model_CPT::__construct
		 */
		public function testPropertyPlural()
		{
			$this->assertClassHasAttribute( 'plural', '\Base_Model_CPT' );
			$this->assertSame( 'Books', $this->getReflectionPropertyValue( $this->_cpt, 'plural' ) );
		}
		
		/**
		 * @covers Base_Model_CPT::init_labels
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

			$this->assertClassHasAttribute( 'labels', '\Base_Model_CPT' );
			$this->assertTrue( method_exists( $this->_cpt, 'init_labels' ) );
			$this->reflectionMethodInvokeArgs( $this->_cpt, 'init_labels', 'footxtdomain' );
			$this->assertEquals( $expected, $this->getReflectionPropertyValue( $this->_cpt, 'labels' ) );
		}
		
		/**
		 * @covers Base_Model_CPT::get_singular
		 */
		public function testMethodGetSingular()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_singular' ), 'get_singular() does not exist' );
			$this->assertSame( 'Book', $this->_cpt->get_singular() );
		}
		
		/**
		 * @covers Base_Model_CPT::get_plural
		 */
		public function testMethodGetPlural()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_plural' ), 'get_plural() does not exist' );
			$this->assertSame( 'Books', $this->_cpt->get_plural() );
		}
		
		/**
		 * @covers Base_Model_CPT::get_slug
		 */
		public function testMethodGetSlug()
		{
			$this->assertClassHasAttribute( 'slug', '\Base_Model_CPT' );
			$this->assertTrue( method_exists( $this->_cpt, 'get_slug' ) );
			$this->assertEquals( 'fooslug', $this->_cpt->get_slug() );
		}

		/**
		 * @covers Base_Model_CPT::set_args
		 */
		public function testMethodSetArgs()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'set_args' ) );
			$this->_cpt->set_args( array( 'foo' => 'bar' ) );
			$this->assertEquals( array( 'foo' => 'bar' ), $this->getReflectionPropertyValue( $this->_cpt, 'args' ) );
		}

		/**
		 * @covers Base_Model_CPT::set_args
		 */
		public function testMethodSetArgsNonArray()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'set_args' ) );
			$this->assertEquals(
				new \WP_Error( 'FAIL', 'Base_Model_CPT::set_args expects an array', 'foo' ),
				$this->_cpt->set_args( 'foo' )
			);
		}

		/**
		 * @covers Base_Model_CPT::get_args
		 */
		public function testMethodGetArgs()
		{
			$this->assertTrue( method_exists( $this->_cpt, 'get_args' ) );
			$this->setReflectionPropertyValue( $this->_cpt, 'args', array( 'foo' => 'bar' ) );
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
