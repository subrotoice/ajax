<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Vocabulary BCS</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    body {
      font-family: "Times New Roman", Times, serif;
      font-size: 18px;
    }
    p {
      font-size: 18px;
    }
    img {
      width: 100%;
    }
    .row {
        border-bottom: 1px solid #ddd;
        height: 302px;
        max-height: 302px;
        overflow: hidden;
    }
    img {
        width: auto;
        max-width: 100%;
        height: 100%;
    }
    .b-r {
      border-right: 1px dashed #eee;
    }
    .voca .row:nth-child(5n+0) {
      border-bottom: none;
    }
    .col-4, .col-2, .col-3 {
      height: 302px;
      max-height: 302px;
    }
    ul {
      padding: 0;
      margin: 0;
      list-style: none;
      height: 100%;
    }
    li {
      height: 49.99999%;
    }
    li:first-child {
      border-bottom: 1px dashed #eee;
    }
    .word-img {
    position: relative;
    color: white;
    height: 100%;
    text-align: right;
}
    .sentence {
    position: relative;
    color: white;
    height: 100%;
}
.top-left {
    position: absolute;
    top: 2px;
    left: 2px;
    padding: 2px;
    background: #fff;
    color: #000;
    border-radius: 2px;
    font-size: 18px;
    font-weight: bold;
}
.sentence p {
    position: absolute;
    top: 2px;
    left: 2px;
    color: #000;
}
.bottom-right {
    position: absolute;
    bottom: 2px;
    right: 2px;
    padding: 2px;
    background: #fff;
    color: #000;
    border-radius: 2px;
    font-size: 14px;
}
.bottom-right i{
  color: #ddd;
  font-size: 10px;
}
  </style>
</head>
<body>
  <div class="container voca">
    <?php include 'vocaList.php' ?>
  </div> <!-- End Container -->
</body>
</html>
