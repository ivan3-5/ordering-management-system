<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ninong Ry's</title>
    <!-- Link to Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kotta+One&display=swap');

        body {
            background-color: #E4B279; 
            color: #3e2a47; 
            font-family: "Kotta One", sans-serif;
            font-size: large;
        }

        header {
            background-color: #6f4f1f;
            padding: 1rem;
        }

        header nav a {
            color: #f8f4e3;
            text-decoration: none;
            padding: 10px 15px;
            font-weight: bold;
        }

        header nav a:hover {
            background-color: #AC9361;
            color: #f8f4e3;
            outline: none; 
        }

        .about-us {
            padding: 3rem;
            background-color: #fff; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .about-us h1, .about-us h2 {
            color: #6f4f1f; 
        }

        .about-us ul li {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        footer {
            background-color: #6f4f1f; 
            color: #f8f4e3;
            text-align: center;
            padding: 1rem;
        }

        /* Style for the image boxes */
        .image-box {
            position: relative;
            width: 100%;
            padding-top: 100%;
            border: 2px solid #6f4f1f;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-box img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            border-radius: 10px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }


        @media (max-width: 768px) {
            .image-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .image-grid {
                grid-template-columns: 1fr;
            }
        }


        .image-name {
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            color: #f8f4e3;
            background-color: rgba(0, 0, 0, 0.6); 
            padding: 5px;
            border-radius: 5px;
        }

        .image-name:hover {
            background-color: rgba(0, 0, 0, 0.8); 
        }
    </style>
</head>
<body>

    <header>
        <nav class="d-flex justify-content-center">
            <a href="homepage.php">Home</a>
            <a href="MenuList (1).php">Menu</a>
        </nav>
    </header>

    <main class="container my-5">
        <section class="about-us">
            <h1>About Us</h1>
            <p>Welcome to <strong>Ninong Ry's</strong>, where every cup is crafted with care and passion. We specialize in serving high-quality coffees and freshly baked pastries that bring comfort and joy with every bite and sip.</p>

            <p>At <strong>Ninong Ry's</strong>, we believe that coffee is not just a drink, but an experience. Our beans are carefully selected, roasted to perfection, and brewed just the way you love. Whether you enjoy a bold espresso, a creamy cappuccino, or a smooth cold brew, we’ve got something to satisfy your every coffee craving.</p>

            <p>In addition to our coffee, we offer a range of delicious pastries, from buttery croissants to rich cakes and cookies. Each treat is freshly baked in-house to pair perfectly with your favorite brew.</p>

            <p>Our mission is to create a warm and inviting atmosphere where friends, families, and colleagues can come together to enjoy great coffee, delightful pastries, and good conversation. We are passionate about making every visit to <strong>Ninong Ry's</strong> a special experience, whether you're grabbing a quick coffee to go or settling in for a relaxing break.</p>

            <h2>Meet the Team</h2>
            <div class="image-grid">
                <div class="image-box">
                    <img src="https://i.mydramalist.com/4e08N6_5f.jpg" alt="Friend 1">
                    <div class="image-name">Kyla Samson</div>
                </div>
                <div class="image-box">
                    <img src="https://scontent.fdvo2-2.fna.fbcdn.net/v/t39.30808-6/451714270_1686283265474872_5332516603744044174_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeEA8D5ZQF7aKTFz22su975r0pBJ0EvsePbSkEnQS-x49tib7v2ZZPfPSwvje-Vetoepa5MiKuZs9XeI1Tw35lvK&_nc_ohc=cxDxb9Xs0soQ7kNvgHI2fBd&_nc_zt=23&_nc_ht=scontent.fdvo2-2.fna&_nc_gid=AA_0tHyAPg8Z9u5Zbo8Zq99&oh=00_AYD7_q5VbTx2tAzZzrr5aN98BpAHMFBpO5rhiVnmEy36zA&oe=676338FB" alt="Friend 2">
                    <div class="image-name">Jose Agbas</div>
                </div>
                <div class="image-box">
                    <img src="https://scontent.fdvo2-1.fna.fbcdn.net/v/t39.30808-6/448869558_1921468548311260_133757006781767697_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFX2_pQ1Dk0H3Jt2nriMfz5CI4G6eKjw5sIjgbp4qPDm4TgyZrOhaXbAdePATPZvf89ll2g69k4V9IGyUGNfTaU&_nc_ohc=XTyk9pd-__YQ7kNvgGvCWzP&_nc_zt=23&_nc_ht=scontent.fdvo2-1.fna&_nc_gid=AiH6bm3xYm3LUn5S6EsT753&oh=00_AYCxd3Jq2aTCaAUVHENNXoLgrbGIDPUYQR3M1ZUe9vG21g&oe=67631C6F" alt="Friend 3">
                    <div class="image-name">Ivan Adcan</div>
                </div>
                <div class="image-box">
                    <img src="https://scontent.fdvo2-1.fna.fbcdn.net/v/t1.6435-9/55783908_304967350176837_1171587496899772416_n.jpg?stp=dst-jpg_s206x206_tt6&_nc_cat=108&ccb=1-7&_nc_sid=fe5ecc&_nc_eui2=AeF84uV3QeXyi0fegGRo0igPQqwFwiHqLyFCrAXCIeovIR76TEClwp683r0uI34FtX3wLoVqlBm6bYZUur6WZqD9&_nc_ohc=Zv6S4gO7d5kQ7kNvgFvkGtu&_nc_zt=23&_nc_ht=scontent.fdvo2-1.fna&_nc_gid=ASEuzXempz7IjkaBK0OYRRv&oh=00_AYAZlkwKdOQaASYXlWPRVwEUAOIo11_Ef5naOp4KTotaRA&oe=6784C30A" alt="Friend 4">
                    <div class="image-name">Sylver Fuentes</div>
                </div>
                <div class="image-box">
                    <img src="https://scontent.fdvo2-2.fna.fbcdn.net/v/t39.30808-6/463964802_9121328864566244_3820922542396607233_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeFSXzULhKOol8IFwUvMgyCI2XmrH1TfmPDZeasfVN-Y8Nu01mpiM7YfRH3KzWfL1sa6TDPdlV_m8dsShFKRRjHA&_nc_ohc=kVeSZ9bqS7UQ7kNvgHZ1ACz&_nc_zt=23&_nc_ht=scontent.fdvo2-2.fna&_nc_gid=Azofysi9o62q0BrERA-04cU&oh=00_AYCzFDGGjmXwMmP_cw4rq1NL8RV882hMPbcJfaNa7jK2-g&oe=67632488" alt="Friend 5">
                    <div class="image-name">Christian Jericho Loquillano</div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Ninong Ry's. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
