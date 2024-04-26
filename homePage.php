<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 50px auto 0; /* Added top margin of 40px */
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.mainImageContainer {
    text-align: center;
    margin-bottom: 40px;
}

.mainImageContainer img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.mainImageContainer h1 {
    margin-top: 20px;
    font-size: 36px;
    font-weight: 500;
    color: #f5f5dc; /* Off-white color for the "Weng's Mama's" text */
}

#about-us {
    text-align: center;
    margin-bottom: 40px;
}

#about-us h2 {
    font-size: 28px;
    font-weight: 500;
    color: #333;
    margin-bottom: 20px;
}

#about-us p {
    line-height: 1.6;
    color: #555;
}

footer {
    text-align: center;
    margin-top: 40px;
}

footer h2 {
    font-size: 24px;
    font-weight: 500;
    color: #333;
    margin-bottom: 20px;
}

.social-icons {
    display: flex;
    justify-content: center;
    align-items: center;
}

.social-icons a {
    margin: 0 10px;
    transition: transform 0.3s ease-in-out;
}

.social-icons a:hover {
    transform: scale(1.2);
}
</style>

<body>
    <?php
    session_start();
    include "navigationPanel.php";
    ?>
    <div class="container">
        <div class="mainImageContainer">
            <img src="default images/homePage.jpg" alt="Home Page Food">
            <h1>Weng's Mama's</h1>
        </div>
        <section id="about-us">
            <h2>About Us</h2>
            <p>Weng's Mama's celebrates the harmonious fusion of Malay and Chinese cuisines, born from Weng's profound love for his mother's cooking. Her home-cooked meals blending bold Malay spices with Chinese techniques blossomed into this cozy restaurant. Each bite connects cultures, showcasing food's power to unite. Join us on this delectable cross-cultural journey honoring Weng's culinary heritage.</p>
        </section>
        <footer>
            <h2>Follow us on social media</h2>
            <div class="social-icons">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="icons/instagram-icon.png" alt="Instagram Icon" width="50" height="50">
                </a>
                <a href="https://www.facebook.com" target="_blank">
                    <img src="icons/facebook-icon.png" alt="Facebook Icon" width="50" height="50">
                </a>
            </div>
        </footer>
    </div>
</body>
</html>