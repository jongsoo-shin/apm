# docker-amp

Docker example with Apache, MySql 8.4, PhpMyAdmin and Php8.2


I use docker-compose as an orchestrator. To run these containers:

```
docker-compose up -d
```

Open phpmyadmin at [http://localhost:8000](http://localhost:8000)
Open web browser to look at a simple php example at [http://localhost:80](http://localhost:80)

Run mysql client:

- `docker-compose exec db mysql -u root -p` 

Enjoy !
