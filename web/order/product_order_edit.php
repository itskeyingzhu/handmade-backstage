<?php

$id = $_GET["id"];



if (!isset($id)) {
    header("location:product_order-list.php");
}




require_once("../../db-connect.php");


// *******確認是否擁有coupon_id******* //

$sqlCoupon = $db_host->prepare("SELECT coupon_id FROM product_order 
WHERE product_order.id = $id");

try {
    $sqlCoupon->execute();
    $couponIsset = $sqlCoupon->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// *******擁有的話 資料連接coupon資料庫******* //

$couponId = $couponIsset["coupon_id"];
if ($couponId != "") {
    $sqlJoin = ",coupon.discount_type_id,coupon.coupon_discount,coupon.pay,coupon.name AS couponName";
    $JoinFrom = "JOIN coupon ON product_order.coupon_id = coupon.id";
} else {
    $sqlJoin = "";
    $JoinFrom = "";
}




// *******撈取訂單資料******* //

$sqlOrder = $db_host->prepare("SELECT product_order.*,user.account,user.email,order_staus.name AS orderName , payment.name AS payment, delivery.name AS delivery, payment_state.name AS payment_state $sqlJoin FROM product_order 
JOIN user ON product_order.user_id = user.id 
JOIN order_staus ON product_order.order_state_id = order_staus.id 
JOIN payment ON product_order.payment_id = payment.id
JOIN delivery ON product_order.delivery_id = delivery.id
JOIN payment_state ON product_order.payment_state_id = payment_state.id
$JoinFrom
WHERE product_order.id = $id");





// *******撈取訂單明細******* //
$sql = $db_host->prepare("SELECT product_order_list.*,product.name AS productName, product.category_id,category.category_en_name,product_img.img_name  FROM product_order_list 
JOIN product ON product_order_list.product_id = product.id 
JOIN category ON product.category_id = category.id 
JOIN product_img ON product.id = product_img.product_id  
WHERE product_order_list.order_id = $id");



try {
    $sqlOrder->execute();
    $orderRow = $sqlOrder->fetch(PDO::FETCH_ASSOC);
    // print_r($orderRow);

    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
    $rowsCount = count($rows);
    // print_r($rows);
} catch (PDOException $e) {
    echo "預處理陳述式失敗! <br/>";
    echo "error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

// *******將折價券低消設成數字******* //
$couponId != "" ? $couponPay = intval($orderRow["pay"]) : "";

?>

<!doctype html>
<html lang="en">

<head>
    <title>體驗課程 訂單明細</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="css/order-detail-style.css">


    <style>
        .table-w {
            width: 90%;
        }

        .customer-left,
        .customer-right {
            width: 50%;
        }


        .note-p {
            padding-left: 12px;
            padding-right: 25px;
        }

        .note {
            padding-left: 12px;
        }

        .select-padding {
            padding-left: 0;
        }

        #p-order_active{
            background: var(--main-color);
            color: #fff;
        }
    </style>

</head>

<body>
    <?php
    require("../main-menu.html");
    ?>
    <main>
        <!-- 顧客資料 -->

        <form action="do_product_Update.php" class="row mb-4 align-items-center" method="post">
            <input name="id" type="hidden" value="<?= $orderRow["id"] ?>">

            <div class="d-flex ">
                <div class="customer-left">
                    <div class="row mx-5 my-3">
                        <p class="col-2 boldWord">訂單編號</p>
                        <p class="col-auto"><?= $orderRow["id"] ?></p>
                    </div>

                    <div class="row mx-5 mb-3">
                        <p class="col-2 boldWord">訂單日期</p>
                        <p class="col-auto"><?= $orderRow["create_time"] ?></p>
                    </div>

                    <div class="row mx-5 mb-1">
                        <p class="col-2 boldWord">訂購帳號</p>
                        <p class="col-auto"><?= $orderRow["account"] ?></p>
                    </div>

                    <div class="row mx-5 mb-1 align-items-center">
                        <p class="col-2 boldWord">收件人</p>
                        <p class="col-auto"><input name="name" type="text" class="form-control" value="<?= $orderRow["name"] ?>" required></p>
                    </div>

                    
                <div class="row mx-5 mb-1">
                    <p class="col-2 boldWord">連絡電話</p>
                    <p class="col-auto"><input name="phone" type="tel" class="form-control" value="<?= $orderRow["phone"] ?>" required></p>
                </div>

                    <div class="row mx-5 mb-3 align-items-center">
                        <p class="col-2 boldWord">收件地址</p>
                        <p class="col-10"><input name="address" type="text" class="form-control" value="<?= $orderRow["address"] ?>" required></p>
                    </div>

                    <div class="row mx-5">
                        <p class="col-2 boldWord">連絡信箱</p>
                        <p class="col-auto"><?= $orderRow["email"] ?></p>
                    </div>

                </div>


                <div class="customer-right">
                    <div class="row mx-5 mb-3">
                        <p class="col-2 boldWord">付款方式</p>
                        <p class="col-auto"><?= $orderRow["payment"] ?></p>
                    </div>

                    <div class="row mx-5 mb-3">
                        <p class="col-2 boldWord">配送方式</p>
                        <p class="col-auto"><?= $orderRow["delivery"] ?></p>
                    </div>


                    <div class="row ms-5 mb-3 align-items-center">
                        <p class="col-2 boldWord">付款狀態</p>
                        <p class="col-4 select-padding">
                            <select name="payment_state_id" id="" class="form-select searchState col-auto">
                                <option <?php if ($orderRow["payment_state_id"] == '1') print 'selected '; ?> value="1">已付款</option>
                                <option <?php if ($orderRow["payment_state_id"] == '2') print 'selected '; ?> value="2">未付款</option>
                                <option <?php if ($orderRow["payment_state_id"] == '3') print 'selected '; ?> value="3">已退款</option>
                            </select>
                        </p>




                        <p class="col-2 boldWord">訂單狀態</p>
                        <p class="col-4 select-padding">
                            <select name="order_state_id" id="" class="form-select searchState col-auto">
                                <option <?php if ($orderRow["order_state_id"] == '1') print 'selected '; ?> value="1">未出貨</option>
                                <option <?php if ($orderRow["order_state_id"] == '2') print 'selected '; ?> value="2">已出貨</option>
                                <option <?php if ($orderRow["order_state_id"] == '4') print 'selected '; ?> value="4">完成</option>
                                <option <?php if ($orderRow["order_state_id"] == '5') print 'selected '; ?> value="5">取消</option>
                            </select>
                        </p>
                    </div>

                    <div class="row mt-5 mx-5 my-3 justify-content-end">
                        <a href="product_order_detail.php?id=<?= $orderRow["id"] ?>" class="col-auto btn btn-bg-color editBtn me-3">取消</a>
                        <button type="submit" class="col-auto btn btn-bg-color ">儲存</button>
                    </div>


                </div>
            </div>
        </form>


        <div class="d-flex mx-5 mb-3">
            <p class="note-p boldWord">顧客備註</p>
            <div class="note pt-1"><?= $orderRow["note"] ?></div>

        </div>
        <!-- 顧客資料結束 -->



        <!-- 顧客購買項目 -->

        <div class="d-flex justify-content-center">
            <table class="table table-hover mt-5 table-w">
                <thead>
                    <tr class="text-center order-title row order-th">
                        <td class="col-1"></td>
                        <td class="col-3 boldWord">課程名稱</td>
                        <td class="col boldWord">數量</td>
                        <td class="col boldWord">單價</td>
                        <td class="col boldWord">小計</td>
                    </tr>
                </thead>
                <tbody>

                    <?php $orderId = "" ?>
                    <?php $thePrice = intval("") ?>
                    <?php $totalPrice = intval("") ?>
                    <?php foreach ($rows as $row) : ?>
                        <?php if ($orderId == $row["id"]) : ?>
                            <?php continue; ?>
                        <?php else : ?>
                            <tr class="text-center row detail-tr">
                                <td class="col-1"><img class="coursePic imgObject" src="../../img/product/product_<?= $row["category_en_name"] ?>_<?= $row["product_id"] ?>/<?= $row["img_name"] ?>" alt=""></td>
                                <td class="col-3"><?= $row["productName"] ?></td>
                                <td class="col"><?= $row["amount"] ?></td>
                                <td class="col">$<?= $row["price"] ?></td>
                                <td class="col">$<?= $row["amount"] * $row["price"] ?></td>
                            </tr>

                            <?php $orderId = $row["id"] ?>
                            <?php $thePrice = intval($row["amount"] * $row["price"]) ?>
                            <?php $totalPrice += $thePrice ?>
                        <?php endif; ?>
                    <?php endforeach ?>




                </tbody>
            </table>
        </div>

        <?php if ($couponId!="") :?>
            <div class="ps-5 ms-5 boldWord">
                使用折價券：  <?=$orderRow["couponName"]?>
            </div>
        <?php endif;?>
        <div class="text-end boldWord ">
            <div class="row mx-5 pe-5 mt-2 justify-content-end">
                <p class="col-2 boldWord ">訂單總金額</p>
                <p class="col-1 ">$<?= $totalPrice ?></p>
            </div>

            <div class="row mx-5  pe-5 justify-content-end">
                <p class="col-2 boldWord ">優惠券折扣</p>

                <?php if (($couponId != "") && ($orderRow["discount_type_id"] == 1)) : ?>
                    <?php $discountPercent = floatval($orderRow["coupon_discount"] * 10) ?>
                    <p class="col-1"><?= $discountPercent ?> 折</p>
                <?php elseif (($couponId != "") && ($orderRow["discount_type_id"] == 2) && ($totalPrice >= $couponPay)) : ?>
                    <p class="col-1">$<?= $orderRow["coupon_discount"] ?></p>
                <?php elseif (($couponId != "") && ($orderRow["discount_type_id"] == 2) && ($totalPrice < $couponPay)) : ?>
                    <p class="col-1">$0</p>
                <?php else : ?>
                    <p class="col-1">$0</p>
                <?php endif; ?>

            </div>

            <div class="row mx-5  pe-5 justify-content-end ">
                <p class="col-1 boldWord totalPrice pb-2">實付金額</p>

                <?php if (($couponId != "") && ($orderRow["discount_type_id"] == 1)) : ?>
                    <p class="col-1 totalPrice ">$<?= round($totalPrice * $discountPercent / 10) ?> </p>

                <?php elseif (($couponId != "") && ($orderRow["discount_type_id"] == 2) && ($totalPrice >= $couponPay)) : ?>
                    <?php $couponPrice = intval($orderRow["coupon_discount"]) ?>
                    <p class="col-1 totalPrice">$<?= $totalPrice - $couponPrice ?></p>

                <?php elseif (($couponId != "") && ($orderRow["discount_type_id"] == 2) && ($totalPrice < $couponPay)) : ?>
                    <p class="col-1 totalPrice">$<?= $totalPrice ?></p>

                <?php else : ?>
                    <p class="col-1 totalPrice">$<?= $totalPrice ?></p>
                <?php endif; ?>



            </div>


        </div>
    </main>

    <script>
        let goBack = document.querySelector("#goBack");

        goBack.addEventListener('click', () => {
            document.referrer === '' ?
                window.location.href = "https://www.google.com" :
                window.history.go(-1);
        })
    </script>

</body>

</html>