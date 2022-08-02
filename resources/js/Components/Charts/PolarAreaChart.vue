<script>
import { defineComponent, h } from 'vue'

import { PolarArea } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  RadialLinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement, RadialLinearScale)

export default defineComponent({
  name: 'PolarAreaChart',
  components: {
    PolarArea
  },
  props: {
    chartId: {
      type: String,
      default: 'polar-chart'
    },
    chartData: {
      type: Object,
      default: {},
    },
    width: {
      type: Number,
      default: 300
    },
    height: {
      type: Number,
      default: 300
    },
    cssClasses: {
      default: '',
      type: String
    },
    labels: {
      default: [],
      type: Array,
    },
    data: {
      default: [],
      type: Array,
    },
    backgroundColor: {
      default: [],
      type: Array,
    }
  },
  setup(props) {
    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        r: {
          ticks: {
            display: false,
            backdropColor: 'rgba(0,0,0,0)',
            color: '#fff',
          },
          pointLabels: {
            display: true,
            centerPointLabels: true,
            color: '#fff',
            font: {
              size: 16,
              family: 'Nunito',
            }
          }
        }
      },
      plugins: {
        legend: {
          display: false,
        },
      }
    }
    return () =>
      h(PolarArea, {
        chartData: props.chartData,
        chartOptions,
        chartId: props.chartId,
        width: props.width,
        height: props.height,
        cssClasses: props.cssClasses,
      })
  }
})
</script>