# Test task

## Subject
Write a script that will request the exchange rates for yesterday from the API of the Central Bank of the Russian Federation and return them in JSON format

## Requirements
- composer
- php >= 7.1 with ctype, iconv, json extensions

## Installation
Clone project, install dependencies, run migrations and database seeding
```
git clone https://github.com/dzaporoz/test_10_2020.git
cd test_10_2020
composer install
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```
Then generate keys
```
mkdir -p config/jwt
JWT_PASSPHRASE=$(grep ''^JWT_PASSPHRASE='' .env | cut -f 2 -d ''='')
echo "$JWT_PASSPHRASE" | openssl genpkey -out config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
echo "$JWT_PASSPHRASE" | openssl pkey -in config/jwt/private.pem -passin stdin -out config/jwt/public.pem -pubout
```

## Running
1. Start the server
```
symfony server:start --daemon
```

2. Lets register 2 users (a customer manager and a customer) and store their tokens for further requests
```
curl -X POST -H "Content-Type: application/json" https://localhost:8000/register -d '{"username":"manager","password":"manager_password","role":"manager"}'
curl -X POST -H "Content-Type: application/json" https://localhost:8000/register -d '{"username":"customer","password":"customer_password","role":"customer"}'
CUSTOMER_TOKEN=$(curl -s -X POST -H "Content-Type: application/json" https://localhost:8000/authentication_token -d '{"username":"customer","password":"customer_password"}' | grep -m1 -oP '"token"\s*:\s*"\K[^"]+')
MANAGER_TOKEN=$(curl -s -X POST -H "Content-Type: application/json" https://localhost:8000/authentication_token -d '{"username":"manager","password":"manager_password"}' | grep -m1 -oP '"token"\s*:\s*"\K[^"]+')
```

3. Manager can view clients and their deals
```
curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer ${MANAGER_TOKEN}" https://localhost:8000/manager_area/customers
```

4. Customer can view automobile brands available at showroom at the moment. And get their models with buy prices and sell prices for trade in program
```
curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer ${CUSTOMER_TOKEN}" https://localhost:8000/customer_area/cars/brands
curl -X GET -H "Content-Type: application/json" -H "Authorization: Bearer ${CUSTOMER_TOKEN}" https://localhost:8000/customer_area/cars/audi
```
5. Customer can sell his car for trade in by passing Id of his car model from service database
```
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer ${CUSTOMER_TOKEN}" https://localhost:8000/customer_area/sell_car -d '{"carModelId":9}'
```
In case of success he will receive trade in deal object data in response.

6. And then he can buy a new car with a surchrge by passing Id of new car and surcharge amount which must be exactly subtotal between price of new car and price of traded in car
```
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer ${CUSTOMER_TOKEN}" https://localhost:8000/customer_area/buy_car_with_surcharge -d '{"carModelId":9,"surchargeAmount":35952.6}'
```
Trade in object data will be send in response in case of succes operation

7. Finally customer manager can delete customer and all information about him
```
curl -X DELETE -H "Content-Type: application/json" -H "Authorization: Bearer ${MANAGER_TOKEN}" https://localhost:8000/manager_area/customers/1

```

## Testing
1. First prepare database for test environement
```
rm -f var/db.sqlite_test &&  php bin/console doctrine:migrations:migrate --env=test --no-interaction
```

2. Run tests
```
php bin/phpunit
```
