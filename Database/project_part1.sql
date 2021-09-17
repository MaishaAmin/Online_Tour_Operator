-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2021 at 08:54 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_part1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `bus_stat` (IN `from_date` DATE, IN `to_date` DATE)  begin
    
		SELECT 
			r.FROM_PLACE,
			r.TO_PLACE,
			b.BUS_NAME,
			sum(br.AMOUNT) as Total_Sale
    
		FROM
			routes r,
			bus_ticket bt,
			bus_goes_routes bgr,
			busreservation br,
			bus b
		where br.BUS_TICKET_ID=bt.BUS_TICKET_ID and bt.BUS_ROUTE_ID=bgr.BUS_ROUTE_ID and bgr.ROUTE_ID=r.ROUTE_ID and bgr.BUS_NAME=b.BUS_NAME and br.Date>=from_date and br.Date<=to_date
		group by r.FROM_PLACE, r.TO_PLACE, b.BUS_NAME;
		
    end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `flight_stat` (IN `from_date` DATE, IN `to_date` DATE)  begin
    
		SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            f.FLIGHT_NAME,
            sum(fr.AMOUNT) as Total_Sale

        FROM
            routes r,
            flight_ticket ft,
            flight_goes_routes fgr,
            flightreservation fr,
            flight f
        where fr.FLIGHT_TICKET_ID=ft.FLIGHT_TICKET_ID and ft.FLIGHT_ROUTE_ID=fgr.FLIGHT_ROUTE_ID and fgr.ROUTE_ID=r.ROUTE_ID and fgr.FLIGHT_NAME=f.FLIGHT_NAME and fr.Date>='from_date' and fr.Date<='to_date'
        group by r.FROM_PLACE, r.TO_PLACE, f.FLIGHT_NAME;
    
    
    end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `train_stat` (IN `from_date` DATE, IN `to_date` DATE)  begin
		SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            t.TRAIN_NAME,
            sum(tr.AMOUNT) as Total_Sale

        FROM
            routes r,
            train_ticket tt,
            train_goes_routes tgr,
            trainreservation tr,
            train t
        where tr.TRAIN_TICKET_ID=tt.TRAIN_TICKET_ID and tt.TRAIN_ROUTE_ID=tgr.TRAIN_ROUTE_ID and tgr.ROUTE_ID=r.ROUTE_ID and tgr.TRAIN_NAME=t.TRAIN_NAME and tr.Date>=from_date and tr.Date<=to_date
        group by r.FROM_PLACE, r.TO_PLACE, t.TRAIN_NAME;
    end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `UserName`, `Password`) VALUES
(2, 'admin', 'f1f4aac98f256da03bf3e24fcbbd6b96');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `BUS_NAME` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`BUS_NAME`) VALUES
(''),
('Eagle Paribahan'),
('Green Line Paribahan'),
('Saint Martin Paribahan');

-- --------------------------------------------------------

--
-- Table structure for table `busreservation`
--

CREATE TABLE `busreservation` (
  `RESERVATION_ID` smallint(4) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `BUS_TICKET_ID` smallint(5) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `AMOUNT` decimal(10,2) DEFAULT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL,
  `TOTAL_PURCHASE` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `busreservation`
--

INSERT INTO `busreservation` (`RESERVATION_ID`, `USER_ID`, `BUS_TICKET_ID`, `Date`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`, `TOTAL_PURCHASE`) VALUES
(1, 3, 7, '2021-09-05 00:00:00', '5000.00', NULL, NULL, NULL),
(2, 3, 3, '2021-09-06 00:00:00', '5000.00', NULL, NULL, NULL),
(3, 3, 3, '2021-10-06 00:00:00', '5000.00', NULL, NULL, NULL),
(4, 3, 7, '2021-10-06 00:00:00', '5000.00', NULL, NULL, NULL),
(5, 3, 3, '2021-09-08 00:00:00', '5000.00', NULL, NULL, NULL),
(6, 7, 3, '2021-09-09 00:00:00', '8000.00', '123465746516', 'BKASH', NULL),
(7, 7, 3, '2021-09-09 00:00:00', '8000.00', '123465746516', 'BKASH', 3),
(8, 7, 3, '2021-09-09 15:13:43', '6000.00', 'SSLCZ_TEST_6139d046e15fe', 'BKASH-BKash', 3),
(9, 9, 3, '2021-09-09 19:56:53', '8000.00', 'SSLCZ_TEST_613a12a4cfe9b', 'BKASH-BKash', 4),
(10, 9, 3, '2021-09-09 20:03:35', '8000.00', 'SSLCZ_TEST_613a1436ce85d', 'BKASH-BKash', 4);

--
-- Triggers `busreservation`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_done` AFTER INSERT ON `busreservation` FOR EACH ROW begin
		update bus_ticket set SEATS = SEATS-new.TOTAL_PURCHASE where BUS_TICKET_ID=new.BUS_TICKET_ID;
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_counter`
--

CREATE TABLE `bus_counter` (
  `COUNTER_ID` mediumint(8) NOT NULL,
  `NAME` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bus_counter`
--

INSERT INTO `bus_counter` (`COUNTER_ID`, `NAME`) VALUES
(1, 'Rajarbagh'),
(2, 'Gabtoli'),
(3, ''),
(4, 'Khulna Bus Counter'),
(5, 'Teknaf Bus Counter'),
(6, 'Malibagh');

-- --------------------------------------------------------

--
-- Table structure for table `bus_goes_routes`
--

CREATE TABLE `bus_goes_routes` (
  `BUS_ROUTE_ID` smallint(5) NOT NULL,
  `ROUTE_ID` smallint(4) NOT NULL,
  `BUS_NAME` varchar(45) NOT NULL,
  `PRICE` mediumint(8) NOT NULL,
  `DEPARTURE_TIME` time NOT NULL,
  `COUNTER_ID` mediumint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bus_goes_routes`
--

INSERT INTO `bus_goes_routes` (`BUS_ROUTE_ID`, `ROUTE_ID`, `BUS_NAME`, `PRICE`, `DEPARTURE_TIME`, `COUNTER_ID`) VALUES
(10, 12, 'Green Line Paribahan', 1700, '11:30:00', 1),
(11, 12, 'Green Line Paribahan', 1700, '12:30:00', 1),
(12, 12, 'Green Line Paribahan', 1700, '09:30:00', 1),
(13, 17, 'Green Line Paribahan', 1000, '00:00:10', 1),
(14, 17, 'Green Line Paribahan', 2000, '19:11:00', 1),
(15, 18, 'Saint Martin Paribahan', 1000, '23:25:00', 2),
(16, 20, 'Eagle Paribahan', 1300, '11:30:00', 4),
(17, 21, 'Saint Martin Paribahan', 2000, '20:00:00', 5),
(18, 5, 'Green Line Paribahan', 1200, '23:30:00', 6),
(19, 12, 'Saint Martin Paribahan', 1000, '20:05:00', 2),
(20, 5, 'Eagle Paribahan', 1299, '20:09:00', 6),
(21, 5, 'Saint Martin Paribahan', 1200, '20:10:00', 1),
(22, 17, 'Saint Martin Paribahan', 800, '20:12:00', 2),
(23, 9, 'Eagle Paribahan', 1300, '19:20:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_ticket`
--

CREATE TABLE `bus_ticket` (
  `BUS_TICKET_ID` smallint(5) NOT NULL,
  `BUS_ROUTE_ID` smallint(5) NOT NULL,
  `SEATS` smallint(8) NOT NULL,
  `DEPARTURE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bus_ticket`
--

INSERT INTO `bus_ticket` (`BUS_TICKET_ID`, `BUS_ROUTE_ID`, `SEATS`, `DEPARTURE_DATE`) VALUES
(3, 14, 12, '2021-09-03'),
(5, 16, 30, '2021-09-05'),
(7, 18, 30, '2021-09-05'),
(9, 20, 30, '2021-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `departure_schedule`
--

CREATE TABLE `departure_schedule` (
  `DEPARTURE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departure_schedule`
--

INSERT INTO `departure_schedule` (`DEPARTURE_DATE`) VALUES
('2021-09-02'),
('2021-09-03'),
('2021-09-05'),
('2021-09-06'),
('2021-09-07'),
('2021-09-08'),
('2021-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `FLIGHT_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`FLIGHT_NAME`) VALUES
('Emirates');

-- --------------------------------------------------------

--
-- Table structure for table `flightreservation`
--

CREATE TABLE `flightreservation` (
  `RESERVATION_ID` smallint(4) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `FLIGHT_TICKET_ID` smallint(5) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `AMOUNT` decimal(10,2) NOT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL,
  `B_CLASS_PURCHASE` smallint(5) DEFAULT 0,
  `E_CLASS_PURCHASE` smallint(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flightreservation`
--

INSERT INTO `flightreservation` (`RESERVATION_ID`, `USER_ID`, `FLIGHT_TICKET_ID`, `Date`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`, `B_CLASS_PURCHASE`, `E_CLASS_PURCHASE`) VALUES
(6, 7, 1, '2021-09-05 00:00:00', '8000.00', '123465746516', 'BKASH', 0, 5),
(7, 7, 1, '2021-09-09 16:36:14', '450000.00', 'SSLCZ_TEST_6139e39e892c7', 'BKASH-BKash', 5, 0),
(8, 9, 1, '2021-09-09 22:43:30', '192000.00', 'SSLCZ_TEST_613a39b235ac6', 'BKASH-BKash', 0, 4);

--
-- Triggers `flightreservation`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_done_flight` AFTER INSERT ON `flightreservation` FOR EACH ROW begin
		if new.B_CLASS_PURCHASE <> 0 then update flight_ticket set B_CLASS_SEATS = B_CLASS_SEATS-new.B_CLASS_PURCHASE where FLIGHT_TICKET_ID=new.FLIGHT_TICKET_ID;
        else update flight_ticket set E_CLASS_SEATS = E_CLASS_SEATS-new.E_CLASS_PURCHASE where FLIGHT_TICKET_ID=new.FLIGHT_TICKET_ID;
        end if;
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `flight_goes_routes`
--

CREATE TABLE `flight_goes_routes` (
  `FLIGHT_ROUTE_ID` smallint(5) NOT NULL,
  `ROUTE_ID` smallint(4) NOT NULL,
  `FLIGHT_NAME` varchar(30) NOT NULL,
  `DEPARTURE_TIME` time NOT NULL,
  `E_CLASS_PRICE` int(11) DEFAULT NULL,
  `B_CLASS_PRICE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flight_goes_routes`
--

INSERT INTO `flight_goes_routes` (`FLIGHT_ROUTE_ID`, `ROUTE_ID`, `FLIGHT_NAME`, `DEPARTURE_TIME`, `E_CLASS_PRICE`, `B_CLASS_PRICE`) VALUES
(1, 22, 'Emirates', '20:30:00', 48000, 90000),
(2, 22, 'Emirates', '20:00:00', 50000, 89999),
(3, 23, 'Emirates', '22:00:00', 50000, 89999);

-- --------------------------------------------------------

--
-- Table structure for table `flight_ticket`
--

CREATE TABLE `flight_ticket` (
  `FLIGHT_TICKET_ID` smallint(5) NOT NULL,
  `FLIGHT_ROUTE_ID` smallint(5) NOT NULL,
  `DEPARTURE_DATE` date NOT NULL,
  `B_CLASS_SEATS` smallint(9) NOT NULL,
  `E_CLASS_SEATS` smallint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flight_ticket`
--

INSERT INTO `flight_ticket` (`FLIGHT_TICKET_ID`, `FLIGHT_ROUTE_ID`, `DEPARTURE_DATE`, `B_CLASS_SEATS`, `E_CLASS_SEATS`) VALUES
(1, 1, '2021-09-05', 345, 491);

-- --------------------------------------------------------

--
-- Table structure for table `guide_reservation`
--

CREATE TABLE `guide_reservation` (
  `RESERVATION_ID` smallint(5) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `PLACE_GUIDE_ID` smallint(5) NOT NULL,
  `DATE` datetime NOT NULL,
  `AMOUNT` decimal(10,2) NOT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guide_reservation`
--

INSERT INTO `guide_reservation` (`RESERVATION_ID`, `USER_ID`, `PLACE_GUIDE_ID`, `DATE`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`) VALUES
(1, 7, 2, '2021-09-05 00:00:00', '2000.00', '123465746516', 'BKASH'),
(2, 7, 2, '2021-09-09 17:44:49', '1000.00', 'SSLCZ_TEST_6139f3b0aa11b', 'BKASH-BKash');

--
-- Triggers `guide_reservation`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_done_guide` AFTER INSERT ON `guide_reservation` FOR EACH ROW begin
		update tourist_place_tour_guide set STATUS = 'NO' where ID=new.PLACE_GUIDE_ID;
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hotelroom`
--

CREATE TABLE `hotelroom` (
  `RoomID` smallint(4) NOT NULL,
  `RoomType` varchar(45) NOT NULL,
  `RoomDescription` mediumtext NOT NULL,
  `RoomPrice` mediumint(5) NOT NULL,
  `Occupancy` smallint(4) NOT NULL,
  `RoomPicture` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hotelroom`
--

INSERT INTO `hotelroom` (`RoomID`, `RoomType`, `RoomDescription`, `RoomPrice`, `Occupancy`, `RoomPicture`) VALUES
(1, 'Single', 'verygood room', 2000, 5, 'img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lonch`
--

CREATE TABLE `lonch` (
  `LONCH_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lonch`
--

INSERT INTO `lonch` (`LONCH_NAME`) VALUES
('MV Awlad');

-- --------------------------------------------------------

--
-- Table structure for table `lonchreservation`
--

CREATE TABLE `lonchreservation` (
  `RESERVATION_ID` smallint(4) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `LONCH_TICKET_ID` smallint(5) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `AMOUNT` decimal(10,2) DEFAULT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL,
  `CABIN_PURCHASE` smallint(5) DEFAULT 0,
  `DECK_PURCHASE` smallint(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lonchreservation`
--

INSERT INTO `lonchreservation` (`RESERVATION_ID`, `USER_ID`, `LONCH_TICKET_ID`, `Date`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`, `CABIN_PURCHASE`, `DECK_PURCHASE`) VALUES
(1, 7, 3, '2021-09-09 00:00:00', '8000.00', '123465746516', 'BKASH', 4, 0),
(2, 7, 3, '2021-09-09 16:18:44', '250.00', 'SSLCZ_TEST_6139df8392101', 'BKASH-BKash', 0, 5),
(3, 9, 3, '2021-09-09 22:45:58', '4000.00', 'SSLCZ_TEST_613a3a4665c13', 'BKASH-BKash', 4, 0);

--
-- Triggers `lonchreservation`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_done_lonch` AFTER INSERT ON `lonchreservation` FOR EACH ROW begin
		if new.CABIN_PURCHASE <> 0 then update lonch_ticket set TOTAL_CABIN = TOTAL_CABIN-new.CABIN_PURCHASE where LONCH_TICKET_ID=new.LONCH_TICKET_ID;
        else update lonch_ticket set TOTAL_DECK = TOTAL_DECK-new.DECK_PURCHASE where LONCH_TICKET_ID=new.LONCH_TICKET_ID;
        end if;
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lonch_goes_routes`
--

CREATE TABLE `lonch_goes_routes` (
  `LONCH_ROUTE_ID` smallint(5) NOT NULL,
  `ROUTE_ID` smallint(4) NOT NULL,
  `LONCH_NAME` varchar(30) NOT NULL,
  `DEPARTURE_TIME` time NOT NULL,
  `CABIN_PRICE` smallint(4) DEFAULT NULL,
  `DECK_PRICE` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lonch_goes_routes`
--

INSERT INTO `lonch_goes_routes` (`LONCH_ROUTE_ID`, `ROUTE_ID`, `LONCH_NAME`, `DEPARTURE_TIME`, `CABIN_PRICE`, `DECK_PRICE`) VALUES
(1, 24, 'MV Awlad', '22:30:00', 1500, 50),
(2, 25, 'MV Awlad', '22:30:00', 1000, 50);

-- --------------------------------------------------------

--
-- Table structure for table `lonch_ticket`
--

CREATE TABLE `lonch_ticket` (
  `LONCH_TICKET_ID` smallint(5) NOT NULL,
  `LONCH_ROUTE_ID` smallint(5) NOT NULL,
  `DEPARTURE_DATE` date NOT NULL,
  `TOTAL_CABIN` smallint(9) NOT NULL,
  `TOTAL_DECK` smallint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lonch_ticket`
--

INSERT INTO `lonch_ticket` (`LONCH_TICKET_ID`, `LONCH_ROUTE_ID`, `DEPARTURE_DATE`, `TOTAL_CABIN`, `TOTAL_DECK`) VALUES
(3, 2, '2021-09-09', 22, 195);

-- --------------------------------------------------------

--
-- Table structure for table `package_reservation`
--

CREATE TABLE `package_reservation` (
  `RESERVATION_ID` smallint(5) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `PACKAGE_ID` smallint(5) NOT NULL,
  `DATE` datetime NOT NULL,
  `AMOUNT` decimal(10,2) NOT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package_reservation`
--

INSERT INTO `package_reservation` (`RESERVATION_ID`, `USER_ID`, `PACKAGE_ID`, `DATE`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`) VALUES
(1, 7, 2, '2021-09-05 00:00:00', '2000.00', '123465746516', 'BKASH'),
(2, 7, 2, '2021-09-09 17:54:07', '2000.00', 'SSLCZ_TEST_6139f5deaef65', 'DBBLMOBILEB-Dbbl Mobile Banking'),
(3, 9, 2, '2021-09-09 22:49:26', '2000.00', 'SSLCZ_TEST_613a3b16936c0', 'BKASH-BKash');

-- --------------------------------------------------------

--
-- Table structure for table `roomallotment`
--

CREATE TABLE `roomallotment` (
  `RoomNumber` smallint(4) NOT NULL,
  `RoomTypeID` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roomreservation`
--

CREATE TABLE `roomreservation` (
  `ReservationID` smallint(5) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `RoomNumber` smallint(4) NOT NULL,
  `CheckIn` date NOT NULL,
  `CheckOut` date NOT NULL,
  `Price` mediumint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `ROUTE_ID` smallint(4) NOT NULL,
  `FROM_PLACE` varchar(45) NOT NULL,
  `TO_PLACE` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`ROUTE_ID`, `FROM_PLACE`, `TO_PLACE`) VALUES
(18, 'Chattogram', 'Dhaka'),
(19, 'Dhaka', ''),
(9, 'Dhaka', 'Chattogram'),
(5, 'Dhaka', 'Coxs Bazar'),
(22, 'Dhaka', 'Dubai'),
(12, 'Dhaka', 'Khulna'),
(14, 'Dhaka', 'Rangamati'),
(13, 'Dhaka', 'Rnagamati'),
(24, 'Dhaka', 'Shariatpur'),
(17, 'Dhaka', 'Sreemangal'),
(11, 'Dhaka', 'Sylhet'),
(23, 'Dubai', 'Dhaka'),
(20, 'Khulna', 'Chattogram'),
(25, 'Shariatpur', 'Dhaka'),
(21, 'Teknaf', 'Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `tourist_place`
--

CREATE TABLE `tourist_place` (
  `PLACE_ID` smallint(5) NOT NULL,
  `PLACE_NAME` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tourist_place`
--

INSERT INTO `tourist_place` (`PLACE_ID`, `PLACE_NAME`) VALUES
(1, 'Bandarban'),
(2, 'Coxs Bazar');

-- --------------------------------------------------------

--
-- Table structure for table `tourist_place_tour_guide`
--

CREATE TABLE `tourist_place_tour_guide` (
  `ID` smallint(5) NOT NULL,
  `GUIDE_ID` smallint(5) NOT NULL,
  `PLACE_ID` smallint(5) NOT NULL,
  `PER_DAY_RENT` smallint(5) NOT NULL,
  `DATE` date NOT NULL,
  `DESCRIPTION` mediumtext NOT NULL,
  `STATUS` enum('YES','NO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tourist_place_tour_guide`
--

INSERT INTO `tourist_place_tour_guide` (`ID`, `GUIDE_ID`, `PLACE_ID`, `PER_DAY_RENT`, `DATE`, `DESCRIPTION`, `STATUS`) VALUES
(2, 2, 1, 1000, '2021-09-08', 'Description Here', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tour_guide`
--

CREATE TABLE `tour_guide` (
  `GUIDE_ID` smallint(5) NOT NULL,
  `GUIDE_NAME` varchar(45) NOT NULL,
  `PHONE` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tour_guide`
--

INSERT INTO `tour_guide` (`GUIDE_ID`, `GUIDE_NAME`, `PHONE`, `EMAIL`) VALUES
(2, 'Shakib Al Hasan', '01317258981', 'shakib@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tour_package`
--

CREATE TABLE `tour_package` (
  `PACKAGE_ID` smallint(5) NOT NULL,
  `PACKAGE_NAME` varchar(45) NOT NULL,
  `PLACE_ID` smallint(5) NOT NULL,
  `DESCRIPTION` mediumtext NOT NULL,
  `PRICE` mediumint(5) NOT NULL,
  `PERSON` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tour_package`
--

INSERT INTO `tour_package` (`PACKAGE_ID`, `PACKAGE_NAME`, `PLACE_ID`, `DESCRIPTION`, `PRICE`, `PERSON`) VALUES
(2, 'Package CXB', 2, 'here is the description', 2000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

CREATE TABLE `train` (
  `TRAIN_NAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`TRAIN_NAME`) VALUES
('sonar bangla'),
('Sonar Bangla Express'),
('Upobon Express');

-- --------------------------------------------------------

--
-- Table structure for table `trainreservation`
--

CREATE TABLE `trainreservation` (
  `RESERVATION_ID` smallint(4) NOT NULL,
  `USER_ID` mediumint(5) NOT NULL,
  `TRAIN_TICKET_ID` smallint(5) NOT NULL,
  `Date` datetime NOT NULL,
  `AMOUNT` mediumint(8) NOT NULL,
  `TRANSACTION_NUMBER` varchar(45) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(45) DEFAULT NULL,
  `F_CLASS_PURCHASE` smallint(5) DEFAULT 0,
  `S_CLASS_PURCHASE` smallint(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trainreservation`
--

INSERT INTO `trainreservation` (`RESERVATION_ID`, `USER_ID`, `TRAIN_TICKET_ID`, `Date`, `AMOUNT`, `TRANSACTION_NUMBER`, `PAYMENT_METHOD`, `F_CLASS_PURCHASE`, `S_CLASS_PURCHASE`) VALUES
(1, 7, 3, '2021-09-09 00:00:00', 8000, '123465746516', 'BKASH', 3, 0),
(2, 7, 3, '2021-09-09 00:00:00', 8000, '123465746516', 'BKASH', 3, 0),
(3, 7, 3, '2021-09-09 00:00:00', 8000, '123465746516', 'BKASH', 0, 3),
(4, 7, 3, '2021-09-09 15:56:06', 4000, 'SSLCZ_TEST_6139da369bcf5', 'BKASH-BKash', 4, 0),
(5, 9, 3, '2021-09-09 22:41:33', 4000, 'SSLCZ_TEST_613a393d34922', 'BKASH-BKash', 4, 0);

--
-- Triggers `trainreservation`
--
DELIMITER $$
CREATE TRIGGER `after_purchase_done_train` AFTER INSERT ON `trainreservation` FOR EACH ROW begin
		if new.F_CLASS_PURCHASE <> 0 then update train_ticket set F_CLASS_SEAT = F_CLASS_SEAT-new.F_CLASS_PURCHASE where TRAIN_TICKET_ID=new.TRAIN_TICKET_ID;
        else update train_ticket set S_CLASS_SEAT = S_CLASS_SEAT-new.S_CLASS_PURCHASE where TRAIN_TICKET_ID=new.TRAIN_TICKET_ID;
        end if;
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `train_goes_routes`
--

CREATE TABLE `train_goes_routes` (
  `TRAIN_ROUTE_ID` smallint(5) NOT NULL,
  `ROUTE_ID` smallint(4) NOT NULL,
  `TRAIN_NAME` varchar(20) NOT NULL,
  `DEPARTURE_TIME` time NOT NULL,
  `F_CLASS_PRICE` mediumint(8) DEFAULT NULL,
  `S_CLASS_PRICE` mediumint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `train_goes_routes`
--

INSERT INTO `train_goes_routes` (`TRAIN_ROUTE_ID`, `ROUTE_ID`, `TRAIN_NAME`, `DEPARTURE_TIME`, `F_CLASS_PRICE`, `S_CLASS_PRICE`) VALUES
(1, 11, 'Upobon Express', '09:30:00', 600, 200),
(2, 9, 'sonar bangla', '07:00:00', 1000, 600),
(3, 18, 'Sonar Bangla Express', '08:00:00', 1000, 600);

-- --------------------------------------------------------

--
-- Table structure for table `train_ticket`
--

CREATE TABLE `train_ticket` (
  `TRAIN_TICKET_ID` smallint(5) NOT NULL,
  `TRAIN_ROUTE_ID` smallint(5) NOT NULL,
  `DEPARTURE_DATE` date NOT NULL,
  `F_CLASS_SEAT` smallint(9) NOT NULL,
  `S_CLASS_SEAT` smallint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `train_ticket`
--

INSERT INTO `train_ticket` (`TRAIN_TICKET_ID`, `TRAIN_ROUTE_ID`, `DEPARTURE_DATE`, `F_CLASS_SEAT`, `S_CLASS_SEAT`) VALUES
(3, 3, '2021-09-07', 385, 297);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `USER_ID` mediumint(5) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FIRST_NAME` varchar(45) NOT NULL,
  `LAST_NAME` varchar(45) NOT NULL,
  `ADDRESS` varchar(45) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `PHONE` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`USER_ID`, `UserName`, `Password`, `FIRST_NAME`, `LAST_NAME`, `ADDRESS`, `EMAIL`, `PHONE`) VALUES
(3, 'shak75', 'f1f4aac98f256da03bf3e24fcbbd6b96', 'Shakib', 'Al Hasan', 'Bashundhara', 'shakib@gmail.com', '01317258981'),
(4, 'mushfq', '245794a1bb77cfba0d137ec74a90aabc', 'Mushfiq', 'Rahim', 'Uttara', 'mushfiq@gmail.com', '01317258982'),
(5, 'omi', '827ccb0eea8a706c4c34a16891f84e7b', 'Farhan', 'Omi', 'House-19, Road - 5/A, Block - C, Bashundhara ', 'omifarhan@gmail.com', '01317258981'),
(6, 'admin', 'f1f4aac98f256da03bf3e24fcbbd6b96', 'Farhan', 'Omi', 'House-19, Road - 5/A, Block - C, Bashundhara ', 'omifarhan@gmail.com', '01317258981'),
(7, 'shakib75', '827ccb0eea8a706c4c34a16891f84e7b', 'Shakib', 'Al Hasan', 'House-19, Road - 5/A, Block - C, Bashundhara ', 'shak.75@gmail.com', '01317258981'),
(8, 'mriad', '6a398cc685361df4b919433703b6b57a', 'Mahmudullah', 'Riad', 'Mirpur', 'mriad@gmail.com', '2316516198'),
(9, 'Fermion75', '827ccb0eea8a706c4c34a16891f84e7b', 'Farhan', 'Omi', 'House-19, Road - 5/A, Block - C, Bashundhara ', 'farhan.omi@northsouth.edu', '01317258981');

--
-- Triggers `userinfo`
--
DELIMITER $$
CREATE TRIGGER `after_user_reg` AFTER INSERT ON `userinfo` FOR EACH ROW begin
		insert into user_login
        values (new.UserName, new.Password);
	end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `UserName` varchar(255) NOT NULL,
  `PassWords` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`UserName`, `PassWords`) VALUES
('admin', 'f1f4aac98f256da03bf3e24fcbbd6b'),
('Fermion75', '827ccb0eea8a706c4c34a16891f84e7b'),
('mriad', '6a398cc685361df4b919433703b6b5'),
('mushfq', '245794a1bb77cfba0d137ec74a90aa'),
('omi', '827ccb0eea8a706c4c34a16891f84e'),
('shakib75', '827ccb0eea8a706c4c34a16891f84e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`BUS_NAME`);

--
-- Indexes for table `busreservation`
--
ALTER TABLE `busreservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_BusReservation_UserInfo1_idx` (`USER_ID`),
  ADD KEY `fk_BusReservation_BUS_TIKCET1_idx` (`BUS_TICKET_ID`);

--
-- Indexes for table `bus_counter`
--
ALTER TABLE `bus_counter`
  ADD PRIMARY KEY (`COUNTER_ID`);

--
-- Indexes for table `bus_goes_routes`
--
ALTER TABLE `bus_goes_routes`
  ADD PRIMARY KEY (`BUS_ROUTE_ID`),
  ADD KEY `fk_Routes_has_BUS_BUS1_idx` (`BUS_NAME`),
  ADD KEY `fk_Routes_has_BUS_Routes_idx` (`ROUTE_ID`),
  ADD KEY `counter_fk_idx` (`COUNTER_ID`);

--
-- Indexes for table `bus_ticket`
--
ALTER TABLE `bus_ticket`
  ADD PRIMARY KEY (`BUS_TICKET_ID`),
  ADD KEY `fk_BUS_GOES_ROUTES_has_DEPARTURE_SCHEDULE_DEPARTURE_SCHEDUL_idx` (`DEPARTURE_DATE`),
  ADD KEY `fk_BUS_TIKCET_BUS_GOES_ROUTES1_idx` (`BUS_ROUTE_ID`);

--
-- Indexes for table `departure_schedule`
--
ALTER TABLE `departure_schedule`
  ADD PRIMARY KEY (`DEPARTURE_DATE`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`FLIGHT_NAME`);

--
-- Indexes for table `flightreservation`
--
ALTER TABLE `flightreservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_BusReservation_UserInfo1_idx` (`USER_ID`),
  ADD KEY `flightreservation_ibfk_2` (`FLIGHT_TICKET_ID`);

--
-- Indexes for table `flight_goes_routes`
--
ALTER TABLE `flight_goes_routes`
  ADD PRIMARY KEY (`FLIGHT_ROUTE_ID`),
  ADD KEY `fk_Routes_has_FLIGHT_FLIGHT1_idx` (`FLIGHT_NAME`),
  ADD KEY `fk_Routes_has_FLIGHT_Routes1_idx` (`ROUTE_ID`);

--
-- Indexes for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  ADD PRIMARY KEY (`FLIGHT_TICKET_ID`),
  ADD KEY `fk_FLIGHT_GOES_ROUTES_has_DEPARTURE_SCHEDULE_DEPARTURE_SCHE_idx` (`DEPARTURE_DATE`),
  ADD KEY `fk_FLIGHT_TICKET_FLIGHT_GOES_ROUTES1_idx` (`FLIGHT_ROUTE_ID`);

--
-- Indexes for table `guide_reservation`
--
ALTER TABLE `guide_reservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_UserInfo_has_TOURIST_PLACE_TOUR_GUIDE_TOURIST_PLACE_TOUR_idx` (`PLACE_GUIDE_ID`),
  ADD KEY `fk_UserInfo_has_TOURIST_PLACE_TOUR_GUIDE_UserInfo1_idx` (`USER_ID`);

--
-- Indexes for table `hotelroom`
--
ALTER TABLE `hotelroom`
  ADD PRIMARY KEY (`RoomID`),
  ADD UNIQUE KEY `RoomType_UNIQUE` (`RoomType`),
  ADD UNIQUE KEY `RoomID_UNIQUE` (`RoomID`);

--
-- Indexes for table `lonch`
--
ALTER TABLE `lonch`
  ADD PRIMARY KEY (`LONCH_NAME`);

--
-- Indexes for table `lonchreservation`
--
ALTER TABLE `lonchreservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_BusReservation_UserInfo1_idx` (`USER_ID`),
  ADD KEY `fk_LonchReservation_LONCH_TICKET1_idx` (`LONCH_TICKET_ID`);

--
-- Indexes for table `lonch_goes_routes`
--
ALTER TABLE `lonch_goes_routes`
  ADD PRIMARY KEY (`LONCH_ROUTE_ID`),
  ADD KEY `fk_Routes_has_LONCH_LONCH1_idx` (`LONCH_NAME`),
  ADD KEY `fk_Routes_has_LONCH_Routes1_idx` (`ROUTE_ID`);

--
-- Indexes for table `lonch_ticket`
--
ALTER TABLE `lonch_ticket`
  ADD PRIMARY KEY (`LONCH_TICKET_ID`),
  ADD KEY `fk_DEPARTURE_SCHEDULE_has_LONCH_GOES_ROUTES_DEPARTURE_SCHED_idx` (`DEPARTURE_DATE`),
  ADD KEY `fk_LONCH_TICKET_LONCH_GOES_ROUTES1_idx` (`LONCH_ROUTE_ID`);

--
-- Indexes for table `package_reservation`
--
ALTER TABLE `package_reservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_UserInfo_has_TOUR_PACKAGE_TOUR_PACKAGE1_idx` (`PACKAGE_ID`),
  ADD KEY `fk_UserInfo_has_TOUR_PACKAGE_UserInfo1_idx` (`USER_ID`);

--
-- Indexes for table `roomallotment`
--
ALTER TABLE `roomallotment`
  ADD PRIMARY KEY (`RoomNumber`),
  ADD KEY `fk_RoomAllotment_HotelRoom1_idx` (`RoomTypeID`);

--
-- Indexes for table `roomreservation`
--
ALTER TABLE `roomreservation`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `fk_RoomReservation_UserInfo1_idx` (`USER_ID`),
  ADD KEY `fk_RoomReservation_RoomAllotment1_idx` (`RoomNumber`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`ROUTE_ID`),
  ADD UNIQUE KEY `unique_index` (`FROM_PLACE`,`TO_PLACE`);

--
-- Indexes for table `tourist_place`
--
ALTER TABLE `tourist_place`
  ADD PRIMARY KEY (`PLACE_ID`);

--
-- Indexes for table `tourist_place_tour_guide`
--
ALTER TABLE `tourist_place_tour_guide`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_TOUR_GUIDE_has_TOURIST_PLACE_TOURIST_PLACE1_idx` (`PLACE_ID`),
  ADD KEY `fk_TOUR_GUIDE_has_TOURIST_PLACE_TOUR_GUIDE1_idx` (`GUIDE_ID`);

--
-- Indexes for table `tour_guide`
--
ALTER TABLE `tour_guide`
  ADD PRIMARY KEY (`GUIDE_ID`);

--
-- Indexes for table `tour_package`
--
ALTER TABLE `tour_package`
  ADD PRIMARY KEY (`PACKAGE_ID`),
  ADD KEY `fk_TOUR_PACKAGE_TOURIST_PLACE1_idx` (`PLACE_ID`);

--
-- Indexes for table `train`
--
ALTER TABLE `train`
  ADD PRIMARY KEY (`TRAIN_NAME`);

--
-- Indexes for table `trainreservation`
--
ALTER TABLE `trainreservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `fk_BusReservation_UserInfo1_idx` (`USER_ID`),
  ADD KEY `fk_TrainReservation_TRAIN_TICKET1_idx` (`TRAIN_TICKET_ID`);

--
-- Indexes for table `train_goes_routes`
--
ALTER TABLE `train_goes_routes`
  ADD PRIMARY KEY (`TRAIN_ROUTE_ID`),
  ADD KEY `fk_Routes_has_TRAIN_TRAIN1_idx` (`TRAIN_NAME`),
  ADD KEY `fk_Routes_has_TRAIN_Routes1_idx` (`ROUTE_ID`);

--
-- Indexes for table `train_ticket`
--
ALTER TABLE `train_ticket`
  ADD PRIMARY KEY (`TRAIN_TICKET_ID`),
  ADD KEY `fk_TRAIN_GOES_ROUTES_has_DEPARTURE_SCHEDULE_DEPARTURE_SCHED_idx` (`DEPARTURE_DATE`),
  ADD KEY `fk_TRAIN_TICKET_TRAIN_GOES_ROUTES1_idx` (`TRAIN_ROUTE_ID`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `UserName_UNIQUE` (`UserName`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `busreservation`
--
ALTER TABLE `busreservation`
  MODIFY `RESERVATION_ID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bus_counter`
--
ALTER TABLE `bus_counter`
  MODIFY `COUNTER_ID` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bus_goes_routes`
--
ALTER TABLE `bus_goes_routes`
  MODIFY `BUS_ROUTE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bus_ticket`
--
ALTER TABLE `bus_ticket`
  MODIFY `BUS_TICKET_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `flightreservation`
--
ALTER TABLE `flightreservation`
  MODIFY `RESERVATION_ID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `flight_goes_routes`
--
ALTER TABLE `flight_goes_routes`
  MODIFY `FLIGHT_ROUTE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  MODIFY `FLIGHT_TICKET_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guide_reservation`
--
ALTER TABLE `guide_reservation`
  MODIFY `RESERVATION_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotelroom`
--
ALTER TABLE `hotelroom`
  MODIFY `RoomID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lonchreservation`
--
ALTER TABLE `lonchreservation`
  MODIFY `RESERVATION_ID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lonch_goes_routes`
--
ALTER TABLE `lonch_goes_routes`
  MODIFY `LONCH_ROUTE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lonch_ticket`
--
ALTER TABLE `lonch_ticket`
  MODIFY `LONCH_TICKET_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package_reservation`
--
ALTER TABLE `package_reservation`
  MODIFY `RESERVATION_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roomreservation`
--
ALTER TABLE `roomreservation`
  MODIFY `ReservationID` smallint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `ROUTE_ID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tourist_place`
--
ALTER TABLE `tourist_place`
  MODIFY `PLACE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tourist_place_tour_guide`
--
ALTER TABLE `tourist_place_tour_guide`
  MODIFY `ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tour_guide`
--
ALTER TABLE `tour_guide`
  MODIFY `GUIDE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tour_package`
--
ALTER TABLE `tour_package`
  MODIFY `PACKAGE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trainreservation`
--
ALTER TABLE `trainreservation`
  MODIFY `RESERVATION_ID` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `train_goes_routes`
--
ALTER TABLE `train_goes_routes`
  MODIFY `TRAIN_ROUTE_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `train_ticket`
--
ALTER TABLE `train_ticket`
  MODIFY `TRAIN_TICKET_ID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `USER_ID` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `busreservation`
--
ALTER TABLE `busreservation`
  ADD CONSTRAINT `busreservation_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `busreservation_ibfk_2` FOREIGN KEY (`BUS_TICKET_ID`) REFERENCES `bus_ticket` (`BUS_TICKET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bus_goes_routes`
--
ALTER TABLE `bus_goes_routes`
  ADD CONSTRAINT `bus_goes_routes_ibfk_1` FOREIGN KEY (`ROUTE_ID`) REFERENCES `routes` (`ROUTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bus_goes_routes_ibfk_2` FOREIGN KEY (`BUS_NAME`) REFERENCES `bus` (`BUS_NAME`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `counter_fk` FOREIGN KEY (`COUNTER_ID`) REFERENCES `bus_counter` (`COUNTER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bus_ticket`
--
ALTER TABLE `bus_ticket`
  ADD CONSTRAINT `bus_ticket_ibfk_1` FOREIGN KEY (`DEPARTURE_DATE`) REFERENCES `departure_schedule` (`DEPARTURE_DATE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bus_ticket_ibfk_2` FOREIGN KEY (`BUS_ROUTE_ID`) REFERENCES `bus_goes_routes` (`BUS_ROUTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flightreservation`
--
ALTER TABLE `flightreservation`
  ADD CONSTRAINT `flightreservation_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `flightreservation_ibfk_2` FOREIGN KEY (`FLIGHT_TICKET_ID`) REFERENCES `flight_ticket` (`FLIGHT_TICKET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `flight_goes_routes`
--
ALTER TABLE `flight_goes_routes`
  ADD CONSTRAINT `flight_goes_routes_ibfk_1` FOREIGN KEY (`ROUTE_ID`) REFERENCES `routes` (`ROUTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flight_goes_routes_ibfk_2` FOREIGN KEY (`FLIGHT_NAME`) REFERENCES `flight` (`FLIGHT_NAME`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  ADD CONSTRAINT `flight_ticket_ibfk_1` FOREIGN KEY (`DEPARTURE_DATE`) REFERENCES `departure_schedule` (`DEPARTURE_DATE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flight_ticket_ibfk_2` FOREIGN KEY (`FLIGHT_ROUTE_ID`) REFERENCES `flight_goes_routes` (`FLIGHT_ROUTE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `guide_reservation`
--
ALTER TABLE `guide_reservation`
  ADD CONSTRAINT `fk_UserInfo_has_TOURIST_PLACE_TOUR_GUIDE_TOURIST_PLACE_TOUR_G1` FOREIGN KEY (`PLACE_GUIDE_ID`) REFERENCES `tourist_place_tour_guide` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UserInfo_has_TOURIST_PLACE_TOUR_GUIDE_UserInfo1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lonchreservation`
--
ALTER TABLE `lonchreservation`
  ADD CONSTRAINT `lonchreservation_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lonchreservation_ibfk_2` FOREIGN KEY (`LONCH_TICKET_ID`) REFERENCES `lonch_ticket` (`LONCH_TICKET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lonch_goes_routes`
--
ALTER TABLE `lonch_goes_routes`
  ADD CONSTRAINT `lonch_goes_routes_ibfk_1` FOREIGN KEY (`ROUTE_ID`) REFERENCES `routes` (`ROUTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lonch_goes_routes_ibfk_2` FOREIGN KEY (`LONCH_NAME`) REFERENCES `lonch` (`LONCH_NAME`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lonch_ticket`
--
ALTER TABLE `lonch_ticket`
  ADD CONSTRAINT `lonch_ticket_ibfk_1` FOREIGN KEY (`DEPARTURE_DATE`) REFERENCES `departure_schedule` (`DEPARTURE_DATE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lonch_ticket_ibfk_2` FOREIGN KEY (`LONCH_ROUTE_ID`) REFERENCES `lonch_goes_routes` (`LONCH_ROUTE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `package_reservation`
--
ALTER TABLE `package_reservation`
  ADD CONSTRAINT `fk_UserInfo_has_TOUR_PACKAGE_TOUR_PACKAGE1` FOREIGN KEY (`PACKAGE_ID`) REFERENCES `tour_package` (`PACKAGE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UserInfo_has_TOUR_PACKAGE_UserInfo1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `roomallotment`
--
ALTER TABLE `roomallotment`
  ADD CONSTRAINT `fk_RoomAllotment_HotelRoom1` FOREIGN KEY (`RoomTypeID`) REFERENCES `hotelroom` (`RoomID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roomreservation`
--
ALTER TABLE `roomreservation`
  ADD CONSTRAINT `fk_RoomReservation_RoomAllotment1` FOREIGN KEY (`RoomNumber`) REFERENCES `roomallotment` (`RoomNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_RoomReservation_UserInfo1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tourist_place_tour_guide`
--
ALTER TABLE `tourist_place_tour_guide`
  ADD CONSTRAINT `fk_TOUR_GUIDE_has_TOURIST_PLACE_TOURIST_PLACE1` FOREIGN KEY (`PLACE_ID`) REFERENCES `tourist_place` (`PLACE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_TOUR_GUIDE_has_TOURIST_PLACE_TOUR_GUIDE1` FOREIGN KEY (`GUIDE_ID`) REFERENCES `tour_guide` (`GUIDE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour_package`
--
ALTER TABLE `tour_package`
  ADD CONSTRAINT `fk_TOUR_PACKAGE_TOURIST_PLACE1` FOREIGN KEY (`PLACE_ID`) REFERENCES `tourist_place` (`PLACE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainreservation`
--
ALTER TABLE `trainreservation`
  ADD CONSTRAINT `trainreservation_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `userinfo` (`USER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainreservation_ibfk_2` FOREIGN KEY (`TRAIN_TICKET_ID`) REFERENCES `train_ticket` (`TRAIN_TICKET_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `train_goes_routes`
--
ALTER TABLE `train_goes_routes`
  ADD CONSTRAINT `train_goes_routes_ibfk_1` FOREIGN KEY (`ROUTE_ID`) REFERENCES `routes` (`ROUTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `train_goes_routes_ibfk_2` FOREIGN KEY (`TRAIN_NAME`) REFERENCES `train` (`TRAIN_NAME`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `train_ticket`
--
ALTER TABLE `train_ticket`
  ADD CONSTRAINT `train_ticket_ibfk_1` FOREIGN KEY (`DEPARTURE_DATE`) REFERENCES `departure_schedule` (`DEPARTURE_DATE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `train_ticket_ibfk_2` FOREIGN KEY (`TRAIN_ROUTE_ID`) REFERENCES `train_goes_routes` (`TRAIN_ROUTE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
