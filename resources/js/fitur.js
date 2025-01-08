import { Dropdown } from "flowbite";
import { Datepicker } from "flowbite-datepicker";
import { DateRangePicker } from "flowbite-datepicker";

export class searchAutocomplete {
  constructor(ele, options = {}, table) {
    this.inputEle = ele;
    this.resultTarget = $(`#${this.inputEle.data("search-result-target")}`);
    this.exceptSearch = [];
    this.options = options;
    this.itemClickHandler = null; // Properti untuk menyimpan handler klik item
    this.init();
  }
  init() {
    this.inputEle.on("input", () => {
      // console.log(this.inputEle.val());
      var term = this.inputEle.val();
      if (term.length < 2) {
        $(this.resultTarget).empty(); // Mengosongkan hasil jika input kurang dari 2 karakter
        return;
      }
      this.sendToDb(term);
    });
  }

  sendToDb(term) {
    console.log(this.options.searching);

    let by = ["name", "sku"].includes(this.options.searching)
      ? this.options.searching
      : "name";
    $.ajax({
      url: "/admin/simple-search",
      dataType: "json",
      data: {
        table: "2d2d2c4b9e1d2f6f2bcd345b223ee6d4",
        search: by,
        term: term,
      },
      success: (data) => {
        if (data.debuging) {
          console.log(data.data);
        }

        this.resultTarget.empty();

        // Mengecek apakah ada data yang dikembalikan
        if (data.data && data.data.length > 0) {
          this.renderResult(data);
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
                              <li data-autocomplete-item="${this.resultTarget.data(
                                "search-result-target"
                              )}" data-autocomplete-id="${
          item.id
        }" data-autocomplete-name="${item.name}" data-autocomplete-sku="${
          item.sku
        }"
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
      this.resultTarget.find("li").on("click", (event) => {
        const clickedItem = $(event.currentTarget);
        const itemData = {
          id: clickedItem.data("autocomplete-id"),
          name: clickedItem.data("autocomplete-name"),
          sku: clickedItem.data("autocomplete-sku"),
        };
        if (this.options.addExcept) {
          this.exceptSearch.push(itemData.id);
        }
        this.itemClickHandler(itemData);
        this.resultTarget.empty().hide();
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

export class ImagePreview {
  constructor(element) {
    this.element = element;
    this.target = $(element).attr("data-preview-target");
    this.targetElement = $(`[data-preview=${this.target}]`);
    this.currentImage = this.targetElement.attr("src");
    this.reader = new FileReader();
    this.init();
  }

  init() {
    this.element.on("change", (event) => {
      const files = event.target.files;
      if (files && files[0]) {
        this.reader.onload = (e) => {
          this.targetElement.attr("src", e.target.result);
        };
        this.reader.readAsDataURL(files[0]);
      } else {
        this.targetElement.attr("src", this.currentImage);
      }
    });
  }
}

export class trackingForm {
  constructor(elements) {
    this.elements = elements;
    this.initialValues = {};
    this.currentValues = {};
    this.changed = false;
    this.trackingCallback = null;
    this.init();
  }
  init() {
    this.elements.forEach((element) => {
      if (element.attr("type") === "file") {
        this.currentValues[element.attr("id")] = element[0].files[0]; // Mengambil daftar file
      } else {
        this.currentValues[element.attr("id")] = element.val();
      }
      this.initialValues[element.attr("id")] = this.currentValues[
        element.attr("id")
      ];
      element.on("change input", () => {
        if (element.attr("type") === "file") {
          this.initialValues[element.attr("id")] = element[0].files[0]; // Mengambil daftar file
        } else {
          this.initialValues[element.attr("id")] = element.val();
        }
        this.isChanged();
        this.triggerTrackingCallback();
      });
    });
  }

  isChanged() {
    if (
      JSON.stringify(this.initialValues) !== JSON.stringify(this.currentValues)
    ) {
      this.changed = true;
    } else {
      this.changed = false;
    }
  }

  getValue() {
    return this.initialValues;
  }

  tracking(callback) {
    this.trackingCallback = callback;
    return this;
  }

  triggerTrackingCallback() {
    if (this.trackingCallback) {
      this.trackingCallback();
    }
  }
}

export class DropdownSelector {
  constructor(triggerSelector, dropdownTargetSelector) {
    this.triggerSelector = triggerSelector;
    this.options = {
      placement: "bottom",
      triggerType: "click",
      offsetSkidding: 0,
      offsetDistance: 10,
      delay: 300,
      ignoreClickOutsideClass: false,
      onHide: () => {},
      onShow: () => {},
      onToggle: () => {},
    };
    this.$triggerEl = $(triggerSelector).get(0);
    this.$targetEl = $(
      `#${$(triggerSelector).data("dropdown-select-target")}`
    ).get(0);
    this.dropdown = new Dropdown(this.$targetEl, this.$triggerEl, this.options);
    this.onChangeCallback = null;
    this.initialize();
  }

  initialize() {
    this.updateSelectedItem();

    $("[data-item-value]").on("click", (event) => {
      const $item = $(event.currentTarget);
      $("[data-item-value]").each(function () {
        $(this).removeAttr("data-selected");
      });
      $item.attr("data-selected", true);
      this.updateSelectedItem();
      this.dropdown.hide();
      if (typeof this.onChangeCallback === "function") {
        this.onChangeCallback(this.value);
    }
    });
  }

  getValue() {
    const selectedItem = $('[data-selected="true"]').data("item-value");
    return selectedItem || this.value || null;
  }
  updateSelectedItem() {
    const itemSelected = $('[data-selected="true"]').text();
    $(`${this.triggerSelector} span`).text(itemSelected);
  }
  onchange(callback) {
    // Assign the callback function for onchange event
    if (typeof callback === "function") {
      this.onChangeCallback = callback;
    } else {
      console.error("onchange callback must be a function");
    }
  }
}
