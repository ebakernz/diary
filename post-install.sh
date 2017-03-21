#!/bin/bash

if [ ! -f "../_ss_environment.php" ]; then
	echo -e "Fetching placeholder _ss_environment.php file"
	curl -s https://gist.githubusercontent.com/jaedb/448ddfa9ad9a831838ed/raw > ../_ss_environment.php
fi
echo