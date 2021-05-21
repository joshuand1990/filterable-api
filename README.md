
# Filterable API

### Requirements
- [x]  CLI command to convert the input CSV file (see last section) to a JSON and XML file.
- [x]  REST API to serve the contents of the JSON file filterable by name and discount_percentage. Serving a filtered response in XML format.
- [x]  README file with anything you would like us to know about your solution and any future improvements you might make.

### Installation
- Docker need to be installed on your machine.
- run `docker compose build` to build the necessary dependencies.
- run `docker compose up` to start the machine.
- To ssh into the docker container there is a script in _./docker/shell.sh_, on MacOS you can `sh ./docker/shell.sh`.
- Once in the default directory */var/www/html*, run `composer install`, all the necessary packages will be installed.
- After the installation scripts of composer please create config file, `.env`, in the root directory of the project
- When the installation completes, all the available cli commands can be accessed using `php artisan` while in the root directory via the terminal.
- Web server can be accessed using http://localhost.
- Since we are using an `.env` file, the "database" (json file) can be configured using hte key `CSV_FILE`, in-case there needs to be any path changes - the full path needs to given
- There is a sample `.env` file called `.env.example` that can be used as a  template



## API Reference

#### Get all items

```http
  GET /api/listings
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | *optional*.  Filters by name |
| `discount_percentage` | `string` | *optional*. Filters by discount percentage |



  #### CSV Convertor
  ```shell
  php artisan app:convert {file} {formats=xml,json} {outputFilename}
  ```
  This command will create the necessary files for the web api to read and serve.
  

### Notes:
- Lumen Framework (lite framework with a quick router)
- PHP 7.2
- main csv file is under the _storage_ folder

### Testing:
- run tests using the `composer test` command while the active directory is the project root.
- all tests are available in the _tests_ folder.

### Improvements
- Adding Auth System using JWT
- Using a database (maybe sqlite) to complete the CURD operations.
- Move the api to JSON.
- Depending on the volume of data, we could implement a cache system.
