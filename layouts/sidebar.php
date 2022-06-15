<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat&family=Roboto&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.sidebar {
    position: fixed;
    width: 250px;
    height: 100%;
    left: 0;
    background: #fff;
    margin-top: 100px;
}

nav ul {
    background: #fff;
    height: 100%;
    width: 100%;
    list-style: none;
}

nav ul li a {
    position: relative;
    color: red;
    text-decoration: none;
    font-size: 35px;
    padding-left: 18px;
    padding-top: 8px;
    padding-bottom: 8px;
    display: block;
    width: 100%;
    border-left: 3px solid transparent;
}

nav ul li.active a {
    color: #fff;
    background: linear-gradient(yellow, red);
    border-left-color: #8a52fe;
}

nav ul li a:hover {
    background: linear-gradient(yellow, red);
    color: #fff;
}

nav ul ul {
    position: static;
    display: none;
}

nav ul .first-show.show {
    display: block;
}

nav ul .sec-show.show1 {
    display: block;
}

nav ul .third-show.show2 {
    display: block;
}

nav ul ul li {
    border-top: none;
}

nav ul ul li a {
    font-size: 30px;
    color: red;
    background: white;
    padding-left: 28px;
    padding-top: 8px;
    padding-bottom: 8px;
}

nav ul li.active ul li a {
    color: red;
    background: white;
    border-left-color: transparent;
}

nav ul li.active ul li.active a {
    color: #fff;
    background: linear-gradient(yellow, red);
    border-left-color: white;
}

nav ul ul li a:hover {
    color: #fff !important;
    background: linear-gradient(yellow, red) !important;
}

.title {
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-left: 20px;
    height: 100px;
    background-color: #FFB54B;
    font-size: 35px;
    border-bottom: 1px solid black;
    width: 100vw;
    position: fixed;
    font-family: 'Bebas Neue';
    letter-spacing: 1rem;
    background-image: linear-gradient(yellow, red);
    color: #fff;
}

.contents {
    margin-left: 300px;
    padding-top: 80px;
}

.main-contents {
    padding: 3%;
}
</style>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<div class="title">
    <div class="main">
        <h1>Lemon Squeeze</h1>
    </div>
</div>
<nav class="sidebar">
    <ul>
        <li class="<?= get_filename('home.php') ? 'active' : '' ?>">
            <a href="home.php" class="home-btn">Home</a>
        </li>
        <li class="<?= get_filename('products-manage.php') || get_filename('products-create.php') ? 'active' : '' ?>">
            <a href="#" class="first-btn">Products</a>
            <ul
                class="first-show <?= get_filename('products-manage.php') || get_filename('products-create.php') ? 'show' : '' ?>">
                <li class="<?= get_filename('products-manage.php') ? 'active' : '' ?>"><a
                        href="products-manage.php">-Manage Products</a></li>
                <li class="<?= get_filename('products-create.php') ? 'active' : '' ?>"><a
                        href="products-create.php">-Add Products</a></li>
            </ul>
        </li>
        <li class="<?= get_filename('sales-manage.php') || get_filename('sales-create.php') ? 'active' : '' ?>">
            <a href="#" class="sec-btn">Sales</a>
            <ul
                class="sec-show <?= get_filename('sales-manage.php') || get_filename('sales-create.php') ? 'show1' : '' ?>">
                <li class="<?= get_filename('sales-manage.php') ? 'active' : '' ?>"><a href="sales-manage.php">-Manage
                        Sales</a></li>
                <li class="<?= get_filename('sales-create.php') ? 'active' : '' ?>"><a href="sales-create.php">-Add
                        Sales</a></li>
            </ul>
        </li>
        <li class="<?= get_filename('sales-report.php') ? 'active' : '' ?>">
            <a href="#" class="third-btn ">Sales
                Report</a>
            <ul class="third-show <?= get_filename('sales-report.php') ? 'show2' : '' ?>">
                <li class="<?= get_filename('sales-report.php') ? 'active' : '' ?>"><a href="sales-report.php">-Sales by
                        Date</a></li>
            </ul>
        </li>
        <li>
            <a href="logout.php" class="home-btn">Logout</a>
        </li>
    </ul>
</nav>

<script>
$('.first-btn').click(function() {
    $('nav ul .first-show').toggleClass("show");
});
$('.sec-btn').click(function() {
    $('nav ul .sec-show').toggleClass("show1");
});
$('.third-btn').click(function() {
    $('nav ul .third-show').toggleClass("show2");
});
$('nav ul li').click(function() {
    $(this).addClass("active").siblings().removeClass("active");
});
</script>