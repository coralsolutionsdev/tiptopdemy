<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style type="text/css">
      body{
        font-family: Tahoma, Verdana, Segoe, sans-serif;

      }
    
      header{
        padding: 30px;
        font-weight: bold;
        font-size: 58px;
      }
      footer{
        padding: 30px;
      }
      .card{
        padding: 25px;
      }
    </style>
  </head>
  <body class="bg-light ">
    <header>
      <div class="d-flex justify-content-center text-muted">
        <h1>{{getSite()->name}}</h1>
      </div>
    </header>

    <section>
      <div class="container">
          <div class="card border-light">
            <div class="card-body text-center">
              <h4>  
                  <strong>We're glad you're here, {{$user->name}}.</strong>
              </h4>
              <p class="text-center text-muted">One step more! to activate your account click the button below:</p>
                @component('mail::button', ['url' => route('sendverifyemail', ["email"=>$user->email,"verify_token"=>$user->verify_token])])
                Activate Now!
                @endcomponent
            </div>
          </div>
      </div>
    </section>
    <footer>
      <div class="d-flex justify-content-center text-muted">
        <p>Copyright © {{date('Y')}} {{getSite()->name}}, All rights reserved.</p>
      </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>



