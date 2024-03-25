CREATE DATABASE IF NOT EXISTS restaurantDB;

USE restaurantDB;

CREATE TABLE IF NOT EXISTS User (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50),
    Email VARCHAR(50) NOT NULL,
    ContactNo INT(11) NOT NULL,
    UserType ENUM('Admin', 'Customer') NOT NULL
);

