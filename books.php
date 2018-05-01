<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

  <title>Наши книги</title>
</head>

<body class="main-background">
  <?php
    include 'database.php';
    $query = "SELECT * FROM books" ;
      $result = mysql_query($query) or die(mysql_error());
      $num_of_books = mysql_num_rows($result);
      $num_of_pages = $num_of_books/25;

    $page = $_GET["page"];
    if($page=="" || $page=="1"){
      $current_page=1;
    }
    else {
      $current_page=$page*25-25;
    }
  ?>
  <header class="main-header container-fluid">
    <nav class="navbar navbar-light row justify-content-center" style="background-color: #e3f2fd;">
      <ul class="row nav">
        <li class="nav-item"><a class="nav-link" href="index.html ">Главная</a></li>
        <li class="nav-item"><a class="nav-link" href="about-us.html">О нас</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Наши книги</a></li>
        <li class="nav-item"><a class="nav-link navbar-brand" href="index.html"><img src="img/bureau-logo.png" width=100;
                 height=50 alt="Логотип книжного магазина Бюро"></a></li>
        <li class="nav-item"><a class="nav-link" href="for_authors.html">Авторам</a></li>
        <li class="nav-item"><a class="nav-link" href="contacts.html">Контакты</a></li>
      </ul>
    </nav>
  </header>
  <main class="container">
    <div class="col bg-light text-dark">
       <form action="books.php" method="GET">

<input class="form-control mb-1" type="text" name="Name" placeholder="Введите название книги">
<input class="form-control mb-1" type="text" name="Author" placeholder="Введите фамилию автора">
  <div class="row mb-3" >  <div class="col-10">  <select class="form-control" name="Category">
  <option value="" disabled selected>Выберите категорию книги</option>
<?php
$query= "SELECT DISTINCT category from books";
$result=mysql_query($query);
while ($row = mysql_fetch_array($result)) {
echo '<option value="'.$row[0].'">'. $row[0]. '</option>';
}

?>
</select></div>
<div class="col"><input class="btn btn-primary" type="submit" name="find" value="Найти"></div></div>
      <h2 class="mb-5">Список изданных книг</h2>
          <?php
            if( isset( $_GET['find'] ) )
            {
    $name = trim($_GET['Name']);
    $author = trim($_GET['Author']);
    $category = trim($_GET['Category']);
    $query = "SELECT * FROM books where name like '%$name%'and author like '%$author%'and category like '%$category%'" ;
      $result = mysql_query($query) or die(mysql_error());
      $num_of_books = mysql_num_rows($result);
      $num_of_pages = $num_of_books/25;
      $query = "SELECT * FROM books where name like '%$name%'and author like '%$author%'and category like '%$category%' LIMIT $current_page, 25" ;
        $result = mysql_query($query) or die(mysql_error());
      if (mysql_num_rows($result)==0){
        echo '<div style="position: relative; bottom: 20px;" class="pb-4 alert alert-warning">Книг по данному запросу не найдено.</div>';
      }
      echo '<nav aria-label="Навигация по сайту">
    <ul class="pagination justify-content-center">';
    for($i=1;$i<=$num_of_pages;$i++){
    echo '<li class="page-item"><a class="page-link" href="books.php?Name='.$name.'&Author='.$author.'&Category='.$category.'&find=Найти&page='.$i.'">'.$i.' </a></li>'; }
    echo '  </ul></nav>';
            while ($row = mysql_fetch_array($result))
            {
              echo '<div class="row">';
              echo '<div class="col-md-2 text-center">';
              echo '<img src="'.$row[6].'">';
              echo '</div>';
              echo '<div class="col-md-10">';
              echo '<h5>'.$row[1].'</h5>';
              echo '<p>
                        <span style="color:#50C1E9; font-size:14px">'.$row[2].'</span><br><span>'.$row[4].' год • '.$row[3].' страниц • '.$row[8].'</span><br>
                          <button class="btn btn-primary" type="button" data-toggle="collapse" data-tarGET="#'.+$row[0].'" aria-expanded="false" aria-controls="collapseExample">
                          Описание
                          </button>
                          <a href="'.$row[5].'/read" target="_blank">Пролистать</a>
                    </p>
                    <div class="collapse" id="'.+$row[0].'">
                    <div class="card card-body">
                      '.$row[7].'
                    </div>
                  </div>';
              echo '</div>';
              echo '</div>';
            }
            echo '<nav aria-label="Навигация по сайту">
  <ul class="pagination justify-content-center">';
    for($i=1;$i<=$num_of_pages;$i++){
      echo '<li class="page-item"><a class="page-link" href="books.php?Name='.$name.'&Author='.$author.'&Category='.$category.'&find=Найти&page='.$i.'">'.$i.' </a></li>'; }
      echo '  </ul></nav>';
          }
          else {$query = "SELECT * FROM books LIMIT $current_page, 25" ;
            $result = mysql_query($query) or die(mysql_error());
            echo '<nav aria-label="Навигация по сайту">
  <ul class="pagination justify-content-center">';
    for($i=1;$i<=$num_of_pages;$i++){
      echo '<li class="page-item"><a class="page-link" href="books.php?page='.$i.'">'.$i.' </a></li>'; }
      echo '  </ul></nav>';
            while ($row = mysql_fetch_array($result))
            {
              echo '<div class="row">';
              echo '<div class="col-md-2 text-center">';
              echo '<img src="'.$row[6].'">';
              echo '</div>';
              echo '<div class="col-md-10">';
              echo '<h5>'.$row[1].'</h5>';
              echo '<p>
                        <span style="color:#50C1E9; font-size:14px">'.$row[2].'</span><br><span>'.$row[4].' год • '.$row[3].' страниц • '.$row[8].'</span><br>
                          <button class="btn btn-primary" type="button" data-toggle="collapse" data-tarGET="#'.+$row[0].'" aria-expanded="false" aria-controls="collapseExample">
                          Описание
                          </button>
                          <a href="'.$row[5].'/read">Пролистать</a>
                    </p>
                    <div class="collapse" id="'.+$row[0].'">
                    <div class="card card-body">
                      '.$row[7].'
                    </div>
                  </div>';
              echo '</div>';
              echo '</div>';
            }
            echo '<nav aria-label="Навигация по сайту">
          <ul class="pagination justify-content-center">';
          for($i=1;$i<=$num_of_pages;$i++){
          echo '<li class="page-item"><a class="page-link" href="books.php?page='.$i.'">'.$i.' </a></li>'; }
          echo '  </ul></nav>'; }?>
    </div>
  </main>
  <footer id="footer" class="bottom navbar navbar-light bg-light" style="color:black">
    <p class="footer-contacts">
      Издательство "Бюро"<br> Адрес: г. Москва, ул. Щербаковская, Д. 38
    </p>
    <div class="footer-finance-academy">
      <a href="http://fa.ru"><img src="img/fa100-logo.png" width="150" height="55"></a>
    </div>
    <p class="footer-author">
      <b>Разработано:</b>
      <span>Александр Пантелеев ПИ3-2<br>Курсовая работа</span>
    </p>
  </footer>
  <script>
    footer = document.getElementById('footer');
    if (document.body.offsetHeight < window.innerHeight) {
    footer.className = "fixed-bottom navbar navbar-light bg-light";
  }
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>

</html>
