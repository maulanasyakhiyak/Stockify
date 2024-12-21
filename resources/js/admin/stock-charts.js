import ApexCharts from "apexcharts";
import { Dropdown } from "flowbite";
var csrfToken = $('meta[name="csrf-token"]').attr("content");

// Menggunakan AJAX untuk mengambil data
async function getdata(params) {
    try {
        const response = await $.ajax({
            url: "/get_stock_for_chart",
            method: "GET",
            data: {
                _token: csrfToken,
                params: params,
            },
        });
        if (response.status == "fail") {
            console.log(response.message);
        }
        const chartData = response.data;
        console.log(response.data);

        return chartData;
    } catch (error) {
        console.error("Terjadi kesalahan dalam mengambil data:", error.message);
        return null;
    }
}

const getMainChartOptions = (data) => {
    let mainChartColors = {};

    if (document.documentElement.classList.contains("dark")) {
        mainChartColors = {
            borderColor: "#374151",
            labelColor: "#9CA3AF",
            opacityFrom: 0,
            opacityTo: 0.15,
        };
    } else {
        mainChartColors = {
            borderColor: "#F3F4F6",
            labelColor: "#6B7280",
            opacityFrom: 0.45,
            opacityTo: 0,
        };
    }

    const dates = data.map((item) => item.date);
    const totals = data
        .map((item) => parseFloat(item.total_quantity)) // Mengambil total_quantity dan mengonversi ke angka
        .filter((total) => !isNaN(total)); // Menyaring nilai yang valid (bukan NaN)
    const maximal = data.map((item) => item.total_all)

    return {
        chart: {
            height: 420,
            type: "area",
            fontFamily: "Inter, sans-serif",
            foreColor: mainChartColors.labelColor,
            toolbar: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                enabled: true,
                opacityFrom: mainChartColors.opacityFrom,
                opacityTo: mainChartColors.opacityTo,
            },
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
        grid: {
            show: true,
            borderColor: mainChartColors.borderColor,
            strokeDashArray: 1,
            padding: {
                left: 35,
                bottom: 15,
            },
        },
        series: [
            {
                name: "Stocks",
                data: totals,
                color: "#1A56DB",
            },
        ],
        markers: {
            size: 5,
            strokeColors: "#ffffff",
            hover: {
                size: undefined,
                sizeOffset: 3,
            },
        },
        xaxis: {
            categories: dates,
            min: 1,
            max: maximal,
            labels: {
                style: {
                    colors: [mainChartColors.labelColor],
                    fontSize: "14px",
                    fontWeight: 500,
                },
            },
            axisBorder: {
                color: mainChartColors.borderColor,
            },
            axisTicks: {
                color: mainChartColors.borderColor,
            },
            crosshairs: {
                show: true,
                position: "back",
                stroke: {
                    color: mainChartColors.borderColor,
                    width: 1,
                    dashArray: 10,
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: [mainChartColors.labelColor],
                    fontSize: "14px",
                    fontWeight: 500,
                },
                formatter: function (value) {
                    return value;
                },
            },
        },
        legend: {
            fontSize: "14px",
            fontWeight: 500,
            fontFamily: "Inter, sans-serif",
            labels: {
                colors: [mainChartColors.labelColor],
            },
            itemMargin: {
                horizontal: 10,
            },
        },
        responsive: [
            {
                breakpoint: 1024,
                options: {
                    xaxis: {
                        labels: {
                            show: false,
                        },
                    },
                },
            },
        ],
    };
};

let chart;

async function fetchAndRender(range) {
    if (chart) {
        chart.destroy();
    }
    const data = await getdata(range);

    chart = new ApexCharts(
        document.getElementById("stock-charts"),
        getMainChartOptions(data.data)
    );

    $('[data-chart="total"]').text(data.total);
    $('[data-chart="time"]').text(data.message);
    chart.render();
}

if (document.getElementById("stock-charts")) {
    const selectedRange = $('[data-selected="true"]').data("item-value");

    fetchAndRender(selectedRange);
}

$("#range-select").on("change", async function () {
    const selectedRange = $(this).val();
    fetchAndRender(selectedRange);
});

// SELECT RANGE CHART ==================================================================================================================================================================

const options = {
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

const $triggerEl = $("#range-button").get(0);
const $targetEl = $(
    `#${$("#range-button").data("dropdown-select-target")}`
).get(0);
const dropdown = new Dropdown($targetEl, $triggerEl, options);

function changeSelectedItem() {
    var itemSelected = $('[data-selected="true"]').text();
    $("#range-button span").text(itemSelected);
}

changeSelectedItem();

$("[data-item-value]").on("click", function () {
    var value = $(this).data("item-value");

    $("[data-item-value]").each(function () {
        $(this).removeAttr("data-selected");
    });

    $(this).attr("data-selected", true);

    changeSelectedItem();

    fetchAndRender(value);

    dropdown.hide();
});
