# jOnix Web Application

This project is an application to create, send, read, edit, update ONIX messages. The main aim is to create a tool to utilize the ONIX data model and create valid ONIX messaging for correpondence. The application validates the document as they are typed, so the user can follow how the final resulting ONIX message will look like.

## Underlying tools

jOnix Web is a client side application that uses Angular JS framework. The input and the output of the application are ONIX messages. It is intended to be used togeter with the [jOnix](https://gitlab.mw.metropolia.fi/jonix) backend application but it it can also be used as a standalone application or with different backends.

### Running the app

You can pick one of these options:

* serve this repository with your webserver
* install node.js and run `scripts/web-server.js`

### Running the app in production

All you need in production are all the files under the `app/` directory.
Everything else should be omitted.

Angular apps are really just a bunch of static html, css and js files that just need to be hosted
somewhere, where they can be accessed by browsers.
