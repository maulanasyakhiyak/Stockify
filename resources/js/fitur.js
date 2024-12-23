class searchAutocomplete {
    constructor(ele, options={},table) {
        this.inputEle = ele
        this.resultTarget = $(`#${this.inputEle.data('search-result-target')}`)
        this.exceptSearch = [];
        this.options = options;
        this.itemClickHandler = null; // Properti untuk menyimpan handler klik item
        this.init()
    }
    init() {
        this.inputEle.on('input', () => {
            // console.log(this.inputEle.val());
            var term = this.inputEle.val()
            if (term.length < 2) {
                $(this.resultTarget).empty(); // Mengosongkan hasil jika input kurang dari 2 karakter
                return;
            }
            this.sendToDb(term)
        })
    }

    sendToDb(term) {
        $.ajax({
            url: "/admin/simple-search",
            dataType: "json",
            data: {
                table: "2d2d2c4b9e1d2f6f2bcd345b223ee6d4",
                term: term,
            },
            success: (data) => {
                if (data.debuging) {
                    console.log(data.debuging);
                }

                this.resultTarget.empty();

                // Mengecek apakah ada data yang dikembalikan
                if (data.data && data.data.length > 0) {
                    this.renderResult(data)
                } else {
                    console.log("No results found");
                }
            },
            error: () => {
                console.log("Error during AJAX request");
            },
        });
    }

    renderResult(data) {
        var results = data.data.map((item) => {
            if (!this.exceptSearch.includes(item.id)) {
                return `
                              <li data-autocomplete-item="${this.resultTarget.data('search-result-target')}" data-autocomplete-id="${item.id}" data-autocomplete-name="${item.name}" data-autocomplete-sku="${item.sku}"
                                  class="p-2 bg-white hover:bg-blue-300 cursor-pointer dark:text-gray-300 dark:hover:bg-gray-700 flex justify-between">
                                  ${item.name} <span>${item.sku}</span>
                              </li>
                          `;
            }
        });

        // Menambahkan hasil ke dalam ul
        this.resultTarget.append(results.join(""));

        // Menampilkan hasil
        this.resultTarget.show();

        if (this.itemClickHandler) {
            this.resultTarget.find('li').on('click', (event) => {

                const clickedItem = $(event.currentTarget);
                const itemData = {
                    id: clickedItem.data('autocomplete-id'),
                    name: clickedItem.data('autocomplete-name'),
                    sku: clickedItem.data('autocomplete-sku')
                };
                if (this.options.addExcept) {
                    this.exceptSearch.push(itemData.id);
                }
                this.itemClickHandler(itemData);
                this.resultTarget.empty().hide()
            });
        }

    }

    itemOnClick(callback) {
        this.itemClickHandler = callback;
    }

    removeExceptSearch(id) {
        this.exceptSearch = this.exceptSearch.filter((index) => index !== id);
    }
}



export default searchAutocomplete
