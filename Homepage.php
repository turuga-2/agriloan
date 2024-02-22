<!DOCTYPE html>
<html>
<head>
    <title> Agriloan </title>
<style>
body {
    background-color: #22503a;
    font-family: Arial, sans-serif;
    background-position: center;
    background-size: cover;
    background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(plant2.jpg);
    
    }

body h1 {
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    align-content: center;
    color: #7f8f7d;
}

body p {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    align-self: center;
    justify-content: center;
    color: #7f8f7d;
}

center{
    font-size: 20px;
}

.content{ 
    padding-top: 23% ;
    align-content: center;
    font-size: 20px;
    color: #7f8f7d;
    
}
.content .btn{

    display: inline-block;
    align-items: center;
    padding: 10px 30px;
    font-size: 20px;
    background: #333;
    color: aliceblue;
    margin: 0 5px;

}


</style>
</head>
<body>


    
    <center>
        <h1> Agriloan </h1>
        <p><b><i> Welcome to Agriloan where we make farmers' dreams come true!
        <br>Join us today to get the support you need for a wonderful harvest!
        <br>We provide affordable loans in form of farm inputs and seeds.
    </i></b></p>

    

    <div class="content">

        <a href="farmerlogin.php" class="btn"> I am a Farmer </a>

        <a href="adminlogin.php" class="btn"> Staff Member </a>

 
</div>
    </center>
    


<script>
    
    function redirect() {
            var link = document.getElementById("profile").value;
            window.open(link);
        }
</script>
</body>
</html>
