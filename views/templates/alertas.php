<?php

foreach($alertas as $key => $mensaje) {
    foreach($mensaje as $error) {
        echo '<div class="alerta ' . $key . '">';
        echo $error;
        echo '</div>';
    }
    
}