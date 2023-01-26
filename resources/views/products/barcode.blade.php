<center >
<?php 
    for ($i=0; $i < $barcode_qty; $i++) { 
        echo DNS1D::getBarcodeSVG("$product->id", 'C128', 2,70,'', false).'<br>'; 
        echo '<span style="font-size:20px; font-weight:bold">'. $product->id .'</span><br>';
        echo '<span style="font-size:20px; font-weight:bold">'. $product->title .'</span><br><br><br>';
    }

?>
    
<br>
<br>
<br>
<br>
<br>
</center>
<?php 

?>
<style>
        /* svg {
            width: 260px;
            height: 70px;
        } */
        @media print {
            body {
                margin-top: 5px;
                margin-left: 10px;
                /* transform: scale(1.5); */
                transform-origin: 0 0;
            }
        }
</style>

<script>
    window.print();
</script>