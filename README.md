# Speed up response by delaying heavy tasks

Watch full tutorial [here](https://youtu.be/)

## Launch project

Run in terminal `make up`

### Sample API request:

```
curl --location --request POST 'http://localhost:8080/api/v1/reservations' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "some reservation",
    "price": 200
}'
```

## Run worker

```
docker-compose exec php bin/console messenger:consume async -vv
```

# Other video tutorials

## Design pattern "Chain of responsibility" (Symfony implementation)

There is a [video](https://youtu.be/3KQlubIv684)

## Create Symfony 5 project with Docker and Postgres

There is a [video](https://youtu.be/69wjRPQ0A_U)

## How to use data transfer objects (DTO) in Symfony API application
    
There is a [branch](https://github.com/Cap-Coding/symfony_api/tree/data_transfer_objects) and here is a [video](https://youtu.be/XxIhzgGv214)

## How to build simple CRUD API service with Symfony 5 (for beginners)
    
There is a [branch](https://github.com/Cap-Coding/symfony_api/tree/crud_api) and here is a [video](https://youtu.be/tbXpX4dAqjg)
 
## How to use Symfony Form Events in API service 
    
There is a [video](https://youtu.be/lLwx96DA_Ww)
 
## How to use object factories with Symfony Forms 
    
There is a [video](https://youtu.be/chgvsi6TWM8)
