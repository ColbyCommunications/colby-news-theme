#!/bin/bash
COMMIT_MESSAGE=BUILD: $(shell git log -1 --pretty=%B | cat | tr -d "\'")


test -d /root || mkdir /root
test -d /root/.ssh || mkdir /root/.ssh
chmod 700 /root/.ssh
cp .deploy/.ci_ssh_config /root/.ssh/config
chmod 600 /root/.ssh/config

git clone --branch dev $PLATFORM_REPO_URL $PLATFORM_REPO_FOLDER
git config --global user.email "$GIT_EMAIL"
git config --global user.name "$GIT_USER"

composer update -v --working-dir $PLATFORM_REPO_FOLDER colbycommunications/colby-news-theme
(cd $PLATFORM_REPO_FOLDER; git status; git commit -am "$COMMIT_MESSAGE" || echo "No changes, nothing to commit!" && git push origin dev)
