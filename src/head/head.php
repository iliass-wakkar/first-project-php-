<?php
session_start();
?>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      
      .img_bg {
    /* Ensure the background covers the entire viewport */
    width: 100vw;
    height: 100vh;
    position: relative;
    top: 0;
    left: 0;
    background-size: cover;
    background-image: url('background.jpg');
    /* Center the background vertically and horizontally */
    background-position: center;
    /* Ensure the background doesn't repeat */
    background-repeat: no-repeat;
}
.cost_icon {
    position: relative;
    top: 68%;
    left: 48%;
    z-index: 1000; /* Adjust the z-index as needed */
}
        .content-container {
            position: relative;
            z-index: 1; /* Ensure content appears above the background image */
            padding-top: 100vh; /* Add padding to push content below the background image */
        }
        .cost_btn {
      position: relative;
      top: 70%; /* Adjust top position */
      left: 20%; /* Adjust left position */
    }
    .cost_txt {
      position: relative;
      top: 60%; /* Adjust top position */
      left: 2%; /* Adjust left position */
    }
    .cost_icon {
      position: relative;
      top: 68%; /* Adjust top position */
      left: 48%;
      z-index: 100; /* Adjust left position */
    }
    .cost_logo {
      position: relative;
      top: 60%; /* Adjust top position */
      left: 23%; /* Adjust left position */
    }
    .logo{
      width: 112px;
      height: 112px;
    }
    body {
    overflow-x: hidden;
    }
    .prod_fdiv {
    width: 16.66%; /* Sets the width of each gallery item */
    margin-bottom: 24px; /* Adds margin at the bottom of each gallery item */
    padding: 0 8px; /* Adds padding to each gallery item */
}

/* Media queries for responsiveness */
@media screen and (max-width: 1700px) {
    .prod_fdiv {
        width: 15%; /* Adjusts the width of gallery items for screens up to 1700px width */
    }
}

@media screen and (max-width: 1500px) {
    .prod_fdiv {
        width: 20%; /* Adjusts the width of gallery items for screens up to 1500px width */
    }
}

@media screen and (max-width: 1300px) {
    .prod_fdiv {
        width: 33.33%; /* Adjusts the width of gallery items for screens up to 1300px width */
    }
}
.div_cont{
  
}
.center-div {
      width: 90%;
      margin: 50px auto 0; /* top margin: 50px, center horizontally */
      background-color: #f0f0f0; /* Light gray background color */
      padding: 20px; /* Padding around content */
      border-radius: 10px; /* Rounded corners */
    }
.pad{
    padding-top: 2%;
}
    .old-price {
      text-decoration: line-through;
    }
    .prod_div{
      width: 80%;
      
    }
    @media screen and (max-width: 1700px) {
    .img_size {
        height: 40%; /* Adjusts the height of images for screens up to 1700px width */
    }
}

@media screen and (max-width: 1500px) {
    .img_size {
        height: 45%; /* Adjusts the height of images for screens up to 1500px width */
    }
}

@media screen and (max-width: 1300px) {
    .img_size {
        height: 50%; /* Adjusts the height of images for screens up to 1300px width */
    }
}
.input-group-btn {
    display: flex;
    align-items: center;
    text-align: center;
}
    /* Hide the default number input arrows */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        /* Firefox */
        -moz-appearance: textfield;
    }

    
    </style>
</head>