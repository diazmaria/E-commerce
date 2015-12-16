## E-commerce Online Shop

### Description
Through this web-based system, users can consult a catalogue of books and CDs, search for products based on a certain type or title and add them to their shopping carts.
Also they can register, edit their personal details, order the products in their shopping carts and access all the orders they have made to date.
The administrator can add new products to the catalogue, edit them and delete them. Handling payment was not required in this prototype.
All the requisites were specified on an assignment for the “Programación Web” (Web Programming) module that I took at university in my second year of studies (2012-2013). 
Two of my classmates participated with me during this project.


### Technology
- **PHP**
- **CodeIgniter** Web Framework, that utilizes the MVC architecture and the Active Record Database Pattern
- HTML, CSS, Bootstrap, SQL, MySQL and Apache HTTP Server


### License
This project is licensed under the [Apache 2 License](http://www.apache.org/licenses/LICENSE-2.0). 


### Run the Web Application Locally
Below there is an explanation of how to run the web app locally using WAMP or XAMPP (you can also separately install and configure Apache and a SGBD if you would prefer).

1. Clone the repository or download the zip file.
2. Place the project folder or extract the zip file into the **htdocs** folder (XAMP) or **www** folder (WAMP).
3. Create a new database and import the **tienda.sql** file attached in the project into it (you can use phpMyAdmin for this duty).
4. Modify your database connection values (username, password and database name) in the file CodeIgniter/application/config/**database.php**.
5. Run XAMPP or WAMP and go to: http://localhost/CodeIgniter


### Demo
<center>
![demo](http://i1030.photobucket.com/albums/y369/MariaPhotoB/shop_zpswkytkike.gif)
</center>