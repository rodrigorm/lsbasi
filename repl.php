<?php
/**
 * PHP REPL in a tweet
 *
 * https://gist.github.com/turanct/c725739b7aaa8f136d12
 */
while(1){echo"> ";$i=rtrim(stream_get_line(STDIN,512,PHP_EOL),';');try{@eval('print_r('.$i.');');}catch(Exception$e){print_r($e);}echo"\n";}
