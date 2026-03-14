<?php
session_start();
include "db.php";

if (!isset($_SESSION['last_order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = intval($_SESSION['last_order_id']);

$query = mysqli_query($conn, "SELECT total_price FROM orders WHERE id=$order_id");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Order not found");
}

$order = mysqli_fetch_assoc($query);
$total = floatval($order['total_price']);
?>
<style>
/* Override default nav background for this page */
.navbar { position: relative; }
body{
  margin:0;
  font-family: Arial, sans-serif;
  background:#000;
  padding-top: 0;
  color:#fff;
}

.overlay{
  height:calc(100vh - 80px); /* Adjust for navbar */
  display:flex;
  align-items:center;
  justify-content:center;
}

.box{
  width:1000px;
  height:560px;
  background:#111;
  border-radius:20px;
  box-shadow:0 20px 60px rgba(0,0,0,0.8);
  display:flex;
  overflow:hidden;
  position:relative;
  border: 1px solid #333;
}

/* LEFT */
.left{
  width:35%;
  background:linear-gradient(135deg,#0a1128,#162447);
  color:#fff;
  padding:50px 40px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  border-right: 1px solid #222;
}

.left h2{
  font-size:28px;
  margin-bottom:25px;
  letter-spacing:1px;
}

.left div > div:nth-child(2){
  color:#aaa;
  font-size:15px;
  margin-bottom:5px;
  text-transform:uppercase;
  letter-spacing:1px;
}

.left > div:last-child{
  color:#888;
  font-size:14px;
  display:flex;
  align-items:center;
  gap:8px;
}

.left > div:last-child::before{
  content:'🔒';
  font-size:18px;
}

.price{
  font-size:38px;
  font-weight:bold;
  color:#00ff88;
}

/* RIGHT */
.right{
  width:65%;
  display:flex;
}

/* MENU */
.menu{
  width:32%;
  background:#151515;
  padding:30px 20px;
  border-right:1px solid #222;
}

.menu div{
  padding:16px;
  border-radius:10px;
  margin-bottom:12px;
  cursor:pointer;
  color:#aaa;
  font-weight:500;
  transition:all 0.3s ease;
}

.menu div.active{
  background:#222;
  color:#fff;
  box-shadow:0 4px 15px rgba(0,0,0,0.4);
  border-left:4px solid #007AFF;
}

.menu div:hover:not(.active){
  background:#1a1a1a;
  color:#ddd;
}

/* CONTENT */
.content{
  width:68%;
  padding:40px;
  position:relative;
}

.timer{
  text-align:right;
  font-size:13px;
  color:#777;
  margin-bottom:25px;
}

#time{
  color:#ff4a4a;
  font-weight:bold;
}

/* QR */
.qr-box{
  background:#000;
  padding:30px;
  border-radius:16px;
  text-align:center;
  margin-top:10px;
  border:1px dashed #444;
}

.qr-box p{
  color:#aaa;
  margin-top:15px;
  font-size:14px;
}

.qr-box img{
  width:160px;
  border-radius:8px;
  padding:10px;
  background:#fff;
}

/* INPUTS */
input, select{
  width:100%;
  padding:16px;
  margin-top:15px;
  background:#000;
  color:#fff;
  border:1px solid #333;
  border-radius:10px;
  font-size:15px;
  transition:all 0.3s;
  box-sizing:border-box;
}

input:focus, select:focus{
  border-color:#007AFF;
  outline:none;
  box-shadow:0 0 0 3px rgba(0,122,255,0.2);
}

input::placeholder{
  color:#666;
}

select {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 15px center;
  background-size: 15px;
}

button{
  margin-top:30px;
  width:100%;
  padding:18px;
  background:#007AFF;
  color:#fff;
  border:none;
  border-radius:10px;
  font-weight:bold;
  font-size:16px;
  cursor:pointer;
  transition:all 0.3s;
  text-transform:uppercase;
  letter-spacing:1px;
}

button:hover{
  background:#005bb5;
  transform:translateY(-2px);
  box-shadow:0 8px 20px rgba(0,122,255,0.3);
}

.loader{
  display:none;
  margin-top:20px;
  text-align:center;
  font-weight:bold;
  color:#007AFF;
  font-size:15px;
}

.success{
  display:none;
  position:absolute;
  top:0; left:0;
  width:100%;
  height:100%;
  background:rgba(0,255,136,0.95);
  color:#000;
  align-items:center;
  justify-content:center;
  flex-direction:column;
  font-size:28px;
  font-weight:bold;
  z-index:10;
  backdrop-filter:blur(5px);
}
</style>
<?php include 'includes/header.php'; ?>

<div class="overlay" style="margin-top: 4rem; margin-bottom: 2rem;">
<div class="box" id="box">

<div class="left">
  <div>
    <h2>KickZone</h2>
    <div>Price Summary</div>
    <div class="price">₹<?php echo $total; ?></div>
  </div>
  <div>Secured Payment</div>
</div>

<div class="right">

<div class="menu">
  <div class="active" onclick="showTab('upi',this)">UPI</div>
  <div onclick="showTab('card',this)">Cards</div>
  <div onclick="showTab('netbanking',this)">Netbanking</div>
  <div onclick="showTab('wallet',this)">Wallet</div>
</div>

<div class="content">

<div class="timer">Session expires in <span id="time">10:00</span></div>

<!-- UPI -->
<div id="upi">
  <div class="qr-box">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=kickzone@upi">
    <p>Scan QR or Enter UPI ID</p>
  </div>
  <input type="text" placeholder="Enter UPI ID (example@upi)">
</div>

<!-- CARD -->
<div id="card" style="display:none;">
  <input type="text" placeholder="Card Number">
  <input type="text" placeholder="MM/YY">
  <input type="text" placeholder="CVV">
</div>

<!-- NETBANKING -->
<div id="netbanking" style="display:none;">
  <select>
    <option>Select Bank</option>
    <option>SBI</option>
    <option>HDFC</option>
    <option>ICICI</option>
  </select>
</div>

<!-- WALLET -->
<div id="wallet" style="display:none;">
  <select>
    <option>Select Wallet</option>
    <option>Paytm</option>
    <option>PhonePe</option>
    <option>Amazon Pay</option>
  </select>
</div>

<button onclick="processPayment()">Pay ₹<?php echo $total; ?></button>

<div class="loader" id="loader">Processing Payment...</div>

</div>
</div>

<div class="success" id="success">
✔ Payment Successful<br><br>
Redirecting...
</div>

</div>
</div>

<script>

/* TAB SWITCH */
let currentTab = 'upi';

function showTab(tab,el){
  currentTab = tab;
  document.querySelectorAll('.menu div').forEach(x=>x.classList.remove('active'));
  el.classList.add('active');

  document.getElementById('upi').style.display='none';
  document.getElementById('card').style.display='none';
  document.getElementById('netbanking').style.display='none';
  document.getElementById('wallet').style.display='none';

  document.getElementById(tab).style.display='block';
}

/* TIMER */
let minutes = 10;
let seconds = 0;

let timer = setInterval(function(){
  if(seconds==0){
    if(minutes==0){
      clearInterval(timer);
      alert("Session expired!");
      window.location.href="checkout.php";
    }
    minutes--;
    seconds=59;
  } else {
    seconds--;
  }

  document.getElementById("time").innerHTML =
    minutes + ":" + (seconds<10 ? "0"+seconds : seconds);

},1000);

/* FAKE PROCESS */
function processPayment(){
  let isValid = false;
  
  if (currentTab === 'upi') {
    let upiInput = document.querySelector('#upi input').value.trim();
    if (upiInput !== '') isValid = true;
  } else if (currentTab === 'card') {
    let inputs = document.querySelectorAll('#card input');
    if (inputs[0].value.trim() !== '' && inputs[1].value.trim() !== '' && inputs[2].value.trim() !== '') {
      isValid = true;
    }
  } else if (currentTab === 'netbanking') {
    let select = document.querySelector('#netbanking select').value;
    if (select !== 'Select Bank') isValid = true;
  } else if (currentTab === 'wallet') {
    let select = document.querySelector('#wallet select').value;
    if (select !== 'Select Wallet') isValid = true;
  }
  
  if (!isValid) {
    alert("Please fill in the required payment details for the selected method.");
    return;
  }

  document.getElementById("loader").style.display="block";

  setTimeout(()=>{
    document.getElementById("success").style.display="flex";
    setTimeout(()=>{
     window.location.href="payment_success.php?order=<?php echo $order_id; ?>";
    },2000);
  },2000);
}

</script>

<?php include 'includes/footer.php'; ?>