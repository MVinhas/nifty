<?php

include 'header.php' ?>
<?php
include 'sidebar.php' ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="chartjs-size-monitor"
             style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
            <div class="chartjs-size-monitor-expand"
                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                </div>
            </div>
            <div class="chartjs-size-monitor-shrink"
                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                </div>
            </div>
        </div>
        <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard
            </h1>
        </div>
        <p class="h5">Visits today: <?= $data->sessions['today'] ?? 0 ?>
        </p>
        <p class="h5">Visits this week: <?= $data->sessions['week'] ?? 0 ?>
        </p>
        <p class="h5">Visits all time: <?= $data->sessions['alltime'] ?? 0 ?>
        </p>
        <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1539" height="649"
                style="display: block; width: 1539px; height: 649px;">
        </canvas>
        <hr>
    </main>
<?php
include 'footer.php' ?>