drop database EpicVideo;
CREATE DATABASE EpicVideo;
USE EpicVideo;


CREATE ROLE if not exists 'administrator', 'app_read','rental';

GRANT ALL ON EpicVideo.* TO 'administrator';
GRANT SELECT ON app_EpicVideo.* TO 'app_read';
GRANT INSERT, UPDATE, DELETE ON app_EpicVideo.* TO 'rental';

CREATE USER IF NOT EXISTS 'hansi'@'localhost' IDENTIFIED BY 'hansi*pass';
CREATE USER IF NOT EXISTS 'nuwan'@'localhost' IDENTIFIED BY 'kaman$pass';
CREATE USER IF NOT EXISTS 'keshini'@'localhost' IDENTIFIED BY 'rehan%pass';
CREATE USER IF NOT EXISTS 'kylie'@'localhost' IDENTIFIED BY 'rosan^pass';
CREATE USER IF NOT EXISTS 'nilu'@'localhost' IDENTIFIED BY 'sanjupass';


GRANT'administrator'TO'hansi'@'localhost';
GRANT'app_read'TO'nuwan'@'localhost','keshini'@'localhost','kylie'@'localhost','nilu'@'localhost';
GRANT'rental'TO'nuwan'@'localhost','keshini'@'localhost','kylie'@'localhost','nilu'@'localhost';


CREATE TABLE IF NOT EXISTS Country(
    country_id INT primary key not NULL AUTO_INCREMENT,
    country_name VARCHAR(30)
);

INSERT INTO Country(country_id,country_name)VALUES(DEFAULT,'AUSTRALIA');
INSERT INTO Country(country_id,country_name)VALUES(DEFAULT,'INDIA');
INSERT INTO Country(country_id,country_name)VALUES(DEFAULT,'SRILanka');
select * from Country;

CREATE TABLE IF NOT EXISTS States(
    state_id INT not NULL AUTO_INCREMENT,
    country_id INT,
    state_name VARCHAR(30),

    PRIMARY KEY(state_id),
    FOREIGN KEY(country_id) REFERENCES Country(country_id)
);

INSERT INTO States(state_id,country_id,state_name)VALUES(DEFAULT,'1','VIC');
INSERT INTO States(state_id,counntry_id,state_name)VALUES(DEFAULT,'1','NSW');
INSERT INTO States(state_id,country_id,state_name)VALUES(DEFAULT,'1','VIC');
select * from States;


CREATE TABLE IF NOT EXISTS Cities(
    city_id INT not null AUTO_INCREMENT,
    state_id INT,
    city_name VARCHAR(50),
    postcode int(4),

    PRIMARY KEY(city_id),
     FOREIGN KEY(state_id)REFERENCES States(state_id)
);
INSERT INTO Cities(city_id,state_id,city_name,postcode)VALUES(DEFAULT,'1','Melbourne','3000');
INSERT INTO Cities(city_id,state_id,city_name,postcode)VALUES(DEFAULT,'1','Werribee','3030');
select * from Cities;


CREATE TABLE IF NOT EXISTS Address_type(
    address_type_id INT primary key not NULL,
    address_type VARCHAR(30)
);
INSERT INTO Address_Type(address_type_id,address_type)VALUES('1','Customer');
INSERT INTO Address_Type(address_type_id,address_type)VALUES('2','Staff');
select * from Address_Type;


CREATE TABLE IF NOT EXISTS Addresses(
    address_id int not NULL AUTO_INCREMENT,
    address1 varchar(50),
    address2 varchar(50),
    address3 varchar(50),
    city_id int not null,
    address_type_id INT,
   
    PRIMARY KEY(address_id),
    FOREIGN KEY(city_id) REFERENCES Cities(city_id),
    FOREIGN KEY(address_type_id) REFERENCES Address_type(address_type_id)
);
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'5','Latham Street','','1','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'12','Plenty Road','','2','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'205','Latham Street','','2','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'500','Silly Street','','2','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'20','rosella street','','2','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'202','Latham Street','','2','1');
INSERT INTO Addresses(address_id,address1,address2,address3,city_id,address_type_id)VALUES(DEFAULT,'2','Humming Street','','2','1');
select * from Addresses;



CREATE TABLE IF NOT EXISTS Customers(
    customer_id int not NULL AUTO_INCREMENT ,
    first_name  varchar(50) not NULL,
    last_name varchar(50),
    phone int(10),
    email varchar(50),
    no_of_rented_copies  int check(no_of_rented_copies<=6),
    username NVARCHAR(50) UNIQUE,
    customer_password Nvarchar(8) UNIQUE,

    PRIMARY KEY(customer_id) 
);
INSERT INTO Customers(first_name,last_name,phone,email,no_of_rented_copies,username,customer_password)VALUES('Nilupa','Dhanawal','0912232712','nilupa.sanju@gmail.com','4','nilu','dhana');
INSERT INTO Customers(first_name,last_name,phone,email,no_of_rented_copies,username,customer_password)VALUES('Nil','Dhan','0812232712','nil.sanj@gmail.com','3','123','adf');
select * from Customers;


CREATE TABLE IF NOT EXISTS Customer_address(
    address_id INT,
    customer_id INT,

    FOREIGN KEY (address_id) REFERENCES Addresses(address_id), 
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
   
    UNIQUE (address_id,customer_id)
);
INSERT INTO Customer_address(address_id,customer_id)VALUES('1','2');
INSERT INTO Customer_address(address_id,customer_id)VALUES('2','3');
select * from Customer_address;


CREATE TABLE IF NOT EXISTS LoginStaff(
    login_id INT not null primary key AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    username NVARCHAR(50) UNIQUE,
    loginpassword NVARCHAR(8),

    UNIQUE (loginpassword)
);
INSERT INTO LoginStaff(login_id,first_name,last_name,username,loginpassword)VALUES(DEFAULT,'hansi','rath','hansini','HANSI1');
INSERT INTO LoginStaff(login_id,first_name,last_name,username,loginpassword)VALUES(DEFAULT,'keshini','don','keshini','rehans1');
INSERT INTO LoginStaff(login_id,first_name,last_name,username,loginpassword)VALUES(DEFAULT,'nuwan','rath','don','nuwand2');
select * from LoginStaff;


CREATE TABLE IF NOT EXISTS Roles (
    role_id INT not null primary key,
    roles_description varchar(255)
);
INSERT INTO Roles(role_id,roles_description)VALUES('1','MAnager');
INSERT INTO Roles(role_id,roles_description)VALUES('2','Cashier');
INSERT INTO Roles(role_id,roles_description)VALUES('3','DataEntry Oparator');
select * from Roles;


CREATE TABLE IF NOT EXISTS Staff(
    staff_id int not NULL,
    login_id INT UNIQUE,
    phone INT(10),
    email VARCHAR(100),
    gender VARCHAR(6),
    wage INT(7),
    

    PRIMARY KEY(staff_id),
    CONSTRAINT FK_LoginStaff FOREIGN KEY(login_id) REFERENCES LoginStaff(login_id)
);
INSERT INTO Staff(staff_id,login_id,phone,email,gender,wage)VALUES('1','1','0914158766','hansi@gmail.com','Female','10000');
INSERT INTO Staff(staff_id,login_id,phone,email,gender,wage)VALUES('2','2','0912258766','keshini@gmail.com','Female','10000');
INSERT INTO Staff(staff_id,login_id,phone,email,gender,wage)VALUES('3','3','0914158256','hansi@gmail.com','Female','10000');
select * from Staff;


CREATE TABLE IF NOT EXISTS Staff_Roles (
    role_id  INT,
    staff_id INT,

    FOREIGN KEY(staff_id) REFERENCES Staff(staff_id),
    FOREIGN KEY(role_id) REFERENCES Roles(role_id),
    UNIQUE (staff_id,role_id)
);
INSERT INTO Staff_Roles(staff_id,role_id)VALUES('1','2');
INSERT INTO Staff_Roles(staff_id,role_id)VALUES('2','1');
INSERT INTO Staff_Roles(staff_id,role_id)VALUES('3','3');
select * from Staff_Roles;


CREATE TABLE IF NOT EXISTS Staff_address(
    address_id INT,
    staff_id INT,

    FOREIGN KEY (address_id) REFERENCES Addresses(address_id), 
    FOREIGN KEY (staff_id) REFERENCES Staff(staff_id),
    UNIQUE (address_id,staff_id)
);
INSERT INTO Staff_address(address_id,staff_id)VALUES('4','2');
INSERT INTO Staff_address(address_id,staff_id)VALUES('5','1');
INSERT INTO Staff_address(address_id,staff_id)VALUES('6','3');
select * from Staff_address;


CREATE TABLE IF NOT EXISTS Transactions(
    transaction_id INT not null AUTO_INCREMENT,
    staff_id int,
    customer_id INT ,
    date_of_pay DATE not null,
    amount DECIMAL not null,

    PRIMARY KEY(transaction_id),
    
    FOREIGN KEY(staff_id) REFERENCES Staff(staff_id),
    FOREIGN KEY(customer_id) REFERENCES Customers(customer_id)
);
INSERT INTO Transactions(transaction_id,staff_id,customer_id,date_of_pay,amount)VALUES(DEFAULT,'2','1','2019-03-23','43.00');
INSERT INTO Transactions(transaction_id,staff_id,customer_id,date_of_pay,amount)VALUES(DEFAULT,'2','2','2019-03-25','43.00');
INSERT INTO Transactions(transaction_id,staff_id,customer_id,date_of_pay,amount)VALUES(DEFAULT,'1','3','2019-03-23','43.00');
select * from Transactions;


CREATE TABLE IF NOT EXISTS Movie_genre(
    genre_id INT primary key not null,
    genre_description VARCHAR(100)
);
INSERT INTO Movie_genre(genre_id,genre_description)VALUES('1','Horror');
INSERT INTO Movie_genre(genre_id,genre_description)VALUES('2','Commedy');
INSERT INTO Movie_genre(genre_id,genre_description)VALUES('3','Kids');
INSERT INTO Movie_genre(genre_id,genre_description)VALUES('4','Romantic');
INSERT INTO Movie_genre(genre_id,genre_description)VALUES('5','Action');
select * from Movie_genre;


CREATE TABLE IF NOT EXISTS Customer_genre(
    genre_id INT not null,
    customer_id int not null,

    primary key (genre_id,customer_id)
);
INSERT INTO Customer_genre(genre_id,customer_id)VALUES('1','1');
INSERT INTO Customer_genre(genre_id,customer_id)VALUES('2','1');
INSERT INTO Customer_genre(genre_id,customer_id)VALUES('3','2');
INSERT INTO Customer_genre(genre_id,customer_id)VALUES('4','2');
select * from Customer_genre;



CREATE TABLE IF NOT EXISTS Movies(
    movie_id INT primary key not null AUTO_INCREMENT,
    genre_id INT,
    title VARCHAR(100),
    movie_year INT(4),
    movie_description VARCHAR(255),
    movie_length TIME,
    daily_price DECIMAL,
    obselete BOOlean,

    
    FOREIGN KEY(genre_id) REFERENCES Movie_genre(genre_id)
);
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'3','Moana','2016','Moana, daughter of chief Tui, embarks on a journey to return the heart of goddess.','1:53:00','10.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'3','Frozen','201','The film depicts a princess who sets off on a journey alongside an iceman, his reindeer, and a snowman to find her estranged sister, whose icy powers have inadvertently trapped their kingdom in eternal winter.','1:53:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'1','code of black','2001','abde','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'2','Davinci Code','2003','efg','2:53:00','30.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'1','code of black','2001','abde','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'1','IT S ALIVE!','1975','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'1','code of black','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'4','Note Book','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'4','Stair way to heaven','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'4','Me before you','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'5','Marvel','2001','abde','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'5','Spider Man','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');
INSERT INTO Movies(movie_id,genre_id,title,movie_year,movie_description,movie_length,daily_price,obselete)
VALUES(DEFAULT,'5','Super Man','2001','Leaving their son, Chris (Daniel Holzman), with a family friend ','1:55:00','20.00','0');

select * from Movies;


CREATE TABLE IF NOT EXISTS Movie_Format(
    format_id INT primary key not null,
    format_typ VARCHAR(3)
);
INSERT INTO Movie_Format(format_id,format_typ)VALUES('1','DVD');
INSERT INTO Movie_Format(format_id,format_typ)VALUES('2','VHS');
select * from Movie_Format;



CREATE TABLE IF NOT EXISTS Movie_Copies(
    copy_id INT not null AUTO_INCREMENT,
    movie_id INT not null,
    format_id INT not null,
    conditiontype VARCHAR(10),

    PRIMARY KEY(copy_id),
    FOREIGN KEY(movie_id) REFERENCES Movies(movie_id),
    FOREIGN KEY(format_id) REFERENCES Movie_Format(format_id)
    
);
INSERT INTO Movie_Copies(copy_id,movie_id,format_id,conditiontype)VALUES(DEFAULT,'1','2','good');
INSERT INTO Movie_Copies(copy_id,movie_id,format_id,conditiontype)VALUES(DEFAULT,'3','1','good');
INSERT INTO Movie_Copies(copy_id,movie_id,format_id,conditiontype)VALUES(DEFAULT,'1','2','damaged');
INSERT INTO Movie_Copies(copy_id,movie_id,format_id,conditiontype)VALUES(DEFAULT,'1','2','stolen');
select * from Movie_Copies;


CREATE TABLE IF NOT EXISTS Stock(
    movie_id INT not null,
    copy_id int not null,
    available_copies int,
    rented_copies int,
    damaged_copies int,
    stolen_copies int,

     PRIMARY KEY(copy_id,movie_id)
    
);
INSERT INTO Stock(movie_id,copy_id,available_copies,rented_copies,damaged_copies,stolen_copies)VALUES('1','1','4','3','1','0');
INSERT INTO Stock(movie_id,copy_id,available_copies,rented_copies,damaged_copies,stolen_copies)VALUES('2','3','4','3','1','0');
select * from Stock;


CREATE TABLE IF NOT EXISTS Rental_Status(
    rent_status_id INT primary key not null,
    status_description VARCHAR(255)
);
INSERT INTO Rental_Status(rent_status_id,status_description)VALUES('1','Rented');
INSERT INTO Rental_Status(rent_status_id,status_description)VALUES('2','returned');
INSERT INTO Rental_Status(rent_status_id,status_description)VALUES('3','overdue');
select * from Rental_Status;


CREATE TABLE IF NOT EXISTS Rating(
    rating_id INT primary key not null,
    rating INT not null,
    rating_description VARCHAR(255)
);
INSERT INTO Rating(rating_id,rating,rating_description)VALUES('1','1','Excelent');
INSERT INTO Rating(rating_id,rating,rating_description)VALUES('2','2','Good');
INSERT INTO Rating(rating_id,rating,rating_description)VALUES('3','3','Bad ');
INSERT INTO Rating(rating_id,rating,rating_description)VALUES('4','4','Very Bad');
select * from Rating;


CREATE TABLE IF NOT EXISTS Customer_Rating(
    rating_id INT not null,
    movie_id INT not null,
    customer_id INT not null,
    
    PRIMARY KEY(rating_id,movie_id),
    FOREIGN KEY(customer_id) REFERENCES Customers(customer_id)
);
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('1','1','1');
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('2','2','1');
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('4','3','2');
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('3','4','1');
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('1','5','1');
INSERT INTO Customer_Rating(rating_id,movie_id,customer_id)VALUES('4','1','2');
select * from Customer_Rating;


CREATE TABLE IF NOT EXISTS Packages(
    package_id INT primary key not null,
    no_of_days INT,
    package_name VARCHAR(10),
    price        decimal,
    format_id    INt,

    FOREIGN KEY(format_id) REFERENCES Movie_Format(format_id)
);
INSERT INTO Packages(package_id,no_of_days,package_name,price,format_id)VALUES('1','1','daily','10.00','1');
INSERT INTO Packages(package_id,no_of_days,package_name,price,format_id)VALUES('2','3','thrise','30.00','1');
INSERT INTO Packages(package_id,no_of_days,package_name,price,format_id)VALUES('3','7','weekly','70.00','1');
select * from Packages;


CREATE TABLE IF NOT EXISTS Rent_Movie(
    rent_id INT not null AUTO_INCREMENT,
    customer_id INT,
    rent_status_id INT,
    package_id INT,
    rent_date DATE not null,
    due_date DATE not null,
    rent_amount_due DECIMAL not null,
    note VARCHAR(255),

    PRIMARY KEY(rent_id),
    FOREIGN KEY(customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY(rent_status_id) REFERENCES Rental_Status(rent_status_id),
    FOREIGN KEY(package_id) REFERENCES Packages(package_id)
);
INSERT INTO Rent_Movie(rent_id,customer_id,rent_status_id,package_id,rent_date,due_date,rent_amount_due)VALUES(DEFAULT,'1','2','1','2020-01-01','2020-01-02','10.00');
INSERT INTO Rent_Movie(rent_id,customer_id,rent_status_id,package_id,rent_date,due_date,rent_amount_due)VALUES(DEFAULT,'1','2','1','2021-01-01','2021-01-02','10.00');
INSERT INTO Rent_Movie(rent_id,customer_id,rent_status_id,package_id,rent_date,due_date,rent_amount_due)VALUES(DEFAULT,'2','1','2','2021-02-22','2020-02-26','10.00');
INSERT INTO Rent_Movie(rent_id,customer_id,rent_status_id,package_id,rent_date,due_date,rent_amount_due)VALUES(DEFAULT,'2','1','3','2020-02-25','2020-03-03','10.00');
select * from Rent_Movie;



CREATE TABLE If not exists Messages (
    message_id INT not null primary key AUTO_INCREMENT,
    customer_id int,
    message_description VARCHAR(255),
    messagedate datetime,
    message_reply varchar(255),

    FOREIGN KEY(customer_id) REFERENCES Customers(customer_id)
);
/*INSERT INTO Messages(message_id,customer_id,message_description,message_reply)VALUES(DEFAULT,'1','Hi','hi');
INSERT INTO Messages(message_id,customer_id,message_description,message_reply)VALUES(DEFAULT,'1','How are you','');
INSERT INTO Messages(message_id,customer_id,message_description,message_reply)VALUES(DEFAULT,'1','Hi','');
INSERT INTO Messages(message_id,customer_id,message_description,message_reply)VALUES(DEFAULT,'1','Hi','');
select * from messages;*/


CREATE TABLE If not exists Enquiry (
    Enquiry_id INT not null primary key AUTO_INCREMENT,
    Cus_name varchar(10),
    mobile int(12),
    email VARCHAR(30),
    enquiry VARCHAR(255)
);

CREATE TABLE Images(
      Image_ID int NOT NULL primary key AUTO_INCREMENT,
      image_file BLOB

 );
 INSERT into images(image_id,genre_id)Values('a1','5');
INSERT into images(image_id,genre_id)Values('a2','5');
INSERT into images(image_id,genre_id)Values('a3','5');
INSERT into images(image_id,genre_id)Values('a4','5');
INSERT into images(image_id,genre_id)Values('h1','1');
INSERT into images(image_id,genre_id)Values('h2','1');
INSERT into images(image_id,genre_id)Values('h3','1');
INSERT into images(image_id,genre_id)Values('h4','1');
INSERT into images(image_id,genre_id)Values('k1','3');
INSERT into images(image_id,genre_id)Values('k2','3');
INSERT into images(image_id,genre_id)Values('k3','3');
INSERT into images(image_id,genre_id)Values('k4','3');
INSERT into images(image_id,genre_id)Values('c1','2');
INSERT into images(image_id,genre_id)Values('c2','2');
INSERT into images(image_id,genre_id)Values('c3','2');
INSERT into images(image_id,genre_id)Values('c4','2');
INSERT into images(image_id,genre_id)Values('r1','4');
INSERT into images(image_id,genre_id)Values('r2','4');
INSERT into images(image_id,genre_id)Values('r3','4');
INSERT into images(image_id,genre_id)Values('r4','4');

CREATE TABLE Customer_Images(
      Image_ID int NOT NULL,
      customer_id int not null,
      movie_id int,
      
      PRIMARY KEY(image_id,customer_id)

 );    
 CREATE VIEW rental_information
AS SELECT rent_date, due_date, Customers.first_name,
Customers.phone,Rental_Status.status_description
FROM Rent_Movie, Customers, Rental_Status 
WHERE Rent_Movie.rent_status_id=Rental_Status.rent_status_id
AND Rent_Movie.customer_id=Customers.customer_id;

select * from rental_information;

CREATE VIEW movie_information
AS SELECT title, movie_length, Movie_Format.format_typ,
Movie_Copies.copy_id
FROM Movies, Movie_Copies, Movie_Format
WHERE Movies.movie_id=Movie_Copies.movie_id
AND Movie_Copies.format_id=Movie_Format.format_id;

select * from movie_information;


CREATE TABLE Blog(
    blog_id int NOT NULL primary key AUTO_INCREMENT,
    customer_id int,
    title varchar(100),
    content BLOB,
    comment varchar(255),
    create_date TIMESTAMP,

    FOREIGN KEY(customer_id) REFERENCES Customers(customer_id)
     
 );
 
 /*SELECT Blog.title, Blog.content, Customers.first_name FROM Blog                 
 JOIN Customers ON Customers.customer_id = Blog.customer_id where Blog.customer_id=1;

 INSERT INTO Blog(customer_id,title,content,comment)VALUES(1,'hi','how are you','');*/

 ALTER TABLE Rent_Movie ADD COLUMN copy_id int After customer_id;
  ALTER TABLE Customer_Rating ADD COLUMN review varchar(255) After customer_id;

 /*UPDATE states
SET state_name = NSW
WHERE state_id=2;*/


 






















































/*CREATE INDEX idx_firstname
ON Customers (first_name);


SELECT Movies.title, Movie_Format.format_typ
FROM ((Movies
INNER JOIN Movie_Copies ON Movie_Copies.movie_id = Movies.movie_id)
INNER JOIN Movie_Format ON Movie_Format.format_id = Movie_Copies.format_id);

SELECT Movies.title, Movie_genre.genre_description
FROM Movies
INNER JOIN Movie_genre ON Movie_genre.genre_id = Movies.movie_id 
where Movie_genre.genre_description='kids';

SELECT * from Movies where title like '%a';

select * from Customers where first_name like '%' or phone='0912232712';

select * from Rent_Movie 
   INNER join Rental_Status on Rent_Movie.rent_status_id=Rental_Status.rent_status_id 
   INNER join Customers on Rent_Movie.customer_id=Customers.customer_id
   where status_description="Rented";

CREATE VIEW rental_information
AS SELECT rent_date, due_date, Customers.first_name,
Customers.phone,Rental_Status.status_description
FROM Rent_Movie, Customers, Rental_Status 
WHERE Rent_Movie.rent_status_id=Rental_Status.rent_status_id
AND Rent_Movie.customer_id=Customers.customer_id;

select * from rental_information;

CREATE VIEW movie_information
AS SELECT title, movie_length, Movie_Format.format_typ,
Movie_Copies.copy_id
FROM Movies, Movie_Copies, Movie_Format
WHERE Movies.movie_id=Movie_Copies.movie_id
AND Movie_Copies.format_id=Movie_Format.format_id;

select * from movie_information;




select * from Movies 
    INNER join Movie_Copies on Movies.movie_id=Movie_Copies.movie_id
    INNER join Rent_Movie on Rent_Movie.copy_id=Movie_Copies.copy_id
    INNER join Rental_Status on Rent_Movie.rent_status_id=Rental_Status.rent_status_id;
    
select * From Movies
    INNER join Movie_Copies on Movies.movie_id=Movie_Copies.movie_id
    INNER join Movie_Condition on Movie_Condition.condition_id=Movie_Copies.condition_id;

select title, Movie_Condition.condtion_status, Movie_Copies.copy_id From Movies
    INNER join Movie_Copies on Movies.movie_id=Movie_Copies.movie_id
    INNER join Movie_Condition on Movie_Condition.condition_id=Movie_Copies.condition_id;


 select customer_id, rent_date, due_date from Rent_Movie 
   INNER join Rental_Status on Rent_Movie.rent_status_id=Rental_Status.rent_status_id where status_description="Rented";

select movie_id from Movies 
   union select movie_id from Movie_Copies;
   
CREATE VIEW Profile
AS SELECT Customers.customer_id, Customers.first_name, Customers.last_name,Customers.phone, Customers.email, Movie_genre.genre_description

FROM Customers, Movie_genre
WHERE Movie_genre.genre_id=Customer_genre.genre_id
AND Customers.customer_id=Customer_genre.customer_id;

select * from Profile;


SELECT Customers.customer_id,Customers.first_name,Customers.last_name,Customers.phone,Customers.email,Movie_genre.genre_description
  From Customers,Movie_genre,Customer_genre
  where Customers.customer_id = Customer_genre.customer_id
  and Movie_genre.genre_id = Customer_genre.genre_id;

SELECT Customers.customer_id,Customers.first_name,Customers.last_name,Customers.phone,Customers.email,Movie_genre.genre_description
  From Customers
  LEFT JOIN Customer_genre on Customers.customer_id = Customer_genre.customer_id
  LEFT JOIN Movie_genre on Movie_genre.genre_id = Customer_genre.genre_id where customer_id= 2;

CREATE VIEW Customer_Profie
AS SELECT Customers.customer_id,Customers.first_name,Customers.last_name,Customers.phone,Customers.email,Movie_genre.genre_description
  From Customers,Movie_genre,Customer_genre
  where Customers.customer_id = Customer_genre.customer_id
  and Movie_genre.genre_id = Customer_genre.genre_id;*/
