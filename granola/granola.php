<?php
/*
Plugin Name: Granola Share
Plugin URI: http://github.com/josephturner/granola-wp
Description: Share your Granola savings with the world
Author: Joseph Turner
Version: 1
Author URI: http://thejosephturner.com
*/
 
/* 
This is very simple plugin that grabs your Granola Share (http://grano.la/community/granola_share.php) and displays it as a Wordpress sidebar widget
*/
function draw_gshare()
{
?>
    <!-- If your WP theme includes jQuery, you can remove the next line -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script >
    <div id="badge" style="background: #f7f7f7; width: 160px; padding: 8px; text-align: center;">
      <p id="fallback_str">I am doing my part to save the world. Shouldn't you?</p>
      <p style="display: none" id="data_str">I am doing my part to save the world, having saved <span id="kwh"></span>kWh of energy across <span id="nr_systems"></span> systems (<span id="saving_pct"></span>% average CPU energy saved)!</p>
      <p><a href="http://grano.la"><img src="http://grano.la/_IMAGES/logo.png" alt="Granola by MiserWare" /></a></p>
    </div>
    <script type="text/JavaScript">
      function gshare_callback(data){
        // Fill in the data string
        $("#kwh").text(Math.round(data.group.total_kwh_saved * 100.0) / 100.0);
        $("#nr_systems").text(data.group.number_machines);
        $("#saving_pct").text(Math.round(data.group.average_percent_saved * 1000.0) / 10.0);
        // Then replace the fallback string with the filled data string
        $("#fallback_str").css("display", "none");
        $("#data_str").css("display", "block");
      }
    </script>
    <!-- The server response will be a call to the gshare_callback function with the response data as an argument -->
    <script src="http://api.grano.la/rest/v1/services/savingscalculator/[YOUR GRANOLA SHARE ID]/text" type="text/javascript"></script>
<?php  
}
 
function widget_granola_share($args) {
  extract($args);
  echo $before_widget;
  draw_gshare();
  echo $after_widget;
}
 
function granola_share_init()
{
  register_sidebar_widget(__('Granola Share'), 'widget_granola_share');
}
add_action("plugins_loaded", "granola_share_init");
?>
