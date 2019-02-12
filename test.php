<?php

if ( extension_loaded('pdo') ) {
    echo "PDO installed. \n";
}else{
	echo "PDO is NOT installed. \n";
}

if ( extension_loaded('pdo_mysql') ) { // e.g., pdo_mysql
    echo "PDO MySQL installed. \n";
}else{
    echo "PDO MySQL in NOT installed. \n";
}