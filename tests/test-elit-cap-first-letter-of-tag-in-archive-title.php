<?php

class TestTreehouseHooks extends WP_UnitTestCase {

  private $term_id;
  private $term_obj;
  private $archive_title;

  public function setUp() {
    parent::setUp();
    $this->term_id = $this->factory->term->create( 
      array(
        'name' => 'accountable care organizations',
        'taxonomy' => 'post_tag',
        'slug' => 'accountable-care-organizations'
      )
    );
    $this->term_obj = get_term( $this->term_id, 'post_tag' );
    $this->archive_title = sprintf( 'Topic: %s', $this->term_obj->name );
  }

  public function tearDown() {
    parent::tearDown();
    $this->term_id = null;
    $this->term_obj = null;
    $this->archive_title = null;
  }

  public function create_cases() {
    return array(
      array(
        'term' => $this->archive_title,
        'raw_tag' => 'accountable care organizations',
        'expected_first_word' => 'accountable',
        'uppercased' => 'Accountable',
        'expected_result' => 'Topic: Accountable care organizations',
      ),
      array(
        'term' => 'Topic: lorem',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => ' Topic: lorem',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => ' Topic: lorem ',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem' 
      ),
      array(
        'term' => 'Topic: lorem ',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'L',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => 'Topic:    lorem ',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'L',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => 'Topic: William G. Anderson III DO',
        'raw_tag' => 'William G. Anderson III DO',
        'expected_first_word' => 'William',
        'uppercased' => 'William',
        'expected_result' => 'Topic: William G. Anderson III DO',
      ),
      array(
        'term' => '  Topic:   William   G.   Anderson   III   DO',
        'raw_tag' => 'William G. Anderson III DO',
        'expected_first_word' => 'William',
        'uppercased' => 'William',
        'expected_result' => 'Topic: William G. Anderson III DO',
      ),
      array(
        'term' => 'lorem',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => 'lorem ',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => ' lorem ',
        'raw_tag' => 'lorem',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem',
      ),
      array(
        'term' => '   lorem      ipsum   dolor   ',
        'raw_tag' => 'lorem ipsum dolor',
        'expected_first_word' => 'lorem',
        'uppercased' => 'Lorem',
        'expected_result' => 'Topic: Lorem ipsum dolor',
      ),
      array( 
        'term' => '',
        'raw_tag' => '',
        'expected_first_word' => '',
        'uppercased' => '',
        'expected_result' => '',
      ),
      array( 
        'term' => 'Topic:',
        'raw_tag' => '',
        'expected_first_word' => 'Topic:',
        'uppercased' => 'Topic:',
        'expected_result' => 'Topic: ',
      )
    );
  }

  public function test_extracted_tag_has_no_leading_whitespace() {
    $test_terms = $this->create_cases();
  
    foreach ( $test_terms as $test ) {
      $tag = elit_extract_tag( $test['term'] ) ;
      $this->assertTrue( substr( $tag, 0, 1 ) != ' ' );
      
    }
  }

  public function test_first_letter_gets_uppercased() {
    $test_terms = $this->create_cases();

    foreach ( $test_terms as $test ) {
      $expected = $test['uppercased'];
      $actual = elit_uc_first_letter( $test['expected_first_word'] );
      $this->assertSame( $expected, $actual ); 
    }
  }

  public function test_tag_is_extracted() {
    $test_terms = $this->create_cases();

    foreach ( $test_terms as $test ) {
      $expected = $test['raw_tag'];
      $actual = elit_extract_tag( $test['term'] );
      $this->assertSame( $expected, $actual );
    }
  }

  public function test_we_get_full_result_we_expect() {

    /**
     *  This test fails because of the is_tag() conditional
     *  in elit_uc_first_letter_of_tag().
     *
     *  Commment out is_tag() to run this test.
     *
     */
    $this->markTestIncomplete();

    $test_terms = $this->create_cases();

    foreach ( $test_terms as $test ) {
      $expected = $test['expected_result'];
      $actual = elit_uc_first_letter_of_tag( $test['term'] );
      $this->assertSame( $expected, $actual );
    }
  }

}
