<script>
import { Line,Bar } from "vue-chartjs";
import { getStyle, hexToRgba } from "@coreui/coreui/dist/js/coreui-utilities";
import { CustomTooltips } from "@coreui/coreui-plugin-chartjs-custom-tooltips";
import { random } from "@/shared/utils";

export default {
  props: ["height", "data"],
  mounted() {
    //this.renderLineChart();
  },
  computed: {
    chartData: function() {
      return this.data;
    }
  },
  extends: Line,
   methods: {
    renderLineChart: function() {
    this.renderChart(
      {
        labels: this.chartData.labels,
        datasets: [
          {
            label: this.chartData.datasets[0].label,
            // backgroundColor: "#f87979",
            fill: false,
            borderColor:"#009688",
            data: this.chartData.datasets[0].data
          },
           {
            label: this.chartData.datasets[1].label,
            // backgroundColor: "#f87979",
            fill: false,
            borderColor:"#f87979",
            data: this.chartData.datasets[1].data
          }
        ]
      },
      { responsive: true, maintainAspectRatio: false }
    );      
    }
  },
  watch: {
    type: 'line',
    data: function() {
      //this._chart.destroy();

      this.renderChart(this.data, this.options);
      this.renderLineChart();
    }
  }
};
</script>