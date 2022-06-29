#!/bin/bash

# change global npm install location to get around permission issues
mkdir ~/.npm-global
npm config set prefix '~/.npm-global'
export PATH=~/.npm-global/bin:$PATH

#install sitemap_utils, ava, and tap-xunit (utility for outputting tests as JUnit)
npm install --unsafe-perm=true
npm install -g tap-xunit ava
