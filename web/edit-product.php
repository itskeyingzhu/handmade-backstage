<?php
if(!isset($_GET["type"])){
    echo "沒有帶商品類型參數";
    exit;
}
require_once("../db-connect.php");
$type=$_GET["type"];
$id=$_GET["id"];
if($type=="course"){
    $stmt=$db_host->prepare("SELECT course.*,category.*,store.name AS store_name FROM course JOIN category ON course.category_id = category.id JOIN store ON course.store_id = store.id WHERE course.id = ?");
    $stmtImg=$db_host->prepare("SELECT * FROM course_img WHERE course_img.course_id = ?");
}elseif($type=="product"){
    $stmt=$db_host->prepare("SELECT product.*,category.*,store.name AS store_name FROM product JOIN category ON product.category_id = category.id JOIN store ON product.store_id = store.id WHERE product.id = ?");
    $stmtImg=$db_host->prepare("SELECT * FROM product_img WHERE product_img.product_id = ?");
}





try{    
    

    $stmt->execute([$id]);    
    $row=$stmt->fetch();

    $stmtCategory=$db_host->prepare("SELECT * FROM category");
    $stmt_store=$db_host->prepare("SELECT store.id,store.name FROM store WHERE store.category_id = ?");
    $stmtCategory->execute();    
    $rowsCategory=$stmtCategory->fetchAll(PDO::FETCH_ASSOC);
    $stmt_store->execute([$row["category_id"]]);
    $rows_store=$stmt_store->fetchAll(PDO::FETCH_ASSOC);
    $stmtImg->execute([$id]);    
    $rows_Img=$stmtImg->fetchAll(PDO::FETCH_ASSOC);    
}catch (PDOException $e){
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}
if($type=="course"){
    $datetime=explode(" ",($row["course_date"]??""));
    $date=$datetime[0];
    $time=$datetime[1];
}
$db_host = NULL;
?>
<!doctype html>
<html lang="en">
  <head>
    <title>新增商品-手手</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/c927f90642.js" crossorigin="anonymous"></script>

  </head>
  <body>
    <?php
    require("./main-menu.html");
    ?>
    <main>
        <div class="container-fluid">            
            <form action="do-update-product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$id?>">
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="">圖片</label>
                    <?php for($i=1;$i<=count($rows_Img);$i++): ?>   
                        <div class="col-auto position-relative p-0 mx-2"> 
                            <input class="img-state" type="hidden" name="change<?=$i?>" value="unchange"> 
                            <input class="d-none upload_image" type="file" name="product_img<?=$i?>" accept="image/*">
                            <img src="../img/<?=$type?>/<?=$type?>_<?= $row["category_en_name"].'_'.$id.'/'.$rows_Img[$i-1]["img_name"] ?>"
                            class="previewImage object-cover" alt="圖片預覽" onerror="this.src='../img/previewImage.jpg'">
                            <i class="fa-solid fa-xmark text-light position-absolute top-0 end-0 translate-end p-1 cancel-img"></i>
                        </div>
                    <?php endfor; ?>
                    <?php for($i=count($rows_Img)+1;$i<=4;$i++):?>
                    <div class="col-auto position-relative p-0 mx-2">
                        <input class="img-state" type="hidden" name="change<?=$i?>" value="unchange">
                        <input class="d-none upload_image" type="file" name="product_img<?=$i?>" accept="image/*">
                        <img src="" class="previewImage object-cover" alt="圖片預覽" onerror="this.src='/HANDMADE/img/previewImage.jpg'">
                        <i class="fa-solid fa-xmark text-light position-absolute top-0 end-0 translate-end p-1 cancel-img d-none"></i>
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="product_name">名稱</label>
                    <input class="col form-control" type="text" name="product_name" placeholder="請輸入商品名稱" required
                    value="<?= $row["name"] ?>">
                </div>
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="intro">簡介</label>
                    <textarea class="form-control col" name="intro" cols="30" rows="10" style="resize:none" placeholder="請輸入商品介紹" required><?= $row["intro"] ?></textarea>                   
                </div>
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="price">價格</label>
                    <input class="col form-control" type="number" name="price" placeholder="請輸入商品價格" required value="<?= $row["price"] ?>">
                </div>                
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="amount">數量</label>
                    <input class="col form-control" type="number" name="amount" placeholder="請輸入商品數量" required value="<?= $row["amount"] ?>">
                </div>                
                <div class="my-3 row justify-content-between">
                    <div class="col-5 d-flex align-items-center">
                        <label class="col-2 me-2" for="category">類別</label>
                        <select id="category" class="form-select col" aria-label="Default select example" name="category">
                        <?php foreach($rowsCategory as $Category): ?>
                        <option value="<?=$Category["id"]?>" <?=$Category["id"]==$row["category_id"]?"selected":""?>>
                            <?=$Category["category_name"] ?>
                        </option>
                        <?php endforeach; ?>         
                        </select>
                    </div>
                    <div class="col-5 d-flex pe-0  align-items-center">
                        <label class="col-2 me-2" for="store">品牌</label>
                        <select  id="store" class="form-select col" aria-label="Default select example" name="store">
                        <?php foreach($rows_store as $store): ?>
                        <option value="<?=$store["id"]?>" <?=$store["id"]==$row["store_id"]?"selected":""?>><?=$store["name"]?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-5 d-flex gy-3  align-items-center">
                        <label class="col-2 me-2" for="type">商品類型</label>
                        <input type="hidden" name="type" value="<?=$type?>">
                        <select id="type" class="form-select col" aria-label="Default select example" name="type" disabled>
                        <option value="course" <?=$type=="course"?"selected":""?>>體驗課程</option>
                        <option value="product" <?=$type=="product"?"selected":""?>>實體商品</option>                    
                        </select>
                    </div>
                </div> 
                <div id="course" class="<?=$type=="course"?"":"d-none"?>">
                    <div class="my-3 row align-items-center">
                        <label class="col-1" for="datetime">課程日程</label>
                        <div class="col-2 p-0">
                        <input id="date" class="form-control" type="date" name="date" value=<?=$date?>>                        
                        </div>
                        <div class="col-1">
                        <input id="timepicker" class="form-control timepicker" type="text" name="time" placeholder="時間" value="<?=$time?>" <?=$type=="course"?"required":""?>>
                        </div>
                    </div>
                    <div class="my-3 row align-items-center">
                        <label class="col-1" for="hour">課程時長</label>
                        <input class="col form-control" type="number" step="0.5" min="0" name="hour" placeholder="請輸入課程時長" value="<?= $row["course_time"]??"" ?>" <?=$type=="course"?"required":""?>>
                    </div>
                </div>
                <div class="my-3 row align-items-center">
                    <label class="col-1" for="notice">注意事項</label>
                    <textarea class="form-control col" name="notice" cols="30" rows="10" style="resize:none" placeholder="請輸入商品注意事項" required><?= $row["note"] ?></textarea>
                </div>
                <div class="my-5 d-flex justify-content-end">
                    <a id="back" class="ms-3 btn btn-bg-color">取消</a>
                    <button class="ms-3 btn btn-main-color" type="submit">儲存</button>                    
                </div>                
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.css" integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js" integrity="sha512-WHnaxy6FscGMvbIB5EgmjW71v5BCQyz5kQTcZ5iMxann3HczLlBHH5PQk7030XmmK5siar66qzY+EJxKHZTPEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
    <script>
        const previewImages=document.querySelectorAll(".previewImage");
        const upload_images=document.querySelectorAll(".upload_image");
        const cancel_img=document.querySelectorAll(".cancel-img");
        const imgs_state=document.querySelectorAll(".img-state");

        for(let i=0;i<previewImages.length;i++){
            previewImages[i].addEventListener("click",function(){
                upload_images[i].click();
            })
            upload_images[i].addEventListener("change",function(){
                const myFile=this.files[0];                
                const img=previewImages[i];
                if(myFile==undefined){
                    cancel_img[i].click();
                    return;
                }
                const objUrl=URL.createObjectURL(myFile);
                const state=imgs_state[i];
                img.src=objUrl;
                img.onload=()=>window.URL.revokeObjectURL(objUrl);  
                console.log(cancel_img[i]);
                cancel_img[i].classList.remove("d-none");
                state.value="new";
            })
            cancel_img[i].addEventListener("click",function(){
                this.classList.add("d-none");
                const state=imgs_state[i];
                const imgFile=upload_images[i];
                const preImg=previewImages[i];
                imgFile.value="";
                preImg.setAttribute("src","../img/previewImage.jpg");   
                state.value="del";    
            })
        } 

        const type=document.querySelector("#type");
        const course=document.querySelector("#course");
        type.addEventListener("change",function(){
            // console.log("type change");
            if(this.value=="course"){
                course.classList.remove("d-none");
            }else{
                course.classList.add("d-none");
            }
        })

        const category=document.querySelector("#category");
        const store=document.querySelector("#store");
        category.addEventListener("change",function(){
            // console.log("category change");
            categoryValue=this.value;
            // console.log(store.children);
            for(let i=store.children.length-1;i>=0;i-- ){
                store.removeChild(store[i]);
            }
            $.ajax({
            	method: "POST",  //or GET
            	url:  "../api/filte-store.php",
            	dataType: "json",
            	data: { category_id: categoryValue } //如果需要
            	})
            	.done(function( response ) {
                	console.log(response);
                    for(let result of response.stores){
                        html=document.createElement("option");
                        html.textContent=result.name;
                        html.setAttribute("value",result.id);
                        console.log(html);
                        store.prepend(html);
                    }                    
            	}).fail(function( jqXHR, textStatus ) {
                	console.log( "Request failed: " + textStatus );
            	});
        })
        
        const backBtn=document.querySelector("#back");
        backBtn.addEventListener("click",function(){
            history.back();
        })
        // const date=document.querySelector("#date");
        // let currentDate=new Date();
        // let year=currentDate.getFullYear();
        // let month=currentDate.getMonth()+1<10?"0"+(currentDate.getMonth()+1):currentDate.getMonth()+1;
        // let day=currentDate.getDate()+1<10?"0"+(currentDate.getDate()+1):currentDate.getDate()+1;
        // let curDate=`${year}-${month}-${day}`
        // // date.setAttribute("min","2022-07-14T08:00");
        // date.value =curDate;
        $(function () {
            $(".timepicker").timepicker ({ 
                'scrollDefault' : 'now' ,
                'disableTextInput' : true,
                'timeFormat': 'H:i'
            })
            
        });

    </script>
  </body>
</html>