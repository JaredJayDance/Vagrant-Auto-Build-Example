# Automatic Building Net-cafe Booking System

## Description
This application is designed to allow users at a netcafe to create bookings. This is achieved by initializing 3 Virtual Machines (VMs) with the following design. One virtual machine hosts a web server for creating bookings, the second hosts a web server for netcafe staff to execute adminsitrative features such as modify users, add new machines to the store and change their status. The third VM hosts a database server which contains the data about users, machines and bookings.

## Prerequisites/Installation
Before attempting to run this application, ensure you have Vagrant and VirtualBox installed. Then clone this repo to your desired location and follow these steps.

## Usage
In command prompt/git bash, navigate to the directory that you cloned this repo to and run the command 'vagrant up'. This will begin the automatic build. Once this is complete simply navigate to '127.0.0.1:8080/booking.php' to create a booking or navigate to the administrative page.

## Contributing
For anyone wanting to modify this applciation, follow the steps in Prerequisites/Installation and Usage, then make changes as you best see fit. To test your changes, in command prompt/git bash run the command 'vagrant destroy' and then 'vagrant up' to rebuild the application.

## Authors and acknowledgment
Author: Jay Dance

Much of this code was heavily inspired by the work of David Eyers and Pradeesh in their project: https://altitude.otago.ac.nz/cosc349/vagrant-multivm
