import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    if (!window.dashboardData) {
        return;
    }
    /*
    ==========================
    COUNTER ANIMATION
    ==========================
    */

    const counters=document.querySelectorAll('.counter');


    counters.forEach(counter=>{


        const target=parseInt(counter.dataset.target) || 0;

        let count=0;


        const update=()=>{


            const increment=Math.ceil(target/60);


            count += increment;



            if(count < target){


                if(counter.classList.contains('money-counter')){


                    counter.innerText =
                    "KSh " + count.toLocaleString();


                }else{


                    counter.innerText =
                    count.toLocaleString();


                }


                requestAnimationFrame(update);


            }else{


                if(counter.classList.contains('money-counter')){


                    counter.innerText =
                    "KSh " + target.toLocaleString();


                }else{


                    counter.innerText =
                    target.toLocaleString();


                }


            }


        };


        update();


    });





    /*
    ==========================
    OCCUPANCY DONUT CHART
    ==========================
    */


    const occupancyChart =
    document.getElementById('occupancyChart');



    if(occupancyChart){


        new Chart(occupancyChart,{


            type:'doughnut',


            data:{


                labels:[
                    'Occupied',
                    'Vacant'
                ],


                datasets:[{


                    data:[

                        window.dashboardData.occupied,

                        window.dashboardData.vacant

                    ],


                    backgroundColor:[

                        '#22c55e',

                        '#ef4444'

                    ],


                    borderWidth:0


                }]


            },


            options:{


                responsive:true,


                cutout:'75%',


                plugins:{


                    legend:{


                        position:'bottom'


                    }


                }


            }


        });


    }







    /*
    ==========================
    REVENUE GRAPH
    ==========================
    */


    const revenueChart =
    document.getElementById('revenueChart');



    if(revenueChart){


        new Chart(revenueChart,{


            type:'line',


            data:{


                labels:window.dashboardData.months,


                datasets:[{


                    label:'Monthly Revenue',


                    data:window.dashboardData.revenue,


                    borderWidth:3,


                    tension:.4,


                    fill:true


                }]


            },


            options:{


                responsive:true,


                maintainAspectRatio:false,


                plugins:{


                    legend:{


                        display:true

                    }


                }



            }



        });


    }

    const financeChart = document.getElementById('financeChart');
    if (financeChart) {
        new Chart(financeChart, {
            type: 'bar',
            data: {
                labels: ['This month'],
                datasets: [
                    { label: 'Collected income', data: [window.dashboardData.collected], backgroundColor: '#22c55e', borderRadius: 8 },
                    { label: 'Expenses', data: [window.dashboardData.expenses], backgroundColor: '#f97316', borderRadius: 8 },
                    { label: 'Net profit', data: [window.dashboardData.profit], backgroundColor: '#38bdf8', borderRadius: 8 },
                ],
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } },
        });
    }




});
