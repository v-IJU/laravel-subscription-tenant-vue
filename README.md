# Installing Instructions

Laravel --version 9

## System Requirements

```shell
php version 8.0 and above
```

To get started with development, you need to install few tools

1. git

    `git` version 2.13.1 or higher. Download [git](https://git-scm.com/downloads) if you don't have it already.

    To check your version of git, run:

    ```shell
     git --version
     git config --global user.name "John Doe"
     git config --global user.email johndoe@example.com
    ```

2. node

    `node` version 16.15.1 or higher. Download [node](https://nodejs.org/en/download/) if you don't have it already.

    To check your version of node, run:

    ```shell
     node --version
    ```

3. npm

    `npm` version 5.6.1 or higher. You will have it after you install node.

    To check your version of npm, run:

    ```shell
     npm --version
    ```

4. composer

    Open [https://getcomposer.org/download/](https://getcomposer.org/download/) to view it in your browser. You will have it after you install composer.

    To check your version of composert, run:

    ```shell
     composer --version
    ```

## Setup

To set up a development environment, please follow these steps:

1. Clone the repo

    ```shell
     git clone https://gitlab.com/dtech9013045/school-uniform.git
    ```

2. Checkout to development Branch

    ```shell
     git checkout development
    ```

3. get pull all things in development Branch

    ```shell
     git pull origin development
    ```

4. Install the dependencies

    ```shell
    composer install &&  npm install --force && npm run dev
    ```

5. Create a New Branch and work on

    ```shell
     git chekcout -b <branchname>

    ```

6. After Completed work just push the code

    ```shell
     git push origin <your created branch name>

    ```

    If you get an error, please check the console for more information.

    If you don't get an error, you are ready to start development.

7. Run the app

    ```shell
    php artisan serve

    Username : admin
    Password : admin123
    ```

    Project will be running in the browser.

    Open [http://localhost:8000/administrator](http://localhost:8000/administrator) to view it in your browser.

    For live [https://admin.vivektailor.webbazaardevelopment.com/administrator]

8. Some useful Commands

    ```shell
    # migrte defaukt table
    php artisan migrate
    # Create a new module
    php artisan make:cms-module <modulename>
    #create module with crud views
    php artisan make:cms-module <modulename> --crud
    #create controller
    php artisan make:cms-controller <controller-name> <module-name>
    # Migrate our tables
    php artisan cms-migrate
    # Seeding
    php artisan db:cms-seed
    php artisan db:seed --class=DomainConfigurationSeeder
    #register modules to table
    php artisan update:cms-module
    #register plugins
    php artisan update:cms-plugins
    #regiser menus
    php artisan update:cms-menu
    #create repository
    php artisan make:cms-repository core UserRepository user
    Details
    make:cms-repository {type}-core/local {name}-name_of_your_file {module-name}->module_name
    #Repository Implementation
    Please refer hoe to use reporistory in cms/core/user/usercontroller
    ```

#
