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
/data/{table_id} | Main logic action which takes every line from API and returns a view based on a current action. By refreshing several times we can watch ongoing game step by step.