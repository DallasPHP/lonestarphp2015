# config valid only for Capistrano 3.1
lock '3.2.1'

set :application, 'lonestarphp2015'
set :repo_url, 'https://github.com/DallasPHP/lonestarphp2015.git'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# Default deploy_to directory is /var/www/my_app
set :deploy_to, '/var/www/lonestarphp2015'

# Default value for :scm is :git
set :scm, :git

# Default value for :format is :pretty
set :format, :pretty

# Default value for :log_level is :debug
set :log_level, :debug

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
# set :linked_files, %w{config/database.yml}

# Default value for linked_dirs is []
set :linked_dirs, %w{vendor node_modules}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 5

namespace :deploy do

  desc 'Composer Install'
  task :composer_install do
    on roles(:web) do
      within release_path do
        execute 'composer', 'install', '--no-dev', '--optimize-autoloader'
      end
    end
  end

  desc 'Parse SASS and minify'
  task :sass_parse do
    on roles(:web) do
      within release_path do
        execute 'gulp', 'styles'
      end
    end
  end

  desc 'Generate sculpin site'
  task :sculpin_generate do
    on roles(:web) do
      within release_path do
        execute './vendor/bin/sculpin', 'generate', '--env prod'
      end
    end
  end

  desc 'Gulp Install'
  task :gulp_install do
    on roles(:web) do
      within release_path do
        execute 'npm', 'install'
      end
    end
  end

  after :publishing, :composer_install
  after :publishing, :gulp_install
  after :publishing, :sass_parse
  after :publishing, :sculpin_generate

end
