#!/bin/bash
COMMIT_MESSAGE=BUILD: $(shell git log -1 --pretty=%B | cat | tr -d "\'")

test -d /root || mkdir /root
test -d /root/.ssh || mkdir /root/.ssh
chmod 700 /root/.ssh
cp .deploy/.ci_ssh_config /root/.ssh/config
chmod 600 /root/.ssh/config

git clone --branch newcity --single-branch $GITHUB_REPO_URL $GITHUB_REPO_FOLDER
git config --global user.email "$GIT_EMAIL"
git config --global user.name "$GIT_USER"

rsync -rlD --delete --exclude=.git --exclude=.gitignore $PROJECT_DIR/$DEPLOY_THEMES/$WP_THEME_NAME/* $GITHUB_REPO_FOLDER/
cd $GITHUB_REPO_FOLDER && git add . && git commit -m "$COMMIT_MESSAGE" || echo "No changes, nothing to commit!" && git push origin newcity