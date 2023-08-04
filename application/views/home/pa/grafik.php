<?php $this->load->view('layout/header.php');?>
<div class="table-responsive rounded" style="background: #f2f2f2;padding-left: 2%;padding-right: 2%">
    <div class="row pl-5 pr-5 pt-3 pb-3">
        <div class="col-md-12 text-center"><h5>GRAFIK SUMMARY FORM PA</h5></div>
    </div>
    <div class="col-md-12 pl-5 pr-5 pb-3 text-center" style="font-size:13px">
        <canvas id="myChart" width="500"></canvas>
    </div>

<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: '<?php echo $chart ?>',
        data: {
            labels: [<?php for ($i=0; $i < count($nilai_x); $i++) { echo '"'.$nilai_x[$i]->nilai_x.'",'; } ?>],
            datasets: [{
                <?php   $total_y = 0; 
                        $rata_y = 0;
                    ?>
                    <?php for ($i=0; $i < count($nilai_y); $i++) {
                        $total_y += $nilai_y[$i]->nilai_y; 
                        }
                        $rata_y = round($total_y / count($nilai_y),2);
                    ?>

                    // label: 'AVG :  <?php echo $rata_y; ?>',
                    label: 'AVG',
                    data: [<?php for ($i=0; $i < count($nilai_y); $i++) { echo '"'.$nilai_y[$i]->nilai_y.'",'; } ?>],
                    

                    backgroundColor: 'rgba(31,161,161, 0.4)',
                    borderColor: 'rgba(31,161,161, 1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            min : 40,
                            max : 100,
                            StepSize : 10
                            // beginAtZero: true
                        }
                    }]
            }
        }
    });
</script>

    <div class="col text-center pb-3">
        <button class="btn btn-secondary" onclick="window.close();">TUTUP</button>
    </div>
</div>

