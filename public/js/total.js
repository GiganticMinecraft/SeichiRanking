$(function(){
    var ctx = document.getElementById("totalBreak").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["yuki_256", "tar0ss", "watarunrun", "susumu2015", "ice31", "uraking_play", "unchama"],
            datasets: [{
                backgroundColor: [
                    "#2ecc71",
                    "#3498db",
                    "#95a5a6",
                    "#9b59b6",
                    "#f1c40f",
                    "#e74c3c",
                    "#34495e"
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
});