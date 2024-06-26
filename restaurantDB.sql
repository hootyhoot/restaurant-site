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

CREATE TABLE IF NOT EXISTS Category(
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Food(
    FoodID INT AUTO_INCREMENT PRIMARY KEY,
    FoodName VARCHAR(50) NOT NULL,
    Price DECIMAL(6,2) NOT NULL,
    Availability ENUM('Available', 'Not Available') NOT NULL,
    FoodPic LONGBLOB NOT NULL,
    Description VARCHAR(255),
    CategoryID INT,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID) ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Cart(
    CartID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FoodID INT,
    Quantity INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY (FoodID) REFERENCES Food (FoodID) ON UPDATE RESTRICT ON DELETE RESTRICT
);

INSERT IGNORE INTO User (UserID, Username, Password, FirstName, LastName, Email, ContactNo, UserType) VALUES 
        (1, 'admin', 'admin123', 'Moon', 'Son', 'restaurant_admin@gmail.com', '0125559999', 'Admin'),
        (2, 'SpongeBob', 'SquarePants234', 'SpongeBob', 'SquarePants', 'bikini_bottom@gmail.com', '3344418088', 'Customer'),
        (3, 'Patrick', 'Star123', 'Patrick', 'Star', 'under_the_rock@gmail.com', '0173396049', 'Customer');

INSERT IGNORE INTO Category (CategoryID, CategoryName) VALUES 
        (1, 'Appetizers'),
        (2, 'Main Courses'),
        (3, 'Desserts');

INSERT IGNORE INTO Food (FoodID, FoodName, Price, Availability, FoodPic, Description, CategoryID) VALUES 
        (1, 'Laksa Penang', 13.50, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/laksaPenang.jpg'), 'Rice noodles in a rich and tangy fish broth', 2),
        (2, 'Hainanese Chicken Rice', 12.50, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/hainaneseChickenRice.jpg'), 'Steamed chicken served with broth seasoned rice', 2),
        (3, 'Prawn Fried Rice', 11.00, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/prawnFriedRice.jpg'), 'Classic fried rice with jumbo prawns', 2),
        (4, 'Seremban Siew Pau', 4.00, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/serembanSiewPau.jpg'), 'Flaky, crispy exterior with BBQ chicken filling', 1),
        (5, 'Baked Spring Rolls', 3.00, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/bakedSpringRolls.jpg'), 'Light and airy vegetable rolls', 1),
        (6, 'Karipap', 1.30, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/karipap.jpg'), 'Iconic malay flaky curry puffs', 1),
        (7, 'Cendol', 7.50, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/cendol.jpg'), 'Shaved ice with brown sugar and local toppings', 3),
        (8, 'Apam Balik', 4.00, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/apamBalik.jpg'), 'Fluffy palm sugar pancakes', 3),
        (9, 'Kuih Sagu', 5.00, 'Available', LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/restaurant-site/default images/kuihSagu.jpg'), 'Chewy rose syrup soaked sagu coated in coconut', 3);

CREATE TABLE IF NOT EXISTS Payment(
    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    PaymentType ENUM('Credit Card', 'Touch N Go') NOT NULL,
    Amount DECIMAL(10,2) NOT NULL,
    PaymentDate DATETIME NOT NULL
);


CREATE TABLE IF NOT EXISTS DeliveryDetails(
    DeliveryID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    ContactNo VARCHAR(11) NOT NULL,
    Address VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS FoodOrder( 
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    FoodID INT,
    Quantity INT,
    PaymentID INT,
    DeliveryID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY (FoodID) REFERENCES Food(FoodID) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY (DeliveryID) REFERENCES DeliveryDetails(DeliveryID) ON UPDATE RESTRICT ON DELETE RESTRICT
);
