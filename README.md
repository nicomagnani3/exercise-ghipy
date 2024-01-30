Exercise Giphy

## Documentation
it's located in /Documentation
Into:
    -gif_collection.json (is collection postman for use endpoints and examples)
    -Diagram Entity-relation  https://drive.google.com/file/d/1DJr8z42Hg3Dpeo5CJsrp0L8rFY7odEC_/view?usp=sharing
    -Diagram of sequence https://drive.google.com/file/d/1jvmZyE5hQ--ARkZBqDo_eoG1Jhkcu9Fq/view?usp=sharing
    -Use Cases https://drive.google.com/file/d/13lyhcOc92Ijc4f0mvEbSeii3pQM6lxgk/view?usp=sharing


## Requirements
- docker
- docker-compose



## Setup

1. clone project -https://github.com/nicomagnani3/exercise-ghipy with SSH o HTTP
1. `cd exercise-giphy`
1. `docker-compose build`
1.  configure .env
1. `docker-compose up -d`
1. `docker-compose exec app bash`.
        Into bash execute:  `php artisan migrate `
                            `php artisan db:seed `
1.      Generate OAuth client within the container to operate on the API, using the command `php artisan passport:client --password`
                            `php artisan config:cache`
1. Use endpoints 
1.user: admin@admin.com passwd: admin1234
