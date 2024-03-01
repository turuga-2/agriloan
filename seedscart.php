<?php include "config/databaseconfig.php";
session_start();



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
 
            <script>

        let cartTotal = 0;
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

        
        function checkout() {
            $.ajax({
        url: 'setorders.php', // Replace with the actual server-side script
        method: 'POST',
        data: { cartTotal: cartTotal},
        success: function(response) {
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

            cart.length = 0;
            updateCart();
        }
        

        function toggleCartDropdown() {
            const cartDropdown = document.getElementById('cart-dropdown');
            cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
        }

    </script>
    
</body>
</html>

