#LiuKS

###Team members:
* Laurynas Baltrėnas
* Saulius Baltutis

###Mentor:
* Darius Grigalevičius

#Working routes

Route | Functionality
------------ | -------------
/users | You can view all users in database and navigate to other users pages. These are simple CRUD views generated based on an entity.
/table | You can view all Tables registered in database and do other kind of CRUD stuff with it. All non-default CRUD actions will have a separate description.
/table/{table_id}/data | Main logic action which takes every line from API and returns a view based on a current action. By refreshing several times we can watch ongoing game step by step. Later this route will be used in ajax script to constantly update database with newest data from APIs.