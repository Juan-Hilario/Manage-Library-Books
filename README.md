## How run the app
Make sure to have PHP, Composer, and a MySQL(or MariaDB) database server installed.

## Setup

Install the dependencies and add a .env file to the project directory:
```bash
composer install
touch .env
```

Write these variables to the .env file:
```ini
CI_ENVIRONMENT = development
database.default.hostname = localhost
database.default.database = library_books
database.default.username = librarian
database.default.password = 123
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Next, start the mysql server up through the terminal:

Mac(mysql):
```bash
brew services start mysql
```
Linux(mariadb):
```bash
sudo systemctl start mariadb
```

Create a database and user (run with root/admin access):

```sql
CREATE DATABASE library_books;
CREATE DATABASE 'librarian'@'localhost' IDENTIFIED By '123';
GRANT ALL ON library_books.* TO 'librarian'@'localhost';
```

Migrate the database and start up app :
```bash
php spark migrate
php spark serve
```


Open http://localhost:8080/books.


## Design Decisions

### Colors
- I kept the colors minimal but I made sure to make the colors of the different sections different. So, the table header, table body, and page body have different backgrounds.

### Navagation
- I made a nav bar at the top with the title 'Library' with the two page links, this way they can be accessed from either page.

### Photo Upload
- I decided to show the image and its file name when editing a book record. Otherwise the user wouldn't know from the form page if that record had a image already. 
- I also made a checkbox that allows the user to delete that current image and update the record without an image. When checked, a new file upload won't be allowed as the input is disabled.
