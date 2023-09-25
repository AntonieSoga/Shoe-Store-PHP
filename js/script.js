const applyFiltersBtn = document.querySelector('#applyFilters');
const priceRange1 = document.querySelector('#priceRange1');
const priceRange2 = document.querySelector('#priceRange2');
const sortByPrice = document.querySelector('#sortByPrice');
const filterByBrand = document.querySelector('#filterByBrand');

applyFiltersBtn.addEventListener('click', () => {
  mainSection.innerHTML = '';
  let match = false;
  products.forEach(product => {
    let price = parseFloat(product.querySelector('.price').innerText);
    let brand = product.querySelector('.card-text').innerText.toLowerCase();
    if (price >= Math.min(priceRange1.value, priceRange2.value) && price <= Math.max(priceRange1.value, priceRange2.value)
      && (filterByBrand.value === '' || brand === filterByBrand.value.toLowerCase())) {
      mainSection.appendChild(product)
      match = true;
    }
  });
  if (!match) {
    mainSection.innerHTML = '<div class="d-flex mx-auto"><h3 class="text-danger text-center">No products match the selected filters</h3></div>';
  } else if (sortByPrice.value === 'asc' || sortByPrice.value === 'desc') {
    let sortedProducts = Array.from(mainSection.children);
    sortedProducts.sort((a, b) => {
      let priceA = parseFloat(a.querySelector('.price').innerText);
      let priceB = parseFloat(b.querySelector('.price').innerText);
      return sortByPrice.value === 'asc' ? priceA - priceB : priceB - priceA;
    });
    mainSection.innerHTML = '';
    sortedProducts.forEach(product => mainSection.appendChild(product));
  }
});
