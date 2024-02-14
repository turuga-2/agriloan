<?php include "config/databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];
// Retrieve the cart total from the session
$cartTotal = isset($_SESSION['cartTotal']) ? $_SESSION['cartTotal'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Application</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-position: center;
      background-size: cover;
    }

    header {
      background-color: #287247; /* Green header color */
      padding: 15px;
      text-align: center;
    }
    .date-time {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 17px;
    }
    .navbar {
    background-color: rgb(71, 160, 118);
    overflow: hidden;
    }
 /* Style the navigation bar links */
    .navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        margin-left: 20px;
        margin-right: 20px;
    }
    /* Change the color of links on hover */
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
    .navbar a:active,
        .navbar a.active {
            background-color: #2c5e3f;
            color: black;
        }
    .container{
      width: 600px;
      height: 640px;
      margin: 5% auto;
      background-color: #6d947cd2;
      border-radius: 5px;
      position: relative;
    }
    .container form{
      width: 80%;
      height: max-content;
      margin: 0 auto;
      position: relative;
      top: 30px;
      left: 20px;
      bottom: 30px;
    }
    
    form label {
      display: block;
      margin-bottom: 5px; /* Add spacing between labels and text areas */
      font-weight: bold;
    }

    form .text-area {
      height: auto;
      display: block;
      padding: 10px;
      margin-bottom: 15px; /* Add spacing between text areas */
      border: 1px solid #999;
      border-radius: 3px;
      background-color: #999;
    }
    input::placeholder {
            color: black; /* Change this to the desired color code */
        }
    label {
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;

    }
    .financialdetails{
      width: 600px;
      height: 500px;
      margin: auto;
      background-color: #6d947cd2;
      border-radius: 5px;
      position: relative;
      top: 10px; 
      bottom: 60px;
      
    }
    .financialdetails .btn{
          width: 50%;
          align-items: center;
          margin-left: 20%;
          padding: 10px;
          background-color: #333;
          color: #fff;
          border: none;
          border-radius: 5px;
          cursor: pointer;
    } 
    .farmdetails {
      display: block;
      justify-content: center;
      width: 55%;
      height: max-content;
      max-width: 1200px; /* Adjust the max-width based on your design */
      margin: 2% auto;
      background-color: rgba(109, 148, 124, 0.8);
      border-radius: 5px;
      position: relative;
      top: 10px;
      padding: 30px; /* Added padding for spacing */
      box-sizing: border-box;
            
        }

        .loanbundles{
          display: flex;
        }

        .maizebundle,
        .beansbundle {
            width: 35%;
            background-color: #c4e0cf;
            height: 15%;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 10px;
            box-shadow: #333;
            transition: box-shadow 0.3s; /* Added transition for a smoother effect */
            margin-left: 20px;
            margin-right: 25px;
        }

        .maizebundle button,
        .beansbundle button {
            width: 80px;
            padding: 8px;
            background-color: #579670;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .maizebundle.selected,
        .beansbundle.selected {
            box-shadow: 0 0 10px #f39c12;
        }
    .acres{
    width: 40%;
    background-color: #9fa8a0;
    border-radius: 5px; 
    color: black;
    } 
    /* Style the select buttons */
    .maizebundle li{
        height: 30%;
          padding: 8px;
          border-bottom: 1px solid black;
          font-size: 14px;
    }
    .maizebundle img {
            max-width: 70px;
            height: 20%;
            margin-bottom: 10px;
            border-radius: 4px;
    }
    
    .beansbundle li{
      height: 40%;
          padding: 4px;
          border-bottom: 1px solid black;
          font-size: 14px;
    }
    .beansbundle img {
            max-width: 70px;
            height: 20%;
            margin-bottom: 10px;
            border-radius: 4px;
    }
    #cart{
      
      max-width: max-content;
      height: fit-content;
    }
    
  </style>
  <style>
    .progress-bar {
      display: flex;
      justify-content: space-between;
      padding: 15px;
      background-color: #333;
      color: #fff;
      font-weight: bold;
    }
    .progress-step {
      flex: 1;
      text-align: center;
    }
    .progress-step.active {
      color: #f39c12; /* Active step color */
    }
    .form-container {
      display: none;
    }
  </style>
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

  <header>
    <h1>Loan Application</h1>
  </header>
  <div class="date-time">
            <?php
                echo"Today's date:",date("d-m-y, h:m:s")
            ?>
    </div>

  <div class="navbar">
        <a href="home.php"> Home </a>   
        <a href="profile.php"> My profile</a>
        <a href="loanapplication.php"class="active">Loan Application</a>
        <a href="loanrepayment.php">Loan Repayment</a>
        <a href="logout.php">Logout </a>
  </div>

  <div class="progress-bar">
    <div class="progress-step financialDetails">Financial Details</div>
    <div class="progress-step farmDetails">Farm Details</div>
  </div>

    <!-- Step 1: Personal Details -->
  
   <!-- Step 2: Financial Details -->
  <div id="financialDetails" class="form-container" style="display: block;">
    <div id="step2" class="financialdetails">
      <!-- ... -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
    <h2>Financial details</h2>
        <p>insert a copy of your CRB clearance certificate below</p>
        <label for="crbcert">Choose a PDF file:</label>
        <input type="file" id="crbcert" name="crbcert" accept=".pdf">
        <br>

        <p><br>insert a copy of your current bank statement below</p>
        <label for="bankstmt">Choose a PDF file:</label>
        <input type="file" id="bankstmt" name="bankstmt" accept=".pdf">
        <br>

        <p><br>insert a copy of your title deed below</p>
        <label for="deed">Choose a PDF file:</label>
        <input type="file" id="deed" name="deed" accept=".pdf">
        <br>

      
        <input type="submit" value="Upload" class="btn">
      </form>
        
        <button onclick="nextStep('farmDetails')">Next</button>
      
    </div>
  </div>

      <div id="farmDetails" class="form-container">
      <div id="step3" class="farmdetails">
      <h2>Loan details</h2>
        
            <h4>Please enter your acreage </h4>
            <p><i>This will calculate the right quantity to be included in your bundle</i></p>

            <label for="acres">Select Acres (1 to 10):</label>
            <input type="number" id="acres" name="acres" step="0.5" min="0.5" max="10"  class="acres" placeholder="0" required>
            <h4>Please select the loan bundle to apply for </h4>
            

          <div class="loanbundles">
            <div class="maizebundle">
            Maize bundle
              <ol>
                <li class="maizebundleproducts">
                <img src="seeds\KENYASEEDH516.png" alt="KENYASEEDH516">
                KenyaseedH516 2kg - ksh420
                </li>

                <li class="maizebundleproducts">
                <img src="fertiliser\CAN.jpeg" alt="CAN">
                CAN 25kg - ksh2151
                </li>

                <li class="maizebundleproducts">
                <img src="fertiliser\DAPplanting.png" alt="DAP">
                DAP 25 kg -ksh2975
                </li>
                Total price = 
              </ol>
              <button class="select-btn" onclick="selectBundle('maizebundle')">Select</button>
            </div>

            <div class="beansbundle" data-price="5824">
              Beans Bundle
              <ol>
                <li class="beansbundleproducts">
                <img src="seeds\WairimuBeanSeed.png" alt="WairimuBeanSeed">
                Wairimu Bean Seeds 2kg - ksh698
              </li>
              <li class="beansbundleproducts">
                <img src="fertiliser\CAN.jpeg" alt="CAN">
                CAN 25kg - ksh2151
              </li>
              <li class="beansbundleproducts">
                <img src="fertiliser\DAPplanting.png" alt="DAP">
                DAP 25kg -ksh 2975
              </li> 
            
              </ol>
              Total price = ksh 5824
              <button class="select-btn" onclick="selectBundle('beansbundle')">Select</button>
              
            </div>
            </div>
       <h3>To add more items to your loan please click here</h3>
       <button class="opencart" onclick="loadCart('seedscart.php')">Open Cart</button>

       <div id="cart">

       </div>

       <div class="total">

       </div>

       <button onclick="prevStep('financialDetails')">Previous</button>
       <button type="submit">Submit</button>    
            
    </div>
      
    </div>
    
    <script>
  function nextStep(nextStepId) {
    var currentStep = document.querySelector('.form-container[style="display: block;"]');
    var nextStep = document.getElementById(nextStepId);

    if (currentStep && nextStep) {
      currentStep.style.display = 'none';
      nextStep.style.display = 'block';

      updateProgressBar(nextStepId);
    }
  }

  function prevStep(prevStepId) {
    var currentStep = document.querySelector('.form-container[style="display: block;"]');
    var prevStep = document.getElementById(prevStepId);

    if (currentStep && prevStep) {
      currentStep.style.display = 'none';
      prevStep.style.display = 'block';

      updateProgressBar(prevStepId);
    }
  }

  function updateProgressBar(activeStepId) {
    var steps = document.querySelectorAll('.progress-step');
    steps.forEach(function (step) {
      step.classList.remove('active');
    });

    var activeStep = document.querySelector('.' + activeStepId);
    if (activeStep) {
      activeStep.classList.add('active');
    }
  }
</script>
    <script>

    // Get the input element reference
    var acresInput = document.getElementById('acres');
    // Variable to store the entered value
    let enteredValue = 0;

    // Add an event listener to capture the value when it changes
    acresInput.addEventListener('input', function() {
        enteredValue = parseFloat(acresInput.value) || 0; // Convert to a float or default to 0 if not a valid number
        console.log('Entered Value:', enteredValue);
    });

    var totalPrice = 0;
     // Echo the PHP variable into a JavaScript variable
     var cartTotal = <?php echo $cartTotal; ?>;

     // Use the value of acres as the multiplier
     const multiplier = parseFloat(acresInput.value) || 1; // Default to 1 if the input is not a valid number


    function updateTotalPrice() {

      // Get the input element reference
      const acresInput = document.getElementById('acres');

        // Reset total price
        totalPrice = 0;

        // Check if the maize bundle is selected
        const maizeBundle = document.querySelector('.maizebundle');
        if (maizeBundle.classList.contains('selected')) {
            totalPrice += calculateBundleTotal('.maizebundleproducts');
        }

        // Check if the beans bundle is selected
        const beansBundle = document.querySelector('.beansbundle');
        if (beansBundle.classList.contains('selected')) {
            totalPrice += calculateBundleTotal('.beansbundleproducts');
        }

        console.log('Bundle Price:', totalPrice);

          // Make an AJAX request to set_totals.php to store the total price in the session
    $.ajax({
        type: 'POST',
        url: 'set_totals.php',
        data: { totalPrice: totalPrice },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Total price stored successfully');
            } else {
                console.error('Error storing total price:', response.message);
            }
        },
        error: function() {
            console.error('AJAX request to set_totals.php failed');
        }
    });

    return totalPrice;
}
    function calculateBundleTotal(productClass) {
        // Calculate the total price for the selected bundle
        const products = document.querySelectorAll(productClass);
        let bundleTotal = 0;

        products.forEach(product => {
            const priceMatch = product.textContent.match(/ksh\s*(\d+)/i);
            if (priceMatch && priceMatch[1]) {
                const price = parseFloat(priceMatch[1], 10);
                bundleTotal += price; 
            
            }
        });
        
            bundleTotal= bundleTotal*enteredValue;
            
        return bundleTotal;
        
    }
    function selectBundle(bundle) {
    event.preventDefault();
    const selectedBundle = document.querySelector(`.${bundle}`);
    const otherBundle = bundle === 'maizebundle' ? document.querySelector('.beansbundle') : document.querySelector('.maizebundle');

    if (!selectedBundle.classList.contains('selected')) {
        // If the selected bundle is not already selected, deselect the other bundle
        otherBundle.classList.remove('selected');
    }

    // Toggle the selected state for the clicked bundle
    selectedBundle.classList.toggle('selected');

    // Update the total price based on the selected bundle
    const totalPrice = updateTotalPrice();

    // Get additional data
    const idNumber = '<?php echo $idNumber; ?>'; // Replace with your actual session variable or user data
    const orderId = 1; // You should generate a unique order ID or fetch it from your database

    // Make an AJAX request to store the data in the database
    $.ajax({
        type: 'POST',
        url: 'setbundle.php', // Create this PHP file to handle database insertion
        data: {
            idNumber: idNumber,
            orderId: orderId,
            acreage:multiplier,
            bundle: bundle,
            totalPrice: totalPrice
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log('Data stored in the database successfully');
            } else {
                console.error('Error storing data:', response.message);
            }
        },
        error: function () {
            console.error('AJAX request to store_loan_data.php failed');
        }
    });
    }

    function loadCart(pageUrl) {
        $.ajax({
            url: pageUrl,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                // Replace the content of the div with the loaded content
                $('#cart').html(data);
            },
            error: function () {
                console.error('Error loading page.');
            }
        });
    }

    function checkout() {
        
        alert('Loan application has been submitted successfully');
        console.log('Bundle Price:', cartTotal);
    }
</script>
       

</body>
</html>
