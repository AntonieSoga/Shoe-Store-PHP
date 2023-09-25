// SEARCH section
const searchItem = document.querySelector('#searchInput');
const searchBtn = document.querySelector('button#searchBtn');
// const products = document.querySelectorAll('.product');
const mainSection = document.querySelector('.main-section');
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
}

searchBtn.addEventListener('click', search)

document.addEventListener('keyup', (e) => {
	if (e.keyCode !== 13) return;
	let isFocused = (document.activeElement === searchItem)
	if (isFocused) {
		this.search()
	}
});
// end of search