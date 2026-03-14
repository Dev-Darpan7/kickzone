<!-- FOOTER -->
<footer class="footer">
<div class="footer-container">

<div class="footer-section">
<h3>KickZone</h3>
<p>Premium footwear for style and comfort. Walk with confidence.</p>
</div>

<div class="footer-section">
<h4>Quick Links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="register.php">Register</a></li>
</ul>
</div>

<div class="footer-section">
<h4>Contact</h4>
<p>Email: support@kickzone.com</p>
<p>Phone: +91 98765 43210</p>
<p>Location: Mumbai, India</p>
</div>

</div>

<div class="footer-bottom">
<p>© <?php echo date("Y"); ?> KickZone. All rights reserved.</p>
</div>
</footer>
<script>
function toggleMenu(){
const menu = document.querySelector(".nav-menu");
const burger = document.querySelector(".hamburger");
if(menu && burger) {
    menu.classList.toggle("active");
    burger.classList.toggle("active");
}
}
</script>

</body>
</html>
