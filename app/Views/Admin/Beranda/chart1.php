<script>
    var tahun_masuk = $('#tahun_masuk').val();
    console.log(tahun_masuk);
    var chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            type: 'column'
        },
        title: {
            text: 'Grafik Jumlah Perjurusan ' + tahun_masuk + ''
        },
        xAxis: {
            enabled: false
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            name: 'IPA',
            data: [<?= $c1; ?>]
        }, {
            name: 'IPS',
            data: [<?= $c2; ?>]
        }, {
            name: 'Belum Dinilai',
            data: [<?= $belum; ?>]
        }],

    });
</script>