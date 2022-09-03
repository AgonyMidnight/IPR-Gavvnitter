# gavnitter

## Project setup
```

npm install --force
npm run serve 

copy .env
php artisan migrate
php artisan key:generate
php artisan passport:install
php artisan passport:keys

php artisan storage:link

в storage/app/public/ распоковать архив из public

php artisan bd:seed DatabaseSeeder
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your unit tests
```
npm run test:unit
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
