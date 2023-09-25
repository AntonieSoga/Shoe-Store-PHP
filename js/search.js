// SEARCH section
const searchItem = document.querySelector('#searchInput');
const searchBtn = document.querySelector('button#searchBtn');
// const products = document.querySelectorAll('.product');
const mainSection = document.querySelector('.main-section');
const filterBtn = document.querySelector('#filterBtn');
const priceLow = document.querySelector('#priceLow');
const priceHigh = document.querySelector('#priceHigh');
const sortOrder = document.querySelector('#sortOrder');
const brandFilter = document.querySelector('#brandFilter');
function search() {
	// console.log('hello', products);
	if (!searchItem.value) return;
	mainSection.innerHTML = '';
	let match = false;
	products.forEach(product => {
		let title = product.querySelector('.card-title').innerText.toLowerCase();
		if (title.includes(searchItem.value.toLowerCase())) {
			mainSection.appendChild(product)
			match = true;
		}
	});
	if (!match) {
		mainSection.innerHTML = `
		<div class="d-flex mx-auto">
			<h3 class="text-danger text-center">No '${searchItem.value}' Found</h3>
			</div>`;
	}
	writeLog(`Searched for: ${searchItem.value}`);
}

filterBtn.addEventListener('click', function() {
    const request = new XMLHttpRequest();
    request.open("POST","fetch_products.php", true);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.onreadystatechange = function() {
		if(this.readyState === 4 && this.status === 200) {
			mainSection.innerHTML = this.responseText;
		}
	};
	
	const params = `lowPrice=${priceLow.value}&highPrice=${priceHigh.value}&sortOrder=${sortOrder.value}&brandFilter=${brandFilter.value}`;
	request.send(params);
});



searchBtn.addEventListener('click', search)

document.addEventListener('keyup', (e) => {
	if (e.keyCode !== 13) return;
	let isFocused = (document.activeElement === searchItem)
	if (isFocused) {
		this.search()
	}
});
// end of search