<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    
    <?php 
        session_start(); 
        include "navigationPanel.php";
    ?>


    <div class="mainImageContainer">
            <img src="default images/homePage.jpg" alt="Home Page Food">
            <h1>Weng's Mama's</h1>
    </div>
    
    <section id="about-us" style="text-align: center;">
        <h2>About Us</h2>
        <p>Weng's Mama's celebrates the harmonious fusion of Malay and Chinese cuisines, born from Weng's profound love for his mother's cooking. Her home-cooked meals blending bold Malay spices with Chinese techniques blossomed into this cozy restaurant. Each bite connects cultures, showcasing food's power to unite. Join us on this delectable cross-cultural journey honoring Weng's culinary heritage.</p>
    </section>

    <footer style="text-align: center;">
        <h2>Follow us on social media</h2>
            <a href="https://www.instagram.com" target="_blank">
                <img src="icons/instagram-icon.png" alt="Instagram Icon" width="50" height="50">
            </a>

            <a href="https://www.facebook.com" target="_blank">
                <img src="icons/facebook-icon.png" alt="Facebook Icon" width="50" height="50">
            </a>
    </footer>
    
  

</body>
</html>