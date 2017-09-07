$(function(){
    var ctx = document.getElementById("totalBreak").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["石", "土", "砂利", "花崗岩", "閃緑岩", "安山岩", "石炭"],
            datasets: [{
                backgroundColor: [
                    "#A4A4A4",
                    "#B45F04",
                    "#F5ECCE",
                    "#9b59b6",
                    "#f1c40f",
                    "#e74c3c",
                    "#2E2E2E"
                ],
                backgroundImage: [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                ],
                data: [1957739, 812261, 126630, 109335, 78530, 75213, 67578]
            }]
        }
    });


    var ex = document.getElementById("example");
    var myChart2 = new Chart(ex, {
        type: 'radar',
        data: {
            labels: [
                "s1:整地1", "s1:整地2", "s1:整地3",
                "s2:整地1", "s2:整地2", "s2:整地3",
                "s3:整地1", "s3:整地2", "s3:整地3"
            ],
            datasets: [{
                label: 'player1',
                backgroundColor: "rgba(153,255,51,0.4)",
                borderColor: "rgba(153,255,51,1)",
                data: [12, 19, 3, 17, 28, 24, 7]
            }, {
                label: 'player2',
                backgroundColor: "rgba(255,153,0,0.4)",
                borderColor: "rgba(255,153,0,1)",
                data: [30, 29, 5, 5, 20, 3, 10]
            }]
        }
    });
});