/********************************************************************
CSCI 466 - Group Project - Insert Auto Parts

Progammer: Salman Ahmed, Rafa Diaz, Rachel Schmitt, Joseph Utz
Section: 1
Date Due: 11/30/2022
*********************************************************************/

use 'z1926743';             -- Select the personal database 

---------------------------------------------------------------------

INSERT INTO Customer (`Customer_ID`, `F_Name`, `L_Name`, `Address_Shipping`, `Address_Billing`)
VALUES ('82389', 'Sam', 'Jones', '4287 Fairway Lane', '4287 Fairway Lane'),
('98433', 'Sarah', 'Scott', '8923 Glen Drive', '8923 Glen Drive'),
('21893', 'Max', 'Stroll',  '4513 Hallaway Ct', '4513 Hallaway Ct'),
('18734', 'Nathan', 'Avery', '6783 Bethleham Drive', '6783 Bethleham Drive'),
('57832', 'David', 'Schwartz', '9851 Kanter Street', '9851 Kanter Street');

---------------------------------------------------------------------

INSERT INTO Employee (`Emp_ID`, `F_Name`, `L_Name`, `Address`, `Phone_Num`, `Payroll`)
VALUES ('56987', 'Ben', 'Jackson', '528 Fire Lane', '4289534569', '12'),
('24698', 'James', 'Smith', '569 Oak Street', '4586328567', '15'),
('32674', 'Jess', 'Anderson',  '241 Stright Ct', '8575236895', '11'),
('12687', 'Rose', 'Johnson', '539 Stone Drive', '5136358469', '17');
---------------------------------------------------------------------

INSERT INTO Part (`Part_Num`, `Name`, `Amount`, `Price`)
VALUES ('01', 'Battery', '376', '98.99'),
('02', 'Brakes', '176', '132.99'),
('03', 'Axle', '298', '82.99'),
('04', 'Fuel Injector', '165', '45.99'),
('05', 'Piston', '233', '34.99'),
('06', 'A/C Compressor', '324', '85.99'),
('07', 'Radiator', '136', '99.99'),
('08', 'Engine Fan', '254', '75.99'),
('09', 'Clutch', '364', '125.99'),
('10', 'Car Jack', '623', '89.99'),
('11', 'Spare Tire', '156', '64.99'),
('12', 'Transmission', '135', '795.99'),
('13', 'Shock Absorbers', '312', '95.99'),
('14', 'Air Filter', '487', '12.99'),
('15', 'Spark Plugs', '236', '9.99'),
('16', 'Catalytic Converter', '216', '75.99'),
('17', 'Muffler', '532', '36.99'),
('18', 'Tire Pressue Gauge', '698', '8.99'),
('19', 'Alternator', '125', '59.99'),
('20', 'Power Steering Fluid', '243', '6.99');

---------------------------------------------------------------------

INSERT INTO Customer_Cart (`Customer_ID`, `Part_Num`, `Name`, `Amount`, `Price`, `Subtotal`)
VALUES ();

---------------------------------------------------------------------

INSERT INTO Orders (`Order_Num`, `Customer_ID`, `Confirmation_Num`, `Part_Num`, `Date_of_Order`, `Shipping_Num`, `Status_Order`, `Cost`, `Amount`)
VALUES ('44', '57832', '467409', '7', '2022-11-30', '358769', 'Processing', '199.98', '2'),
('51', '98433', '179938', '10', '2022-11-30', '572935', 'Processing', '629.39', '7'),
('77', '21893', '691613', '3', '2022-11-30', '833942', 'Processing', '82.99', '1'),
('85', '82389', '813058', '1', '2022-11-30', '286921', 'Processing', '395.96', '4'),
('88', '18734', '753413', '11', '2022-11-30', '665705', 'Processing', '1299.8', '20');

---------------------------------------------------------------------
