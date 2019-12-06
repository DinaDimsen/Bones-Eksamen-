<?php

function load_stylesheets(){
    


    wp_register_style("mainstyle", get_template_directory_uri() ."/CSS/main.css",
    array(), 1,"all");
    wp_enqueue_style("mainstyle");

    wp_register_style("query", get_template_directory_uri() ."/CSS/query.css",
    array(), 1,"all");
    wp_enqueue_style("query");

}
add_action("wp_enqueue_scripts","load_stylesheets");



// load scripts

function addjs(){

    wp_register_script("javascriptmain", get_template_directory_uri() . "/JS/splash.js",array() , 1, 1, 1);
    wp_enqueue_script("javascriptmain");
  
    wp_register_script("javascriptdark", get_template_directory_uri() . "/JS/darkmode.js",array() , 1, 1, 1);
    wp_enqueue_script("javascriptdark");
}
add_action("wp_enqueue_scripts","addjs");




