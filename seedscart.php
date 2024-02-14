<?php include "config/databaseconfig.php";
session_start();
$totalPrice = $_SESSION['totalPrice'] ;

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
    <title>Shopping Cart</title>
    <style>
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
          width: 900px;
          margin: auto;
          max-width: 90vw;
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
</head>
<body>
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
                        <?php echo $fertilizer['productName']; ?> - ksh<?php echo number_format($fertilizer['price'], 2); ?>
                        <button onclick="addToCart(<?php echo $fertilizer['product_id']; ?>)">Add to Cart</button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h3>Agrochemicals category</h3>
            <ul id="item-list">
                <?php foreach ($agrochemicals as $agrochemical): ?>
                    <li class="item" data-id="<?php echo $agrochemical['product_id']; ?>">
                        <img src="<?php echo $agrochemical['image_path']; ?>" alt="<?php echo $agrochemical['productName']; ?>">
                        <?php echo $agrochemical['productName']; ?> - ksh<?php echo number_format($agrochemical['price'], 2); ?>
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
  
            <p>Cart Total: ksh<span id="total">0.00</span><span id="btn"><button onclick="checkout()" id="checkoutbutton">Checkout</button></span></p>
 
            
    <script>

        var totalPrice = parseFloat(<?php echo $totalPrice ;?>);

        // Cart array to store added items
        const cart = [];
        // Function to add an item to the cart
        function addToCart(itemId) {
            // Select the item based on its data-id attribute
            const item = document.querySelector(`.item[data-id="${itemId}"]`);
            const itemName = item.textContent.trim(); // Extract item name
            const price = parseFloat(item.textContent.match(/\ksh([\d.]+)/)[1]); // Extract price from text
             
            // Create a cart item object
            const cartItem = {
                id: itemId,
                name: itemName,
                price: price
            };
            // Add the cart item to the cart array
            cart.push(cartItem);
            // Update the cart display
            updateCart();
            Swal.fire({
            title: 'Item added to cart!',
            icon: 'success',
            timer: 700, // Auto-close the popup after 2 seconds (adjust as needed)
            showConfirmButton: false,
            customClass: {
                popup: 'custom-popup-class', // Add your custom class for styling
            },
            width: '300px', // Adjust the width as needed
        });
        }

        // Function to update the cart display
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

                

                //li.classList.add('cart-item');
                li.textContent = `${item.name.split(' - ')[0]} - ${item.price.toFixed(2)}`;
                //li.textContent = `${item.name} - $ksh{item.price.toFixed(2)}`;

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.onclick = () => removeFromCart(item.id);

                li.appendChild(removeButton);
                cartDropdown.appendChild(li);

                total += item.price;
                // $_SESSION['total'] = total;
            });
            totalElement.textContent = total.toFixed(2);
            
            const totali=totalElement.textContent;
            cartCount.textContent = cart.length;

            return totali;
        }

        // Function to remove an item from the cart
        function removeFromCart(itemId) {
            const itemIndex = cart.findIndex(item => item.id === itemId);

            if (itemIndex !== -1) {
                cart.splice(itemIndex, 1);
                updateCart();
            }
        }
       
        // Function to simulate the checkout process
        function checkout() {
           
            const cartTotal = updateCart(); // Get the total from the updateCart function
            const grandTotal = parseFloat(cartTotal) + parseFloat(totalPrice);
            const interest = grandTotal * 0.065;
        // to send the grand total ndio isaviwe kwa session
            $.ajax({
        type: 'POST',
        url: 'setgrandtotal.php',
        data: { grandTotal: grandTotal },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Grand Total  stored successfully');
            } else {
                console.error('Error storing grand total:', response.message);
            }
        },
        error: function() {
            console.error('AJAX request to setgrandtotal.php failed');
        }
    });

    // to send the interest ndio isaviwe kwa session
    // $.ajax({
    //     type: 'POST',
    //     url: 'setgrandtotal.php',
    //     data: { interest: interest },
    //     dataType: 'json',
    //     success: function(response) {
    //         if (response.success) {
    //             console.log('Interest stored successfully');
    //         } else {
    //             console.error('Error storing interest:', response.message);
    //         }
    //     },
    //     error: function() {
    //         console.error('AJAX request to setgrandtotal.php failed');
    //     }
    // });
    $.ajax({
        type: 'POST',
        url: 'setorders.php',
        data: {
            cartItems: JSON.stringify(cart),
            grandTotal: grandTotal
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log('Order details saved successfully');
                // Add any additional logic or redirect the user as needed
            } else {
                console.error('Error saving order details:', response.message);
                // Handle error scenario
            }
        },
        error: function () {
            console.error('AJAX request to save_order.php failed');
            // Handle error scenario
        }
    });

    


    
    const cartItems = cart.map(item => `${item.name.split(' - ')[0]} - ${item.price.toFixed(2)}`);    Swal.fire({
            title: 'Purchase Successful!',
            html: `<p>Grand Total: ksh ${grandTotal.toFixed(2)}</p>
                   <p>Successfully Purchased Items:</p>
                   <ol style="text-align: left;">${cartItems.map(item => `<li>${item}</li>`).join('')}</ol>
                   `,
            icon: 'success',
            customClass: {
                popup: 'custom-popup-class', 
                icon: 'custom-icon-class'
            },
            width: '400px', // Adjust the width as needed
        });

            //alert('Loan application has been submitted successfully.\nGrand Total: ksh'+ grandTotal.toFixed(2));
            
            cart.length = 0;
            updateCart();

            
            
        }
        // Function to toggle the visibility of the cart dropdown
        function toggleCartDropdown() {
            const cartDropdown = document.getElementById('cart-dropdown');
            cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
        }
        function calculateinterest(){

        }

    </script>
</body>
</html>
