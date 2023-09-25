const cart = document.querySelector('.cart span');
const products = document.querySelectorAll('.product');
const cartProducts = document.querySelector('.cart-products table tbody');

const btnCheckout = document.querySelector('.btn-checkout');

function addProduct() {
  const pid = this.dataset.pid;
  const parent = this.parentNode;
  const productBody = parent.parentNode;

  const title = productBody.querySelector('.card-title').innerHTML;
  const price = parent.querySelector('.price').innerHTML;

  let prod = JSON.parse(localStorage.getItem('myCart')) || [];

  const item = {
    p_id: pid,
    title,
    quantity: 1,
    price,
  };

  let productExists = false;

  for (let i = 0; i < prod.length; i++) {
    if (prod[i]['p_id'] === pid) {
      prod[i]['quantity'] += 1;
      productExists = true;
      break;
    }
  }

  if (!productExists) {
    prod.push(item);
  }

  localStorage.setItem('myCart', JSON.stringify(prod));
  cart.textContent = ' ' + prod.length;

  // Log the add to cart action
  writeLog(`Added ${title} to the cart`);
}

function populate() {
  let prod = JSON.parse(localStorage.getItem('myCart')) || [];

  if (prod) cart.textContent = prod.length + ' ';

  if (!cartProducts || prod.length === 0) return;

  let total = 0;
  prod.forEach(function (el) {
    let t = el.price.split('').filter((a) => !isNaN(a)).join('');
    total += Number(t) * el.quantity;
  });

  cartProducts.innerHTML = '';

  prod.forEach(function (p) {
    const el = document.createElement('tr');
    el.innerHTML = `
            <th>${p.p_id}</th>
            <td>${p.title}</td>
            <td>${p.quantity}</td>
            <td>${p.price}</td>
        `;
    cartProducts.appendChild(el);
  });

  const totalContainer = document.createElement('div');
  totalContainer.style.fontSize = '1.2rem';
  totalContainer.textContent = `Total : $${total}`;

  const wrapper = document.querySelector('.wrapper');
  wrapper.insertBefore(totalContainer, btnCheckout);
}

function checkout() {
  localStorage.removeItem('myCart');

  cartProducts.innerHTML = '';
  cart.textContent = '0 ';

  // Log the checkout action
  writeLog('Checked out');
}

products.forEach(function (element) {
  btnAdd = element.querySelector('.buy-button');
  btnAdd.addEventListener('click', addProduct);
});

if (btnCheckout) {
  btnCheckout.addEventListener('click', checkout);
}

populate();
