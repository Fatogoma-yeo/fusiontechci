
<div class="flex flex-auto bg-white flex-col shadow rounded-lg py-2 w-full">
    <!-- <div id="chartContainer" class="w-full h-72"></div> -->
  <canvas class="flex flex-auto w-full" id="myChart"></canvas>
  <div id="" class="flex justify-center">
    <ul class="text-sm">
        <li onclick="updateChart(0)" class="px-2 cursor-pointer" id="legend_0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-flex bg-blue-700 text-blue-700 rounded-full">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
            </svg>
            {{ __( 'Current Week' ) }}
        </li>
        <li onclick="updateChart(1)" class="px-2 cursor-pointer" id="legend_1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-flex bg-gray-400 text-gray-400 rounded-full">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" />
            </svg>
            {{ __( 'Previous Week' ) }}
        </li>
    </ul>
  </div>
</div>
@push('javascript')

<script src="{{ asset('js/chart.js') }}"></script>

<script>
  const ctx = document.getElementById('myChart');

  const chartDetails1 = <?php echo $day_of_currentweek_detail ?>;
    const chartDetails2 = <?php echo $day_of_lastweek_detail ?>;
    var lsale1 = 0; var lsale2 = 0;
    var msale1 = 0; var msale2 = 0;
    var mercsale1 = 0; var mercsale2 = 0;
    var jsale1 = 0; var jsale2 = 0;
    var vsale1 = 0; var vsale2 = 0;
    var samsale1 = 0; var samsale2 = 0;
    var dimsale1 = 0; var dimsale2 = 0;

    if (chartDetails1) {
        chartDetails1.forEach(element => {
            var dayDetail = element.day;
            var saleDetail = element.sale;
            dayDetail === "Monday" ? lsale1+=saleDetail : lsale1+=0;
            dayDetail === "Tuesday" ? msale1+=saleDetail : msale1+=0;
            dayDetail === "Wednesday" ? mercsale1+=saleDetail : mercsale1+=0;
            dayDetail === "Thursday" ? jsale1+=saleDetail : jsale1+=0;
            dayDetail === "Friday" ? vsale1+=saleDetail : vsale1+=0;
            dayDetail === "Saturday" ? samsale1+=saleDetail : samsale1+=0;
            dayDetail === "Sunday" ? dimsale1+=saleDetail : dimsale1+=0;
        });
    }
    if (chartDetails2) {
        chartDetails2.forEach(element => {
            var dayDetail = element.day;
            var saleDetail = element.sale;
            dayDetail === "Monday" ? lsale2+=saleDetail : lsale2+=0;
            dayDetail === "Tuesday" ? msale2+=saleDetail : msale2+=0;
            dayDetail === "Wednesday" ? mercsale2+=saleDetail : mercsale2+=0;
            dayDetail === "Thursday" ? jsale2+=saleDetail : jsale2+=0;
            dayDetail === "Friday" ? vsale2+=saleDetail : vsale2+=0;
            dayDetail === "Saturday" ? samsale2+=saleDetail : samsale2+=0;
            dayDetail === "Sunday" ? dimsale2+=saleDetail : dimsale2+=0;
        });
    }
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        datasets: [
            {
                label: "{{ __( 'Current Week' ) }}",
                data: [dimsale1, lsale1, msale1, mercsale1, jsale1, vsale1, samsale1],
                backgroundColor : (context) => {
                    const bgColor = [
                        'rgb(29 78 216)',
                        'rgb(96 165 250)',
                        'rgb(219 234 254)',
                    ];
                    if (!context.chart.chartArea) {
                        return;
                    }
                    const {ctx, data, chartArea: {top, bottom} } = context.chart;
                    const gradientBg = ctx.createLinearGradient(0, top, 0, bottom);
                    gradientBg.addColorStop(0, bgColor[0]);
                    gradientBg.addColorStop(0.5, bgColor[1]);
                    gradientBg.addColorStop(1, bgColor[2]);
                    return gradientBg;
                },
                borderColor: '#5f83f3',
                borderWidth: 4,
                pointRadius: 0,
                tension: 0.4,
                fill: true
            },
            {
                label: "{{ __( 'Previous Week' ) }}",
                data: [dimsale2, lsale2, msale2, mercsale2, jsale2, vsale2, samsale2],
                backgroundColor: 'rgb(229 231 235)',
                backgroundColor : (context) => {
                    const bgColor = [
                        'rgb(55 65 81)',
                        'rgb(156 163 175)',
                        'rgb(243 244 246)',
                    ];
                    if (!context.chart.chartArea) {
                        return;
                    }
                    const {ctx, data, chartArea: {top, bottom} } = context.chart;
                    const gradientBg = ctx.createLinearGradient(0, top, 0, bottom);
                    gradientBg.addColorStop(0, bgColor[0]);
                    gradientBg.addColorStop(0.5, bgColor[1]);
                    gradientBg.addColorStop(1, bgColor[2]);
                    return gradientBg;
                },
                borderColor: '#AAA',
                borderWidth: 4,
                pointRadius: 0,
                segment:{
                    borderDash:[6.0]
                },
                tension: 0.4,
                fill: true
            }
        ]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    function updateChart(dataset) {

        const isDataShown = myChart.isDatasetVisible(dataset);
        if (isDataShown === false) {
            myChart.show(dataset);
            document.getElementById('legend_'+dataset).classList.remove('text-gray-300');
        } else {
            myChart.hide(dataset);
            document.getElementById('legend_'+dataset).classList.add('text-gray-300');
        }
    }

</script>


@endpush
