<?php 
    session_start();
    if($_SESSION['userType'] !== 'admin'){
        if($_SESSION['userType'] === 'etud'){
            header('Location:./recap.php');
        } else {
            header('Location:./authentification.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/homeAdminPageStyle.css">
    <title>AdminPanel</title>
</head>
<body>

<body>
    <div class="container position-relative p-4 m-4 ">
        <div class= "search-bar d-flex  align-items-center mb-0">
            <div class="input-container flex-grow-1 ">
                <input type="text" name="searchKey" class="search-input js-search-input " placeholder="Search...">
            </div>
            <div class="icon-container" >
                <i class="fa fa-search search-icon" onclick="searchEnter()"></i>
            </div>
        </div>
        <div class="search-result js-search-result container position-relative  mt-1 pt-4 text-light rounded bg-dark opacity-0 ">
            
        </div>
    </div>
   

    <div class="childContainer">
        <button type="button" class="btn btn-danger" onclick="window.location.href='../adminActions.php?action=lister';">Lister tous les Condidats</button>
        <div class="container row ">
            <div class="col"></div>
            <div class="col-sm- text-center"><a href="../adminActions.php?action=logout">se deconnecter</a></div>
            <div class="col"></div>
        </div>
    </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function searchEnter(){
           console.log("Will be done soon...");
        }
    
       $(document).ready(()=>{
        const resultElement = $(".search-result.js-search-result");
        $(".js-search-input").on("keyup", ()=>{
            let dataSearch = $('.js-search-input').val();
            if (dataSearch.trim() === '') {
            resultElement.removeClass("show").html(''); // Hide results if input is empty
            } else {
             $.ajax({
                url : '../adminActions.php?action=search',
               method :'POST',
               data : {user:dataSearch},
               contentType: 'application/x-www-form-urlencoded', // Default for form data
               success: (response) => {
                    console.log(response);
                    if(response.trim() !== ''){
                        resultElement.addClass("show").html(response);
                    }
                    else if (response.trim() == ''){
                        resultElement.addClass("show").html('<p>Cette utilisateur n\'existe pas</p>');
                    }
               },
               error: (jqXHR, textStatus, errorThrown) => {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
            });
       }});


        /*
        $(".js-search-input").on("keydown", () => {
            resultElement.removeClass("show").html('')
        })
            */

       });
       /*
        let searchBtn = document.querySelector('.js-search-input');
        searchBtn.addEventListener("keyup" , ()=>{
            let data = searchBtn.value;
            console.log(data);
        })
            */
    </script>
</body>
</html>