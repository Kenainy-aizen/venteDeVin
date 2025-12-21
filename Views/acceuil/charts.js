// /Views1/acceuil/js/charts.js

google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    // Ces variables seront injectées depuis PHP
    const data1 = new google.visualization.DataTable(window.chartData.data1);
    const data2 = new google.visualization.DataTable(window.chartData.data2);
    const data3 = new google.visualization.DataTable(window.chartData.data3);
    const data4 = new google.visualization.DataTable(window.chartData.data4);

    // ---------------- Options et graphiques ----------------
    const options1 = {
        title: "Recette par mois",
        fontName: 'Poppins',
        backgroundColor: '#28a745',
        titleTextStyle: { color: 'white', fontSize: 26, bold: true },
        chartArea: { top: 100, left: 80, width: '70%', height: '65%' },
        hAxis: { title: "Mois", titleTextStyle: { color: 'white', fontSize: 18 }, textStyle: { color: 'white', fontSize: 14 } },
        vAxis: { title: "Recette (Ar)", titleTextStyle: { color: 'white', fontSize: 18 }, textStyle: { color: 'white', fontSize: 14 } },
        legend: { textStyle: { color: 'white', fontSize: 16 } },
        series: { 0: { color: 'yellow', lineWidth: 5, pointSize: 8, pointShape: 'circle' } }
    };

    const options3 = {
        title: "Le produit vendu ce mois",
        fontName: 'Poppins',
        backgroundColor: '#28a745',
        titleTextStyle: { fontSize: 25, color: 'white' },
        chartArea: { left: 220, top: 50, width: '100%', height: '80%' },
        hAxis: {
            title: "Nombre", titleTextStyle: { color: 'white', fontSize: 18, bold: true },
            textStyle: { color: 'white', fontSize: 14 }
        },
        vAxis: {
            title: "Type produit", titleTextStyle: { color: 'white', fontSize: 18, bold: true },
            textStyle: { color: 'white', fontSize: 14 }
        }
    };

    const options4 = {
        title: "Le paiement par mode de règlement",
        fontName: 'Poppins',
        pieHole: 0.4,
        backgroundColor: '#28a745',
        chartArea: { left: 10, top: 50, width: '100%', height: '80%' },
        titleTextStyle: { fontSize: 20, color: 'white' },
        legend: { position: 'right', textStyle: { fontSize: 16, color: 'white' } }
    };

    const options5 = { ...options4, title: "Le type de client a vendu", chartArea: { left: 10, top: 75, width: '100%', height: '80%' } };

    // Dessin des graphiques
    new google.visualization.ColumnChart(document.getElementById("myChart1")).draw(data1, options1);
    new google.visualization.BarChart(document.getElementById("myChart2")).draw(data2, options3);
    new google.visualization.PieChart(document.getElementById("myChart3")).draw(data3, options4);
    new google.visualization.PieChart(document.getElementById("myChart4")).draw(data4, options5);
}
