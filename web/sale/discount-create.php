<?php

require("../../db-connect.php");
session_start();

$sql = "SELECT * FROM discount";

$result = $db_host->prepare($sql);
$result->execute();
$row = $result->fetch();
$discountCount = $result->rowCount();

?>

<!doctype html>
<html lang="en">

<head>
    <title>一般折扣-新增-手手</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c927f90642.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        form ul {
            position: relative;
            list-style-type: none;
            right: 30px;
        }

        form li {
            color: #3f3f3f;
        }

        .btn {
            color: #ffffff;
            font-size: 600;
        }

        .btn-cancel {
            background: #D7BAA5;
        }

        .btn-red {
            background: #D6624F;
        }

        .button {
            position: relative;
            right: 235px;
        }

        .state-title {
            position: relative;
            left: 800px;
        }

        select {
            position: relative;
            left: 115px;
        }

        #discount_active {
            color: #fff;
            background: var(--main-color);
        }

        #discount_active a::before {
            content: "";
            height: 25px;
            width: 5px;
            background: #fff;
            position: absolute;
            top: 50%;
            transform: translate(-300%, -50%);
        }
    </style>
    </style>
</head>

<body>
    <?php
    require("../main-menu.html");
    ?>
    <main>
        <?php if ($discountCount > 0) : ?>
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <p class="title">新增一般折扣</p>
                </div>
                <form action="discount-doCreate.php" method="POST" class="mb-3">
                    <div></div>
                    <ul>
                        <input type="hidden" name="id">
                        <li>活動名稱</li>
                        <li><input type="text" class="form-control my-3" style="width: 1200px;" name="name"></li>

                        <?php if (isset($_SESSION["discount"]["name"])) : ?>
                            <div class="text-danger col-10 text-end fw-bold">活動名稱 <?= $_SESSION["discount"]["name"] ?> 重複囉！請發揮創意</div>
                        <?php endif; ?>

                        <li>活動簡介</li>
                        <li><textarea type="text" class="form-control my-3 content" style="width: 1200px; height:400px;" name="content"></textarea></li>
                        <li class="mb-3">折扣內容</li>
                        <div class="d-flex">
                            <!-- discount_type_id = 1 -->
                            <div class="d-flex">
                                <input class="mt-3" type="radio" name="discount_type_id" value="1">
                                <p class="mt-2 ms-2 me-3 OFFSTYLE">折數</p>
                                <input type="text" class="form-control" style="width: 100px; height: 40px" name="product_discount">
                            </div>
                            <!-- discount_type_id = 2 -->
                            <div class="d-flex">
                                <input class="mt-3 ms-5" type="radio" name="discount_type_id" value="2">
                                <p class="mt-2 ms-2 me-3 OFFSTYLE">滿</p>
                                <input type="text" class="form-control" style="width: 100px; height: 40px" name="pay">
                                <p class="mt-2 ms-3 me-3 OFFSTYLE">折</p>
                                <input type="text" class="form-control" style="width: 100px; height: 40px" name="product_discount2">
                            </div>
                        </div>
                        </li>
                        <div class="d-flex">
                            <li class="pt-4">活動期間</li>
                            <li class="pt-4 state-title">活動狀態</li>
                        </div>

                        <div class="d-flex">
                            <li><input type="date" class="form-control my-3 me-3" style="width: 350px;" name="start_date"></li>
                            <li>
                                <div class="pt-4">至</div>
                            </li>
                            <li><input type="date" class="form-control my-3 ms-3" style="width: 350px;" name="end_date"></li>
                            <li>
                                <select class="form-select my-3" aria-label="Default select example" style="width: 337px;" name="state">
                                    <option value="1" select>接下來</option>
                                    <option value="2">進行中</option>
                                    <option value="3">已結束</option>
                                </select>
                            </li>
                        </div>
                    </ul>
                    <div class="text-end me-5 button">
                        <a href="discount.php" class="btn btn-cancel mx-2">取消</a>
                        <button class="btn btn-red mx-2" type="submit">儲存</button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            CANNOT FIND THE USER
        <?php endif; ?>
    </main>
</body>

</html>