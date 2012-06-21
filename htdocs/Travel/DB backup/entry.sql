-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2012 at 03:07 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `username` varchar(50) DEFAULT NULL,
  `supervisor` varchar(50) DEFAULT NULL,
  `datefrom` varchar(50) DEFAULT NULL,
  `dateto` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `placefrom` varchar(50) DEFAULT NULL,
  `placeto` varchar(50) DEFAULT NULL,
  `purpose` varchar(50) DEFAULT NULL,
  `cost` varchar(50) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `approval` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `traveltype` varchar(100) DEFAULT 'local',
  `reason` varchar(250) DEFAULT '',
  `fromdate` date NOT NULL COMMENT 'Travel start date',
  `todate` date NOT NULL COMMENT 'Travel end date',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=246 ;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`username`, `supervisor`, `datefrom`, `dateto`, `name`, `placefrom`, `placeto`, `purpose`, `cost`, `comments`, `approval`, `id`, `traveltype`, `reason`, `fromdate`, `todate`) VALUES
('dominic.dsouza@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-06-01', '2011-06-02', 'DOMINIC DSOUZA ', 'Boston', 'Toronto', 'Final presentation to Mold-Masters, travel for sel', '1800', 'Dominic to fly down, David-Gurmeet to drive down.', 'Approved', 186, 'Local', '', '0000-00-00', '0000-00-00'),
('jitender.hooda@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-25', '2011-05-25', 'JITENDER HOODA ', 'San Jose', 'Mexico', 'Andreas customer meeting- for business continuity ', '1000', '', 'Approved', 185, 'International', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-05-23', '2011-05-23', 'ANAND SIVARAMAN ', 'DTW', 'LGA', 'LF meeting to discuss revised SOW and invoicing fo', '600', 'Meeting with Gary Miller to raise invoices for $1 mil for services rendered thru May.', 'Approved', 184, 'Local', '', '0000-00-00', '0000-00-00'),
('muralidaran.vasudevan@itcinfotech.com', 'Gururaj.Kulkarni@ITCINFOTECH.COM', '2011-05-26', '2011-05-26', 'MURALIDARAN VASUDEVAN ', 'NYC', 'Milwaukee, WI', 'BD', '1650', 'Visit to QBE - meeting between Tim Bremer and Prasad Natu.\r\n\r\nAir Tickets: 640.8 + 798.8\r\nEnterprise: 100 (Plus Fuel )\r\nIncidental : On Actuals', 'Approved', 183, 'Local', '', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-18', '2011-05-18', 'RAGHU NAYAR ', 'Houston', 'Aberdeen UK', 'Meeting with GE Managers & Elaine', '2500', 'Air + Local Transport in Aberdeen + Hotel 2 nights + Meals', 'Approved', 182, 'International', 'ok', '0000-00-00', '0000-00-00'),
('dominic.dsouza@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-16', '2011-05-18', 'DOMINIC DSOUZA ', 'Boston', 'Toronto', 'Joint Scoping Workshop for MoldMasters', '1000', 'Flight ~ 600, Hotel ~ 200, Car ~100, Others ~100', 'Approved', 181, 'International', '', '0000-00-00', '0000-00-00'),
('amit.kumar@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-05-15', '2011-05-17', 'AMIT KUMAR ', 'NYC', 'Orlando, FL', 'Sapphire', '1000', 'Expenses for flight, hotel, rental car & meals.', 'Declined', 180, 'Local', 'As the trip was cancelled.', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-30', '2011-06-02', 'ANAND SIVARAMAN ', 'DTW', 'ABERDEEN', 'Meeting with Elaine Ellis and GE managers', '2000', 'Cost includes airfare ($1600) and hotel, meals expenses. Raghu will be joining me for the visit', 'Approved', 179, 'International', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-18', '2011-05-18', 'GURMEET MANN ', 'Detroit', 'Orlando', 'Meeting with Tupperware', '400', '', 'Approved', 178, 'Local', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-11', '2011-05-11', 'GURMEET MANN ', 'DTW', 'Orlando', 'Meeting with Tupperware', '400', '', 'Declined', 177, 'Local', 'Duplicate entry', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-17', '2011-05-20', 'RAGHU NAYAR ', 'HOUSTON', 'Detroit', 'Meeting with 2 Prospects (1) Morgan (Robert) & (2)', '900', 'ticket 400 + Hotel + rental car + meals', 'Approved', 176, 'Local', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-06', '2011-05-06', 'GURMEET MANN ', 'dtw', 'nyc', 'meeting Tom of PTC', '485', '', 'Declined', 175, 'Local', 'Dont think this will be needed. The presentation prep can be coordinated over the phone, and by exchanging ppts. you will be meeting him at Planet PTC', '0000-00-00', '0000-00-00'),
('andrew.cohen@itcinfotech.com', 'Ronojit.Mukherjee@itcinfotech.com', '2011-05-05', '2011-05-05', 'ANDREW COHEN ', 'New York', 'Philadelphia', 'Business Development', '500', 'dinner and meeting with IT director Morgan Lewis law firm', 'Approved', 174, 'Local', 'ok', '0000-00-00', '0000-00-00'),
('deepanjan.roy@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-04', '2011-05-04', 'DEEPANJAN ROY ', 'ewr', 'lhr', 'Business', '1397', '', 'Approved', 173, 'International', '', '0000-00-00', '0000-00-00'),
('deepanjan.roy@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-09', '2011-05-12', 'DEEPANJAN ROY ', 'ewr', 'lhr', 'Business', '1396', '', 'Approved', 172, 'Local', '', '0000-00-00', '0000-00-00'),
('deepanjan.roy@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-04-15', '2011-04-20', 'DEEPANJAN ROY ', 'ewr', 'xna', 'Business', '779', '', 'Declined', 171, 'Local', '', '0000-00-00', '0000-00-00'),
('deepanjan.roy@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-04', '2011-05-04', 'DEEPANJAN ROY ', 'ewr', 'xna', 'Business', '779', '', 'Declined', 170, 'Local', '', '0000-00-00', '0000-00-00'),
('muralidaran.vasudevan@itcinfotech.com', 'Gururaj.Kulkarni@ITCINFOTECH.COM', '2011-05-04', '2011-05-05', 'MURALIDARAN VASUDEVAN ', 'New York', 'Milwaukee, WI', 'Visit to QBE', '800', 'Cost of Air Travel + Hotel + Car Rental + Incidental\r\nAir tickets for Murali and Raj: USD 229.3 / person , Hotel: USD 131/room\r\nCar: TBD', 'Approved', 169, 'Local', '', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-05-02', '2011-05-02', 'KATHY BENSON ', '', '', '', '300', 'Renting conference room at Holiday Inn to prepare for AA meeting', 'Approved', 168, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-04-30', '2011-04-30', 'ANAND SIVARAMAN ', 'DTW', 'MCO (Orlando)', 'Attend Sapphire', '500', '', 'Approved', 167, 'Local', '', '0000-00-00', '0000-00-00'),
('cmcgloin@pyxisolutions.com', 'Gururaj.Kulkarni@ITCINFOTECH.COM', '2011-04-28', '2011-04-28', 'CMCGLOIN@PYXISOLUTIONS ', 'Paramus, NJ', 'Atlanta, GA', 'Sales call and presentation of solution', '900', '', 'Approved', 166, 'Local', '', '0000-00-00', '0000-00-00'),
('taniya.baveja@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-16', '2011-05-23', 'TANIYA BAVEJA ', 'San Jose', 'Bangalore', 'HR conference', '1500', 'Tickets will be issued by Travel In style once approved. ', 'Approved', 165, 'International', '', '0000-00-00', '0000-00-00'),
('bharath.kirumakki@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-08', '2011-05-14', 'BHARATH KIRUMAKKI ', 'San Francisco', 'Bangalore', 'Client Visit Apollo', '2000', '', 'Approved', 164, 'International', '', '0000-00-00', '0000-00-00'),
('gururaj.kulkarni@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-05-04', '2011-05-05', 'GURURAJ KULKARNI ', 'New Jersey', 'Madison, WI', 'Meeting with QBE', '500', 'Meeting with Tim regarding existing proposal and new initiatives', 'Approved', 163, 'Local', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-04', '2011-05-05', 'GURMEET MANN ', 'DTW', 'Windsor Locks', 'Meeting Stanadyne', '700', '', 'Approved', 162, 'Local', '', '0000-00-00', '0000-00-00'),
('amit.kumar@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-04-25', '2011-04-26', 'AMIT KUMAR ', 'NYC', 'Detroit', 'SME meeting', '900', 'Estimated expenses for flight, hotel, taxi & meals.', 'Approved', 161, 'Local', 'ok', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-23', '2011-06-04', 'KATHY BENSON ', 'dfw', 'blr', 'WestJet on-site', '2000', 'Tickets anticipated to be around $1600', 'Approved', 160, 'International', '', '0000-00-00', '0000-00-00'),
('bawick.bhan@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-04-20', '2011-04-20', 'BAWICK BHAN ', 'Detroit', 'Delhi /Bangalore', 'Visa Stamping / Campus visit', '2000', '', 'Approved', 159, 'International', '', '0000-00-00', '0000-00-00'),
('andrew.cohen@itcinfotech.com', 'Ronojit.Mukherjee@itcinfotech.com', '2011-04-18', '2011-04-20', 'ANDREW COHEN ', 'New York, New Yrok', 'Newport Beach, California', 'Business development at Pacific Life Insurance', '2000', 'Business development at Pacific Life and other California accounts.', 'Approved', 158, 'Local', 'ok', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-04-14', '2011-04-14', 'ANAND SIVARAMAN ', 'Detroit', 'NYC/ Paramus', 'Sales Heads Review with Bala on Verticals/ Account', '500', '', 'Approved', 157, 'Local', 'approved', '0000-00-00', '0000-00-00'),
('ronojit.mukherjee@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-04-14', '2011-04-14', 'RONOJIT MUKHERJEE ', '04/25/2011', '05/13/2011', 'Several Customer Visits', '2500', 'Several visits are lined up = \r\nAquent - 27th\r\nCISCO - 29th\r\nGalaxy - 3/4/5\r\nApollo - 10/11', 'Approved', 156, 'International', 'approved', '0000-00-00', '0000-00-00'),
('bharath.kirumakki@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-04-20', '2011-04-20', 'BHARATH KIRUMAKKI ', 'San Jose', 'Phoenix', 'Apollo & Wyndham visit', '500', '', 'Approved', 155, 'Local', '', '0000-00-00', '0000-00-00'),
('bharath.kirumakki@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-04-07', '2011-04-08', 'BHARATH KIRUMAKKI ', 'San Jose', 'Peoria, IL', 'Apollo Service Desk Visit', '1500', '', 'Approved', 154, 'Local', '', '0000-00-00', '0000-00-00'),
('muralidaran.vasudevan@itcinfotech.com', 'Gururaj.Kulkarni@ITCINFOTECH.COM', '2011-04-18', '2011-04-19', 'MURALIDARAN VASUDEVAN ', 'NYC', 'Newport Beach, CA', 'New BD', '1000', 'Travel + Hotel + Incidental (food/cab)\r\n\r\nAirfare: 617.8\r\nHotel: USD 140 (approx)\r\n\r\nFood / Cab\r\n\r\nVisit to Pacific Life.', 'Approved', 153, 'Local', '', '0000-00-00', '0000-00-00'),
('randeep.mathiladath@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-05-05', '2011-05-13', 'RANDEEP MATHILADATH ', 'houston ', 'bangalore', 'ally visit', '2500', 'Joining client during calcutta and Bangalore visit', 'Approved', 152, 'International', 'OK for the visit. Please liaise with Taniya; she will route your booking thru our travel agent to get a good rate for the travel and keep it to within usd 2000.', '0000-00-00', '0000-00-00'),
('randeep.mathiladath@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-04-18', '2011-04-21', 'RANDEEP MATHILADATH ', 'houston/atlanta', 'detroit', 'thompson/Ally', '1500', 'Trip is to meet with Thompson, Coke and Ally', 'Approved', 151, 'Local', '', '0000-00-00', '0000-00-00'),
('satish.girirajan@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-03-30', '2011-03-30', 'SATISH GIRIRAJAN ', 'Paramus', 'Baltimore', 'Columbia Association - Review of Outstandings', '250', 'Sir, request your approval to travel to Baltimore to meet representatives from CA to discuss outstanding receivables.', 'Approved', 139, 'Local', 'approved', '0000-00-00', '0000-00-00'),
('dena.kopczynski@itcinfotech.com', 'Anand.Sivaraman@itcinfotech.com', '2011-04-17', '2011-04-21', 'DENA KOPCZYNSKI ', 'Spokane, Wa', 'Phoenix, AZ', 'EskoWorld 2011', '1000', 'Cost for airfare, 4 night hotel, est. of misc items', 'Approved', 150, 'Local', '', '0000-00-00', '0000-00-00'),
('saravanan.raman@itcinfotech.com', 'satish.girirajan@itcinfotech.com', '2011-03-31', '2011-03-31', 'SARAVANAN RAMAN ', 'Paramus', 'New York', 'Pyxis Infrastructure Set-Up', '25', 'This is only a test message for demo', 'Declined', 140, 'Local', 'this is only a test message for demo', '0000-00-00', '0000-00-00'),
('saravanan.raman@itcinfotech.com', 'satish.girirajan@itcinfotech.com', '2011-04-01', '2011-04-01', 'SARAVANAN RAMAN ', 'nyc', 'sfo', 'test', '100', 'Testing from phone.pls let me know if you received the email', 'WIP', 141, 'Local', '', '0000-00-00', '0000-00-00'),
('randeep.mathiladath@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-04-11', '2011-04-13', 'RANDEEP MATHILADATH ', 'houston', 'atlanta/detroit', 'business/new project', '1400', 'Have to be in coke for the meeting SAP acct leadership and next steps on assessment we are doing next weekk. Need to be detroit for kick off of FPA project and meetign with Dan on a new SOW. ', 'Approved', 142, 'Local', '', '0000-00-00', '0000-00-00'),
('', '', '2011-04-11', '2011-04-13', 'RANDEEP MATHILADATH ', 'houston', 'atlanta/detroit', 'business/new project', '1400', 'Have to be in coke for the meeting SAP acct leadership and next steps on assessment we are doing next weekk. Need to be detroit for kick off of FPA project and meetign with Dan on a new SOW. ', 'WIP', 143, 'Local', '', '0000-00-00', '0000-00-00'),
('saravanan.raman@itcinfotech.com', 'satish.girirajan@itcinfotech.com', '2011-04-05', '2011-04-07', 'SARAVANAN RAMAN ', 'NYC', 'LA', 'Test', '100', 'Testttt', 'WIP', 144, 'Local', '', '0000-00-00', '0000-00-00'),
('amit.kumar@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-04-12', '2011-04-14', 'AMIT KUMAR ', 'New York', 'Las Vegas', 'Conference', '1800', 'NAB expenses for conference pass, flight, hotel, car, meals etc.', 'Approved', 145, 'Local', 'ok', '0000-00-00', '0000-00-00'),
('gururaj.kulkarni@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-04-12', '2011-04-12', 'GURURAJ KULKARNI ', 'New Jersey', 'Delaware', 'Blackrock visit', '150', 'Meeting with Christine and Clarke of Blackrock', 'Approved', 146, 'Local', 'approved', '0000-00-00', '0000-00-00'),
('andrew.cohen@itcinfotech.com', 'Ronojit.Mukherjee@itcinfotech.com', '2011-04-06', '2011-04-06', 'ANDREW COHEN ', 'New York', 'Peoria Illinois', 'Business development at Apollo', '1500', '', 'Approved', 147, 'Local', '', '0000-00-00', '0000-00-00'),
('bawick.bhan@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-04-08', '2011-04-08', 'BAWICK BHAN ', 'Detroit', 'New Jersey ', 'Business Meeting', '1000', 'Meeting at Charming Shoppes along with K S Bharath', 'Approved', 148, 'Local', '', '0000-00-00', '0000-00-00'),
('jitender.hooda@itcinfotech.com', 'Anand.Sivaraman@itcinfotech.com', '2011-04-14', '2011-04-15', 'JITENDER HOODA ', 'san jose', 'seattle', 'business development', '700', 'seattle accounts meeting with Ron Coleman', 'Approved', 149, 'Local', '', '0000-00-00', '0000-00-00'),
('dominic.dsouza@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-05-26', '2011-05-26', 'DOMINIC DSOUZA ', 'Boston', 'Las Vegas', 'PlanetPTC', '1600', 'Friday-Wednesday', 'Approved', 187, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-05-26', '2011-05-26', 'ANAND SIVARAMAN ', 'DTW', 'BOS-LAS-DTW', 'PTC contract discussions in BOS and PlanetPTC  in ', '650', '', 'Approved', 188, 'Local', '', '0000-00-00', '0000-00-00'),
('amit.kumar@itcinfotech.com', 'Ronojit.Mukherjee@ITCINFOTECH.COM', '2011-06-05', '2011-06-06', 'AMIT KUMAR ', 'NYC', 'Tampa, FL', 'Thompson visit', '700', 'Expense estimate for flight, hotel, car, meals & miscellaneous.', 'Approved', 189, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-06-07', '2011-06-08', 'ANAND SIVARAMAN ', 'DTW', 'Bentonville', 'FlexPLM Findings ppt to WM', '1150', 'Presentation of our review/ findings of the the FlexPLM documentations shared with us by WM of their current roadmap with Accenture. Dominic/ Ravi Anand will be joining. This is to make strong push for ITC to be cunsidered for Phase 2.\r\nTicket prices to X', 'WIP', 190, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-06-14', '2011-06-14', 'ANAND SIVARAMAN ', 'LAS', 'IAH', 'Meetings in Houston after PlanetPTC', '160', '', 'WIP', 191, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-06-06', '2011-06-06', 'ANAND SIVARAMAN ', 'GRR ', 'LGA - DTW', 'In GRR for SC meeting and travelling to NYC for LF', '580', '', 'WIP', 192, 'Local', '', '0000-00-00', '0000-00-00'),
('jitender.hooda@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-06-15', '2011-06-16', 'JITENDER HOODA ', 'Las Vegas', 'Guanajuato ,Mexico', 'Andrea Visit', '900', 'visiting Andrea for business development activities', 'WIP', 193, 'International', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-06-16', '2011-06-16', 'GURMEET MANN ', 'Detroit', 'Hartford and Buffalo', 'Sales call', '1600', '', 'Approved', 194, 'Local', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-06-16', '2011-06-16', 'GURMEET MANN ', 'DTW', 'Las Vegas', 'Planet PTC', '3500', '', 'Approved', 195, 'Local', '', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-07-06', '2011-07-07', 'RAGHU NAYAR ', 'IAH Houston', 'N. Carolina', 'Meeting with ABB', '', '$850/- Air + Hotel 1 night + cab + food', 'Approved', 196, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-06-27', '2011-07-04', 'ANAND SIVARAMAN ', 'dtw', 'delhi', 'Aricent Corporate rollout meeting and client relat', '2000', 'Airfares, hotels, etc', 'WIP', 197, 'International', '', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-06-29', '2011-06-29', 'KATHY BENSON ', 'dfw', 'tpa', 'Meeting with Thompson Media', '550', '', 'WIP', 198, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-07-07', '2011-07-07', 'ANAND SIVARAMAN ', 'DTW', 'Seattle', 'Moldmasters, Tommy Bahamas, Flextronics meetings', '1500', 'Airfare and hotel for visits to Moldmasters, Tommy Bahamas, Flextronics and PTC West Region VP ', 'WIP', 199, 'Local', '', '0000-00-00', '0000-00-00'),
('gururaj.kulkarni@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-07-11', '2011-07-11', 'GURURAJ KULKARNI ', 'New Jersey', 'Alabama', 'Meeting -- Max Bank and Jackson Hospital', '950', '', 'WIP', 200, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-07-20', '2011-07-22', 'ANAND SIVARAMAN ', 'DTW', 'LGA', 'Meeting with LF, Aricent', '600', 'airfare and hotel', 'WIP', 201, 'Local', '', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-11-28', '2011-11-30', 'KATHY BENSON ', 'DFW', 'FLL', 'Loyalty conference', '1600', 'Airline Information FFP Conference Price includes airfare, conference fees, hotel and taxi.  Oracle will be there as well.', 'WIP', 202, 'Local', '', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-08-09', '2011-08-12', 'KATHY BENSON ', 'dfw', 'yyc', 'Meetings at WestJet', '1000', '', 'WIP', 203, 'Local', '', '0000-00-00', '0000-00-00'),
('kathy.benson@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-07-26', '2011-07-26', 'KATHY BENSON ', 'DFW', 'SFO', 'Oracle Open World', '1250', '', 'WIP', 204, 'Local', '', '0000-00-00', '0000-00-00'),
('muralidaran.vasudevan@itcinfotech.com', 'Gururaj.Kulkarni@ITCINFOTECH.COM', '2011-08-09', '2011-08-10', 'MURALIDARAN VASUDEVAN ', 'NYC', 'Madison', 'BD', '750', 'Visit to QBE - Meeting with Tim Bremer', 'Approved', 205, 'Local', '', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2011-08-03', '2011-08-03', 'RAGHU NAYAR ', 'Houston TX', 'Dallas TX', 'Meeting with CMC (Vivek Rao)', '575', 'Airticket $400 + mileage + Airport Parking + rental car + gas in Dallas', 'Approved', 206, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-08-09', '2011-08-10', 'ANAND SIVARAMAN ', 'DTW', 'BOS', 'Review mtg with TJX, PTC mtgs', '800', 'Airfare, hotel', 'WIP', 207, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2011-08-15', '2011-08-16', 'ANAND SIVARAMAN ', 'DTW', 'Houston', 'Meeting with Halliburton and GE', '700', 'Airfare, hotel', 'WIP', 208, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-09-10', '2011-09-13', 'ANAND SIVARAMAN ', 'DTW', 'Nailsea (Bristol)', 'GE UK visit', '1500', 'Meeting with Elaine and Bristol stake-owners. Travel by Raghu and Andy', 'WIP', 209, 'International', '', '0000-00-00', '0000-00-00'),
('jitender.hooda@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-08-22', '2011-08-22', 'JITENDER HOODA ', 'san jose', 'leon mexico', 'Andrea- BD actvities', '1200', 'Project extension and customer relationship', 'WIP', 210, 'International', '', '0000-00-00', '0000-00-00'),
('b.arunnair@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2011-12-30', '2011-12-30', 'B ARUNNAIR ', 'Newyork', 'Bangalore', 'Test', '1000', 'Test', 'WIP', 211, 'International', '', '0000-00-00', '0000-00-00'),
('b.arunnair@itcinfotech.com', 'Satish.girirajan@itcinfotech.com', '2012-01-04', '2012-12-12', 'b.arunnair@itcinfotech.com', 'Nykr', 'Boston', 'Test', '1000', 'Test', 'WIP', 212, 'Local', '', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2012-02-04', '2012-02-04', 'RAGHU NAYAR ', 'Houston', 'Aberdeen', 'Meeting with GE UK', '2500', '1500 Ticket / Cab Fares 300 / Food 500 (including Team diner) / Hotel in abeerdeen (2 nights)', 'WIP', 213, 'International', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2012-02-06', '2012-02-10', 'ANAND SIVARAMAN ', 'Detroit', 'Boston (PTC) and Charlotte(Ally)', 'Dinner meeting with PTC Leaders; Meeting with Todd', '1440', 'DTW-BOS-CLT-DTW', 'WIP', 214, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2012-02-12', '2012-02-16', 'ANAND SIVARAMAN ', 'DTW', 'ABERDEEN; MONTROSSE', 'Meetings with GE O&G, UK', '1774', 'Reviews with Elaine and Engineering Leaders', 'WIP', 215, 'International', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2012-02-27', '2012-02-29', 'GURMEET MANN ', 'DTW', 'Hartford', 'meeting Carrier and Stanadyne', '900', '', 'Approved', 216, 'Local', '', '0000-00-00', '0000-00-00'),
('gurmeet.mann@itcinfotech.com', 'Anand.Sivaraman@ITCINFOTECH.COM', '2012-03-12', '2012-03-13', 'GURMEET MANN ', 'DTW', 'Miami', 'meeting BE Aerospace', '900', '', 'Approved', 217, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2012-02-26', '2012-02-27', 'ANAND SIVARAMAN ', 'Detroit', 'Denver', 'Steering Committee mtg at Cabelas', '500', '', 'WIP', 218, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2012-02-27', '2012-02-28', 'ANAND SIVARAMAN ', 'Denver', 'Dallas/ Detroit', 'Meeting with Lineage Power (now part of GE Energy)', '350', '', 'WIP', 219, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2012-03-07', '2012-03-07', 'ANAND SIVARAMAN ', 'DTW', 'LGA', 'LF meeting', '310', '', 'WIP', 220, 'Local', '', '0000-00-00', '0000-00-00'),
('anand.sivaraman@itcinfotech.com', 'LN.Balaji@ITCINFOTECH.COM', '2012-03-07', '2012-03-07', 'ANAND SIVARAMAN ', 'DTW', 'LGA', 'LF meeting', '310', '', 'WIP', 221, 'Local', '', '0000-00-00', '0000-00-00'),
('b.arunnair@itcinfotech.com', 'Satish.girirajan@itcinfotech.com', '2012-04-03', '2012-04-03', 'B ARUNNAIR ', 'JFK', 'Newark', 'Official', '200', '', 'WIP', 222, 'Local', '', '0000-00-00', '0000-00-00'),
('raghu.nayar@itcinfotech.com', 'ln.balaji@itcinfotech.com', '2012-04-28', '2012-04-28', 'RAGHU NAYAR ', 'HOuston ', 'Bangalore ', 'GE onsite visit', '2000', 'Air Ticket + boarding and lodging.', 'WIP', 223, 'International', '', '0000-00-00', '0000-00-00'),
('manojkumar.muralidharan@itcinfotech.com', 'sayali.jawdekar@itcinfotech.com', '2012-05-15', '2012-05-15', 'MANOJ WOLFPACK@GMAIL ', 'jfk', 'phx', 'test travel', '400', 'test travel', 'On Hold', 224, 'Local', '', '0000-00-00', '0000-00-00'),
('manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '2012-05-16', '2012-05-16', 'MANOJ WOLFPACK@GMAIL ', 'JFK', 'BUF', 'Client Visit', '1000', 'test', 'Approved', 225, 'Local', 'approved.', '0000-00-00', '0000-00-00'),
('manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '2012/05/15', '2012/05/17', 'MANOJ WOLFPACK@GMAIL.com', 'jfk1', 'phx1a', 'purpose1', '120', 'new reason', 'WIP', 226, 'Local', 'new reason', '0000-00-00', '0000-00-00'),
('manoj.wolfpack@gmail.com', 'manoj.wolfpack@gmail.com', '05/16/2003', '05/19/2003', NULL, 'source', 'dest', 'purpose', '150', 'Test comment for reports', 'WIP', 228, 'local', 'comments', '0000-00-00', '0000-00-00'),
('manoj.wolfpack@gmail.com', 'manoj.wolfpack@gmail.com', '05/16/2003', '05/19/2003', NULL, 'source', 'dest', 'purpose', '150', 'Checking Declined', 'WIP', 229, 'local', 'reason', '0000-00-00', '0000-00-00'),
('Manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '05/13/2012', '05/20/2012', NULL, 'JFK', 'Buffalow', 'Client Visit', '1500', 'Testing ', 'WIP', 235, 'local', 'Testing ', '0000-00-00', '0000-00-00'),
('Manoj.wolfpack@gmail.com', 'Manoj.wolfpack@gmail.com', '05/16/2012', '05/22/2012', '', 'a', 'a', 'purpose', '150', 'On Hold', 'WIP', 231, 'local', 'comment', '0000-00-00', '0000-00-00'),
('Manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '05/16/2012', '05/22/2012', NULL, 'a22', 'a', 'purpose', '150', 'comment232', 'WIP', 232, 'local', 'comment232', '0000-00-00', '0000-00-00'),
('Manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '05/14/2012', '05/28/2012', NULL, 'boston', 'NYC', 'Test', '1500', 'client Visit', 'WIP', 236, 'local', 'client Visit', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '06/14/2003', '06/20/2003', NULL, 'JFk', 'JFK', 'ad', '1500', 'Ad', 'WIP', 237, 'local', 'sddsfsdf', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/07/2003', '05/15/2003', NULL, 'asd', 'asd', 'asd', '123123', NULL, 'WIP', 238, 'local', 'asdasd', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/07/2012', '05/15/2012', NULL, 'asd', 'asd', 'asdq', '123123', NULL, 'WIP', 239, 'local', 'asdasdasd', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/06/2012', '05/20/2012', NULL, 'asd', 'qwe', 'qwewqe', '1234', NULL, 'WIP', 240, 'local', 'sadasd', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/06/2012', '05/20/2012', NULL, 'asda', 'qwea', 'qwewqe', '1234', NULL, 'WIP', 241, 'local', 'sadasd', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/06/2012', '05/27/2012', NULL, 'asd', 'dsa', 'asdsdsf', '123', NULL, 'WIP', 242, 'local', 'asdsad', '0000-00-00', '0000-00-00'),
('Manoj1', 'manoj.wolfpack@gmail.com', '05/14/2012', '05/29/2012', NULL, 'asd', 'asddgf', 'sadasd', '12222', NULL, 'WIP', 243, 'local', 'asd', '0000-00-00', '0000-00-00'),
('Manoj.wolfpack@gmail.com', 'sayali.jawdekar@itcinfotech.com', '05/14/2012', '05/30/2012', NULL, 'ssda', 'sadas', 'asdasd', '11222', NULL, 'WIP', 244, 'local', 'asdasd', '0000-00-00', '0000-00-00'),
('manoj.wolfpack@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 245, 'local', '', '0000-00-00', '0000-00-00');
