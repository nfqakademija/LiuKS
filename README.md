#LiuKS

###Team members:
* Laurynas Baltrėnas
* Saulius Baltutis

###Mentor:
* Darius Grigalevičius

#Working routes

Route | Functionality
------------ | -------------
/ | All currently logged in user information. Homepage under construction.
/login | Login page. Facebook login and logout buttons.
/users | You can view all users in database. Admins can view single user, edit and delete it.
/tables | You can view all Tables registered in database and navigate to single table page where current game is shown. Logged in users can create table, but it is available only after admin approval. Table owner and admins can edit and delete tables.
/tables/{table_id}/data | An action that takes several events from API and logically processes it. Every time we refresh this page we can see what is happening at that table. Later this route will be used in ajax script to constantly update database with newest data from APIs.