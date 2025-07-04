// Declare GaugeChart class in the global scope
let gaugeChart;

jQuery(function ($) {

  class GaugeChart {

    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig() {
      let element = this._element;

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff'
        },

        geometry: {
          startAngle: 180,
          endAngle: 360
        },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0, 33, 63, 85, 100],
          tick: {
            length: 4
          },

          label: {
            font: {
              color: '#87959f',
              size: 19,
              family: '"Open Sans", sans-serif'
            }
          }
        },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#fff',
            size: 10
          },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#fff',
              weight: 700,
              size: 28
            }
          }
        },



        onInitialized: function () {
          let currentGauge = jQuery(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        }
      };


    }

    getGuidance(){
      jQuery('.gauge').each((index, item) => {

        let gauge = $(item).dxCircularGauge('instance');
        let randomNum = Math.round(Math.random() * this._higherValue);
        let gaugeElement = jQuery(gauge._$element[0]);

        let answer = randomNum + " = ";
        if (randomNum <= 33) {
          answer += `👎👎<br/>Consider it a big NO.`;
        } else if (randomNum > 33 && randomNum < TfcGlobal.AngelsSayYes) { 
          answer += `👎<br/>Yes, but angels say NO (if score <${TfcGlobal.AngelsSayYes})`;
        } else if (randomNum >= TfcGlobal.AngelsSayYes && randomNum < 85) { 
          answer += `👍<br/>You can take it as YES!`;
        } else if (randomNum >= 85) {
          answer += `👍👍<br/>Absolutely YES!`;
        }

        gaugeElement.find('.dxg-title text').last().html(`${randomNum}`);
        gauge.value(randomNum);

        jQuery('#interpretation').html(answer);      
      });

      return false;
    }

    // static randomize() {
    //   jQuery('.gauge').each(function (index, item) {
    //     let gauge = jQuery(item).dxCircularGauge('instance');
    //     gauge.getGuidance(gauge);
    //   });

    //   return false;
    // }

    init() {
      jQuery(this._element).dxCircularGauge(this._buildConfig());
    }
  } //class GaugeChart


  jQuery(document).ready(function ($) {
    //dx.all.js moved to custom-css-js folder because github was loading it very slowly
    const dxDiagJsUrl = "https://www.twinflamescoach.com/wp-content/uploads/custom-css-js/dx.all.js";
    //TfcGlobal.getFullFileUrlFromParts(TfcGlobal.GaugeChartRootPath, "dx.all.js");
    $.getScript(dxDiagJsUrl, function () {    
    //$.getScript("https://paramvirs25.github.io/TwinFlamesCoach/Tools/gauge-chart/dx.all.js", function () {
      let higherValue = 100;

      //Draw gauge chart
      $('.gauge').each(function (index, item) {
        let params = {
          initialValue: 0,
          higherValue: higherValue,
          title: `Score`,
          subtitle: '0'
        };


        gaugeChart = new GaugeChart(item, params);
        gaugeChart.init();

        document.querySelector('svg.dxg').setAttribute('height', '250');
        
        
        //const svgElement = document.querySelector('.gauge svg.dxg-circular-gauge');
        //svgElement.style.marginTop = '-50px'; // Adjust this value as needed
      });
      
    });
  });

});