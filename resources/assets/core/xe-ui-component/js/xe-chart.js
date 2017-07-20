import * as c3 from 'c3';
import * as d3 from 'd3';
import window from 'window';

/**
 * customOptions
 * - data
 *  - color: {
 *    data1: '#000000'
 *  }
 *
 *
 *
 * options
 * - chartType
 * - categories
 * */

class XeChart {

  chart;

  constructor(chartType, obj) {
    this.selector = obj.selector;
    this.chartType = chartType;
    this.data = obj.data;
    this.customOptions = obj.customOptions || {};
    this.options = obj.options || {}
  }

  draw () {
    const chartOptions = $.extend(true, {}, this.getDefaultOptions(), {
      bindto: this.selector,
      data: {
        columns: this.data,
      },
    }, this.customOptions);

    this.chart = c3.generate(chartOptions);
  }

  destroy () {
    this.chart.destroy();
  }

  setLabel (labels) {
    this.chart.lables({
      x: labels.x,
      y: labels.y
    });
  }

  setTitle (title) {
    if($(this.selector).find('svg > text.c3-title').length > 0) {
      $(this.selector).find('svg > text').text(title)
        .attr('x', (d3.select(this.selector).node().getBoundingClientRect().width - d3.select(this.selector + ' svg > text.c3-title').node().getBoundingClientRect().width) / 2)
        .attr('y', 16);

    } else {
      d3.select(this.selector).find('svg').append('text').text(title)
        .attr('x', (d3.select(this.selector).node().getBoundingClientRect().width - d3.select(this.selector + ' svg > text.c3-title').node().getBoundingClientRect().width) / 2)
        .attr('y', 16)
        .attr('class', 'c3-title');
    }
  }

  getDefaultOptions() {
    const chartType = this.chartType;
    let options = {};

    switch (chartType) {
      case 'line':
        options = {
          data: {
            type: 'line',
          },
          axis: {
            x: {
              type: 'category',
              categories: [],
              tick: {
                centered: true,
              },
            },
          },
        };
        break;
      case 'bar':
        options = {
          data: {
            type: 'bar',
          },
          axis: {
            x: {
              tick: {
                centered: true,
                //values: [1, 2, 4, 8, 16, 32]
                //rotate: 60
              },
              //min: 0
              //max: ?
              //padding: { left, bottom }
              //label: { text: 'X Axis Label',  position: 'outer-center'} //inner-top, inner-middle, inner-bottom, outer-top, outer-middle, outer-bottom
            },
          },
        };
        break;
      case 'pie':
        options = {
          data: {
            type: 'pie',
          },
        };
        break;
      case 'donut':
        options = {
          data: {
            type: 'donut',
          },
          donut: {
            title: ""
          }
        };
        break;
      case 'area':
        options = {
          data: {
            type: 'area',
          },
          axis: {
            x: {
              tick: {
                centered: true,
              },
            },
          },
        };
        break;
      case 'spline':
        options = {
          data: {
            type: 'spline',
          },
          axis: {
            x: {
              tick: {
                centered: true,
              },
            },
          },
        };
        break;
      default:
        options = {};
    }

    return options;
  }
}

window.XeChart = XeChart;
