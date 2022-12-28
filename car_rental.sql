CREATE DATABASE car_rental;
use car_rental;
CREATE TABLE admin (
  id int DEFAULT 1,
  email varchar(225) NOT NULL,
  password varchar(225) NOT NULL,
  PRIMARY KEY(id)
);
CREATE TABLE car (
  car_plate varchar(10) NOT NULL,
  model varchar(225) NOT NULL,
  model_year year NOT NULL,
  color varchar(50) NOT NULL,
  admin_id int DEFAULT 1,
  daily_price decimal(10,2) NOT NULL,
  office_id int NOT NULL,
  status varchar(50) NOT NULL,
  image varchar(225) NOT NULL,
  PRIMARY KEY(car_plate)
);
CREATE TABLE car_status (
  car_plate varchar(10) NOT NULL,
  status varchar(50) NOT NULL,
  start_date date NOT NULL,
  end_date date ,
  PRIMARY KEY(car_plate,status,start_date,end_date)
);
CREATE TABLE customer (
  cust_id int AUTO_INCREMENT NOT NULL,
  name varchar(225) NOT NULL,
  email varchar(225) NOT NULL,
  password varchar(225) NOT NULL,
  PRIMARY KEY(cust_id)
);
CREATE TABLE office (
  office_id int AUTO_INCREMENT NOT NULL,
  location varchar(225) NOT NULL,
  PRIMARY KEY(office_id)
);
CREATE TABLE registration (
  register_no int AUTO_INCREMENT NOT NULL,
  car_plate varchar(10) NOT NULL,
  cust_id int NOT NULL,
  office_id int NOT NULL,
  payment decimal(10,2) NOT NULL,
  pay_date date ,
  penalty decimal(10,2) DEFAULT 0.00 ,
  start_date date NOT NULL,
  end_date date DEFAULT NULL,
  return_date date DEFAULT NULL,
  is_returned BOOLEAN DEFAULT FALSE,
  PRIMARY KEY(register_no)
);
ALTER TABLE car
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY(admin_id) REFERENCES admin(id),
  ADD CONSTRAINT `car_ibfk_2` FOREIGN KEY(office_id) REFERENCES office(office_id);

ALTER TABLE car_status
  ADD CONSTRAINT `car_status_ibfk_1` FOREIGN KEY(car_plate) REFERENCES car(car_plate);

ALTER TABLE registration
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`car_plate`) REFERENCES `car` (`car_plate`),
  ADD CONSTRAINT `registration_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`),
  ADD CONSTRAINT `registration_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `office` (`office_id`);
