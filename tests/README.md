# WP MVC Base Test Suite [![Build Status](https://secure.travis-ci.org/dlozupone/wp-mvc-base.png?branch=master)](http://travis-ci.org/dlozupone/wp-mvc-base)

Version: 1.0

Author: [Daryl Lozupone](http://www.github.com/dlozupone)

-------------------------

The WP MVC Base Test Suite uses [PHPUnit](http://phpunit.de) to maintain code quality. This ensures backwards compatibility with existing projects implementing the framework, as well as alerting developers to changes that break that compatibility.

Travis-CI Automated Testing
-----------

The master branch of WP MVC Base is automatically tested on [travis-ci.org](http://travis-ci.org). The image above will show you the latest test's output. Travis-CI will also automatically test all new Pull Requests to make sure they will not break our build.

Quick Start (For Local Testing)
-----------------------------

	# Clone the WP MVC Base repository
    git clone git://github.com/dlozupone/wp-mvc-base.git

    # Checkout the WordPress unit test suite to a directory of your choice (let us assume `/home/foo/wp_unit_tests/`)
    mkdir /home/foo/wp_unit_tests
    svn co --ignore-externals http://unit-tests.svn.wordpress.org/trunk/ /home/foo/wp_unit_tests/


Copy and edit the WordPress Unit Tests Configuration

    cp /home/foo/wp_unit_tests/wp-tests-config-sample.php /home/foo/wp_unit_tests/wp-tests-config.php

Ensure your mySQL server is running and that you have created a database for test use in your mySQL server. The test engine will delete all data in the database, so create a database specifically for testing.

The following edits will need to be applied to the `wp-tests-config.php` using a code editor of your choice.

Please note: WP MVC Base does not need to be in the `wp-content/plugins` directory.
    <?php
    define( 'DB_NAME', 'unit_tests' );
    define( 'DB_USER', 'user' );
    define( 'DB_PASSWORD', 'password' );

	?>
Load up the Terminal and cd into the directory where WP MVC Base is stored and run this command:

    WP_TESTS_DIR=/home/foo/wp_unit_tests phpunit

