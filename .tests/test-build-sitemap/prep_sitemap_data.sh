#!/bin/bash

# change global npm install location to get around permission issues
mkdir ~/.npm-global
npm config set prefix '~/.npm-global'
export PATH=~/.npm-global/bin:$PATH

# install `jq` utility for parsing json
apt update && apt-get --yes install jq

#install sitemap_utils, ava, and tap-xunit (utility for outputting tests as JUnit)
npm install -g sitemap_utils jsonlint sitemap commander

#generate json files of sitemap urls
echo '{"urls": ["https://dev-54ta5gq-4nvswumupeimi.us-4.platformsh.site"]}' > sitemap.json
flatten_sitemap --sitemap https://dev-54ta5gq-4nvswumupeimi.us-4.platformsh.site/sitemap_index.xml --config sitemap.json --limit 50 --randomize