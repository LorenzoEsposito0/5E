<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vetrina Elettronica</title>
    <link rel="stylesheet" href="styles.css"> <!-- Collega il file CSS per la stilizzazione -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: white;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #0779e4 1px solid;
        }
        header a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header a:hover {
            background: #0779e4;
            transition: 0.3s;
        }
        .product {
            display: inline-block;
            width: 24%;
            margin: 1%;
            background-color: white;
            border: 1px solid #ddd;
            box-sizing: border-box;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }
        .product img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
        }
        .product h3 {
            color: #333;
        }
        .product p {
            color: #555;
        }
        .product .price {
            color: #e67e22;
            font-weight: bold;
        }
        .d-flex {
            display: flex;
        }
        .ms-auto {
            margin-left: auto;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>Benvenuto nella Vetrina di Elettronica</h1>
        <div class="d-flex ms-auto align-items-center" style="margin-right: 220px">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="me-3">Ciao <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Utente'); ?>!</span>
                <div class="cart-icon me-3" id="cartToggle">
                    <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                <a href="php/logout.php" class="btn btn-outline-danger">Logout</a>
            <?php else: ?>
                <span class="me-3">Sessione non trovata!</span>
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="container">
    <h2>Scopri i nostri prodotti</h2>
    <div class="products">
        <!-- Prodotto 1 -->
        <div class="product">
            <img src="Img/Samsung.webp" alt="Smartphone Samsung Galaxy S23">
            <h3>Smartphone Samsung Galaxy S23</h3>
            <p>Quantità disponibile: 50</p>
            <p class="price">€ 799.99</p>
        </div>

        <!-- Prodotto 2 -->
        <div class="product">
            <img src="Img/PCsamsung.webp" alt="Laptop HP Pavilion">
            <h3>Laptop HP Pavilion</h3>
            <p>Quantità disponibile: 30</p>
            <p class="price">€ 899.99</p>
        </div>

        <!-- Prodotto 3 -->
        <div class="product">
            <img src="Img/Smartwatch%20Apple%20Watch%20Series%208.webp" alt="Smartwatch Apple Watch Series 8">
            <h3>Smartwatch Apple Watch Series 8</h3>
            <p>Quantità disponibile: 60</p>
            <p class="price">€ 399.99</p>
        </div>

        <!-- Prodotto 4 -->
        <div class="product">
            <img src="Img/TvSony.webp" alt="TV 4K Sony Bravia">
            <h3>TV 4K Sony Bravia</h3>
            <p>Quantità disponibile: 20</p>
            <p class="price">€ 1299.99</p>
        </div>

        <!-- Prodotto 5 -->
        <div class="product">
            <img src="Img/CuffieBose.webp" alt="Cuffie Bose QuietComfort 45">
            <h3>Cuffie Bose QuietComfort 45</h3>
            <p>Quantità disponibile: 100</p>
            <p class="price">€ 349.99</p>
        </div>

        <!-- Prodotto 6 -->
        <div class="product">
            <img src="Img/Ipad.webp" alt="Tablet Apple iPad Air">
            <h3>Tablet Apple iPad Air</h3>
            <p>Quantità disponibile: 70</p>
            <p class="price">€ 599.99</p>
        </div>

        <!-- Prodotto 7 -->
        <div class="product">
            <img src="Img/Fotocamera.webp" alt="Fotocamera Canon EOS R5">
            <h3>Fotocamera Canon EOS R5</h3>
            <p>Quantità disponibile: 15</p>
            <p class="price">€ 3899.99</p>
        </div>

        <!-- Prodotto 8 -->
        <div class="product">
            <img src="Img/EchoDot.webp" alt="Echo Dot 5a Generazione">
            <h3>Echo Dot 5a Generazione</h3>
            <p>Quantità disponibile: 200</p>
            <p class="price">€ 59.99</p>
        </div>

        <!-- Prodotto 9 -->
        <div class="product">
            <img src="Img/Drone.webp" alt="Drone DJI Air 2S">
            <h3>Drone DJI Air 2S</h3>
            <p>Quantità disponibile: 40</p>
            <p class="price">€ 999.99</p>
        </div>

        <!-- Prodotto 10 -->
        <div class="product">
            <img src="Img/10.webp" alt="Console Playstation 5">
            <h3>Console Playstation 5</h3>
            <p>Quantità disponibile: 80</p>
            <p class="price">€ 499.99</p>
        </div>
    </div>
</div>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="php/login.php">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="php/register.php">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="registerName" name="registerName" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="registerEmail" name="registerEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="registerPassword" name="registerPassword" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts di Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
