import { defineComponent, h } from 'vue'
import { hexToRgbA } from '@/Composables/hexToRgbA'
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
    data: {
      default: [],
      type: Array,
    }
  },
  setup(props) {

    // console.log();
    const chartData = {
      labels: props.data.map(el => el.name),
      datasets: [
        {
          label: 'Company Skills by Category',
          data: props.data.map(el => el.companyTotal),
          backgroundColor: props.data.map(el => hexToRgbA('#'+el.color,0.5))
        },
      ]
    }

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        r: {
          ticks: {
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
        chartData,
        chartOptions,
        chartId: props.chartId,
        width: props.width,
        height: props.height,
        cssClasses: props.cssClasses,
      })
  }
})
