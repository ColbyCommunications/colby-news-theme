#!/bin/bash

# If any commands fail (exit code other than 0) entire script exits
set -e

WARNING='\033[0;33m'

if [[ -z "$DEPLOY_PRIVATE_KEY" ]]; then
    echo "DEPLOY_PRIVATE_KEY not set. Either add DEPLOY_PRIVATE_KEY as a GitLab secret variable for this project or pass a different private key using the -k argument."
fi

# Check if ssh config file exists
if [[ ! -e "$CI_PROJECT_DIR/.deploy/.ci_ssh_config" ]]; then
    echo -e "${WARNING}.ci_ssh_config does not exist"
    echo "${WARNING}SSH validation will fail"
fi

eval $(ssh-agent -s)
ssh-add <(echo "$DEPLOY_PRIVATE_KEY")
ssh-add -l
test -d /root/.ssh || mkdir /root/.ssh
chmod 700 /root/.ssh
cp "$CI_PROJECT_DIR/.deploy/.ci_ssh_config" /root/.ssh/config
chmod 600 /root/.ssh/config