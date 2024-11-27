<?php 


header('Content-type: application/zip');
header('Content-disposition: attachment; filename="arquivo.zip"');
readfile('zips/arquivo.zip');

unlink('zips/arquivo.zip');