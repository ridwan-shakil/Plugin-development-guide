<?php
//Hooks

//Action Hook:
do_action( $hook_name:string, $arg:mixed );     // do the action in this LOCATION 

add_action( $hook_name:string, $callback:callable, $priority:integer, $accepted_args:integer );     // add your function in the location (given by do_action)

//Filter hook:

apply_filters( $hook_name:string, $value:mixed, $args:mixed );  //$value will be filterable 

add_filter( $hook_name:string, $callback:callable, $priority:integer, $accepted_args:integer );     //add your filters (to the value passed by apply_filter hook)


// Setting location 
do_action,	apply_filter

// adding new action and filters 
add_action , 	add_ filter

// $priority:integer 
By default hooks priority is  " 10 "   
you can give a lower value to run the function Earlier , 
and a higher value will case the function to run later .

// $accepted_args:integer 
To receive more than one value you have to pass the number or arguments you want to receive .

// Removing hooks:
remove_action( $hook_name:string, $callback:callable|string|array, $priority:integer );
remove_filter( $hook_name:string, $callback:callable|string|array, $priority:integer );

If priority is given when adding the hook , You will definetly have to give the exact priority to remove that hook.
