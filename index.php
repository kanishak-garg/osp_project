<?php

session_start();

if (!isset($_SESSION['logged_in'])) {
    $nav ='includes/nav.php';
}
else {
    $nav ='includes/navconnected.php';
    $idsess = $_SESSION['id'];
}

require 'includes/header.php';
require $nav; ?>

<style>
    .autocomplete {
        /*the container must be positioned relative:*/
        position: relative;
        display: block;

    }
    .autocomplete-items {
        color: #26a69a;
        font: 16px Roboto, sans-serif;
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }
    .autocomplete-items div {
        padding-bottom: 20px;
        padding-top: 20px;
        padding-left: 30px;
        cursor: pointer;
        background-color: #fff;
    }
    .autocomplete-items div:hover {
        /*when hovering an item:*/
        color: #26a69a;
        background-color: #e9e9e9;
    }
    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    #Prescription{
    	width:80%;
    	margin: auto;
    	margin-bottom:50px;

    }
    #form_upload{
    	width:60%;
    	margin:auto;
    	display: flex;
    	flex-direction: row;
    	justify-content: center;
    	align-items: center;
    	border: groove 0.5em white;
    	padding: 15px 0 15px 0;
    	border-radius: 2rem 
    }
    #fileToUpload{
    	color:white;
    }
    .home{
    	padding-top: 150px;
    }
    #chat{
    	color: white; 
    }
    .box{
    	width: 350px;
  		height: 70px;
		color: white;
		background: #21294B;
		padding-bottom: 10px;
		border-top-right-radius: 1.5rem;
		border-top-left-radius: 1.5rem;
    }
    #chatbot{
    	position: fixed;
	  	bottom: 0px;
	 	right:10px;
	  	z-index: 5;
	  	display: flex;
	  	justify-content: center;
	  	align-items: center;
    }
   .in_footer{
        background-color: #abff22f2;
    }
    .in_footer #chat{
    	color: #21294B;
    }
</style>
<div id="chatbot" class="box">
	<a href="" id="chat"><h4>Virtual Help!!</h4></a>
</div>
<div class="container-fluid home" id="top">
<div id="Prescription">
	            <form action="upload.php" method="post" enctype="multipart/form-data" id="form_upload">

	            	<label for="fileToUpload"><h5 style="display: inline; margin-right:10px;color: white ">Prescription</h5></label>
						<input type="file" name="fileToUpload" id="fileToUpload">
					<input type="submit" value="Upload" name="									Upload_Prescription" class="blue waves-light btn">		
				</form>
            </div>
    <div class="container search">

        <nav class="animated slideInUp wow">
            <div class="nav-wrapper" id="search_upload">
                <form method="GET" action="search.php">
                    <div class="input-field">
                        <input id="search" class="searching" type="search" name='searched' required>
                        <label for="search"><i class="material-icons">search</i></label>
                    </div>

                    <div class="center-align">
                        <button type="submit" name="search" class="blue waves-light miaw waves-effect btn hide">Search</button>
                    </div>
                </form>
			
            </div>
            
        </nav>
    </div>
</div>

<div class="container most">
    <div class="row">
        <?php

        include 'db.php';

        // selecting product available in largest quantity
        $queryfirst = "SELECT
    product.id as 'id',
    product.name as 'name',
    product.price as 'price',
    product.thumbnail as 'thumbnail',
    
    SUM(command.quantity) as 'total',
    command.statut,
    command.id_product
    
    FROM product, command
    WHERE product.id = command.id_product AND command.statut = 'paid'
    GROUP BY product.id
    ORDER BY SUM(command.quantity) DESC LIMIT 6";
        $resultfirst = $connection->query($queryfirst);
        if ($resultfirst->num_rows > 0) {
            // output data of each row
            while($rowfirst = $resultfirst->fetch_assoc()) {

                $id_best = $rowfirst['id'];
                $name_best = $rowfirst['name'];
                $price_best = $rowfirst['price'];
                $thumbnail_best = $rowfirst['thumbnail'];
                $totalsold = $rowfirst['total'];

                ?>

                <div class="col s12 m4">
                    <div class="card hoverable animated slideInUp wow">
                        <div class="card-image">
                            <a href="product.php?id=<?= $id_best;  ?>"><img src="products/<?= $thumbnail_best; ?>"></a>
                            <span class="card-title blue-text"><?= $name_best; ?></span>
                            <a href="product.php?id=<?= $id_best; ?>" class="btn-floating blue halfway-fab waves-effect waves-light right"><i class="material-icons">add</i></a>
                        </div>
                        <div class="card-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col s6">
                                        <p class="white-text"><i class="left fa fa-dollar"></i> <?= $price_best; ?></p>
                                    </div>
                                    <div class="col s6">
                                        <p class="white-text"><i class="left fa fa-shopping-basket"></i> <?= $totalsold; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            <?php }} ?>


    </div>
</div>

<div class="container-fluid center-align categories">
    <a href="#category" class="button-rounded btn-large waves-effect waves-light">Categories</a>
    <div class="container" id="category">
        <div class="row">
            <?php

            //get categories
            $querycategory = "SELECT id, name, icon  FROM category";
            $total = $connection->query($querycategory);
            if ($total->num_rows > 0) {
                // output data of each row
                while($rowcategory = $total->fetch_assoc()) {
                    $id_category = $rowcategory['id'];
                    $name_category = $rowcategory['name'];
                    $icon_category = $rowcategory['icon'];

                    ?>

                    <div class="col s12 m4">
                        <div class="card hoverable animated slideInUp wow">
                            <div class="card-image">
                                <a href="category.php?id=<?= $id_category; ?>"><img src="src/img/<?= $icon_category; ?>.png" alt=""></a>
                                <span class="card-title black-text"><?= $name_category; ?></span>
                            </div>
                        </div>
                    </div>

                <?php }} ?>
        </div>
    </div>
</div>


<div class="container-fluid about" id="about">
    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card animated slideInUp wow">
                    <div class="card-image">
                        <img src="src/img/about.jpeg" alt="">
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <h3 class="animated slideInUp wow">About Us</h3>
                <div class="divider animated slideInUp wow"></div>
                <p class="animated slideInUp wow">This project aims to implement an online Pharmacy and chatbot support system. We are making use of PHP and MySQL based dynamically generated web pages
                    to allow purchasing of medicines and getting perscription. We are going to implement a cart system to allow customers to store
                    their items. orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.  </p>
            </div> 

        </div>
    </div>
</div>
<div class="container contact" id="contact">
    <div class="row">
        <form action="https://postmail.invotes.com/send" method="post" id="email_form" class="col s12 animated slideInUp wow">
            <h3 class="animated slideInUp wow">Contact Us</h3>
            <div class="row">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="icon_prefix" name="subject" type="text" class="validate">
                    <label for="icon_prefix">Subject</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">email</i>
                    <input id="email" name="reply_to" type="email" class="validate">
                    <label for="email" data-error="wrong" data-success="right">Email</label>
                </div>
                <div class="input-field col s12 ">
                    <i class="material-icons prefix">message</i>
                    <textarea id="icon_prefix2" class="materialize-textarea" type="text" name="text" rows="4"" style="resize: vertical;min-height: 8rem;" required></textarea>
                    <label for="icon_prefix2">Your message</label>
                </div>
                <input type="hidden" name="access_token" value="6gty83bjcfi8h64bct4ha7on" />
                <input type="hidden" name="success_url" value="." />
                <input type="hidden" name="error_url" value=".?err=1" />
                <div class="center-align">
                    <button id="submit_form" type="submit" name="contact" value="Send" class="button-rounded btn-large waves-effect waves-light">Submit</button>
                </div>
                <!-- <p>Powered by <a href="https://postmail.invotes.com" target="_blank">PostMail</a></p> -->
            </div>
        </form>
    </div>
</div>



<?php
require 'includes/secondfooter.php';
require 'includes/footer.php'; ?>
<script>
    var submitButton = document.getElementById("submit_form");
    var form = document.getElementById("email_form");
    form.addEventListener("submit", function (e) {
        setTimeout(function() {
            submitButton.value = "Sending...";
            submitButton.disabled = true;
        }, 1);
    });
    window.onscroll = function(ev) {

    if ((window.innerHeight + window.scrollY + 330) >= document.body.offsetHeight) {
    	var element = document.getElementById("chatbot");
   		element.classList.add("in_footer");
    }else{
        document.getElementById("chatbot").classList.remove("in_footer");
    }
};
</script>

