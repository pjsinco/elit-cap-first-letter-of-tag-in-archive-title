<?php
/**
 * Plugin Name: Elit Cap First Letter of Tag in Archive Title
 * Description: Capitalizes the first letter in a tag when it's an archive title
 * Version: 1.0.0
 * Author: Patrick Sinco
 * License: GPL2
 */

function elit_uc_first_letter_of_tag( $term ) {
  if ( is_tag() ) {
    if ( $term != '' ) {
      $tag = elit_extract_tag( $term );
      $tag = elit_uc_first_letter( $tag );
      return sprintf( 'Topic: %s', $tag );
    } 
  } 

  return $term;
}
add_filter( 'get_the_archive_title', 'elit_uc_first_letter_of_tag', 10, 1 );

function elit_extract_tag( $title ) {
  if ( trim( $title ) != 'Topic:' ) {
    $terms = explode( ' ', trim( $title ) );
    $filtered_terms = array();

    foreach ( $terms as $term ) {
      if ( $term != 'Topic:' && $term != '' ) {
        array_push( $filtered_terms, $term );
      }
    }
    return implode( ' ', $filtered_terms );
  } else {
    return ''; 
  }
}

function elit_uc_first_letter( $word ) {
  return ucfirst( $word );
}


