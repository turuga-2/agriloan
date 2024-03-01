<?php 
include "config/databaseconfig.php";
// Check if idNumber is not set in the session
if (!isset($_SESSION['idNumber'])) {
    // Redirect to the login page
    header("Location: farmerlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}

$idNumber = $_SESSION['idNumber'];
// Retrieve the cart total from the session
// Fetch products from the database for each category
$seedsQuery = "SELECT * FROM `products` WHERE category = 'seeds'";
$seedsResult = $conn->query($seedsQuery);

$fertilizersQuery = "SELECT * FROM `products` WHERE category = 'fertiliser'";
$fertilizersResult = $conn->query($fertilizersQuery);

$agrochemicalsQuery = "SELECT * FROM `products` WHERE category = 'agrochemicals'";
$agrochemicalsResult = $conn->query($agrochemicalsQuery);

// Function to fetch products from result set
function fetchProducts($result)
{
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

$seeds = fetchProducts($seedsResult);
$fertilizers = fetchProducts($fertilizersResult);
$agrochemicals = fetchProducts($agrochemicalsResult);


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
        button {
            width: max-content;
            align-items: center;
            margin-left: 20px;
            padding: 10px;
            background-color: #e44d26 ;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;

            
            
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
    
  </style><style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            height: max-content;
            display: flex;
            justify-content: space-between;
        
        }

        #cart-container {
          width: 100%;
          margin: auto;
          text-align: center;
          padding-top: 10px;
          transition: transform .5s;
        
          
            /* width: 70%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        }

        #item-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            list-style: none;
            padding: 0;
        }

        .item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: 200px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .item img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .item button {
            background-color: #e44d26;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease-in-out;
        }

        .item button:hover {
            background-color: #333;
        }

        #cart-icon {
            height: 70%;
            width: 22%;
            position: absolute;
            top: 5px;
            right: 20px;
            align-content: space-between;
            cursor: pointer;
            display: inline-block;
            
        }

        #cart-icon img {
            width: 30px; /* Adjust the size as needed */
            margin-right: 5px;
        }
        #cart-icon button {
            width: 60%;
            align-items: center;
            margin-left: 20%;
            padding: 10px;
            background-color: #e44d26 ;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        #cart-count {
            background-color: #e44d26;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
        }

        #cart-dropdown {
            display: none;
            position: relative;
            margin-top: auto;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1;
            width: 200px;
        }

        #cart-dropdown li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        #cart-dropdown li:last-child {
            border-bottom: none;
        }

        button {
            width: max-content;
            align-items: center;
            margin-left: 20px;
            padding: 10px;
            background-color: #e44d26 ;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;

            
            
        }
        p{
            margin-left: 20px;
        }

        #checkout {
            text-align: center;
            margin-top: 20px;
        }
        .custom-icon-class {
        width: 24px;  /* Set the width of the success icon */
        height: 24px; /* Set the height of the success icon */
    }   
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

  <header>
    <h1>Loan Application</h1>
  </header>


  <div class="navbar">
        <a href="home.php"> Home </a>   
        <a href="profile.php"> My profile</a>
        <a href="loanapplication.php"class="active">Loan Application</a>
        <a href="bills.php">My bills</b></a>
        <a href="loanrepayment.php">Loan Repayment</a>
        <a href="logout.php">Logout </a>
  </div>
  <?php
  // SQL statement to select the loan status
$loanStatusQuery = "SELECT loanstatus FROM farmer_details WHERE idNumber = '$idNumber'ORDER BY loanid DESC LIMIT 1";
$loanStatusResult = $conn->query($loanStatusQuery);

// Check if there is a matching loan status
if ($loanStatusResult->num_rows > 0) {
    $loanStatus = $loanStatusResult->fetch_assoc()['loanstatus'];

    // Check if the loan status is either "pending" or "active"
    if ($loanStatus == 'Pending' || $loanStatus == 'Active') {
        echo "You already have an existing loan application. You cannot apply for a new loan.";
        // You can optionally hide the "Start Application" button here
    } else {
        // Allow for the loan application
        echo '<h2><i>Welcome to your loan application</i></h2>';
        echo '<button onclick="startApplication()">Start Application Process</button>';
    }
} else {
    // If there is no matching loan status, allow for the loan application
    echo '<h2><i>Welcome to your loan application</i></h2>';
    echo '<button onclick="startApplication()">Start Application Process</button>';
}
  ?>
  
      <div id="farmDetails" class="form-container" style="display: none;">
      <div class="farmdetails">
      <h2>Loan details</h2>
        
            <h4>Please enter your acreage </h4>
            <p><i>This will calculate the right quantity to be included in your bundle</i></p>

            <label for="acres">Select Acres (1 to 10):</label>
            <input type="number" id="acres" name="acres" step="0.5" min="1" max="10"  class="acres" placeholder="0" required>
            <h4>Please select the loan bundle to apply for </h4>
            

          <div class="loanbundles">
            <div class="maizebundle">
            Maize bundle
              <ol>
                <li class="maizebundleproducts">
                <img src="seeds\KENYASEEDH516.png" alt="KENYASEEDH516">
                KenyaseedH516 25kg - ksh5000
                </li>

                <li class="maizebundleproducts">
                <img src="fertiliser\CAN.jpeg" alt="CAN">
                CAN 50kg - ksh8200
                </li>

                <li class="maizebundleproducts">
                <img src="fertiliser\DAPplanting.png" alt="DAP">
                DAP 50 kg - ksh8205
                </li>
              </ol>
              <button class="select-btn" onclick="selectBundle('maizebundle')">Select</button>
            </div>

            <div class="beansbundle" data-price="5824">
              Beans Bundle
              <ol>
                <li class="beansbundleproducts">
                <img src="seeds\WairimuBeanSeed.png" alt="WairimuBeanSeed">
                Wairimu Bean Seeds 2kg - ksh5500
              </li>
              <li class="beansbundleproducts">
                <img src="fertiliser\CAN.jpeg" alt="CAN">
                CAN 50kg - ksh8200
              </li>
              <li class="beansbundleproducts">
                <img src="fertiliser\DAPplanting.png" alt="DAP">
                DAP 50 kg - ksh8205
              </li> 
            
              </ol>
              <button class="select-btn" onclick="selectBundle('beansbundle')">Select</button>
              
            </div>
            </div>
       <h3>To add more items to your loan please click here</h3>
       <button class="opencart" onclick="opencart()">Open Cart</button>

       <div id="cart" style="display: none;">

       <div class="container">
        <div id="cart-container">
            <h2>Additional loan producs</h2>
            <h3>Seeds category</h3>
            <ul id="item-list">
                <?php foreach ($seeds as $seed): ?>
                    <li class="item" data-id="<?php echo $seed['product_id']; ?>">

                        <img src="<?php echo $seed['image_path']; ?>" alt="<?php echo $seed['productName']; ?>">
                        <?php echo $seed['productName']; ?> - ksh<?php echo number_format($seed['price'], 2); ?>
                        <button onclick="addToCart(<?php echo $seed['product_id']; ?>)">Add to Cart</button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h3>Fertiliser category</h3>
            <ul id="item-list">
                <?php foreach ($fertilizers as $fertilizer): ?>
                    <li class="item" data-id="<?php echo $fertilizer['product_id']; ?>">
                        <img src="<?php echo $fertilizer['image_path']; ?>" alt="<?php echo $fertilizer['productName']; ?>">
                        <?php echo $fertilizer['productName']; ?> - ksh<?php echo $fertilizer['price'];?>
                        <button onclick="addToCart(<?php echo $fertilizer['product_id']; ?>)">Add to Cart</button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h3>Agrochemicals category</h3>
            <ul id="item-list">
                <?php foreach ($agrochemicals as $agrochemical): ?>
                    <li class="item" data-id="<?php echo $agrochemical['product_id']; ?>">
                        <img src="<?php echo $agrochemical['image_path']; ?>" alt="<?php echo $agrochemical['productName']; ?>">
                        <?php echo $agrochemical['productName']; ?> - ksh<?php echo $agrochemical['price']; ?>
                        <button onclick="addToCart(<?php echo $agrochemical['product_id']; ?>)">Add to Cart</button>
                    </li>
                <?php endforeach; ?>
            </ul>


            <div id="cart-icon">
            
            <img src="basket.png" alt="Basket Icon">
                <span id="cart-count">0</span>
                <button onclick="toggleCartDropdown()" class="showcart">Show Cart</button>
                <ul id="cart-dropdown"></ul>

            </div>
            

        </div>

        
    </div>
  
            <p>Cart Total: ksh<span id="total">0.00</span><span id="btn"><button onclick="checkout()" id="checkoutbutton">Done</button></span></p>

            <button type="submit" onclick="loantotal()">Submit Application</button>
       </div>

       <div class="total">

       </div>

      
           
            
    </div>
      
    </div>
    
    
    <script>
    function startApplication() {
      // Show the farmDetails div
      document.getElementById('farmDetails').style.display = 'block';
    }
    function opencart(){
        document.getElementById('cart').style.display = 'block';
    }
    var acresInput = document.getElementById('acres');
    // Variable to store the entered value
    let enteredValue = 0;

    // Add an event listener to capture the value when it changes
    acresInput.addEventListener('input', function() {
        enteredValue = parseFloat(acresInput.value) || 0; // Convert to a float or default to 0 if not a valid number
        console.log('Entered Value:', enteredValue);
    });
    

    var bundlePrice = 0;
     // Echo the PHP variable into a JavaScript variable
     

     // Use the value of acres as the multiplier
     const multiplier = parseFloat(acresInput.value) || 1; // Default to 1 if the input is not a valid number


    function updateBundlePrice() {

      // Get the input element reference
      const acresInput = document.getElementById('acres');

        // Reset bundle price
        bundlePrice = 0;

        // Check if the maize bundle is selected
        const maizeBundle = document.querySelector('.maizebundle');
        if (maizeBundle.classList.contains('selected')) {
            bundlePrice += calculateBundleTotal('.maizebundleproducts');
        }

        // Check if the beans bundle is selected
        const beansBundle = document.querySelector('.beansbundle');
        if (beansBundle.classList.contains('selected')) {
            bundlePrice += calculateBundleTotal('.beansbundleproducts');
        }

        console.log('Bundle Price:', bundlePrice);

          // Make an AJAX request to set_totals.php to store the total price in the session

    return bundlePrice;
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
    const bundlePrice = updateBundlePrice();

    
    }</script>
    <script>
        // Cart array to store added items with quantity
        const cart = [];

        function addToCart(itemId) {
            const item = document.querySelector(`.item[data-id="${itemId}"]`);
            const itemName = item.textContent.trim();
            const price = parseFloat(item.textContent.match(/\ksh([\d.]+)/)[1]);

            const existingCartItem = cart.find(item => item.id === itemId);

            if (existingCartItem) {
                // If item already exists in the cart, update its quantity
                existingCartItem.quantity += 1;
            } else {
                // Create a new cart item object
                const cartItem = {
                    id: itemId,
                    name: itemName,
                    price: price,
                    quantity: 1
                };
                // Add the cart item to the cart array
                cart.push(cartItem);
            }

            // Update the cart display
            updateCart();
            
            Swal.fire({
                title: 'Item added to cart!',
                icon: 'success',
                timer: 700,
                showConfirmButton: false,
                customClass: {
                    popup: 'custom-popup-class',
                },
                width: '300px',
            });
        }

        //let cartTotal = 0;
        function updateCart() {
            const cartCount = document.getElementById('cart-count');
            const cartDropdown = document.getElementById('cart-dropdown');
            const totalElement = document.getElementById('total');

            cartDropdown.innerHTML = ''; // Clear the cart dropdown

            let total = 0;

            // Iterate through each item in the cart and update the display
            cart.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('cart-item');
                li.textContent = `${item.name.split(' - ')[0]} - Quantity: ${item.quantity} - ${item.price.toFixed(2)}`;

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.onclick = () => removeFromCart(item.id);

                li.appendChild(removeButton);
                cartDropdown.appendChild(li);

                total += item.price * item.quantity;
            });

            totalElement.textContent = total.toFixed(2);
            const totali = totalElement.textContent;
            cartCount.textContent = cart.reduce((count, item) => count + item.quantity, 0);
        
        cartTotal = totali;
        return totali;   
        }
        

        function removeFromCart(itemId) {
            const itemIndex = cart.findIndex(item => item.id === itemId);

            if (itemIndex !== -1) {
                if (cart[itemIndex].quantity > 1) {
                    // If quantity is greater than 1, decrement the quantity
                    cart[itemIndex].quantity -= 1;
                } else {
                    // If quantity is 1 or less, remove the item from the cart
                    cart.splice(itemIndex, 1);
                }

                // Update the cart display
                updateCart();
            }
        }

        function toggleCartDropdown() {
        const cartDropdown = document.getElementById('cart-dropdown');
        cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
    }
        function checkout() {
            $.ajax({
        url: 'setorders.php', // Replace with the actual server-side script
        method: 'POST',
        data: { cartTotal: cartTotal},
        success: function(response) {
            //loantotal(cartTotal);
            console.log('carttotal saved to session successfully.',response);
        },
        error: function() {
            console.error('Error saving carttotal to session.');
        }
        });

            $.ajax({
        type: 'POST',
        url: 'setcarttotal.php', // Update the URL to the correct PHP script
        data: { cartItems: JSON.stringify(cart) }, // Convert cart items to JSON
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log('Cart items saved successfully',response);
            } else {
                console.error('Error saving Cart items:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX request to savecartitems.php failed');
            console.error('Status:', status);
            console.error('Error:', error);
        }
        });

            


            const cartItems = cart.map(item => `${item.name.split(' - ')[0]} - Quantity: ${item.quantity} - ${item.price.toFixed(2)}`);

            Swal.fire({
                title: 'Additional Cart items added successfully!',
                html: `<p>Cart Total: ksh ${cartTotal}</p>
                    <p>Successfully Added Items:</p>
                    <ol style="text-align: left;">${cartItems.map(item => `<li>${item}</li>`).join('')}</ol>
                    `,
                icon: 'success',
                customClass: {
                    popup: 'custom-popup-class',
                    icon: 'custom-icon-class'
                },
                width: '400px',
            });

        }
     function loantotal() {
      var bundlePrice = updateBundlePrice();
      bundlePrice = parseFloat(bundlePrice.toFixed(2));

    console.log(cartTotal);
    // Calculate loan total
    var loantotal = bundlePrice + parseFloat(cartTotal);

    // Calculate interest (6.5% of the loan total)
    const interestRate = 0.065;
    const time = 6;
  
    const interest = (loantotal * Math.pow((1 + interestRate), time))-loantotal;

    // Calculate grand total and round to two decimal places
    var grandtotal = (loantotal + interest).toFixed(2);

    // Log the results to the console and display with two decimal places
    console.log('loantotal: ' + loantotal.toFixed(2));
    console.log('interest: ' + interest.toFixed(2)); 
    console.log('grandtotal: ' + grandtotal);
    
    $.ajax({
        url: 'processloan.php',
        method: 'POST',
        data: {
          enteredValue: enteredValue,
          bundlePrice: bundlePrice,
          loantotal: loantotal,
          interest: interest,
          grandtotal: grandtotal
        },
        success: function(response) {
            console.log(response);
            console.log('loan processed  successfully.');
        },
        error: function() {
            console.error('Error processing loan.');
        
        }
    });
    // Show SweetAlert popup for successful loan application
    Swal.fire({
        title: 'Loan application submitted successfully!',
        html: `<p>Your loan status is Pending</p>
          <p>Your Loan Amount is: ksh ${loantotal.toFixed(2)}</p>
          <p>The Interest payable is : ksh ${interest.toFixed(2)}</p>
          <p>Total Loan Amount: ksh ${grandtotal}</p>
        `,
        icon: 'success',
        customClass: {
          popup: 'custom-popup-class',
          icon: 'custom-icon-class'
        },
        width: '400px', // Adjust the width as needed
      });

      // Hide the farmDetails div after successful loan application
      document.getElementById('farmDetails').style.display = 'none';
        
        cart.length = 0;
        updateCart();

        // Refresh the page
        location.reload();
    
    }
    
        
        
        //   Swal.fire({
        //     title: 'Loan application submitted successfully!',
        //     html: `<p>Your loan status is Pending</p>
        //     <p>Total Loan Amount : ksh ${loantotal.toFixed(2)}</p>
        //            <p>Successfully Added Items:</p>
        //            <ol style="text-align: left;">${cartItems.map(item => `<li>${item}</li>`).join('')}</ol>
        //            `,
        //     icon: 'success',
        //     customClass: {
        //         popup: 'custom-popup-class', 
        //         icon: 'custom-icon-class'
        //     },
        //     width: '400px', // Adjust the width as needed
        // });


       


       // return loantotal;


</script>

</body>
</html>

    
    