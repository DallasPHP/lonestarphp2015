from fabric.api import *
from os.path import realpath, split
import sys

# Needed for ubuntu to handle sub imports in functions
full_path = realpath(__file__)
path, file = split(full_path)
sys.path.insert(0, path)


##
# Sculpin
##

@task
def develop():
    local("vendor/bin/sculpin generate --watch --server")


###
# Deployment
###
#
# @task
# def deploy_prod():
#     from fabfile_prod import deploy as do_deploy_prod
#     if prompt("Are you SURE you wish to deploy to the production environment? [n]").lower() == 'y':
#         execute(do_deploy_prod)