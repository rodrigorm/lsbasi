<?php
/**
 * PHP Test Framework in a tweet
 * https://gist.github.com/everzet/8a14043d6a63329cee62
 */
function it($m,$p){echo"\033[3",$p?'2m✔︎':'1m✘'.register_shutdown_function(function(){die(1);})," It $m\033[0m\n";}
