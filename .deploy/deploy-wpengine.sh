#!/bin/bash

# Deployment to WPEngine
# Heavily based on https://github.com/linchpin/wpengine-codeship-continuous-deployment

# If any commands fail (exit code other than 0) entire script exits
set -e

: "${REPO_NAME?'REPO_NAME is not set.'}"

# NOTE: In WPEngine, setting the repo to "production" is not the same as choosing the
#       production environment. All environments should be accessed in "production" mode
#       unless there is a specific reason not to. Do not change this value unless you
#       know what you are doing.
: "${REPO_MODE:=production}"

# No content will be deployed by default.
# To deploy all WP themes, set $DEPLOY_THEMES to the
# path of your themes directory (relative to $PROJECT_DIR)
# To deploy all WP plugins, set $DEPLOY_PLUGINS to the
# path of your plugins directory (relative to $PROJECT_DIR)
if [[ ! -d ${DEPLOY_THEMES} ]]; then
    echo "Themes will not be deployed. To deploy themes, set DEPLOY_THEMES to a valid path."
fi

if [[ ! -d ${DEPLOY_PLUGINS} ]]; then
    echo "Plugins will not be deployed. To deploy plugins, set DEPLOY_PLUGINS to a path."
fi


# Branches will deploy to the correct WPEngine environment based on
# the current branch name
: "${DEPLOY_BRANCH_PROD:=master}"
: "${DEPLOY_BRANCH_STAGE:=staging}"
: "${DEPLOY_BRANCH_DEV:=dev}"

# The name of the git branch on the WPEngine site. WPEngine defaults to "main"
: "${DEPLOY_BRANCH_REMOTE:=main}"

# Set the target directory for the cloned WPEngine site to a default if not explicitly set
: "${CLONE_DIR:=/tmp/build}"
: "${GIT_EMAIL:='geeks@insidenewcity.com'}"
: "${GIT_USER:='NewCity GitLab CI'}"

# In WP Engine's multi-environment setup, we'll target each instance based on current branch with
# variables to designate them individually.
if [[ "$BRANCH_NAME" == "$DEPLOY_BRANCH_PROD" && -n "$DEPLOY_REMOTE_PROD" ]]
then
    target_wpe_install=${DEPLOY_REMOTE_PROD}
fi

if [[ "$BRANCH_NAME" == "$DEPLOY_BRANCH_STAGE" && -n "$DEPLOY_REMOTE_STAGE" ]]
then
    target_wpe_install=${DEPLOY_REMOTE_STAGE}
fi

if [[ "$BRANCH_NAME" == "$DEPLOY_BRANCH_DEV" && -n "$DEPLOY_REMOTE_DEV" ]]
then
    target_wpe_install=${DEPLOY_REMOTE_DEV}
fi

if [[ -z "$target_wpe_install" ]] ; then
    echo "Either current branch \`$BRANCH_NAME\` is not a deploy branch, or no remote target was defined for that branch."
    echo "Valid deploy branches are \`$DEPLOY_BRANCH_PROD\`, \`$DEPLOY_BRANCH_STAGE\`, and \`$DEPLOY_BRANCH_DEV\`"
    kill -SIGINT $$
fi

echo -e  "Install: ${target_wpe_install}"
echo -e  "Repo: $REPO_MODE"

# Begin from the default your git project is checked out into by GitLab.
cd "$PROJECT_DIR"

# Pull the current version of the site at $target_wpe_install from the remote repository
echo "Initiating clone of git@git.wpengine.com:$REPO_MODE/$target_wpe_install.git"
git clone --branch $DEPLOY_BRANCH_REMOTE git@git.wpengine.com:$REPO_MODE/$target_wpe_install.git $CLONE_DIR

# If there was a problem cloning, exit
if [ "$?" != "0" ] ; then
    echo "Unable to clone ${target_wpe_install}"
    kill -SIGINT $$
fi

cd "$CLONE_DIR"

# Add the correct remote environment to the current Git directory
git remote add ${REPO_MODE} git@git.wpengine.com:$REPO_MODE/$target_wpe_install.git

# If $DEPLOY_THEMES has a value, and that value is a path to an existing directory
if [[ -n "$DEPLOY_THEMES" && -d $PROJECT_DIR/$DEPLOY_THEMES ]]; then
    echo "Copying themes from $DEPLOY_THEMES"
    rsync -rlDz --delete $PROJECT_DIR/$DEPLOY_THEMES/ $CLONE_DIR/wp-content/themes
fi

# If $DEPLOY_PLUGINS has a value, and that value is a path to an existing directory
if [[ -n "$DEPLOY_PLUGINS" && -d $PROJECT_DIR/$DEPLOY_PLUGINS ]]; then
    echo "Copying plugins from $DEPLOY_PLUGINS"
    rsync -rlDz --delete $PROJECT_DIR/$DEPLOY_PLUGINS $CLONE_DIR/wp-content/plugins
fi

# Configure global Git settings
git config --global user.email "$GIT_EMAIL"
git config --global user.name "$GIT_USER"
git config core.ignorecase false

if [[ -z $(git status --porcelain) ]]; then
    echo "No changes from remote version – nothing to deploy";
else
    git add --all
    git commit -am "Deployment to $target_wpe_install by $GIT_USER from $REPO_NAME/$BRANCH_NAME"

    # Deploy
    git push -f ${REPO_MODE} $DEPLOY_BRANCH_REMOTE
fi

