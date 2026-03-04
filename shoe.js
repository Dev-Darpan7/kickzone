function addToCart(name) {
  const note = document.createElement("div");
  note.className = "notification";
  note.innerText = name + " added to cart!";
  document.body.appendChild(note);
  setTimeout(() => note.remove(), 2500);
}
