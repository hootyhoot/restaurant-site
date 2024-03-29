CREATE DATABASE IF NOT EXISTS restaurantDB;

USE restaurantDB;


CREATE TABLE IF NOT EXISTS User(
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50),
    Email VARCHAR(50) NOT NULL,
    ContactNo VARCHAR(11) NOT NULL,
    UserType ENUM('Admin', 'Customer') NOT NULL
);


INSERT IGNORE INTO User (UserID, Username, Password, FirstName, LastName, Email, ContactNo, UserType) VALUES 
        (1, 'admin', 'admin123', 'Moon', 'Son', 'restaurant_admin@gmail.com', '0125559999', 'Admin'),
        (2, 'SpongeBob', 'SquarePants234', 'SpongeBob', 'SquarePants', 'bikini_bottom@gmail.com', '3344418088', 'Customer'),
        (3, 'Patrick', 'Star123', 'Patrick', 'Star', 'under_the_rock@gmail.com', '0173396049', 'Customer');


CREATE TABLE IF NOT EXISTS Cart(
    CartID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FoodID INT,
    Quantity INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (FoodID) REFERENCES Food (FoodID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Food(
    FoodID INT AUTO_INCREMENT PRIMARY KEY,
    FoodName VARCHAR(50) NOT NULL,
    Price DECIMAL(6,2) NOT NULL,
    Availability ENUM('Available', 'Not Available') NOT NULL,
    /*FoodPic stores file path to picture only, not going to store the picture itself*/
    FoodPic VARCHAR(255) NOT NULL, 
    Description VARCHAR(255),
    CategoryID INT,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Category(
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(50) NOT NULL
);


CREATE TABLE IF NOT EXISTS FoodOrder( 
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FoodID INT,
    Quantity INT,
    PaymentID INT,
    OrderStatus ENUM('Pending', 'Delivered') NOT NULL,
    DeliveryAddress VARCHAR(255) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (FoodID) REFERENCES Food(FoodID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Payment(
    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(10,2) NOT NULL,
    PaymentDate DATE NOT NULL
);