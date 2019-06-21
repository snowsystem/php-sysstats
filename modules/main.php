<?php

$ram = file('/proc/meminfo','r');

$fh = fopen('/proc/meminfo','r');
  $total = 0;
  $used = 0;
  $cached = 0;
  $inactive = 0;
  while ($line = fgets($fh)) {
    
    $pieces = array();
    if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
      $total = $pieces[1];
    }
    else if (preg_match('/^Active:\s+(\d+)\skB$/', $line, $pieces)) {
        $used = $pieces[1];
    }
    else if (preg_match('/^Cached:\s+(\d+)\skB$/', $line, $pieces)) {
        $cached = $pieces[1];
    }
    else if (preg_match('/^Inactive:\s+(\d+)\skB$/', $line, $pieces)) {
        $inactive = $pieces[1];
    }
  }

  fclose($fh);
  $totalused = $used + $cached + $inactive;
  $totalavg = round($totalused/$total*100);
  $used = round($used/$total*100);
  $cached = round($cached/$total*100);
  $inactive = round($inactive/$total*100);

$cpus = sys_getloadavg();
?>

<div class="row p-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php
                    foreach($cpus as $count => $cpu){
                        $count = $count+1;
                        echo '<b> CPU '.$count.': </b><div class="progress progress-bar-striped"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '.$cpu.'%;" aria-valuenow="'.$cpu.'" aria-valuemin="0" aria-valuemax="100" title="CPU '.$count.': '.$cpu.'%"></div>'. $cpu .'%</div>';
                    }
                    echo '<b> Memory Usage: </b><div class="progress progress-bar-striped">';
                    echo '<div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: '.$used.'%;" aria-valuenow="'.$used.'" aria-valuemin="0" aria-valuemax="100" title="Used: '.$used.'%"></div>';
                    echo '<div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: '.$cached.'%;" aria-valuenow="'.$cached.'" aria-valuemin="0" aria-valuemax="100" title="Cached: '.$cached.'%"></div>';
                    echo '<div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: '.$inactive.'%;" aria-valuenow="'.$inactive.'" aria-valuemin="0" aria-valuemax="100" title="Inactive: '.$inactive.'%"></div>';                
                    echo $totalavg.'%</div>';
                ?>
            </div>
        </div>
    </div>
</div>
<hr />