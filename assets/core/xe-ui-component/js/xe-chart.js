import * as c3 from 'c3';
import * as d3 from 'd3';
import window from 'window';

/**
 * @class
 * */
class XeChart {

  chart;

  /**
   * @param {string} chartType 차트 타입
   * @param {object} obj
   * <pre>
   *   - selector : 차트를 생성할 wrapper selector
   *   - data : chart data
   *   - customOptions : c3 차트생성 오브젝트
   *   -
   * </pre>
   * @description XeChart 생성.
   * */
  constructor(chartType, obj) {
    this.selector = obj.selector;
    this.chartType = chartType;
    this.data = obj.data;
    this.customOptions = obj.customOptions || {};
  }

  /**
   * @description 그래프를 그린다.
   * */
  draw () {
    const chartOptions = $.extend(true, {}, this.getDefaultOptions(), {
      bindto: this.selector,
      data: {
        columns: this.data,
      },
    }, this.customOptions);

    this.chart = c3.generate(chartOptions);
  }

  /**
   * @description 그래프를 삭제한다.
   * */
  destroy () {
    this.chart.destroy();
  }

  /**
   * @param {object} labels
   * <pre>
   *   - x
   *   - y
   * </pre>
   * @description 그래프 상의 x, y축의 명칭을 변경한다.
   * */
  setLabel (labels) {
    this.chart.axis.labels(labels);
  }

  /**
   * @param {object} dimension
   * <pre>
   *   - width
   *   - height
   * </pre>
   * @param {boolean} isPercentage
   * */
  resize (dimension, isPercentage) {

    var sizeObj = {};

    if(dimension.hasOwnProperty('width')) {
      if(isPercentage) {
        var fullWidth = $(this.selector).width();

        sizeObj.width = fullWidth * dimension.width / 100;
      } else {
        sizeObj.width = dimension.width;
      }
    }

    if(dimension.hasOwnProperty('height')) {
      sizeObj.height = dimension.height;
    }

    this.chart.resize(sizeObj);
  }

  /**
   * @param {object} c3 load data
   * @description 차트에 데이터를 로드한다.
   * */
  load (data) {
    this.chart.load(data);
  }

  /**
   * @param {array} ids
   * @description 차트 데이터를 제거한다.
   * */
  unload (ids) {
    this.chart.unload({
      ids
    });
  }

  /**
   * @param {string} title
   * @description 그래프 타이틀을 설정한다.
   * */
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

  /**
   * @description chartType에 의한 기본 옵션을 반환한다.
   * @return {object} options
   * */
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
          tooltip: {
            contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
              var $$ = this, config = $$.config,
                titleFormat = config.tooltip_format_title || defaultTitleFormat,
                nameFormat = config.tooltip_format_name || function (name) { return name; },
                valueFormat = config.tooltip_format_value || defaultValueFormat,
                text, i, title, value, name, bgcolor;
              for (i = 0; i < d.length; i++) {
                if (! (d[i] && (d[i].value || d[i].value === 0))) { continue; }

                if (! text) {
                  title = titleFormat ? titleFormat(d[i].x) : d[i].x;
                  text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2'>" + title + "</th></tr>" : "");
                }

                name = nameFormat(d[i].name);
                value = valueFormat(d[i].value, d[i].ratio, d[i].id, d[i].index);
                bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

                text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + name + "</td>";
                text += "<td class='value'>" + d[i].value + " (" +value + ")</td>";
                text += "</tr>";
              }
              return text + "</table>";
            }
          }
        };
        break;
      case 'donut':
        options = {
          data: {
            type: 'donut',
          },
          donut: {
            title: ""
          },
          tooltip: {
            contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
              var $$ = this, config = $$.config,
                titleFormat = config.tooltip_format_title || defaultTitleFormat,
                nameFormat = config.tooltip_format_name || function (name) { return name; },
                valueFormat = config.tooltip_format_value || defaultValueFormat,
                text, i, title, value, name, bgcolor;
              for (i = 0; i < d.length; i++) {
                if (! (d[i] && (d[i].value || d[i].value === 0))) { continue; }

                if (! text) {
                  title = titleFormat ? titleFormat(d[i].x) : d[i].x;
                  text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2'>" + title + "</th></tr>" : "");
                }

                name = nameFormat(d[i].name);
                value = valueFormat(d[i].value, d[i].ratio, d[i].id, d[i].index);
                bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

                text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + name + "</td>";
                text += "<td class='value'>" + d[i].value + " (" +value + ")</td>";
                text += "</tr>";
              }
              return text + "</table>";
            }
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
