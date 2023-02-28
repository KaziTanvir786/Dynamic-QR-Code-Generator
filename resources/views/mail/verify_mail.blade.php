<!DOCTYPE html>
<head>
  <style>
  .center-text{
    text-align: center;
  }
  .contents{
    width: 40%;
    margin-left: auto;
    margin-right: auto;
  }
  .verification_button{
    background-color: rgb(0, 141, 0);
    color: white !important;
    padding: 10px 15px;
    border-radius: 5px;
    display: grid;
    margin: auto;
    text-align: center;
    width: 60%;
    font-size: 20px;
    text-decoration: none;
  }

  a.link{
    color: white;
  }

  </style>
  </head>
<html lang="en">
    <body>
      <!-- <h1 style="color: red; text-align: center;">{{$code}}</h1>  -->
      <div class="contents">
        <h1 class="center-text">Verify Your Email</h1>
        <p>
          Welcome to Company!
          <br>
          Please click the link below to verify your email address.
          <br>
          If you did not sign up to Company, please ignore this email or contuct us at contact@qrcode.co.ke
          <br><br>
          Web Support Team
          <br><br>
          <a href="{{url('').'/verify-user/'.$email.'/'.$code}}" class="verification_button" target="_blank">Verify Email</a>
        </p>
      </div>
    </body>
</html> 