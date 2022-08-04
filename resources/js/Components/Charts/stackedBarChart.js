import { defineComponent, h } from 'vue'

import { Bar } from 'vue-chartjs'

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default defineComponent({
  name: 'BarChart',
  components: {
    Bar
  },
  props: {
    chartId: {
      type: String,
      default: 'bar-chart'
    },
    chartData: {
      type: Object,
      default: {},
    },
    chartOptions: {
      type: Object,
      default: {
        responsive: true,
        maintainAspectRatio: false,
        animation: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        },
      }
    },
    width: {
      type: Number,
      default: 400
    },
    height: {
      type: Number,
      default: 400
    },
    cssClasses: {
      default: 'h-100',
      type: String
    },
  },
  setup(props) {

    return () =>
      h(Bar, {
        chartData: props.chartData,
        chartOptions: props.chartOptions,
        chartId: props.chartId,
        width: props.width,
        height: props.height,
        cssClasses: props.cssClasses,
      })
  }
})
