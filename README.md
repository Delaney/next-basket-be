## Next-Basket BE

### Introduction

This sample project contains two Laravel microservices communicating via RabbitMQ.

---

### Getting Set Up

1. First, make sure you hav Docker and Composer installed on your local machine, and a [CloudAMQP](https://customer.cloudamqp.com/instance) account set up. If you haven't already created a RabbitMQ instance, navigate to the [CloudAMQP console](https://api.cloudamqp.com/console) and click **"Create New Instance"** and fill out the form. After that, click on the newly created instance to retrieve the server details.

2. In the repo root directory, run the following commands to create `.env` files for the microservices:
```
cp users/.env-example users/.env

cp notifications/.env-example notifications/.env
```

3. Replace the following section with the corresponding values gotten from the CloudAMQP dashboard:
```
MQ_HOST="CLOUDAMQP_HOST"
MQ_PORT="CLOUDAMQP_PORT"
MQ_USER="CLOUDAMQP_USER"
MQ_PASSWORD="CLOUDAMQP_PASSWORD"
MQ_VHOST="CLOUDAMQP_VHOST"
```
Also add values for the exchange name, the queue name and the routing key.

4. From the root directory, run this script `sh install.sh` to build and start the Docker containers

3. Next, `docker compose exec users php artisan migrate` will run the migrations for the MySQL database.

At this point, the services should be running.


### Users Service

The Users service can be accessed via `http://users.localhost`. Making a POST request to `/users` with a body containing the keys `{"email", "firstName", "lastName"}` wouldd create a new user and send this data to the notifications service via RabbitMQ, as long as you have configured that.

### Notifications Service

The Notifications service is accessible via `http://notifications.localhost`, though there are currently no endpoints. New users created on the User service are logged in this service, in the file `notifications/storage/logs/mq.log`.

---

### Testing

From the root directory, simply run the script `sh test.sh` or run `php artisan migrate` in either service directory to run tests.

---