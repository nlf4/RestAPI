# RestAPI

1. Depending on where your project map is regarding htdocs, you will need to change $uri_count in api.php
    
    $uri_count = 3    if your project is in htdocs. And +1 for every submap you use
    
    
2. Depending on how you name everything, you can use these URI's of see them as an example.
    
    
  These can be used in the program postman or in the browser:
  
      View all tasks : http://localhost/Groepswerken/RestAPI/taken
      View 1 task by id : http://localhost/Groepswerken/RestAPI/taak/2
    
    
  These can be used in the program postman
      
      Create a task with POST : http://localhost/Groepswerken/RestAPI/taken
      Update a task with PUT : http://localhost/Groepswerken/RestAPI/taak/9
      Delete a task with DELETE : http://localhost/Groepswerken/RestAPI/taak/9
      
      For the POST and PUT you can fill in raw data. Here you find an example:
          {
            "taa_datum": "2020-03-19",
            "taa_omschr": "Fietsen"
          }
          
NOTE: because of     RewriteRule .* api.php [L]    you won't be able to visit the rest of the site. This is turned on so you can test the API.
    
