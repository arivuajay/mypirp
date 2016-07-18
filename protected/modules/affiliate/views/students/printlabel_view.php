<table style="width: 100%;" >
    <?php
    $i = 1;
    $j = 1;
    $style = "";
    $totalrec = count($std_infos);

    foreach ($std_infos as $infos) {
        $std_city = array();
        $std_address = array();

        $std_name = $infos->first_name . " " . $infos->last_name . "<br>";

        $std_address[] = $infos->address1;
        $std_address[] = $infos->address2;
        $final_address = array_filter($std_address);
        $std_add_info = implode(",", $final_address);

        $std_city[] = $infos->city;
        $std_city[] = $infos->state;
        $final_city = array_filter($std_city);
        $std_cty_info = implode(",", $final_city);
        $std_cty_info = $std_cty_info." ".$infos->zip;

        if ($i == 1 || $i == 3)
            $style = "width: 33%";
        elseif ($i == 2)
            $style = "width: 34%";
        ?>
        <?php if ($i == 1) { ?><tr><?php } ?> 
            <td style="<?php echo$style; ?>">
                <?php echo trim($std_name); ?><?php if ($std_add_info != "") echo trim($std_add_info) . "<br>"; ?><?php if ($std_cty_info != "") echo trim($std_cty_info); ?>                
            </td>  
            <?php if ($i == 3 || $j == $totalrec) { ?></tr><?php } ?>
        <?php if ($i == 3) { ?>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">&nbsp;</td></tr>  
             <tr><td colspan="3">&nbsp;</td></tr>    
            <?php
            $i = 0;
        }
        ?>
        <?php
        $i++;
        $j++;
    }
    ?> 
</table>