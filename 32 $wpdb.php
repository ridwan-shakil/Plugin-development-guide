<?php

dicumentation = https://developer.wordpress.org/reference/classes/wpdb/

// ========================
// database oprations 
// ========================
wpdb oprations
  function clbc_wpdb_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'persons';
  //==================== select
    $wpdb->get_results(
        "
            SELECT *
            FROM $table
            WHERE name = 'Ridwan '
            
        "
    );

  // OR
    $result =  $wpdb->get_row("select * from {$table_name} where id=2");    // give data in Object formate 
     print_r($result);

    $result =  $wpdb->get_row("select * from {$table_name} where id=2", ARRAY_A);   // give data in assosiative array formate 
    $result =  $wpdb->get_row("select * from {$table_name} where id=2", ARRAY_N);   // give data in Numaric array formate 

  
  // ==================  insert
  $wpdb->insert(
        $table_name,
        array(
            'name' => 'Shima',
            'email' => 'shima@gmail.com'
        ),
        array(
            '%s',
            '%s'
        )
    );
// replace or insert if does not exists 
  $wpdb->replace(
        $table_name,
        array(
            'id' => 55,
            'name' => 'replace',
            'email' => 'replaced@gmail.com',
        ),
        array(
            '%d',
            '%s',
            '%s',
        )
    );

// update
// update( $table, $data, $where, $format = null, $where_format = null );
  $wpdb->update(
        $table_name,
        array(
            'name' => 'update',
            'email' => 'update@gmail.com'
        ),
        array('ID' => 1), //update where id = 1
        array(
            '%s',
            '%s'
        ),
        array('%d')
    );

// delete
  $wpdb->delete($table_name, array('ID' => 1));


// ======================================================================
// any database opration can be done by uning "$wpdb->query()" method 
  //  $wpdb->prepare() method is for senitizing query 
  
   $wpdb->query(
        $wpdb->prepare(
            "
                DELETE FROM $table_name
                WHERE id = %d
                AND email = %s
            ",
            11,
            'ridwan@gmail.com'
        )
    );

  
}


  
