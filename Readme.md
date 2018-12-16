Task DDD
==============
**Warehouse API** in Symfony following DDD (Domain Driver Design). 

### Examples in the repo

   - [x] **User authentication** based in JWT 
   - [x] **UUID as binary** to improve the performance and create a nightmare for the dba.
   - [x] Automated tasks with makefile
   - [x] **Dev environment in Docker**. Boosting build speed with docker **cache layers** in pipeline. Orchestrating with **Docker Compose**.
   - [x] An example of **table inheritance and discriminator strategy** 
   - [x] Code structured in layers as appears in DDD in php book.
   - [x] **Command Bus** implementation
   - [x] DomainEvents
   - [x] Events to RabbitMQ 
   - [x] Async Event subscribers
   - [x] Swagger API Doc


### The folder structure 

    src
      \
       |\ Application     `Contains the Use Cases of the domain system and the Data Transfer Objects`
       |
       |\ Domain          `The system business logic layer`
       |
       |\ Infrastructure  `Its the implementation of the system outside the model. I.E: Persistence, serialization, etc`
       |
        \ UI              `User Interface. This use to be inside the Infrastructure layer, but I don't like it.`


## Stack

- PHP 7.2
- Mysql 5.7
- RabbitMQ 3

## Sample Data

| Company Name   	| Type     	| Prefix 	| User Email      	| Password 	|
|----------------	|----------	|--------	|-----------------	|----------	|
| Acme Company   	| merchant 	| XTR    	| u1@merchant.com 	| 11223344 	|
| Long Silver Co 	| merchant 	| MKT    	| u2@merchant.com 	| 11223344 	|
| White Star Co  	| merchant 	| CPU    	| u3@merchant.com 	| 11223344 	|
| FastCargo      	| cargo    	| A      	| u1@cargo.com    	| 11223344 	|
| RabbitLines    	| cargo    	| B      	| u2@cargo.com    	| 11223344 	|
| TeapotCargo    	| cargo    	| C      	| u3@cargo.com    	| 11223344 	|


## Project Setup

Up environment:

`make start`

Static code analysis:

`make style`

Code style fixer:

`make cs`

Code style checker:

`make cs-check`

Enter in php container:

`make s=php sh`

Disable\Enable Xdebug:

`make xoff`

`make xon`

### Disclaimer
Heavily inspired from
    
https://github.com/jorge07/ddd-playground

https://github.com/jorge07/symfony-4-es-cqrs-boilerplate