const initChart = async (tipo = 'ocupacion') => {
  try {
    const res = await fetch(`datos_estadisticas.php?tipo=${tipo}`);
    const data = await res.json();

    const chart1 = echarts.init(document.getElementById('chart1'));

    const option = {
      title: {
        text: data.titulo,
        left: 'center'
      },
      tooltip: {},
      xAxis: {
        type: 'category',
        data: data.labels
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: data.valores,
        type: 'bar',
        showBackground: true,
        backgroundStyle: {
          color: 'rgba(180, 180, 180, 0.2)'
        }
      }]
    };

    chart1.setOption(option);
  } catch (error) {
    console.error("Error al cargar datos del gráfico:", error);
  }
};

document.addEventListener('DOMContentLoaded', () => {
  initChart(); // por defecto: ocupacion

  document.getElementById('Filtrar').addEventListener('click', () => {
    const tipo = document.getElementById('tipoFiltro').value;
    initChart(tipo);
  });
});
