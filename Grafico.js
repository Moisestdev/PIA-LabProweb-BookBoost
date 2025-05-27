const getOptionChart1 = () => {
  return {
    xAxis: {
      type: 'category',
      data: ['Estudiante', 'Profesor', 'Mié', 'Jue', 'Vie', 'Sáb', 'Otro']
    },
    yAxis: {
      type: 'value'
    },
    series: [{
      data: [120, 200, 150, 80, 70, 110, 130],
      type: 'bar',
      showBackground: true,
      backgroundStyle: {
        color: 'rgba(180, 180, 180, 0.2)'
      }
    }]
  };
};

const initChart = () => {
  const chart1 = echarts.init(document.getElementById('chart1'));
  chart1.setOption(getOptionChart1());
};

window.addEventListener('load', function() {
  console.log("Grafico.js cargado");
  initChart();
});
