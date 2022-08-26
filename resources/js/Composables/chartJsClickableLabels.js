/* global route */
import { Inertia } from '@inertiajs/inertia';

const findLabel = (labels, evt) => {
	let found = false;
	let res = null;

	labels.forEach((l) => {
		l.labels.forEach((label, index) => {
			if (evt.x > label.x && evt.x < label.x2 && evt.y > label.y && evt.y < label.y2) {
				res = {
					label: label.label,
					index,
				};
				found = true;
			}
		});
	});

	return [found, res];
};

const getLabelHitboxes = (scales) => (Object.values(scales).map((s) => {
	if (s._labelItems) {
		return {
			scaleId: s.id,
			labels: s._labelItems.map((e, i) => ({
				x: e.translation[0] - s._labelSizes.widths[i],
				x2: e.translation[0] + s._labelSizes.widths[i] / 2,
				y: e.translation[1] - s._labelSizes.heights[i] / 2,
				y2: e.translation[1] + s._labelSizes.heights[i] / 2,
				label: e.label,
				index: i,
			})),
		};
	} else {
		return {
			scaleId: s.axis,
			labels: s._pointLabelItems.map((e, i) => {
				return {
					x: e.left,
					x2: e.right,
					y: e.top,
					y2: e.bottom,
					label: s._pointLabels[i],
					index: i,
				};
			}),
		};
	}
}));

export const chartJsClickableLabels = {
	id: 'customHover',
	afterEvent: (chart, event, opts) => {
		const options = chart.options.plugins.chartJsClickableLabels;
		const evt = event.event;
		const colorArray = [];
		const [found, labelInfo] = findLabel(getLabelHitboxes(chart.scales), evt);
		const points = chart.getElementsAtEventForMode(event.event, 'nearest', {
			intersect: true,
		}, true);
		let datapoint = null;
		if (evt.type == 'mousemove') {
			if (found || points[0]) {
				if (found) {
					datapoint = labelInfo.index;
				} else {
					datapoint = points[0].index;
				}
				for (let i = 0; i < chart.data.datasets[0].backgroundColor.length; i++) {
					if (datapoint === i) {
						colorArray.push(options.hoverColor);
					} else {
						colorArray.push(options.tickColor);
					}
				}
				chart.config.options.scales.r.pointLabels.color = colorArray;
				chart.canvas.style.cursor = 'pointer';
			} else {
				chart.config.options.scales.r.pointLabels.color = options.tickColor;
				chart.canvas.style.cursor = 'default';
			}
			return;
		} else if (evt.type !== 'click') {
			return;
		} else {
			if (found || points[0]) {
				if (found) {
					datapoint = labelInfo.index;
				} else {
					datapoint = points[0].index;
				}
				const routeName = options.routeName;
				Inertia.get(route(routeName, datapoint));
			}
		}
	},
};
