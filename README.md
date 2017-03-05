# csun-comp484-project-3
The third project for COMP 484 (Web Engineering) at CSUN. It's an e-commerce system for a fictitious coffee company.

## Topics Covered

- PHP
- AJAX
- JSON
- Session Handling
- Form Handling and HTTP POST
- Creation of a Shopping Cart
- Database Connectivity with PDO
- Socket.io
- Real-Time Messaging

## Special Installation Instructions

This project requires certain modules from NodeJS (namely `socket.io`) so you'll need to execute the following command:

```npm install```

This will give you all of the dependencies from the `package.json` file.

### Environment Configuration

Copy the `.env.example.php` file to be `.env.php` and fill-out the appropriate values for your environment.

### Document Root

The public functionality is rooted within the `public` directory so that is where you should configure the `DocumentRoot` for Apache when hosting this application.

## Running the Socket Server

In order to run the Socket.io portion of the application you'll need to execute the following command:

```node server.js```

This will create and run a Socket.io server on port 3000. The URL will be `http://localhost:3000/socket-io-coffee` by default.