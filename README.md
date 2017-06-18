# FatFree Framework - Student Mentorship System

Application based on Fat-Free PHP Framework 3.5 ([https://fatfreeframework.com/3.6/home](https://fatfreeframework.com/3.6/home)) and tFPDF 1.24 ([http://www.fpdf.org/en/script/script92.php](http://www.fpdf.org/en/script/script92.php)) library for PDF generating. Requires PHP >=5.3 and jQuery 2.2.0.

tFPDF is a modified version of FPDF and is chosen because it provides UTF-8 support for Croatian characters.

Project is built on MVC principles and makes use of F3's own db mapping, templating and routing.


## Getting Started

Move all the files into the server root folder (or 'project_name' subfolder), this should work in any subdirectory.
Structure should look like this:

    - app/ - Application code
      -- controllers/ - Controller classes
      -- models/ - Model classes
      -- views/ - Templates for view rendering
      -- config/ - Configuration files
        --- config.ini - Called by index.php, used for setting global variables, classes autoloading, db credentials, etc.
        --- routes.ini - Called by index.php, routes map urls to controller classes and actions.


    - public/
      -- css/
      -- js/

    - src/ - Framework code and libraries
      -- fatfree-master/ - F3 code

    - tfpdf/ - tFPDF code
      -- font/ - Available fonts
      -- tfpdf.php - Main TFPDF class

    - tmp/ - Contains rendered views
    - index.php - Main entrypoint


Any folder changes must be written accordingly in config.ini file because of autoloading!

### Database setup

Create a new empty database and name it mentorship. Import schema from mentorship.sql. Setup your database credentials in config.ini file.

Some test data will be available in database as well as 3 user accounts (one for each role).

### Run it
Finally, in browser, enter the URL like this: ```localhost/project_name/``` and log in. Password is 123.


## Installing

You can get Fat-Free and tFPDF via composer:  

    composer require bcosca/fatfree
    composer require docnet/tfpdf

or simply by downloading the packages from the official sites.

But beware, tFPDF will be installed as a full .git repository(cca 100 MB) and apparently there is no way to get around it so I recommend a manual download to avoid unnecessary files. On the other hand, maybe the regular FPDF will suit your needs better.

In case of this simple setup without many other libraries, there is no need for composer. Manual downloading is a *fat free* way to go. For installation instructions, visit this guide: [https://fatfreeframework.com/3.6/getting-started](https://fatfreeframework.com/3.6/getting-started)

The core of the framework lies in ```src/fatfree-master/lib/base.php``` which you require in index file and that's it. Autoloading of classes, views, global variables, routes, etc. are configured with .ini files.


## Application flow

Upon visiting the project folder, .htaccess directs to index.php that controls the workflow. It requires the F3's base.php class and config.ini file that contains paths to models, views and controllers as well as any other global variables that we wan't to set (like database credentials).

Then, routes.ini file contains our application routes which point to methods in controllers. Routes are named for ease of use and flexibility so we only have to change it once, not every instance of that particular route in every view.

When a url that matches the route is visited, it will call its specified Controller that holds the method for execution. Controllers receive some data from views and call methods inside models that manipulate data from/to database. Everything goes through FF's Base class instance, stored in a variable named f3 throughout the application.

Models are mapped to tables in a construct method. It is important to specify the table name if the model is named differently. However, F3 does not support JOINs.

> It makes your application more complex than it should be, and there's the tendency of objects thru eager or lazy fetching techniques to be deadlocked and even out of sync due to object inheritance and polymorphism (impedance mismatch) with the database entities they're mapped to.

In that case:
>If a table cross-references data from another table frequently, consider normalizing your structures or creating a view instead. Then create a mapper object to auto-map that view. It's faster and requires less effort. Tables joined in a view will appear as a single table, and Fat-Free can auto-map a view just as well as a regular table

F3 controllers provide some nice before route and after route methods in which you can define any repetitive code that you need executed before/after particular controller methods. For example, my controllers inherit from a base Controller class that contains f3 base instance, database instance and a beforeroute() method that checks for session existence.

Finally, controllers will render views. F3 provides its own templating system so after it's been rendered the view file (with template syntax translated to php) will be stored into *tmp* folder on index level. You can also manually specify the folder (visit documentation).

## Issues

* Unable to generate PDF if *tfpdf* folder is not on the index.php level
* Ajax requests not working when using jQuery 3


## Built With


* [Fat-Free Framework](https://fatfreeframework.com/3.6/home) - PHP framework
* [tFPDF](http://www.fpdf.org/en/script/script92.php) - tFPDF library

![alt text](https://raw.githubusercontent.com/F3Community/F3com/master/gui/img/f3intro.png)



## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Conclusion

This is by no means a full working application, it is more a study into the framework's abilities and limits. I am impressed by its posibilities since the whole framework is contained into a single 60 something kb file.

It's a great framework for beginners because of it's ease of use and simplicity, solid sized documentation and numerous examples. IMO it's a perfect choice for smaller projects.

