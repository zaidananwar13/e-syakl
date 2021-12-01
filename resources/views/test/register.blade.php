<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Mail Register</title>
</head>
<body>
  <form action="registerPost" method="post">    
  {{ csrf_field() }}

    <input type="mail" name="email" id="email" placeholder="example@mail.com">
    <input type="password" name="password" id="password">
    <input type="password" name="repassword" id="repassword">

    <button type="submit">Okey</button>
  </form>
</body>
</html>