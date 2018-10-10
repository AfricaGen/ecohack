$(document).ready(function() {
    
    // CounterUp Plugin
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
	
	/*Flot 2 Live Chart*/
    var flot2 = function () {
		var data = [],
			totalPoints = 100;
        
		function getRandomData() {

			if (data.length > 0)
				data = data.slice(1);

			while (data.length < totalPoints) {

				var prev = data.length > 0 ? data[data.length - 1] : 50,
					y = prev + Math.random() * 10 - 5;

				if (y < 0) {
					y = 0;
				} else if (y > 100) {
					y = 100;
				}

				data.push(y);
			}
			var res = [];
			for (var i = 0; i < data.length; ++i) {
				res.push([i, data[i]])
			}

			return res;
		}

		var plot2 = $.plot("#flotchart2", [ getRandomData() ], {
			series: {
				shadowSize: 0
			},
			yaxis: {
				min: 0,
				max: 100
			},
			xaxis: {
				show: false
			},
            colors: ["#0159D4"],
            legend: {
                show: false
            },
            grid: {
                color: "#A2B3D5",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            },
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            }
		});

		function update() {
			plot2.setData([getRandomData()]);

			plot2.draw();
			setTimeout(update, 30);
		}

		update();
        
    };
	
    /* Flot 1 */
    var flot1 = function () {
        var data = [[0, 40], [1, 80], [2, 40], [3, 80], [4, 40], [5, 80], [6, 40]];
        var data2 = [[0, 20], [1, 30], [2, 90], [3, 40], [4, 86], [5, 27], [6, 90]];
        var dataset =  [
            {
                data: data,
                color: "rgba(92,83,230,1)",
                lines: {
                    show: true,
                    fill: 0.4,
                },
                shadowSize: 0,
            }, {
                data: data,
                color: "#fff",
                lines: {
                    show: false,
                },
                points: {
                    show: true,
                    fill: true,
                    radius: 4,
                    fillColor: "rgba(92,83,230,1)",
                    lineWidth: 2
                },
                curvedLines: {
                    apply: false,
                },
                shadowSize: 0
            }, {
                data: data2,
                color: "rgba(255,69,92,1)",
                lines: {
                    show: true,
                    fill: 0.6,
                },
                shadowSize: 0,
            },{
                data: data2,
                color: "#fff",
                lines: {
                    show: false,
                },
                curvedLines: {
                    apply: false,
                },
                points: {
                    show: true,
                    fill: true,
                    radius: 4,
                    fillColor: "rgba(255,69,92,1)",
                    lineWidth: 2
                },
                shadowSize: 0
            }
        ];
        
        var ticks = [[0, "1"], [1, "2"], [2, "3"], [3, "4"], [4, "5"], [5, "6"], [6, "7"], [7, "8"]];

        var plot1 = $.plot("#flotchart1", dataset, {
            series: {
                color: "#14D1BD",
                lines: {
                    show: true,
                    fill: 0.2
                },
                shadowSize: 0,
                curvedLines: {
                    apply: true,
                    active: true
                }
            },
            xaxis: {
                ticks: ticks,
            },
            legend: {
                show: false
            },
            grid: {
                color: "#A2B3D5",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'
            },
            tooltip: true,
            tooltipOpts: {
                content: "%yK",
                defaultTheme: false
            }
        });
        
    }; 
	
	/* 
	----------------------------------
	INITIALIZE PLUGINS 
	---------------------------------- */
    
    if($('#flotchart1').length ) {
		flot1();
    };
	
    if($('#flotchart2').length ) {
		flot2();
    };
	
	if($('#example').length ) {
		$('#example').dataTable();
	}
	
	if($('.date-picker').length ) {
		$('.date-picker').datepicker({
			orientation: "top auto",
			autoclose: true
		});
	}
	
	if($('#timepicker1').length ) {
 		$('#timepicker1').timepicker();
	}
    
});