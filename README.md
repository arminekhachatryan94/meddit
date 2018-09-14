# Meddit

> META+Lab Summer Immersive Project

# To run this project:

## back-end:
``` bash
cd forum
# install dependencies
composer install
# migrate tables
php artisan migrate
# seed tables
php artisan db:seed
# start server
php artisan serve
```

## front-end
``` bash
cd forum-vue
# install dependencies
npm install
# run project
npm start
```

> open:  
http://localhost:8080/


For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).
