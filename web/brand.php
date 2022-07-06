<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/c927f90642.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/style.css">


    <style>
      :root{
        --bg-color: #eee6de;
        --main-color: #e65947;
        --line-color: #ddb9a2;
        --main-word-color:#3F3F3F;
        --header-height: 100px;
     }
      .title{
        color:var(--line-color);
        margin-top:-20px;
        font-size:36px;
      }
      .btn-search{
        background: var( --line-color);
        border: 1px solid var(--line-color);
        border-radius:10%;
        padding:5px 20px ;
        color:white;
      }
      .footer{
        display:flex;
        justify-content:center;
        align-items:center;

      }
    </style>
  </head>
  <body>
     <?php
    require("./main-menu.html");
    ?>
     <main>
      <i class="fa-solid fa-bars-filter"></i>
          <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <p class="title">課程管理</p>
                <p>顯示 
                  <select class="count-bg text-center" aria-label="Default select example">
                    <option value="1" selected>6</option>
                    <option value="2">12</option>
                    <option value="3">18</option>
                    <option value="4">24</option>
                    <option value="5">30</option>
                  </select> 
                  筆數
                </p>
            </div>
    <div class="row align-items-center input-group pt-4 mb-3">
         <div class="text-center col-1">
            
         
         </div>
         <div class="col-auto">
             <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg></span>
               <input type="text" class=" form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
            </div>
          <div class="col-3">
             <button type="submit" class="btn-search  ">搜尋</button>
        </div>
    </div>
             <div class="text-end my-4">
              <a href="" class="text-dark m-2"><i class="fa-solid fa-trash m-2"></i>刪除產品</a>
              <a href="" class="text-main-color m-2"><i class="fa-solid fa-square-plus m-2"></i>新增產品</a>
            </div>


        <div class="row gy-4">
            <div class="col-md-4">
                <div>
                    <input type="checkbox" value="1" name="Product_1"><br>
                    <figure class="ratio ratio-4x3 mb-2">
                       <img class="object-cover" src="../imagesTest/spiderman.jpg" alt="">
                    </figure>
                  <div class="text-info">Marvel Comics</div>
                     <h2 class="mb-2 h4">Spider-Man</h2>
                     <div class="text-end text-danger">$500</div>
                  <div class="py-2">
                      <div class="d-grid">
                         <button class="btn btn-info btn-cart" data-id="1">加到購物車</button>
                     </div>
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div>
                <input type="checkbox" value="1" name="Product_1"><br>
                <figure class="ratio ratio-4x3 mb-2">
                    <img class="object-cover" src="../imagesTest/superman.png" alt="">
                </figure>
                <div class="text-info">DC Comics</div>
                <h2 class="mb-2 h4">Superman</h2>
                <div class="text-end text-danger">$1000</div>
                <div class="py-2">
                    <div class="d-grid">
                        <button class="btn btn-info btn-cart" data-id="2">加到購物車</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div>
                <input type="checkbox" value="1" name="Product_1"><br>
                <figure class="ratio ratio-4x3 mb-2">
                    <img class="object-cover" src="../imagesTest/wonderwoman.webp" alt="">
                </figure>
                <div class="text-info">DC Comics</div>
                <h2 class="mb-2 h4">Wonder Woman</h2>
                <div class="text-end text-danger">$3000</div>
                <div class="py-2">
                    <div class="d-grid">
                        <button class="btn btn-info btn-cart" data-id="3">加到購物車</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div>
                <input type="checkbox" value="1" name="Product_1"><br>
                <figure class="ratio ratio-4x3 mb-2">
                    <img class="object-cover" src="../imagesTest/ironman.png" alt="">
                </figure>
                <div class="text-info">Marvel Comics</div>
                <h2 class="mb-2 h4">Iron Man</h2>
                <div class="text-end text-danger">$10000</div>
                <div class="py-2">
                    <div class="d-grid">
                        <button class="btn btn-info btn-cart" data-id="4">加到購物車</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div>
                <input type="checkbox" value="1" name="Product_1"><br>
                <figure class="ratio ratio-4x3 mb-2">
                    <img class="object-cover" src="../imagesTest/batman.webp" alt="">
                </figure>
                <div class="text-info">DC Comics</div>
                <h2 class="mb-2 h4">Batman</h2>
                <div class="text-end text-danger">$10000</div>
                <div class="py-2">
                    <div class="d-grid">
                        <button class="btn btn-info btn-cart" data-id="5">加到購物車</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div>
                <input type="checkbox" value="1" name="Product_1"><br>
                <figure class="ratio ratio-4x3 mb-2">
                <img class="object-cover" src="../imagesTest/blackwidow.jpg" alt="">
                </figure>
                <div class="text-info">Marvel Comics</div>
                <h2 class="mb-2 h4">Black Widow</h2>
                <div class="text-end text-danger">$1100</div>
                <div class="py-2">
                    <div class="d-grid">
                        <button class="btn btn-info btn-cart" data-id="6">加到購物車</button>
                    </div>
                </div>
            </div>
            <div class="footer">
                <?php require("./mod/page-number.php") ?>
            </div>
          
         
    </main>
 
</html>