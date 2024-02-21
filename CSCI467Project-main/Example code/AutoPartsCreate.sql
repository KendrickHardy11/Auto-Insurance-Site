/********************************************************************
CSCI 466 - Group Project - Create Tables Auto Parts

Progammer: Salman Ahmed, Rafa Diaz, Rachel Schmitt, Joseph Utz
Section: 1
Date Due: 11/30/2022
*********************************************************************/

use 'z1926743';             -- Select the personal database 

---------------------------------------------------------------------

CREATE TABLE Customer
    (
        Customer_ID INT(5) PRIMARY KEY,
        F_Name VARCHAR(20) NOT NULL,
        L_Name VARCHAR(20) NOT NULL,
        Address_Shipping VARCHAR(50) NOT NULL,
        Address_Billing VARCHAR(50) NOT NULL,
        Old_Order INT(15) 
    );

---------------------------------------------------------------------

CREATE TABLE Employee
    (
        Emp_ID INT(5) PRIMARY KEY,
        F_Name VARCHAR(20) NOT NULL,
        L_Name VARCHAR(20) NOT NULL,
        Address VARCHAR(50) NOT NULL,
        Phone_Num VARCHAR(10) NOT NULL,
        Payroll VARCHAR(50) NOT NULL
    );

---------------------------------------------------------------------

CREATE TABLE Part
    (
        Part_Num INT(2) PRIMARY KEY,
        Name VARCHAR(20) NOT NULL,
        Amount INT(3) NOT NULL,
        Price FLOAT(6) NOT NULL
    );

---------------------------------------------------------------------

CREATE TABLE Customer_Cart
    (
        Customer_ID INT(5),
        Part_Num INT(2),
        Name VARCHAR(20),
        Amount INT(3), 
        Price FLOAT(6),
        Subtotal FLOAT(8),
        FOREIGN KEY (Part_Num) REFERENCES Part(Part_Num),
        FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
    );

---------------------------------------------------------------------

CREATE TABLE Orders
    (
        Order_Num INT(10) AUTO_INCREMENT,
        Customer_ID INT(5),
        Confirmation_Num INT(10) UNIQUE,
        Part_Num INT(5),
        Date_of_Order VARCHAR(50),
        Shipping_Num INT(10),
        Status_Order VARCHAR(20) DEFAULT "confirmed",
        Cost FLOAT(5),
        Amount INT(5),
        PRIMARY KEY (Order_Num),
        FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
        FOREIGN KEY (Part_Num) REFERENCES Part(Part_Num)
    );

---------------------------------------------------------------------

