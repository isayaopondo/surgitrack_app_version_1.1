###################
SurgiTrack APP
###################

This repo contains Source Code of the Web Application SurgiTrack built on Codeigniter Framework (PHP), MySQL/MariaDB and jQuery.


*******************
Release Information
*******************

This repo contains in-development code for future releases. The Current repo is pre-release version for QA server.


**************************
Changelog and New Features
**************************


Added Multi-tenancy 

*******************
Server Requirements
*******************

PHP version 7.0 or newer is recommended.

It should work on 5.3.6 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Unzip the package.(Or clone the repository)
Upload the Content folders and files to your server. Normally the index.php file will be at your root.
Open the application/config/config.php file with a text editor and set your base URL. 
If you intend to use a database, open the application/config/database.php file with a text editor and set your database settings.




*********
Current Modules and Methods
*********

-  Patient Module (
        - Create, Search, 
        - Edit/Delete and 
        - Manage Patient Log)
-  Booking Module (named Theatre)
    This module is subdivided into sub module:
       1. Waiting List
            - Add patients to waiting list (Make new booking)
            - Edit booking (Current details)
            - Manage MAP Score
            - Manage Comments and Notes
            - Filter patients by Firms.
       2. Admission list
            - Manage Patient Admission
            - Move Patients back to waiting and to Theatre list
            - Send SMS notification to the Patient
            - Manage Comments and Notes
       3. Theatre list
            - Manage Patient Operation details (Record Operation Notes)
            - Move Patients back to admission and to Operation list
            - Manage Comments and Notes
       4. Patient Coding
            - Manage Consumables used during Operation (For Billing)
            - Manage the procedures done during the operation (For Billing)
            - Submit patient coding report to Finance/Admin (STUB)
       
- Settings Module; This module manages general app settings which include:       
      
        - Departments
        - Firms
        - Theatres
        - Wards/ Admission Locations
        - MAPT List (Managing MAPT criteria per procedure)

        - Locations/Suburbs (Where Patients are coming form)
- Terminologies
		- RPL Codes
		- NAPPI Codes
- User Management Module (Facility ADMIN)
    This module performs the following functions
        - User Registration and Invitation 
        - User Profile Management 